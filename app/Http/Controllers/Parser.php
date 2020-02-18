<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ArticleService;

class Parser extends Controller
{
    protected $articleService;

    public function __construct(
        ArticleService $articleService
    ) {
        $this->articleService = $articleService;
    }

//    public function get()
//    {
//        return view('welcome', ['articles' => $this->articleService->selectArticles()]);
//    }

    public function get()
    {
//        dd(json_encode($this->articleService->selectArticles()->items()));
//        return json_encode($this->articleService->selectArticles()->items());
        return view('welcome', ['articles' => $this->articleService->selectArticles()]);
    }

    public function getParsing()
    {
        $this->insertData($this->articleService->parser());

        return('success');
    }

    public function insertData(array $articlesOneDays)
    {
        $this->articleService->insert($articlesOneDays);
    }
}
