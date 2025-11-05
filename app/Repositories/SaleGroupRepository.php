<?php

namespace App\Repositories;

use App\Models\SaleGroup;
use App\Models\SaleGroupClosure;
use App\Models\SaleGroupDescription;
use App\Models\SaleGroupToBonusProgram;
use App\Models\SaleGroupToPromoCodeGroup;
use App\Models\SaleGroupToSale;

class SaleGroupRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'status',
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
        return SaleGroup::class;
    }

    public function with($relations)
    {
        return $this->model->with($relations);
    }

    public function findFull($id, $columns = ['*'])
    {
        $saleGroup = $this->model
            ->with([
                'descriptions.language:id,code',
                'sales',
                'bonusPrograms',
                'promoCodeGroups',
            ])
            ->find($id, $columns);

        if (!$saleGroup) {
            return null;
        }

        $descriptions = $saleGroup->descriptions
            ->mapWithKeys(fn($desc) => [
                (string)($desc->language_id ?? $desc->language->code) => [
                    'name' => $desc->name,
                ]
            ])
            ->toArray();

        return $saleGroup
            ->setRelation('descriptions', $descriptions);
    }
    public function filterRows(array $input)
    {
        $perPage = $input['items_per_page']
            ?? $input['perPage']
            ?? config('settings.admin_items_per_page');

        $languageId = $input['language_id']
            ?? config('settings.locale.default_language_id');

        $query = $this->model::with([
            'descriptions' => fn($q) => $q->where('language_id', $languageId),
        ]);

        $query->whereIn('id', $this->getHierarchyIds($input));

        foreach (['sort_order', 'status'] as $field) {
            if (!empty($input[$field]) && $input[$field] !== 'all') {
                $query->where($field, $input[$field]);
            }
        }

        if (!empty($input['name'])) {
            $name = trim($input['name']);
            $query->whereHas('descriptions', fn($q) =>
            $q->where('language_id', $languageId)
                ->where('name', 'LIKE', "%{$name}%")
            );
        }

        if (!empty($input['sortBy'])) {
            match ($input['sortBy']) {
                'name_asc', 'name_desc' => $query->withAggregate(
                    ['descriptions as name' => fn($q) => $q->where('language_id', $languageId)],
                    'name'
                )->orderBy('name', $input['sortBy'] === 'name_asc' ? 'asc' : 'desc'),

                'created_at_asc' => $query->orderBy('created_at', 'asc'),
                'created_at_desc' => $query->orderBy('created_at', 'desc'),
                default => null,
            };
        }

        $saleGroups = $query->paginate($perPage);

        $saleGroups->getCollection()->transform(function ($item) {
            $item->name = optional($item->descriptions->first())->name;

            return $item;
        });

        return $saleGroups;
    }


    private function getHierarchyIds(array $input)
    {
        if (!empty($input['ancestor_id']) && is_numeric($input['ancestor_id'])) {
            return SaleGroupClosure::where('ancestor_id', (int)$input['ancestor_id'])
                ->whereColumn('ancestor_id', '!=', 'descendant_id')
                ->pluck('descendant_id');
        }

        if (!empty($input['parent_id']) && is_numeric($input['parent_id'])) {
            return SaleGroupClosure::where('ancestor_id', (int)$input['parent_id'])
                ->whereColumn('ancestor_id', '!=', 'descendant_id')
                ->pluck('descendant_id');
        }

        return SaleGroupClosure::where('depth', 0)
            ->pluck('descendant_id');
    }
    public function save(array $input, ?int $id = null)
    {
        $descriptions = $input['descriptions'] ?? [];
        $sales = $input['sales'] ?? [];
        $bonusPrograms = $input['bonus_programs'] ?? [];
        $promoCodeGroups = $input['promo_code_groups'] ?? [];

        unset($input['descriptions'], $input['sales'], $input['bonus_programs'], $input['promo_code_groups']);

        $saleGroup = $this->model->updateOrCreate(['id' => $id], $input);
        $saleGroupId = $saleGroup->id;

        foreach ($descriptions as $languageId => $descData) {
            SaleGroupDescription::updateOrInsert(
                [
                    'sale_group_id' => $saleGroupId,
                    'language_id' => $languageId
                ],
                $descData
            );
        }

        SaleGroupToSale::where('sale_group_id', $saleGroupId)->delete();
        foreach ($sales as $saleId => $saleData) {
            SaleGroupToSale::create([
                'sale_group_id' => $saleGroupId,
                'sale_id' => (int) $saleId,
                'sort_order' => $saleData['sort_order'] ?? 0
            ]);
        }

        SaleGroupToBonusProgram::where('sale_group_id', $saleGroupId)->delete();
        foreach ($bonusPrograms as $programId => $programData) {
            SaleGroupToBonusProgram::create([
                'sale_group_id' => $saleGroupId,
                'bonus_program_id' => (int) $programId,
                'sort_order' => $programData['sort_order'] ?? 0
            ]);
        }

        SaleGroupToPromoCodeGroup::where('sale_group_id', $saleGroupId)->delete();
        foreach ($promoCodeGroups as $groupId => $groupData) {
            SaleGroupToPromoCodeGroup::create([
                'sale_group_id' => $saleGroupId,
                'promo_code_group_id' => (int) $groupId,
                'sort_order' => $groupData['sort_order'] ?? 0
            ]);
        }

        return $saleGroup;
    }

    public function multiDelete($ids): void
    {
        SaleGroupDescription::whereIn('sale_group_id', $ids)->delete();
        SaleGroupToSale::whereIn('sale_group_id', $ids)->delete();
        SaleGroupToBonusProgram::whereIn('sale_group_id', $ids)->delete();
        SaleGroupToPromoCodeGroup::whereIn('sale_group_id', $ids)->delete();

        SaleGroup::whereIn('id', $ids)->delete();
    }
}

