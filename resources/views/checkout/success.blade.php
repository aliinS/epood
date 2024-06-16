<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout success!</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <h1>Payment Successful!</h1>
    <p>Thank you for your purchase. Your order has been successfully processed.</p>
    <button type="button" onclick="window.location='{{ route('welcome') }}'" class="block bg-blue-500 text-white px-4 py-1 rounded-full hover:bg-blue-600 mt-8 text-center">
        Do some more shopping!
    </button>

</body>

</html>
