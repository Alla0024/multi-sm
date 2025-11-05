<?php

namespace App\Repositories;

use App\Models\SaleGroup;
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
        $perPage = $input['items_per_page'] ?? $input['perPage'] ?? config('settings.admin_items_per_page');
        $languageId = $input['language_id'] ?? config('settings.locale.default_language_id');

        $query = $this->model::with([
            'description' => fn($q) => $q->where('language_id', $languageId),
        ]);

        if (isset($input['ancestor_id']) && is_numeric($input['ancestor_id'])) {
            $ancestorId = (int)$input['ancestor_id'];
            $query->whereIn('id', function ($sub) use ($ancestorId) {
                $sub->select('descendant_id')
                    ->from('sale_group_closure')
                    ->where('ancestor_id', $ancestorId)
                    ->whereColumn('ancestor_id', '!=', 'descendant_id');
            });
        } else {
            $query->whereHas('closure', fn($q) => $q->where('depth', 0));
        }

        if (!empty($input['filter_status']) && is_numeric($input['filter_status'])) {
            $query->where('status', $input['filter_status']);
        }

        if (!empty($input['search'])) {
            $search = trim($input['search']);
            $query->whereHas('description', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%");
            });
        }

        if (!empty($input['sort_order']) && $input['sort_order'] !== 'all') {
            $query->orderBy('sort_order', $input['sort_order']);
        }

        $query->orderByDesc('status')->orderByDesc('sort_order');

        $saleGroups = $query->paginate($perPage);

        $saleGroups->appends([
            'items_per_page' => $perPage,
            'search' => $input['search'] ?? null,
            'sort_order' => $input['sort_order'] ?? null,
            'filter_status' => $input['filter_status'] ?? null,
            'ancestor_id' => $input['ancestor_id'] ?? null,
        ]);

        $saleGroups->getCollection()->transform(function ($item) {
            $item->setAttribute('name', optional($item->description)->name);
            return $item;
        });

        return $saleGroups;
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

