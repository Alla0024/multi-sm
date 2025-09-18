<?php

namespace App\Repositories;

use App\Models\AttributeIcon;
use App\Models\AttributeIconDescription;
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

        $descriptions = $attributeIcon->descriptions->keyBy('language_id')->toArray();
        unset($attributeIcon->descriptions);
        $attributeIcon->setAttribute('descriptions', $descriptions);

        return $attributeIcon;
    }
}
