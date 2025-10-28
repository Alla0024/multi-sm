<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreatePromoCodeGroupRequest;
use App\Http\Requests\UpdatePromoCodeGroupRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\PromoCodeDescription;
use App\Repositories\PromoCodeGroupRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use App\Models\PromoCodeGroup;
use Flash;

class PromoCodeGroupController extends AppBaseController
{
    /** @var PromoCodeGroupRepository $promoCodeGroupRepository*/
    private $promoCodeGroupRepository;

    public function __construct(PromoCodeGroupRepository $promoCodeGroupRepo)
    {
        parent::__construct();

        $this->promoCodeGroupRepository = $promoCodeGroupRepo;
    }

    /**
     * Display a listing of the PromoCodeGroup.
     */
    public function index(Request $request)
    {
        $promoCodeGroups = $this->promoCodeGroupRepository->filterRows($request->all());

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            PromoCodeDescription::class,
            PromoCodeGroup::class
        ]);

        $this->template = 'pages.promo_code_groups.index';

        return $this->renderOutput([
            'promoCodeGroups' => $promoCodeGroups,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new PromoCodeGroup.
     */
    public function create()
    {
        $this->template = 'pages.promo_code_groups.create';

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            PromoCodeDescription::class,
            PromoCodeGroup::class
        ]);

        return $this->renderOutput([
            'fields' => $fields,
        ]);
    }

    /**
     * Store a newly created PromoCodeGroup in storage.
     */
    public function store(CreatePromoCodeGroupRequest $request)
    {
        $input = $request->all();

        $promoCodeGroup = $this->promoCodeGroupRepository->save($input);

        Flash::success(__('common.flash_saved_successfully'));

        return redirect(route('promoCodeGroups.index'));
    }

    /**
     * Display the specified PromoCodeGroup.
     */
    public function show($id)
    {
        $promoCodeGroup = $this->promoCodeGroupRepository->findFull($id);

        if (empty($promoCodeGroup)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('promoCodeGroups.index'));
        }

        $this->template = 'pages.promo_code_groups.show';

        return $this->renderOutput(compact('promoCodeGroup'));
}

    /**
     * Show the form for editing the specified PromoCodeGroup.
     */
    public function edit($id)
    {
        $promoCodeGroup = $this->promoCodeGroupRepository->findFull($id);

        if (empty($promoCodeGroup)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('promoCodeGroups.index'));
        }

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            PromoCodeDescription::class,
            PromoCodeGroup::class
        ]);

        $this->template = 'pages.promo_code_groups.edit';

        return $this->renderOutput(compact('promoCodeGroup', 'fields'));
    }

    /**
     * Update the specified PromoCodeGroup in storage.
     */
    public function update($id, UpdatePromoCodeGroupRequest $request)
    {
        $promoCodeGroup = $this->promoCodeGroupRepository->find($id);

        if (empty($promoCodeGroup)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('promoCodeGroups.index'));
        }

        $promoCodeGroup = $this->promoCodeGroupRepository->save($request->all(), $id);

        Flash::success(__('common.flash_updated_successfully'));

        if ($request->ajax()) {
            return redirect(route('promoCodeGroups.edit', $id));
        }

        return redirect(route('promoCodeGroups.index'));
    }

    /**
     * Remove the specified PromoCodeGroup from storage.
     *
     * @throws \Exception
     */
    public function destroy($ids)
    {
        $this->promoCodeGroupRepository->multiDelete(explode(',', $ids));

        Flash::success(__('common.flash_deleted_successfully'));

        return redirect(route('promoCodeGroups.index'));
    }

    public function copy(Request $request)
    {
        $ids = $request->input('promo_code_group_ids');

        if ($request->ajax() && filled($ids)) {
            $ids = is_array($ids) ? $ids : explode(',', $ids);

            $this->promoCodeGroupRepository->copy($ids);

            Flash::success(__('common.flash_copied_successfully'));

            return redirect()->route('promoCodeGroups.index');
        }

        Flash::error(__('common.flash_error'));

        return redirect()->route('promoCodeGroups.index');
    }
}
