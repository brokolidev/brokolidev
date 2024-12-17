<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function index(): Application|Factory|View|\Illuminate\Foundation\Application
    {
        $articles = Article::latest()->simplePaginate(6);

        return view('article.index', ['articles' => $articles]);
    }

    /**
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * @param Request $request
     *
     * @return void
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * @param Article $article
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function show(Article $article): \Illuminate\Foundation\Application|View|Factory|Application
    {
        return view('article.show', ['article' => $article]);
    }

    /**
     * @param $id
     *
     * @return void
     */
    public function edit($id)
    {
        //
    }

    /**
     * @param Request $request
     * @param         $id
     *
     * @return void
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * @param $id
     *
     * @return void
     */
    public function destroy($id)
    {
        //
    }
}
