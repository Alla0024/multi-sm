<?php

namespace App\Repositories;

use App\Models\AttributeIcon;
use App\Models\AttributeIconDescription;
use App\Models\AttributeIconToAttribute;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;

class AttributeIconRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'title',
        'image',
    ];

    protected array $additionalFields = [
        'title'
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
        return AttributeIcon::class;
    }

    public function filterRows(Request $request) {
        $params = $request->all();
        $perPage = $request->input('perPage', 10);
        $languageId = $request->input('language_id', config('settings.locale.default_language_id'));

        $query = $this->model
            ->leftJoin((new AttributeIconDescription())->getTable() . " as aid", 'aid.attribute_icon_id', '=', 'attribute_icons.id')
            ->where('language_id', $languageId);

        if ($request->get('title') !== null && !empty($request->get('title'))) {
            $query->where('title', 'like', '%' . $request->get('title') . '%');
        }

        if ($request->get('image') !== null && !empty($request->get('image'))) {
            $query->where('image', 'like', '%' . $request->get('image') . '%');
        }

        $query->when(isset($params['sortBy']), function ($query) use ($params) {
            switch ($params['sortBy']) {
                case 'name_asc':
                    $query->orderBy('title', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('title', 'desc');
                    break;
                case 'created_at':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'created_at_desc':
                    $query->orderBy('created_at', 'desc');
                    break;
                default:
                    break;
            }

            return $query;
        });


        $attributeIcons = $query->paginate($perPage);

        return $attributeIcons;
    }

    public function findFull($id) {
        $query = $this->model->with(['descriptions']);

        $attributeIcon = $query->find($id);
        $attribute = AttributeIconToAttribute::where('attribute_icon_id', $attributeIcon->id)->first();

        $descriptions = $attributeIcon->descriptions->keyBy('language_id')->toArray();
        unset($attributeIcon->descriptions);
        $attributeIcon->setAttribute('descriptions', $descriptions);
        $attributeIcon->setAttribute('attribute_id', $attribute?->id);

        return $attributeIcon;
    }

    public function save(array $input, $id = null)
    {
        $descriptions = $input['descriptions'] ?? [];
        unset($input['descriptions']);

        $input['pattern'] = $input['pattern'] ?? '';

        $attributeIcon = isset($id) ? $this->model->find($id) : null;

        if (!$attributeIcon) {
            $attributeIcon = new $this->model();
        }

        $attributeIcon->fill($input);
        $attributeIcon->save();

        foreach ($descriptions as $languageId => $descData) {
            AttributeIconDescription::updateOrInsert(
                [
                    'attribute_icon_id' => (int)$attributeIcon->id,
                    'language_id' => $languageId
                ],
                [
                    'title' => $descData['title'] ?? '',
                    'description' => $descData['description'] ?? ''
                ]
            );
        }

        return $attributeIcon;
    }

    public function copy($ids): void
    {
        $attributeIcons = AttributeIcon::whereIn('id', $ids)->get();

        foreach ($attributeIcons as $attributeIcon) {
            $newItem = $attributeIcon->replicate();
            $newItem->status = 0;
            $newItem->save();
        }
    }

    public function multiDelete($ids): void
    {
        News::whereIn('id', $ids)->delete();
        NewsDescription::whereIn('news_id', $ids)->delete();
        FirstPathQuery::where('type', 'news')->whereIn('type_id', $ids)->delete();
    }
}
