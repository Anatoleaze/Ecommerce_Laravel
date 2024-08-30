<!DOCTYPE html>
<html>
<head>
    <title>Confirmation de la mise à jour de vos informations personnelles</title>    
</head>
<body>
    <h1>Bonjour {{$contactData['nom'] }} {{$contactData['prenom']}}, </h1>
    <p> Nous vous confirmons que les modifications que vous avez apportées à vos informations personnelles ont été prises en compte avec succès.</p>
    <p> Si vous n'avez pas effectué ces changements ou si vous avez des questions, n'hésitez pas à nous contacter immédiatement afin que nous puissions examiner la situation.
    <p> Merci de votre confiance.</p>
    <br>
    <p>Cordialement,</p>
    <p>L'équipe de {{$contactData['site']}}</p>
</body>
</html>
