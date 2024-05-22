<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Store</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <!-- Payment Form -->
    <h1 class="font-bold mt-10 text-center text-4xl">Checkout</h1>
    <div class="container mx-auto px-4 mt-10 grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="border-r">
            <div>
                <h2 class="text-xl font-semibold mb-4">Order Details:</h2>
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
                <button type="button" onclick="window.location='{{ route('cart.view') }}'" class="block bg-blue-500 text-white px-4 py-1 rounded-full hover:bg-blue-600 mt-8 text-center">
                    Back to cart
                </button>
            </div>
        </div>
        <div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success_message'))
                    <div class="alert alert-success">
                        {{ session('success_message') }}
                    </div>
                @endif

                <form action="{{ route('checkout.process') }}" method="post" id="payment-form">
                    @csrf

                    <div class="mb-4">
                        <div>
                            <h2 class="text-xl font-semibold mb-4">Payment details:</h2>
                        </div>
                        <label for="card-element" class="block">Email: </label>
                        <input type="email" placeholder="example@gmail.com" class="bg-gray-100 p-1 italic border-slate-100 border">
                        </div>
                        <label for="card-element" class="block">Credit or debit card info:</label>
                        <div id="card-element" class="mt-2 border border-slate-500 p-2">
                            <!-- A Stripe Element will be inserted here. -->
                        </div>
                        
                        <div id="card-errors" role="alert"></div>
                    </div>

                    <button type="submit"
                        class="block border border-green-200 bg-green-100 text-black px-4 py-1 rounded-full hover:bg-green-400 mt-8 mx-auto md:mx-0 w-full md:w-auto"
                        id="submit-button">Pay now</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Stripe JavaScript -->
    <script src="https://js.stripe.com/v3/"></script>

    <script>
        // Create a Stripe client.
        var stripe = Stripe('{{ env('STRIPE_KEY') }}');

        // Create an instance of Elements.
        var elements = stripe.elements();

        // Custom styling can be passed to options when creating an Element.
        var style = {
            base: {
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };

        // Create an instance of the card Element.
        var card = elements.create('card', {
            style: style
        });

        // Add an instance of the card Element into the `card-element` div.
        card.mount('#card-element');

        // Handle real-time validation errors from the card Element.
        card.addEventListener('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        // Handle form submission.
        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            stripe.createToken(card).then(function(result) {
                if (result.error) {
                    // Inform the user if there was an error.
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    // Send the token to your server.
                    stripeTokenHandler(result.token);
                }
            });
        });

        // Submit the form with the token ID.
        function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server.
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

            // Submit the form
            form.submit();
        }
    </script>

</body>

</html>
