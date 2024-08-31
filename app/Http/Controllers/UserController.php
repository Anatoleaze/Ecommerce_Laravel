<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\ModifyUserDataMail;
use Illuminate\Support\Facades\Mail;
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

        $link = config('app.url');

        return view('update_profil',['user' =>$data, 'link'=>$link]);
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
    public function addNewsLetter(Request $request){
        
        $link = config('app.url');

        // Check email 
        $data = $request->validate([
            'email' => 'required|email|max:255',
        ]);

        
        $email = $data['email'];
        
        // Check if email exist
        $existingUser = User::where('email', $email)->first();
        
        if ($existingUser) {

            return redirect()->route('home', ['link'=>$link])->with('message', 'Cet email est déjà utilisé.');
        }

        // Creation of User
        $user = new User();
        $user->name = "";
        $user->first_name = "";
        $user->email = $email;
        $user->password = Hash::make("password");
        
        // Save User 
        $user->save();

        return redirect()->route('home',['link'=>$link])->with('message', 'Vous avez été ajouté à la newsletter !');
    }

}
