<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout error!</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <h1>Payment Error</h1>
    <p>Sorry, there was an error processing your payment. Please try again later or contact support.</p>

    <button type="button" onclick="window.location='{{ route('cart.view') }}'" class="block bg-blue-500 text-white px-4 py-1 rounded-full hover:bg-blue-600 mt-8 text-center">
        Try going back to the shopping cart
    </button>

    <button type="button" onclick="window.location='{{ route('welcome') }}'" class="block bg-blue-500 text-white px-4 py-1 rounded-full hover:bg-blue-600 mt-8 text-center">
        or going back to the main page
    </button>

</body>

</html>
