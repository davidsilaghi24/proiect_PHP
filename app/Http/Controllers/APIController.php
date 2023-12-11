<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Journalist;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class APIController extends Controller
{
    // Constructor pentru a adăuga middleware-ul de autentificare, dacă este necesar
    public function __construct()
    {
        // $this->middleware('auth:api');
    }

    // Metoda pentru listarea tuturor articolelor
    public function getAllArticles()
    {
        $articles = Article::all();
        return response()->json($articles);
    }

    // Metoda pentru afișarea unui articol specific
    public function getArticle($id)
    {
        $article = Article::find($id);
        if ($article) {
            return response()->json($article);
        } else {
            return response()->json(['message' => 'Articolul nu a fost găsit'], Response::HTTP_NOT_FOUND);
        }
    }

    // Metoda pentru crearea unui nou articol
    public function createArticle(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'journalist_id' => 'required|exists:journalists,id'
        ]);

        $article = Article::create($validatedData);
        return response()->json($article, Response::HTTP_CREATED);
    }

    // Metoda pentru actualizarea unui articol existent
    public function updateArticle(Request $request, $id)
    {
        $article = Article::find($id);
        if (!$article) {
            return response()->json(['message' => 'Articolul nu a fost găsit'], Response::HTTP_NOT_FOUND);
        }

        $validatedData = $request->validate([
            'title' => 'sometimes|required|max:255',
            'content' => 'sometimes|required',
            'category_id' => 'sometimes|required|exists:categories,id'
        ]);

        $article->update($validatedData);
        return response()->json($article);
    }

    // Metoda pentru ștergerea unui articol
    public function deleteArticle($id)
    {
        $article = Article::find($id);
        if (!$article) {
            return response()->json(['message' => 'Articolul nu a fost găsit'], Response::HTTP_NOT_FOUND);
        }

        $article->delete();
        return response()->json(['message' => 'Articolul a fost șters'], Response::HTTP_OK);
    }

    // Metoda pentru listarea tuturor categoriilor
    public function getAllCategories()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    // Metoda pentru listarea articolelor unui jurnalist specific
    public function getArticlesByJournalist($journalistId)
    {
        $journalist = Journalist::find($journalistId);
        if ($journalist) {
            $articles = $journalist->articles;
            return response()->json($articles);
        } else {
            return response()->json(['message' => 'Jurnalistul nu a fost găsit'], Response::HTTP_NOT_FOUND);
        }
    }
}
