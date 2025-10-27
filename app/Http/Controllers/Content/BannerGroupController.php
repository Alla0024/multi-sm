<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateBannerGroupRequest;
use App\Http\Requests\UpdateBannerGroupRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Banner;
use App\Models\BannerDescription;
use App\Models\FirstPathQuery;
use App\Repositories\BannerGroupRepository;
use App\Helpers\ModelSchemaHelper;
use App\Repositories\BannerRepository;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use App\Models\BannerGroup;
use Flash;

class BannerGroupController extends AppBaseController
{
    /** @var BannerGroupRepository $bannerGroupRepository */
    private $bannerGroupRepository;

    /** @var CategoryRepository $categoryRepository */
    private $categoryRepository;

    /** @var BannerRepository $bannerRepository */
    private $bannerRepository;

    public function __construct(
        BannerGroupRepository $bannerGroupRepo,
        CategoryRepository    $categoryRepo,
        BannerRepository      $bannerRepo,
    )
    {
        parent::__construct();

        $this->bannerGroupRepository = $bannerGroupRepo;
        $this->categoryRepository = $categoryRepo;
        $this->bannerRepository = $bannerRepo;
    }

    /**
     * Display a listing of the BannerGroup.
     */
    public function index(Request $request)
    {
        $bannerGroups = $this->bannerGroupRepository->filterRows($request->all());

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            BannerGroup::class,
            Banner::class,
            BannerDescription::class,

        ]);

        $categories = $this->categoryRepository->getActiveCategories();

        $this->template = 'pages.banner_groups.index';

        return $this->renderOutput([
            'bannerGroups' => $bannerGroups,
            'fields' => $fields,
            'categories' => $categories
        ]);
    }


    /**
     * Show the form for creating a new BannerGroup.
     */
    public function create()
    {
        $this->template = 'pages.banner_groups.create';

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            BannerDescription::class,
            Banner::class,
            BannerGroup::class
        ]);

        return $this->renderOutput(['fields' => $fields]);
    }

    /**
     * Store a newly created BannerGroup in storage.
     */
    public function store(CreateBannerGroupRequest $request)
    {
        $input = $request->all();

        $bannerGroup = $this->bannerGroupRepository->save($input);

        Flash::success(__('common.flash_saved_successfully'));

        return redirect(route('bannerGroups.index'));
    }

    /**
     * Display the specified BannerGroup.
     */
    public function show($id)
    {
        $bannerGroup = $this->bannerGroupRepository->findFull($id);

        if (empty($bannerGroup)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('bannerGroups.index'));
        }

        $this->template = 'pages.banner_groups.show';

        return $this->renderOutput(compact('bannerGroup'));
    }

    /**
     * Show the form for editing the specified BannerGroup.
     */
    public function edit($id)
    {
        $bannerGroup = $this->bannerGroupRepository->findFull($id);

        if (empty($bannerGroup)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('bannerGroups.index'));
        }
        $banners = $this->bannerRepository->findFull($id);

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            BannerDescription::class,
            Banner::class,
            BannerGroup::class,
        ]);

        $this->template = 'pages.banner_groups.edit';

        return $this->renderOutput(compact('bannerGroup', 'fields', 'banners'));
    }

    /**
     * Update the specified BannerGroup in storage.
     */
    public function update($id, UpdateBannerGroupRequest $request)
    {
        $input = $request->all();
        $bannerGroup = $this->bannerGroupRepository->find($id);

        if (empty($bannerGroup)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('bannerGroups.index'));
        }

        $bannerGroup = $this->bannerGroupRepository->save($input, $id);
        $banners = $this->bannerRepository->save($input, $id);

        Flash::success(__('common.flash_updated_successfully'));

        if ($request->ajax()) {
            return redirect(route('bannerGroups.edit', $id));
        }

        return redirect(route('bannerGroups.index'));
    }

    /**
     * Remove the specified BannerGroup from storage.
     *
     * @throws \Exception
     */
    public function destroy($ids)
    {
        $this->bannerGroupRepository->multiDelete(explode(',', $ids));
        $this->bannerRepository->multiDelete(explode(',', $ids));

        Flash::success(__('common.flash_deleted_successfully'));

        return redirect(route('bannerGroups.index'));
    }

    public function copy(Request $request)
    {
        $ids = $request->input('banner_ids');

        if ($request->ajax() && filled($ids)) {
            $ids = is_array($ids) ? $ids : explode(',', $ids);

            $this->bannerGroupRepository->copy($ids);

            Flash::success(__('common.flash_copied_successfully'));

            return redirect()->route('bannerGroups.index');
        }

        Flash::error(__('common.flash_error'));

        return redirect()->route('bannerGroups.index');
    }
}
