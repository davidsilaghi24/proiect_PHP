<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;

class HomeController extends Controller
{
    // Afișează pagina principală a site-ului
    public function index()
    {
        $articles = Article::latest()->take(10)->get(); // Afișează ultimele 10 articole
        $categories = Category::all(); // Obține toate categoriile

        return view('home', compact('articles', 'categories'));
    }

    // Afișează articolele dintr-o anumită categorie
    public function showCategory($category_id)
    {
        $category = Category::findOrFail($category_id);
        $articles = Article::where('category_id', $category_id)->get();

        return view('category.show', compact('category', 'articles'));
    }

    // Afișează detalii despre un anumit articol
    public function showArticle($article_id)
    {
        $article = Article::findOrFail($article_id);

        return view('article.show', compact('article'));
    }

    // Caută articole bazate pe un cuvânt cheie
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $articles = Article::where('title', 'like', '%' . $keyword . '%')->get();

        return view('search.results', compact('articles', 'keyword'));
    }
}
