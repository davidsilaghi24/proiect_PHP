<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Journalist;
use App\Models\Article;

class JournalistController extends Controller
{
    // Afișează profilul jurnalistului
    public function showProfile($journalist_id)
    {
        $journalist = Journalist::findOrFail($journalist_id);
        $articles = $journalist->articles;

        return view('journalist.profile', compact('journalist', 'articles'));
    }

    // Afișează formularul pentru editarea profilului
    public function editProfile($journalist_id)
    {
        $journalist = Journalist::findOrFail($journalist_id);

        return view('journalist.edit', compact('journalist'));
    }

    // Actualizează profilul jurnalistului
    public function updateProfile(Request $request, $journalist_id)
    {
        $journalist = Journalist::findOrFail($journalist_id);

        // Validare
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'biography' => 'nullable|string',
        ]);

        // Actualizare
        $journalist->update([
            'name' => $request->name,
            'biography' => $request->biography,
        ]);

        // Actualizarea adresei de email a utilizatorului asociat
        $journalist->user->update([
            'email' => $request->email,
        ]);

        return redirect()->route('journalist.profile', $journalist->id);
    }


    // Afișează articolele încărcate de jurnalist
    public function showArticles($journalist_id)
    {
        $journalist = Journalist::findOrFail($journalist_id);
        $articles = $journalist->articles;

        return view('journalist.articles', compact('journalist', 'articles'));
    }

    // Afișează formularul pentru crearea unui nou articol
    public function createArticle()
    {
        return view('articles.create');
    }

    // Salvează noul articol
    public function storeArticle(Request $request)
    {
        // Validează datele articolului
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id'
        ]);

        // Creează articolul
        Article::create([
            'title' => $request->title,
            'content' => $request->content,
            'journalist_id' => auth()->id(),
            'category_id' => $request->category_id,
            'status' => 'pending' // status implicit
        ]);

        return redirect()->route('journalist.articles', auth()->id());
    }

    // Afișează formularul de editare a unui articol
    public function editArticle($article_id)
    {
        $article = Article::findOrFail($article_id);

        return view('articles.edit', compact('article'));
    }

    // Actualizează articolul
    public function updateArticle(Request $request, $article_id)
    {
        $article = Article::findOrFail($article_id);

        // Validează datele articolului
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id'
        ]);

        // Actualizează articolul
        $article->update([
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $request->category_id
        ]);

        return redirect()->route('journalist.article', $article->id);
    }

    // Șterge un articol
    public function deleteArticle($article_id)
    {
        $article = Article::findOrFail($article_id);
        $article->delete();

        return redirect()->route('journalist.articles', auth()->id());
    }
}
