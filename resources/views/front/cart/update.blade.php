@extends('front.layouts.layout');

@section('title')
    Detail
@endsection

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('front/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('/frontcss/style.css') }}" rel="stylesheet">
    <!-- content -->
    <section class="py-5">
        <div class="container">
            <form action="{{ route('cart.update') }}" method="POST">
                @csrf
                <div class="col-lg-8 table-responsive mb-5">
                    <table class="table table-bordered text-center mb-0">
                        <thead class="bg-secondary text-dark">
                            <tr>
                                <th>Products</th>
                                <th>Price</th>
                                <th>Size</th>
                                <th>Color</th>
                                <th>Quantity</th>
                                <th>Update</th>
                            </tr>
                        </thead>
                        <tbody class="align-middle">
                            @if (Auth::guard('member')->check())
                                <tr>
                                    <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                    <input type="hidden" name="id" value="{{ $item->id }}">
                                    <td class="align-middle"><a
                                            href="{{ route('detail', [$item->product_id, $productInfo->slug]) }}"><img
                                                src="{{ asset($productInfo->product_img) }}" alt=""style="width: 50px;"></a>
                                        {{ $productInfo->name }}</td>
                                    <td class="align-middle">@money($productInfo->price)</td>
                                    <td class="align-middle">{{ $item->size }}</td>
                                    <td class="align-middle">{{ $item->color }}</td>
                                    <td class="align-middle">
                                        <div class="input-group" style="width: 150px;">
                                            <button class="btn btn-primary" type="button" onclick="decrementValue()">
                                                <i class="fa fa-minus"></i>
                                            </button>

                                            <input type="text" id="number" name="quantity"
                                                class="form-control  text-center" value="{{ $item->quantity }}">

                                            <button class="btn btn-primary" type="button" onclick="incrementValue()">
                                                <i class="fa fa-plus"></i>
                                            </button>

                                        </div>
                                    </td>

                                    <td class="align-middle">
                                        <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                    </td>
                                </tr>
                            @else
                                @if (session('cart'))
                                    <tr>
                                        <input type="hidden" name="product_id" value="{{ $product['product_id'] }}">
                                        <td class="align-middle"><a
                                                href="{{ route('detail', [$product['product_id'], $product['slug']]) }}"><img
                                                    src="{{ asset($product['img']) }}"
                                                    alt=""style="width: 50px;"></a>
                                            {{ $product['name'] }}</td>
                                        <td class="align-middle">@money($product['price'])</td>
                                        <td class="align-middle">{{ $product['size'] }}</td>
                                        <td class="align-middle">{{ $product['color'] }}</td>
                                        <td class="align-middle">
                                            <div class="input-group" style="width: 150px;">
                                                <button class="btn btn-primary" type="button" onclick="decrementValue()">
                                                    <i class="fa fa-minus"></i>
                                                </button>

                                                <input type="text" id="number" name="quantity"
                                                    class="form-control  text-center" value="{{ $product['quantity'] }}">

                                                <button class="btn btn-primary" type="button" onclick="incrementValue()">
                                                    <i class="fa fa-plus"></i>
                                                </button>

                                            </div>
                                        </td>

                                        <td class="align-middle">
                                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                        </td>
                                    </tr>
                                @endif
                            @endif

                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </section>
    <!-- content -->

    <script type="text/javascript">
        function incrementValue() {
            var value = parseInt(document.getElementById('number').value, 10);
            value = isNaN(value) ? 0 : value;
            if (value < 20) {
                value++;
                document.getElementById('number').value = value;
            }
        }

        function decrementValue() {
            var value = parseInt(document.getElementById('number').value, 10);
            value = isNaN(value) ? 0 : value;
            if (value > 1) {
                value--;
                document.getElementById('number').value = value;
            }

        }
    </script>
@endsection
