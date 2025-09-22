<?php

namespace App\Repositories;

use App\Models\Attribute;
use App\Models\AttributeDescription;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;

class AttributeRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'attribute_group_id',
        'sort_order'
    ];

    protected array $additionalFields = [
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
        return Attribute::class;
    }

    public function getDropdownItems()
    {
        return $this->model
            ->with('descriptions')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'text' => $item->descriptions->where('language_id', config('settings.locale.default_language_id'))->first()->name,
                ];
            });
    }

    public function filterRows(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $languageId = $request->input('language_id', config('settings.locale.default_language_id'));

        $query = $this->model
            ->with(['attributeGroup.descriptions' => function ($query) use ($languageId) {
                $query->where('language_id', $languageId);
            }])
            ->leftJoin(app(AttributeDescription::class)->getTable().' as atd', "attributes.id", "=", "atd.attribute_id")
            ->where('atd.language_id', $languageId);

        if ($request->input('name') !== null) {
            $query->where('atd.name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->input('attribute_group_id') !== null) {
            $query->where('attribute_group_id', $request->input('attribute_group_id'));
        }

        if ($request->input('sort_order') !== null) {
            $query->where('sort_order', $request->input('sort_order'));
        }

        $rows = $query
            ->paginate($perPage)
            ->through(function ($item) {
                $attribute_group = $item->attributeGroup->descriptions->first()->name;
                unset($item->attributeGroup, $item->attribute_group_id);
                $item->attribute_group_id = $attribute_group;
                return $item;
            });

        return $rows;
    }
}
