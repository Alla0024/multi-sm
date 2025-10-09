<?php

namespace App\Repositories;

use App\Models\OptionValueGroup;
use App\Models\OptionValueGroupDescription;
use App\Models\ProductOption;
use App\Models\ProductOptionValueGroup;
use Illuminate\Container\Container as Application;
use App\Models\Option;
use App\Models\OptionDescription;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use function Symfony\Component\String\s;

class OptionRepository extends BaseRepository
{
    /**
     * @var OptionValueGroupRepository $optionValueGroupRepository;
     */
    private $optionValueGroupRepository;

    public function __construct(
        Application $app,
        OptionValueGroupRepository $optionValueGroupRepo,
    )
    {
        $this->optionValueGroupRepository = $optionValueGroupRepo;

        parent::__construct($app);
    }

    protected array $fieldSearchable = [
        'name',
        'value_groups_count',
        'sort_order',
        'appears_in_categories'
    ];

    protected array $additionalFields = [
        'name',
        'value_groups_count',
        'option_value_groups',
        'appears_in_categories'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function getAdditionalFields(): array
    {
        return $this->additionalFields;
    }

    public function model(): string
    {
        return Option::class;
    }

    public function isOptionWithProvidedPathExists($path, int|null $id = null): bool
    {
        $query = $this->model->where('path', $path);

        if ($id !== null) {
            $query->where('id', '<>', $id);
        }

        return $query->exists();
    }

    public function find($id, $columns = ['*'])
    {
        $option = $this->model->find($id, $columns);

        return $option;
    }

    public function getOptions()
    {
        $languageId = config('settings.locale.default_language_id');

        return $this->model
            ->with([
                'description' => fn($q) => $q
                    ->where('language_id', $languageId)
                    ->with('language:id,code'),
                'optionValueGroups',
            ])
            ->get();
    }
    public function filterRows(array $input)
    {
        $perPage    = $input['perPage'] ?? 10;
        $languageId = $input['language_id'] ?? config('settings.locale.default_language_id');

        $query = $this->model::with([
            'descriptions' => fn($q) => $q->where('language_id', $languageId),
            'products.category.descriptions' => fn($q) => $q
                ->select('category_id', 'name')
                ->where('language_id', $languageId),
        ])
            ->withCount('valueGroups as value_groups_count');

        foreach (['sort_order', 'status'] as $field) {
            $query->when($input[$field] ?? null, fn($q, $value) => $q->where($field, $value));
        }

        $query->when($input['name'] ?? null, function ($q, $name) use ($languageId) {
            $q->whereHas('descriptions', function ($sub) use ($languageId, $name) {
                $sub->where('language_id', $languageId)
                    ->where('name', 'LIKE', "%{$name}%");
            });
        });

        $query->when($input['appears_in_categories'] ?? null, function ($q, $categories) use ($languageId) {
            if (!is_array($categories)) {
                $categories = array_filter(explode(',', $categories));
            }
            if (count($categories) > 0) {
                $q->whereHas('products.category.descriptions', function ($sub) use ($languageId, $categories) {
                    $sub->where('language_id', $languageId)
                        ->whereIn('category_id', $categories);
                });
            }
        });

        $query->when($input['sortBy'] ?? null, function ($q, $sortBy) use ($languageId) {
            if (in_array($sortBy, ['name_asc', 'name_desc'])) {
                $q->withAggregate(
                    ['descriptions as name' => fn($sub) => $sub->where('language_id', $languageId)],
                    'name'
                )->orderBy('name', $sortBy === 'name_asc' ? 'asc' : 'desc');
            } elseif ($sortBy === 'created_at_asc') {
                $q->orderBy('created_at', 'asc');
            } elseif ($sortBy === 'created_at_desc') {
                $q->orderBy('created_at', 'desc');
            } elseif ($sortBy === 'sort_order_asc') {
                $q->orderBy('sort_order', 'asc');
            } elseif ($sortBy === 'sort_order_desc') {
                $q->orderBy('sort_order', 'desc');
            }
        });

        $options = $query->paginate($perPage);

        $options->getCollection()->transform(function ($option) {
            $option->setAttribute('name', optional($option->descriptions->first())->name);

            $categories = collect($option->products)
                ->flatMap(fn($p) => $p->category?->descriptions ?? collect())
                ->pluck('name')
                ->filter()
                ->unique()
                ->sort()
                ->values();

            $option->setAttribute('appears_in_categories', $categories->toArray());

            unset($option->products);

            return $option;
        });

        return $options;
    }

    public function findFull($id)
    {
        $option = $this->model
            ->with([
                'descriptions',
                'valueGroups.descriptions',
            ])
            ->find($id);

        if (!$option) {
            return null;
        }

        $option->descriptions = $option->descriptions
            ->keyBy('language_id')
            ->toArray();

        $option->valueGroups->each(function ($group) {
            $group->setRelation(
                'descriptions',
                $group->descriptions->keyBy('language_id')
            );
        });

        return $option;
    }

    public function save(array $data, ?int $id = null)
    {
        $descriptions = $data['descriptions'] ?? [];
        $optionValueGroups = $data['option_value'] ?? [];

        unset($data['descriptions'], $data['option_value']);

        $option = $id ? $this->model->find($id) : $this->model->newInstance();

        $option->fill($data)->save();

        foreach ($descriptions as $languageId => $descData) {
            OptionDescription::updateOrCreate(
                ['option_id' => $option->id, 'language_id' => $languageId],
                $descData
            );
        }

        $this->optionValueGroupRepository->upsertMany($optionValueGroups, $option->id);

        return $option;
    }

    public function copy($ids): void
    {
        $options = Option::with(['descriptions', 'valueGroups.descriptions'])->whereIn('id', $ids)->get();

        foreach ($options as $option) {
            $newOption = $option->replicate();
            $newOption->path = isset($newOption->path) ? $newOption->path.'-copy' : $newOption->path;
            $newOption->save();

            $productsPivot = ProductOption::where('option_id', $option->id)->get();

            foreach ($option->descriptions as $description) {
                $newDescription = $description->toArray();
                $newDescription['option_id'] = $newOption->id;
                OptionDescription::create($newDescription);
            }

            foreach ($option->valueGroups as $option_value_group) {
                $newOptionValueGroup = $option_value_group->replicate();
                $newOptionValueGroup->option_id = $newOption->id;
                $newOptionValueGroup->save();

                foreach ($option_value_group->descriptions as $description) {
                    $newDescription = $description->toArray();
                    $newDescription['option_value_group_id'] = $newOptionValueGroup->id;
                    OptionValueGroupDescription::create($newDescription);
                }
            }

            foreach ($productsPivot as $product) {
                $newProduct = $product->toArray();
                $newProduct['option_id'] = $newOption->id;
                ProductOption::create($newProduct);
            }
        }
    }

    public function multiDelete($ids): void
    {
        Option::whereIn('id', $ids)->delete();
        OptionDescription::whereIn('option_id', $ids)->delete();
        OptionValueGroup::whereIn('option_id', $ids)->delete();
        ProductOption::whereIn('option_id', $ids)->delete();
    }
}
