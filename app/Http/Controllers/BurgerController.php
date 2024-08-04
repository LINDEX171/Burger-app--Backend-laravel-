<?php

namespace App\Http\Controllers;

use App\Models\Burger;
use Exception;
use Illuminate\Http\Request;

class BurgerController extends Controller
{
    public function index()
    {
        try {
            $burgers = Burger::where('is_active', 1)->get();
    
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Les burgers ont été récupérés avec succès.',
                'data' => $burgers
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Erreur lors de la récupération des burgers.',
                'error' => $e->getMessage()
            ]);
        }
    }
    

    public function store(Request $request)
    {
        try {
            $burger = new Burger();
            $burger->name = $request->input('name');
            $burger->price = $request->input('price');
            $burger->description = $request->input('description');
            $burger->is_active = $request->input('is_active', true); // Default true if not provided
    
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images'), $imageName); // Enregistrer l'image dans le répertoire public/images
                $burger->image = 'images/' . $imageName;
            }
    
            $burger->save();
    
            return response()->json([
                'status_code' => 201,
                'status_message' => 'Burger ajouté avec succès',
                'data' => $burger
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Erreur lors de l\'ajout du burger',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
{
    try {
        $burger = Burger::findOrFail($id);
        $burger->name = $request->input('name', $burger->name);
        $burger->price = $request->input('price', $burger->price);
        $burger->description = $request->input('description', $burger->description);
        $burger->is_active = $request->input('is_active', $burger->is_active);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $burger->image = 'images/' . $imageName;
        }

        $burger->save();

        return response()->json([
            'status_code' => 200,
            'status_message' => 'Burger mis à jour avec succès',
            'data' => $burger
        ], 200);
    } catch (Exception $e) {
        return response()->json([
            'status_code' => 500,
            'status_message' => 'Erreur lors de la mise à jour du burger',
            'error' => $e->getMessage()
        ], 500);
    }
}



public function archive($id)
{
    try {
        $burger = Burger::findOrFail($id);
        $burger->is_active = false; // Marquer le burger comme inactif
        $burger->save();

        return response()->json([
            'status_code' => 200,
            'status_message' => 'Burger archivé avec succès',
            'data' => $burger
        ]);
    } catch (Exception $e) {
        return response()->json([
            'status_code' => 500,
            'status_message' => 'Erreur lors de l\'archivage du burger',
            'error' => $e->getMessage()
        ], 500);
    }
}

    


    

}
