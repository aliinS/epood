<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <title>Your Shopping Cart</title>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto py-4">
        <nav class="flex items-center justify-between bg-white shadow-md px-4 py-3">
            <div class="flex items-center">
                <a href="{{ route('welcome') }}"
                    class="text-lg font-semibold flex items-center"><x-heroicon-s-arrow-long-left
                        class="h-5 w-5 mr-1" />back</a>
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

    <div class="container mx-auto py-8 px-4 sm:px-8 md:px-16 lg:px-24 xl:px-32 bg-gray-100 rounded shadow-md">
        <h1 class="text-3xl font-semibold mb-6 text-center">Your Shopping Cart</h1>
        @if (count($cart) > 0)
            <ul class="divide-y divide-gray-300">
                @foreach ($cart as $itemId => $item)
                    <li class="py-4 flex flex-col md:flex-row items-center justify-between border-b border-gray-300">
                        <div class="flex items-center w-full md:w-3/4">
                            <div class="flex-grow">
                                <h2 class="text-xl font-semibold">{{ ucfirst($item['name']) }}</h2>
                                <p class="text-gray-600">Price: {{ $item['price'] }}€</p>
                            </div>
                        </div>
                        <div class="flex items-center text-right w-full md:w-1/4 mt-4 md:mt-0">
                            <form action="{{ route('cart.update', $itemId, ) }}" method="POST" class="inline-flex mr-4">
                                @csrf
                                <button type="submit" name="operation" value="decrement"
                                    class="bg-gray-200 text-gray-600 px-2 py-1 rounded-full hover:bg-gray-300">
                                    <x-zondicon-minus-outline class="h-4 w-4" />
                                </button>
                                <input type="number" name="quantity" min="1" value="{{ $item['quantity'] }}"
                                    class="w-12 text-center border border-gray-300 rounded-md">
                                <button type="submit" name="operation" value="increment"
                                    class="bg-gray-200 text-gray-600 px-2 py-1 rounded-full hover:bg-gray-300">
                                    <x-antdesign-plus-circle-o class="h-4 w-4" />
                                </button>
                            </form>
                            <form action="{{ route('cart.remove', $itemId) }}" method="POST" class="inline-flex">
                                @csrf
                                <button type="submit"
                                    class="bg-red-500 text-white px-4 py-1 rounded-full hover:bg-red-600">Remove</button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
            <p class="text-xl font-semibold mt-8 text-right">Total Price: {{ $total }}€</p>
        @else
            <p class="text-lg text-center">Your shopping cart is currently empty!</p>
        @endif
        <div class="flex justify-between">
            <button type="button" onclick="window.location='{{ route('welcome') }}'" class="block bg-blue-500 text-white px-4 py-1 rounded-full hover:bg-blue-600 mt-8 text-center">
                Continue Shopping
            </button>
            
            <button type="button" onclick="window.location='{{ route('checkout') }}'" class="block border border-green-200 bg-green-100 text-black px-4 py-1 rounded-full hover:bg-green-200 mt-8 text-center">
                Proceed to checkout
            </button>
            
        </div>
        
    </div>
    
</body>

</html>
