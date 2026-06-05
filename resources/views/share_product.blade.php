<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $product->name }}</title>

    <meta property="og:title" content="{{ $product->name }}" />
    <meta property="og:description" content="{{ $firstSentence }}" />
    <meta property="og:image" content="{{ $image }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="product" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $product->name }}" />
    <meta name="twitter:description" content="{{ $firstSentence }}" />
    <meta name="twitter:image" content="{{ $image }}" />

    {{-- Redirect users to the public product page after scrapers read the meta tags --}}
    <meta http-equiv="refresh" content="0;url={{ url('/product/show/' . $product->id) }}">
    <script>window.location.href = "{{ url('/product/show/' . $product->id) }}";</script>
</head>
<body>
    Redirection...
</body>
</html>
