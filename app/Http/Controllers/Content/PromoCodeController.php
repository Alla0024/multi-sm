<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreatePromoCodeRequest;
use App\Http\Requests\UpdatePromoCodeRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\PromoCodeDescription;
use App\Repositories\PromoCodeRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use App\Models\PromoCode;
use Flash;

class PromoCodeController extends AppBaseController
{
    /** @var PromoCodeRepository $promoCodeRepository*/
    private $promoCodeRepository;

    public function __construct(PromoCodeRepository $promoCodeRepo)
    {
        parent::__construct();

        $this->promoCodeRepository = $promoCodeRepo;
    }

    /**
     * Display a listing of the PromoCode.
     */
    public function index(Request $request)
    {
        $promoCodes = $this->promoCodeRepository->filterRows($request->all());

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            PromoCodeDescription::class,
            PromoCode::class
        ]);

        $this->template = 'pages.promo_codes.index';

        return $this->renderOutput([
            'promoCodes' => $promoCodes,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new PromoCode.
     */
    public function create()
    {
        $this->template = 'pages.promo_codes.create';

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            PromoCodeDescription::class,
            PromoCode::class
        ]);

        return $this->renderOutput([
            'fields' => $fields,
        ]);
    }

    /**
     * Store a newly created PromoCode in storage.
     */
    public function store(CreatePromoCodeRequest $request)
    {
        $input = $request->all();

        $promoCode = $this->promoCodeRepository->save($input);

        Flash::success(__('common.flash_saved_successfully'));

        return redirect(route('promoCodes.index'));
    }

    /**
     * Display the specified PromoCode.
     */
    public function show($id)
    {
        $promoCode = $this->promoCodeRepository->findFull($id);

        if (empty($promoCode)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('promoCodes.index'));
        }

        $this->template = 'pages.promo_codes.show';

        return $this->renderOutput(compact('promoCode'));
}

    /**
     * Show the form for editing the specified PromoCode.
     */
    public function edit($id)
    {
        $promoCode = $this->promoCodeRepository->findFull($id);

        if (empty($promoCode)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('promoCodes.index'));
        }

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            PromoCodeDescription::class,
            PromoCode::class
        ]);

        $this->template = 'pages.promo_codes.edit';

        return $this->renderOutput(compact('promoCode', 'fields'));
    }

    /**
     * Update the specified PromoCode in storage.
     */
    public function update($id, UpdatePromoCodeRequest $request)
    {
        $promoCode = $this->promoCodeRepository->find($id);

        if (empty($promoCode)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('promoCodes.index'));
        }

        $promoCode = $this->promoCodeRepository->save($request->all(), $id);

        Flash::success(__('common.flash_updated_successfully'));

        if ($request->ajax()) {
            return redirect(route('promoCodes.edit', $id));
        }

        return redirect(route('promoCodes.index'));
    }

    /**
     * Remove the specified PromoCode from storage.
     *
     * @throws \Exception
     */
    public function destroy($ids)
    {
        $this->promoCodeRepository->multiDelete(explode(',', $ids));

        Flash::success(__('common.flash_deleted_successfully'));

        return redirect(route('promoCodes.index'));
    }

    public function copy(Request $request)
    {
        $ids = $request->input('promo_code_ids');

        if ($request->ajax() && filled($ids)) {
            $ids = is_array($ids) ? $ids : explode(',', $ids);

            $this->promoCodeRepository->copy($ids);

            Flash::success(__('common.flash_copied_successfully'));

            return redirect()->route('promoCodes.index');
        }

        Flash::error(__('common.flash_error'));

        return redirect()->route('promoCodes.index');
    }
}
