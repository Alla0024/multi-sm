<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateArticleAuthorRequest;
use App\Http\Requests\UpdateArticleAuthorRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\ArticleAuthorDescription;
use App\Models\FirstPathQuery;
use App\Models\Language;
use App\Repositories\ArticleAuthorRepository;
use App\Helpers\ModelSchemaHelper;
use App\Repositories\LanguageRepository;
use Illuminate\Http\Request;
use App\Models\ArticleAuthor;
use Flash;

class ArticleAuthorController extends AppBaseController
{
    /**
     * @var ArticleAuthorRepository $articleAuthorRepository
     * @var LanguageRepository $languageRepository
     * @var int $defaultLanguageId
     */
    private ArticleAuthorRepository $articleAuthorRepository;
    private LanguageRepository $languageRepository;
    private int $defaultLanguageId;

    public function __construct(ArticleAuthorRepository $articleAuthorRepo, LanguageRepository $languageRepository)
    {
        parent::__construct();

        $this->articleAuthorRepository = $articleAuthorRepo;
        $this->languageRepository = $languageRepository;

        $this->defaultLanguageId = config('settings.locale.default_language_id');
    }

    /**
     * Display a listing of the ArticleAuthor.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);

        $sortFields = [
            'default',
            'name_asc',
            'name_desc',
            'created_at_asc',
            'created_at_desc',
        ];

        $languages = $this->languageRepository->getAvailableLanguages();
        $languageId = $request->get('language_id') ?? $this->defaultLanguageId;

        $articleAuthors = $this->articleAuthorRepository->filterIndexPage($perPage, $languageId, $request->all());

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            ArticleAuthorDescription::class,
            ArticleAuthor::class
        ]);

        $this->template = 'pages.article_authors.index';

        return $this->renderOutput([
            'articleAuthors' => $articleAuthors,
            'languages' => $languages,
            'sortFields' => $sortFields,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new ArticleAuthor.
     */
    public function create()
    {
        $languages = $this->languageRepository->getAvailableLanguages();

        $this->template = 'pages.article_authors.create';

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            ArticleAuthor::class,
            ArticleAuthorDescription::class,
            FirstPathQuery::class
        ]);
        return $this->renderOutput([
            'fields' => $fields,
            'languages' => $languages,
            'inTabs' => array_unique(array_column($fields, 'inTab')),
        ]);
    }

    /**
     * Store a newly created ArticleAuthor in storage.
     */
    public function store(CreateArticleAuthorRequest $request)
    {
        $input = $request->all();

        $articleAuthor = $this->articleAuthorRepository->create($input);

        Flash::success(__('common.flash_saved_successfully'));

        return redirect(route('articleAuthors.index'));
    }

    /**
     * Display the specified ArticleAuthor.
     */
    public function show($id)
    {
        $articleAuthor = $this->articleAuthorRepository->find($id);
        $languages = $this->languageRepository->getAvailableLanguages();

        if (empty($articleAuthor)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('articleAuthors.index'));
        }

        $seoUrl = FirstPathQuery::where('type_id', $id)->where('type', 'authors')->value('path');;
        $articleAuthor->setAttribute('path', $seoUrl);

        $this->template = 'pages.article_authors.show';

        return $this->renderOutput(compact('articleAuthor', 'languages'));
    }

    /**
     * Show the form for editing the specified ArticleAuthor.
     */
    public function edit($id)
    {
        $articleAuthor = $this->articleAuthorRepository->find($id);
        $languages = $this->languageRepository->getAvailableLanguages();

        if (empty($articleAuthor)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('articleAuthors.index'));
        }

        $seoUrl = FirstPathQuery::where('type_id', $id)->where('type', 'authors')->value('path');;
        $articleAuthor->setAttribute('path', $seoUrl);

        $this->template = 'pages.article_authors.edit';

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            ArticleAuthor::class,
            ArticleAuthorDescription::class,
            FirstPathQuery::class
        ]);
        return $this->renderOutput([
            'articleAuthor' => $articleAuthor,
            'languages' => $languages,
            'fields' => $fields,
            'inTabs' => array_unique(array_column($fields, 'inTab')),
        ]);
    }

    /**
     * Update the specified ArticleAuthor in storage.
     */
    public function update($id, UpdateArticleAuthorRequest $request)
    {
        $articleAuthor = $this->articleAuthorRepository->find($id);

        if (empty($articleAuthor)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('articleAuthors.index'));
        }

        $this->articleAuthorRepository->update($request->all(), $id);

        Flash::success(__('common.flash_updated_successfully'));

        return redirect(route('articleAuthors.index'));
    }

    /**
     * Remove the specified ArticleAuthor from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $articleAuthor = $this->articleAuthorRepository->find($id);

        if (empty($articleAuthor)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('articleAuthors.index'));
        }

        $this->articleAuthorRepository->delete($id);

        Flash::success(__('common.flash_deleted_successfully'));

        return redirect(route('articleAuthors.index'));
    }
}
