<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Store</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

    <div class="container mx-auto py-4">
        <nav class="flex items-center justify-between bg-white shadow-md px-4 py-3 ">
            <div class="flex items-center">
                <a href="{{ route('welcome') }}" class="text-lg font-semibold flex items-center"><x-heroicon-s-arrow-long-left class="h-5 w-5 mr-1" />back</a>
            </div>
            <div class="flex items-center">
                <a href="{{ route('random.product') }}"
                    class="text-lg font-semibold flex items-center"><x-rpg-perspective-dice-random
                        class="h-10 w-10 mr-1" />Random pick</a>
            </div>
            <div class="flex items-center">
                <a href="{{ route('cart.view') }}" class="text-lg font-semibold flex items-center"><x-typ-shopping-cart
                        class="h-5 w-5 mr-1" />Shopping Cart</a>
            </div>
        </nav>
    </div>

    <div class="container mx-auto py-8 px-4 sm:px-8 md:px-16 lg:px-24 xl:px-32">
        <div class="bg-white rounded-lg shadow-md overflow-hidden flex">
            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-1/2 h-auto object-cover">
            <div class="p-4 w-1/2">
                <h1 class="text-3xl font-semibold mb-4">{{ ucfirst($product->name) }}</h1>
                <p class="text-gray-600 mb-4">{{ $product->description }}</p>
                <p class="text-gray-800 font-semibold">Price: {{ $product->price }}€</p>
                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf
                    <label for="quantity" class="block">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" value="1" min="1"
                        max="{{ $product->quantity }}" class="w-16 px-2 py-1 border rounded-md mb-4">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add to
                        Cart</button>
                </form>

            </div>
        </div>
    </div>
</body>

</html>
