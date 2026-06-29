<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\ModifyUserDataMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    //
    public function index()
    {
        $user = auth()->user()->load('address');

        return view('profils', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $user = auth()->user()->load('address');

        return view('update_profil', [
            'user' => $user
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'first_name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $user->id,

            'password' => 'nullable|string|min:8|confirmed',

            'address.street' => 'nullable|string|max:255',
            'address.additional_address' => 'nullable|string|max:255',
            'address.postal_code' => 'nullable|string|max:20',
            'address.city' => 'nullable|string|max:255',
            'address.country' => 'nullable|string|max:255',
            'address.phone' => 'nullable|string|max:30',
        ], [
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        DB::transaction(function () use ($request, $user) {

            // -------------------------
            // Mise à jour utilisateur
            // -------------------------

            $user->fill([
                'name' => $request->name ?? $user->name,
                'first_name' => $request->first_name ?? $user->first_name,
                'email' => $request->email ?? $user->email,
            ]);

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            // -------------------------
            // Mise à jour de l'adresse
            // -------------------------

            if ($request->has('address')) {

                $user->address()->updateOrCreate(
                    [],
                    [
                        'street' => $request->input('address.street'),
                        'additional_address' => $request->input('address.additional_address'),
                        'postal_code' => $request->input('address.postal_code'),
                        'city' => $request->input('address.city'),
                        'country' => $request->input('address.country'),
                        'phone' => $request->input('address.phone'),
                    ]
                );
            }
        });

        $contactData = [
            'nom' => $user->name,
            'prenom' => $user->first_name,
            'mail' => $user->email,
            'site' => config('app.name'),
        ];

        Mail::to($user->email)->send(new ModifyUserDataMail($contactData));

        return response()->json([
            'message' => 'Informations mises à jour avec succès.'
        ]);
    }

    /**
     * Add User in newletters
     */
    public function addNewsLetter(Request $request)
    {

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
