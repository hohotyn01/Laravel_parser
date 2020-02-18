<?php


namespace App\Repositories;

use App\Models\Article;

class ArticleRepository extends BaseRepository
{
    public function __construct(Article $article)
    {
        $this->setModel($article);
    }

    public function insertArticles($articles)
    {
        return Article::insert($articles);
    }

    public function findArticle($idArticle)
    {
        return Article::where('id_article', '=', $idArticle)->count();
    }

    public function articlesPaginate()
    {
        return Article::OrderBy('date', 'DESC')->simplePaginate(10);
    }
}
