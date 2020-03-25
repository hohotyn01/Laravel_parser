<?php


namespace App\Repositories;

use App\Models\TsnArticle;

class ArticleTsnRepository extends BaseRepository
{
    public function __construct(TsnArticle $article)
    {
        $this->setModel($article);
    }

    public function insertTsnArticles($articles)
    {
        return TsnArticle::insertGetId($articles);
    }

    public function findTsnArticle($idArticle)
    {
        return TsnArticle::where('id_article', '=', $idArticle)->count();
    }

    public function articlesTsnPaginate()
    {
        return TsnArticle::latest('date')->paginate(10);
    }
}
