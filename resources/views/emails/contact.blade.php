@extends('emails.layout')

@section('title', 'Nouveau message de contact')

@section('content')
    <h2 style="margin-top:0; font-size:22px;">Nouveau message reçu</h2>
    <p>Vous avez reçu un nouveau message depuis le formulaire de contact.</p>
    <p><strong>Expéditeur :</strong> {{ $contactData['email'] }}</p>
    <p><strong>Message :</strong></p>
    <div style="background-color:#f6f8fb; border-radius:8px; padding:16px; margin-top:12px; color:#2e3a4a;">
        {{ $contactData['message'] }}
    </div>
@endsection
