<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateArticleAuthorRequest;
use App\Http\Requests\UpdateArticleAuthorRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\FirstPathQuery;
use App\Repositories\ArticleAuthorRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use App\Models\ArticleAuthor;
use Flash;

class ArticleAuthorController extends AppBaseController
{
    /** @var ArticleAuthorRepository $articleAuthorRepository*/
    private $articleAuthorRepository;

    public function __construct(ArticleAuthorRepository $articleAuthorRepo)
    {
        parent::__construct();

        $this->articleAuthorRepository = $articleAuthorRepo;
    }

    /**
     * Display a listing of the ArticleAuthor.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);

        $articleAuthors = $this->articleAuthorRepository->paginate($perPage);

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            ArticleAuthor::class
        ]);

        $this->template = 'pages.article_authors.index';

        return $this->renderOutput([
            'articleAuthors' => $articleAuthors,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new ArticleAuthor.
     */
    public function create()
    {
        $this->template = 'pages.article_authors.create';

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            ArticleAuthor::class,
            FirstPathQuery::class
        ]);
        return $this->renderOutput([
            'fields' => $fields,
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

        Flash::success('Article Author saved successfully.');

        return redirect(route('articleAuthors.index'));
    }

    /**
     * Display the specified ArticleAuthor.
     */
    public function show($id)
    {
        $articleAuthor = $this->articleAuthorRepository->find($id)->first();

        if (empty($articleAuthor)) {
            Flash::error('Article Author not found');

            return redirect(route('articleAuthors.index'));
        }

        $seoUrl = FirstPathQuery::where('type_id', $id)->where('type', 'authors')->value('path');;
        $articleAuthor->setAttribute('path', $seoUrl);

        $this->template = 'pages.article_authors.show';

        return $this->renderOutput(compact('articleAuthor'));
}

    /**
     * Show the form for editing the specified ArticleAuthor.
     */
    public function edit($id)
    {
        $articleAuthor = $this->articleAuthorRepository->find($id);

        if (empty($articleAuthor)) {
            Flash::error('Article Author not found');

            return redirect(route('articleAuthors.index'));
        }

        $seoUrl = FirstPathQuery::where('type_id', $id)->where('type', 'authors')->value('path');;
        $articleAuthor->setAttribute('path', $seoUrl);

        $this->template = 'pages.article_authors.edit';

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            ArticleAuthor::class,
            FirstPathQuery::class
        ]);
        return $this->renderOutput([
            'articleAuthor' => $articleAuthor,
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
            Flash::error('Article Author not found');

            return redirect(route('articleAuthors.index'));
        }

        $articleAuthor = $this->articleAuthorRepository->update($request->all(), $id);

        Flash::success('Article Author updated successfully.');

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
            Flash::error('Article Author not found');

            return redirect(route('articleAuthors.index'));
        }

        $this->articleAuthorRepository->delete($id);

        Flash::success('Article Author deleted successfully.');

        return redirect(route('articleAuthors.index'));
    }
}
