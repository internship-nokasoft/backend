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
            <form action="{{route('addtocart')}}" method="post">
                @csrf
                <input type="hidden" value="{{ $product->id }}" name="product_id">
                <input type="hidden" value="{{ $product->price }}" name="price">
                <div class="row gx-5">
                    <aside class="col-lg-6">
                        <div class="border rounded-4 mb-3 d-flex justify-content-center show-pic">
                            <a class="rounded-4" data-type="image" id="image-container">
                                <img style="max-width: 100%; max-height: 100vh; margin: auto;" class="rounded-4 fit"
                                    src="{{ asset($product->product_img) }}" />
                            </a>
                        </div>
                        <div class="d-flex justify-content-center mb-3">
                            {{-- @foreach (json_decode($product->list_image, true) as $item)
                                <p class="border mx-1 rounded-2 item-thumb " data-type="image">
                                    <img width="60" height="60" class="rounded-2" src="{{ url($item) }}" />
                                </p>
                            @endforeach --}}
                        </div>
                        <!-- thumbs-wrap.// -->
                        <!-- gallery-wrap .end// -->
                    </aside>
                    <main class="col-lg-6">

                        <div class="ps-lg-3">
                            <h4 class="title text-dark">
                                {{ $product->product_name }}
                            </h4>
                            <div class="d-flex flex-row my-3">

                                <span class="text-muted"><i class="fas fa-shopping-basket fa-sm mx-1"></i>154 orders</span>
                                <span class="text-success ms-2">In stock</span>
                            </div>

                            <div class="mb-3">
                                <span class="h5">@money($product->price)</span>
                            </div>
                            <p>
                                {{-- {{ $product->desc }} --}}
                            </p>
                            <div class="row">
                                <dt class="col-3">Category:</dt>
                                <dt class="col-9"> {{ $product->category_name }}</dd>
                                <div class="col-md-4 col-6">
                                    <label class="mb-2" for="sizes">Sizes</label>
                                    <select class="form-select border border-secondary w-50" style="height: 35px;"
                                        name="size" id="size">
                                        @foreach ($product['size'] as $size)
                                            <option value="{{ $size }}">{{ $size }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <hr />

                            <div class="row mb-4">
                                <div class="col-md-4 col-6">
                                    <label class="mb-2" for="colors">Colors</label>
                                    <select class="form-select border border-secondary" style="height: 35px;" name="color"
                                        id="color">
                                        @foreach ($product['color'] as $color)
                                            <option value="{{ $color }}">{{ $color }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- col.// -->
                                <div class="col-md-4 col-6 mb-3">
                                    <label class="mb-2 d-block">Quantity</label>
                                    <div class="input-group mb-3" style="width: 170px;">
                                        {{-- <button class="btn btn-white border border-secondary px-3" type="button"
                                            id="button-addon1" data-mdb-ripple-color="dark">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input type="text" id="num_order" name="num_order"
                                            class="form-control text-center border border-secondary" value="1"
                                            aria-label="Example text with button addon" />
                                        <button class="btn btn-white border border-secondary px-3" type="button"
                                            id="button-addon2" data-mdb-ripple-color="dark">
                                            <i class="fas fa-plus"></i>
                                        </button> --}}

                                        <button class="btn btn-primary btn-minus" type="button" onclick="decrementValue()">
                                            <i class="fa fa-minus"></i>
                                        </button>

                                        <input type="text" id="number" name="quantity" class="form-control  text-center" value="1">

                                        <button class="btn btn-primary btn-plus" type="button" onclick="incrementValue()">
                                            <i class="fa fa-plus"></i>
                                        </button>

                                    </div>
                                </div>
                            </div>

                            <button data-id="" type="submit" id="add-cart" class="btn btn-primary shadow-0"> <i
                                    class="me-1 fa fa-shopping-basket"></i>
                                Add to cart </button>

                        </div>

                    </main>
                </div>
            </form>
        </div>
    </section>
    <!-- content -->

    <script type="text/javascript">
        function incrementValue()
        {
            var value = parseInt(document.getElementById('number').value, 10);
            value = isNaN(value) ? 0 : value;
            if(value<20){
                value++;
                    document.getElementById('number').value = value;
            }
        }
        function decrementValue()
        {
            var value = parseInt(document.getElementById('number').value, 10);
            value = isNaN(value) ? 0 : value;
            if(value>1){
                value--;
                    document.getElementById('number').value = value;
            }

        }
        </script>
@endsection
