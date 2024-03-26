<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Shopping Cart</title>
</head>

<body>
    <h1>Your Shopping Cart</h1>

    @if (count($cart) > 0)
        <ul>
            @foreach ($cart as $itemId => $item)
                <li>
                    <h2>{{ $item['name'] }}</h2>
                    <p>Price: ${{ $item['price'] }}</p>
                    <span>Quantity:</span>
                    <form action="{{ route('cart.update', $itemId) }}" method="POST" class="inline-flex">
                        @csrf
                        <button type="submit" name="operation" value="decrement">-</button>
                        <input type="number" name="quantity" min="1" value="{{ $item['quantity'] }}">
                        <button type="submit" name="operation" value="increment">+</button>
                    </form>
                    <form action="{{ route('cart.remove', $itemId) }}" method="POST" class="inline-flex">
                        @csrf
                        <button type="submit">Remove</button>
                    </form>
                </li>
            @endforeach
        </ul>
        <p>Total Price: ${{ $total }}</p>
    @else
        <p>Your shopping cart is empty!</p>
    @endif
    <a href="{{ route('welcome') }}">Continue Shopping</a>
</body>

</html>
