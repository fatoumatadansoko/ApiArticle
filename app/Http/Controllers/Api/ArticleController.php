<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //La méthode index pour renvoyer tous les articles
        return Article::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //elle permet de créer un nouvel article en validant d'abord les données de la requete 
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);
        return Article::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $article = Article::findOrFail($id);
    
        return response()->json($article, 200);
    }
       

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //permet de modifier un article existant
        $article = Article::find($id);
        if(!$article){
            return response()->json(['message' => 'article non trouvé'], 404);
        }
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);
        $article->update($request->all());
        return response()->json(['message' => 'article modifié avec succès ', 'article'=>$article ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return response()->json(null, 204);    }
}
