<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

    </head>
    <body class="antialiased">
    <h1>Product: T-Shirt</h1>
    <h3>Price $20</h3>
    <form action="{{ route('paypal') }}" method="post">
    @csrf
    <input type='hidden' name='price' value=0.02>
    <button>Pay With PayPal</button>
    </form>
    </body>
</html>
