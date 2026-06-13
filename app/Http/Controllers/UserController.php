<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\ModifyUserDataMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class UserController extends Controller {
    //

    public function index(){
        // Mise à jour de l'utilisateur authentifié
        $user = auth()->user();

        return view('profils', ['user' =>$user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(){
        $user = auth()->user();
        $data = [
            'name' => $user->name,
            'first_name' => $user->first_name,
            'email' => $user->email,
        ];

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
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'password.string' => 'Le mot de passe doit être une chaîne de caractères.',
        ]);

        
        if ($validator->fails()) {
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
            $user->password = Hash::make($request->password);
        }
       
        $user->save();

        $contactData = [
            'nom' => $user->name,
            'prenom' => $user->first_name,
            'mail' => $user->email,
            'site' => config('app.name')
        ];
        Mail::to($user->email)->send(new ModifyUserDataMail($contactData));
        
        return response()->json(['message' => 'Informations mises à jour avec succès.']);
    }

    /**
     * Add User in newletters
     */
    public function addNewsLetter(Request $request) {
   
        $data = $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $email = $data['email'];

        $existingUser = User::where('email', $email)->first();

        if ($existingUser) {
            return back()->with('message', 'Cet email est déjà utilisé.');
        }

        $user = new User();
        $user->name = "";
        $user->first_name = "";
        $user->email = $email;
        $user->password = Hash::make("password");

        $user->save();

        return back()->with('message', 'Vous avez été ajouté à la newsletter !');
    }

}
