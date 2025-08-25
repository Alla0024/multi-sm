<?php

namespace App\Repositories;

use Illuminate\Container\Container as Application;
use App\Models\Option;
use App\Models\OptionDescription;
use App\Repositories\BaseRepository;
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

    public function filterIndexPage($perPage, $language_id, array $params)
    {
        $options = $this->model
            ->leftJoin((new OptionDescription())->getTable() . " as od", 'od.option_id', '=', 'options.id')
            ->select('options.*', 'od.*')
            ->where('od.language_id', $language_id)
            ->withCount('optionValueGroups as value_groups_count')
            ->with(['products' => function ($query) use ($language_id) {
                return $query->select('id', 'category_id')->with([
                    'category.descriptions' => function ($query) use ($language_id) {
                        return $query->select('category_id', 'name')->where('language_id', $language_id);
                    }
                ]);
            }])
            ->when(isset($params['name']), function ($q) use ($params) {
                return $q->searchSimilarity(['od.name'], $params['name']);
            })
            ->when(isset($params['appears_in_categories']), function ($q) use ($params, $language_id) {
                return $q->whereHas('products.category.descriptions', function ($query) use ($params, $language_id) {
                    $query->where('language_id', $language_id)
                        ->where('category_id', $params['appears_in_categories']);
                });
            })
            ->paginate($perPage);

        $options->getCollection()->transform(function ($option) {
            $names = collect($option->products)
                ->pluck('category.descriptions.*.name')
                ->flatten()
                ->unique()
                ->sort()
                ->values();

            $option->appears_in_categories = $names->toArray();
            unset($option->products);

            return $option;
        });

        return $options;
    }

    public function getDetails($id)
    {
        $option = $this->model
            ->with([
                'descriptions',
                'optionValueGroups' => function ($q) {
                    $q->with('descriptions');
                }
            ])
            ->find($id);

        $preshaped_descriptions = $option->descriptions
            ->keyBy('language_id')
            ->toArray();

        unset($option->descriptions);

        $option->setAttribute('descriptions', $preshaped_descriptions);

        foreach ($option->optionValueGroups as $option_value_group) {
            $desc = $option_value_group->descriptions
                ->keyBy('language_id')
                ->toArray();

            unset($option_value_group->descriptions);
            $option_value_group->setAttribute('descriptions', $desc);
        }

        return $option;
    }

    public function upsert($input, $id = null)
    {
        $descriptions = $input['descriptions'] ?? [];
        $optionValueGroups = $input['option_value'] ?? [];

        unset($input['descriptions'], $input['option_value']);

        $option = isset($id) ? $this->model->find($id) : null;

        if (!$option) {
            $option = new $this->model();
        }

        $option->fill($input);
        $option->save();

        foreach ($descriptions as $languageId => $descData) {
            OptionDescription::updateOrCreate(
                [
                    'option_id' => $option->id,
                    'language_id' => $languageId
                ],
                $descData
            );
        }

        $this->optionValueGroupRepository->upsertMany($optionValueGroups, $option->id);

        return $option;
    }

    public function delete($id) {
        $option = $this->model->find($id);

        $this->optionValueGroupRepository->deleteAllByOptionId($option->id);

        $option->delete();
    }
}
