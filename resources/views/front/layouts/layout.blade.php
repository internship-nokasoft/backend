<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('page/css/style.css') }}">
</head>

<body>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <div id="wrapper">


        <div id="checkout">
            CHECKOUT
        </div>

        <div id="header">
            <ul>
                <li style="float:left;"><a href="{{ route('home') }}">Home</a></li>
                <li style="float:left;"><a href="">BRANDS</a></li>
                <li style="float:left;"><a href="">DESIGNERS</a></li>
                <li style="float:left;"><a href="">CONTACT</a></li>
                <li style="float:left;">
                    <form action="{{route('home')}}" method="get">
                        <input type="text" name="search" placeholder="Enter your search">
                        <button type="submit">Search</button>
                    </form>
                </li>
            </ul>

            @if (Auth::guard('member')->check())
                <li style="float: right;"><a href="{{ route('logout.member') }}">Logout</a></li>
            @else
                <li style="float: right;"><a href="{{ route('login.member') }}">Login</a></li>
            @endif

            <li style="float: right;"><a href="{{ route('cart') }}"><i
                        class="fa-solid fa-cart-shopping fa-xl"></i></i></a></li>

        </div>



        <div class="main-content">
            @yield('content')
        </div>

    </div>

    <footer class="credit">Author: shipra - Distributed By: <a title="Awesome web design code & scripts"
            href="https://www.codehim.com?source=demo-page" target="_blank">CodeHim</a></footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- partial -->
    <script src="{{ asset('page/js/script.js') }}"></script>

</body>

</html>
