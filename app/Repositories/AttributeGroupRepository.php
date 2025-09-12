<?php

namespace App\Repositories;

use App\Models\AttributeGroup;
use App\Models\AttributeGroupDescription;
use Illuminate\Http\Request;

class AttributeGroupRepository extends BaseRepository
{
    protected array $fieldSearchable = [
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
        return AttributeGroup::class;
    }

    public function filterRows(Request $request) {
        $perPage = $request->integer('perPage', 10);
        $languageId = $request->input('language_id', config('settings.locale.default_language_id'));

        $query = $this->model
            ->leftJoin(app(AttributeGroupDescription::class)->getTable().' as agd', 'agd.attribute_group_id', '=', 'attribute_groups.id')
            ->where('agd.language_id', $languageId);

        if ($request->input('name') !== null) {
            $query->where('agd.name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->input('sort_order') !== null) {
            $query->where('sort_order', $request->input('sort_order'));
        }

        $rows = $query
            ->paginate($perPage);

        return $rows;
    }
}
