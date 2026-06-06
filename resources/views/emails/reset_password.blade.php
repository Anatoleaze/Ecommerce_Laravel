@extends('emails.layout')

@section('title', 'Réinitialisation de votre mot de passe')

@section('content')
    <h2 style="margin-top:0; font-size:22px;">Bonjour {{ $notifiable->name ?? 'Utilisateur' }},</h2>
    <p>Vous recevez cet e-mail car nous avons reçu une demande de réinitialisation du mot de passe pour votre compte.</p>
    <div style="margin:24px 0; text-align:center;">
        <a href="{{ $actionUrl }}" style="display:inline-block; background-color:#2f64e9; color:#ffffff; text-decoration:none; padding:12px 24px; border-radius:8px; font-weight:600;">Réinitialiser le mot de passe</a>
    </div>
    <p>Ce lien expirera dans {{ $count }} minutes.</p>
    <p>Si vous n'avez pas demandé la réinitialisation, aucune action supplémentaire n'est requise.</p>
@endsection
