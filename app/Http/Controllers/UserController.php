<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    //

    public function index(){
        // Mise à jour de l'utilisateur authentifié
        $user = auth()->user();

        return view('profils', ['user' =>$user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $user = auth()->user();
        $data = [
            'name' => $user->name,
            'first_name' => $user->first_name,
            'email' => $user->email,

        ];
       // dd($data);

        return view('update_profil',['user' =>$data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request) {

         // Validation des données
         $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'first_name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . auth()->id(),
            'password' => 'nullable|string|min:8',
        ]);

        
        if ($validator->fails()) {
            Log::debug('Validation failed');
            Log::debug($validator->errors());
            return response()->json(['errors' => $validator->errors()], 422);

        }
        
        // Mise à jour de l'utilisateur authentifié
        $user = auth()->user();
        
        
        if ($request->filled('name')) {
            $user->name = $request->name;
        }
        if ($request->filled('first_name')) {
            $user->first_name = $request->first_name;
        }
        if ($request->filled('email')) {
            $user->email = $request->email;
        }
        if ($request->filled('password')) {
         
            if ($request->filled('password') == $request->filled('confirm')){
         
                $user->password = Hash::make($request->password);
         
            }else{
         
                return response()->json(['message' => 'Votre mot de passe est différent du mot de passe de confirmation'], 200);
         
            }
        
        }
       
        $user->save();

        return response()->json(['message' => 'Informations mises à jour avec succès.']);
    }

}
