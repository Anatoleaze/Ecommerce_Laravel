@extends('emails.layout')

@section('title', 'Confirmation de la mise à jour de vos informations personnelles')

@section('content')
    <h2 style="margin-top:0; font-size:22px;">Bonjour {{ $contactData['nom'] }} {{ $contactData['prenom'] }},</h2>
    <p>Nous vous confirmons que les modifications apportées à vos informations personnelles ont bien été prises en compte.</p>
    <p>Si vous n'avez pas effectué ces changements ou si vous avez des questions, n'hésitez pas à nous contacter immédiatement afin que nous puissions examiner la situation.</p>
    <p style="margin-top:24px;">Merci de votre confiance.</p>
@endsection
