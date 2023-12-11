<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    // Metoda pentru listarea tuturor categoriilor
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    // Metoda pentru afișarea formularului de adăugare a unei noi categorii
    public function create()
    {
        return view('categories.create');
    }

    // Metoda pentru salvarea unei noi categorii
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable'
        ]);

        Category::create($validatedData);
        return redirect()->route('categories.index')->with('success', 'Categorie adăugată cu succes.');
    }

    // Metoda pentru afișarea unei categorii specifice
    public function show($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.show', compact('category'));
    }

    // Metoda pentru afișarea formularului de editare a unei categorii
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    // Metoda pentru actualizarea unei categorii
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable'
        ]);

        $category = Category::findOrFail($id);
        $category->update($validatedData);
        return redirect()->route('categories.index')->with('success', 'Categorie actualizată cu succes.');
    }

    // Metoda pentru ștergerea unei categorii
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Categorie ștearsă cu succes.');
    }
}
