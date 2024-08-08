<?php

namespace App\Http\Controllers;

use App\Models\Burger;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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

    public function reactive()
    {
        try {
            $burgers = Burger::where('is_active', 0)->get();
    
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

    public function show($id){
        $burger = Burger::findOrFail($id);
        return response()->json($burger,201);
    }

    public function update(Request $request, $id)
    {
        try {

            Log::info('Données reçues pour mise à jour:', $request->all());
            // Trouver le burger par ID ou lancer une exception si non trouvé
            $burger = Burger::findOrFail($id);

            Log::info('Données reçues pour mise à jour:', $request->all());
            // Validation des données
            $validatedData = $request->validate([
                'name' => 'string|max:255',
                'price' => 'required|numeric',
                'description' => 'required|string',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validation de l'image
            ]);

            // Mise à jour des données
            $burger->name = $validatedData['name'];
            $burger->price = $validatedData['price'];
            $burger->description = $validatedData['description'];

            // Traitement de l'image si fournie
            if ($request->hasFile('image')) {
                // Supprimer l'ancienne image si elle existe
                if ($burger->image && Storage::exists($burger->image)) {
                    Storage::delete($burger->image);
                }

                // Enregistrer la nouvelle image
                $image = $request->file('image');
                $imagePath = $image->store('images', 'public'); // Stocker l'image dans le répertoire public/images
                $burger->image = $imagePath;
            }

            // Sauvegarder les modifications dans la base de données
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

    
public function restore($id)
{
    try {
        $burger = Burger::findOrFail($id);
        $burger->is_active = true; // Marquer le burger comme actif
        $burger->save();

        return response()->json([
            'status_code' => 200,
            'status_message' => 'Burger réactivé avec succès',
            'data' => $burger
        ]);
    } catch (Exception $e) {
        return response()->json([
            'status_code' => 500,
            'status_message' => 'Erreur lors de la réactivation du burger',
            'error' => $e->getMessage()
        ], 500);
    }
}



    

}
