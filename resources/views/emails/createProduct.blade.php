<!DOCTYPE html>
<html>
<head>
    <title>Découvrez les dernières nouveautés dans notre boutique !</title>    
</head>
<body>
    <h1>Bonjour {{$contactData['nom'] }} {{$contactData['prenom']}}, </h1>
    <p> Nous avons de bonnes nouvelles ! De nouveaux produits viennent de faire leur entrée dans notre boutique. Vous allez adorer découvrir ces ajouts récents qui enrichissent notre sélection.</p>
    <br>
    <p>✨ Découvrez nos Nouveaux Produits ! ✨</p>
    <br>
    <p> Nous avons élargi notre gamme avec des articles qui, nous en sommes sûrs, seront un ajout parfait à votre collection. Explorez les derniers produits disponibles et trouvez ceux qui vous correspondent.</p>
    <p>Pour découvrir tous nos nouveaux produits, cliquez sur le lien ci-dessous :
        <a href="{{$contactData['link']}}">Voir les nouveaux produits</a>
    </p>
    <p>Nous espérons que ces nouveautés répondront à vos attentes. Comme toujours, notre équipe est là pour vous aider si vous avez des questions ou besoin de plus d'informations.</p>
    <br>
    <p> Merci de votre confiance et de votre fidélité et à bientôt dans notre boutique !</p>
    <br>
    <p>Cordialement,</p>
    <p>L'équipe de {{$contactData['site']}}</p>
</body>
</html>