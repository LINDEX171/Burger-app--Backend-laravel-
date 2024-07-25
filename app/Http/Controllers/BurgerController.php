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

            return response()->json([
               'status_code'=>200,
               'statu_message'=>'les burgers ont été recuperer',
               'data'=> Burger::all()
               ]);
            } 
            
            catch (Exception $e) {
               return response()->json($e);
           }
    }


     public function store(Request $request)
    {
        try {
            $burger = new Burger();
            $burger->name = $request->input('name');
            $burger->price = $request->input('price');
            $burger->image = $request->input('image');
            $burger->description = $request->input('description');
            $burger->is_active = $request->input('is_active', true); // Default true if not provided

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


    

}
