@extends('front.layouts.layout');

@section('title')
    Detail
@endsection

@section('content')

    <link href="{{ asset('front/img/favicon.ico') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('front/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('front/css/style.css') }}" rel="stylesheet">
    <!-- Cart Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-bordered text-center mb-0">
                    <thead class="bg-secondary text-dark">
                        <tr>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Size</th>
                            <th>Color</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Update</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @if (Auth::guard('member')->check())
                            @php
                                $alltotal = 0;
                                $total = 0;
                            @endphp

                            @foreach ($cartInfo as $cartItem)
                                @php
                                    $productInfo = App\Models\Product::find($cartItem->product_id);
                                    $total += $productInfo->price * $cartItem->quantity;
                                @endphp
                                <tr>
                                    <td class="align-middle"><a
                                            href="{{ route('detail', [$cartItem->product_id, $productInfo->slug]) }}"><img
                                                src="{{ asset($productInfo->product_img) }}"
                                                alt=""style="width: 50px;"></a>
                                        {{ $productInfo->product_name }}</td>
                                    <td class="align-middle">@money($productInfo->price)</td>
                                    <td class="align-middle">{{ $cartItem->size }}</td>
                                    <td class="align-middle">{{ $cartItem->color }}</td>
                                    <td class="align-middle">{{ $cartItem->quantity }}</td>
                                    <td class="align-middle">@money($total)</td>
                                    <td class="align-middle"><button class="btn btn-sm btn-primary"
                                            onclick="window.location='{{ route('show.cart.update', $cartItem->id) }}'">
                                            <i class="far fa-edit"></i></button>
                                    </td>
                                    <td class="align-middle"><button class="btn btn-sm btn-primary"
                                            onclick="window.location='{{ route('removeitem', $cartItem->id) }}'">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                                @php
                                    $total = 0;
                                @endphp
                            @endforeach

                            @foreach ($cartInfo as $cartItem)
                                @php
                                    $productInfo = App\Models\Product::find($cartItem->product_id);
                                    $productTotal = $productInfo->price * $cartItem->quantity;
                                    $alltotal += $productTotal;
                                @endphp
                            @endforeach
                        @else
                            @php
                                $alltotal = 0;
                            @endphp
                            @if (session('cart'))
                                @php
                                    $total = 0;
                                @endphp
                                @foreach (session('cart') as $detail)
                                    @php $total += $detail['price'] * $detail['quantity'] @endphp
                                    <tr>
                                        <td class="align-middle"><a
                                                href="{{ route('detail', [$detail['product_id'], $detail['slug']]) }}"><img
                                                    src="{{ asset($detail['img']) }}"
                                                    alt=""style="width: 50px;"></a>
                                            {{ $detail['name'] }}</td>
                                        <td class="align-middle">@money($detail['price'])</td>
                                        <td class="align-middle">{{ $detail['size'] }}</td>
                                        <td class="align-middle">{{ $detail['color'] }}</td>
                                        <td class="align-middle">{{ $detail['quantity'] }}</td>
                                        <td class="align-middle">@money($total)</td>
                                        <td class="align-middle"><button class="btn btn-sm btn-primary"
                                                onclick="window.location='{{ route('show.cart.update', $detail['product_id']) }}'">
                                                <i class="far fa-edit"></i></button>
                                        </td>
                                        <td class="align-middle"><button class="btn btn-sm btn-primary"
                                                onclick="window.location='{{ route('removeitem', $detail['product_id']) }}'">
                                                <i class="fa fa-times"></i></button>
                                        </td>
                                    </tr>
                                    @php
                                        $total = 0;
                                    @endphp
                                @endforeach

                                @foreach (session('cart') as $detail)
                                    @php
                                        $productTotal = $detail['price'] * $detail['quantity'];
                                        $alltotal += $productTotal;
                                    @endphp
                                @endforeach
                            @endif
                        @endif



                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Cart Summary</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium">Subtotal</h6>
                            <h6 class="font-weight-medium">@money($alltotal)</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Shipping</h6>
                            <h6 class="font-weight-medium">@money(10000)</h6>
                        </div>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Total</h5>
                            <h5 class="font-weight-bold">@money($alltotal + 10000)</h5>
                        </div>
                        <button class="btn btn-block btn-primary my-3 py-3">Proceed To Checkout</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->


    {{-- <script type="text/javascript">
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
    </script> --}}
@endsection
