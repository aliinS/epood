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
        <nav class="flex items-center justify-between bg-white shadow-md px-4 py-3">
            <div>
                <a href="{{ route('welcome') }}" class="text-lg font-semibold">Welcome</a>
            </div>
            <div class="flex items-center">
                <a href="{{ route('random.product') }}"
                    class="text-lg font-semibold flex items-center"><x-rpg-perspective-dice-random
                        class="h-10 w-10 mr-1" />Random dick pic</a>
            </div>
            <div class="flex items-center">
                <a href="{{ route('cart.view') }}" class="text-lg font-semibold flex items-center"><x-typ-shopping-cart
                        class="h-5 w-5 mr-1" />Shopping Cart</a>
            </div>
        </nav>
    </div>

    <div class="container mx-auto py-8 px-4 sm:px-8 md:px-16 lg:px-24 xl:px-32">
        <h1 class="text-3xl font-semibold mb-8 text-center">Welcome to Our Store</h1>

        @if (count($products) > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @foreach ($products as $product)
                    <a href="{{ route('product.detail', $product->id) }}" class="block hover:no-underline">
                        <div class="bg-white rounded-lg shadow-md overflow-hidden cursor-pointer">
                            
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                class="w-full h-56 object-cover">

                            <div class="p-4">
                                <h2 class="text-xl font-semibold mb-2">{{ ucfirst($product->name) }}</h2>
                                <p class="text-gray-800 font-semibold">{{ $product->price }}€</p>
                            </div>

                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full mx-auto block mb-4">
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <p class="text-center text-gray-600">No products available yet!</p>
        @endif
    </div>
</body>

</html>
