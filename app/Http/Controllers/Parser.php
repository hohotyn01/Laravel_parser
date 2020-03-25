<?php

namespace App\Http\Controllers;

use App\Services\ArticleService;
use App\Services\ArticleTsnService;

class Parser extends Controller
{
    protected $articleService;
    protected $articleTsnService;

    public function __construct(
        ArticleService $articleService,
        ArticleTsnService $articleTsnService
    ) {
        $this->articleService = $articleService;
        $this->articleTsnService = $articleTsnService;
    }

    public function get()
    {
        return view('welcome', ['articles' => $this->articleService->selectArticles()]);
    }

    public function parsingCorespondent()
    {
        try {
            $allDataCorespondent = $this->articleService->parser();
        }catch (\Exception $e){
            dd('Parsing failed');
        }

        $this->articleService->insert($allDataCorespondent);

        dump ('success');
    }

    public function getTsn()
    {
        return view('welcome', ['articles' => $this->articleTsnService->selectArticles()]);
    }

    public function parsingTsn()
    {
        try {
            $allDataTsn = $this->articleTsnService->parser();
        }catch (\Exception $e){
            dd('Parsing failed');
        }

        $this->articleTsnService->insert($allDataTsn);

        dump ('success');
    }
}
