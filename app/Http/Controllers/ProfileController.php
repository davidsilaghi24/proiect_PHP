<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Journalist; // sau modelul corespunzător
use App\Models\Article;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        // Verifică dacă utilizatorul este jurnalist sau editor
        if (!$user->hasAnyRole(['jurnalist', 'editor'])) {
            abort(403, 'Nu aveți permisiunea de a accesa această pagină.');
        }

        return view('profile.edit', [
            'user' => $user,
            // presupunem că 'profile.edit' este calea către view-ul profilului
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Actualizează profilul utilizatorului
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            // Presupunem că dorim să retrimitem email-ul de verificare dacă email-ul a fost schimbat
            $user->sendEmailVerificationNotification();
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'Profil actualizat cu succes!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Asigură-te că utilizatorul este jurnalist sau editor
        if (!$user->hasAnyRole(['jurnalist', 'editor'])) {
            abort(403, 'Nu aveți permisiunea de a efectua această acțiune.');
        }

        Auth::logout();

        // Aici, de exemplu, ștergem toate articolele asociate cu jurnalistul/editorul
        Article::where('journalist_id', $user->id)->delete();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/')->with('status', 'Cont șters cu succes!');
    }

    /**
     * Display the articles written by the journalist.
     */
    public function showArticles(Request $request): View
    {
        $user = $request->user();

        // Verifică dacă utilizatorul este jurnalist
        if (!$user->hasRole('jurnalist')) {
            abort(403, 'Doar jurnaliștii pot vedea această pagină.');
        }

        $articles = Article::where('journalist_id', $user->id)->get();

        return view('journalist.articles', [
            'articles' => $articles
            // presupunem că 'journalist.articles' este calea către view-ul cu articolele jurnalistului
        ]);
    }
}
