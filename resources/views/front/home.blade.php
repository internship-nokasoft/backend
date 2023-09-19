@extends('front.layouts.layout');

@section('title')
    Home
@endsection

@section('content')
    <div id="sidebar">

        <h3>CATEGORIES</h3>
        <div class="checklist categories">
            <ul>
                @foreach ($category_info as $category)
                    <li><a href="{{route('bycategory',[$category->id, $category->slug])}}">{{ $category->category_name }}</a></li>
                @endforeach

            </ul>
        </div>

        <h3>COLORS</h3>
        <div class="checklist colors">

            @foreach ($color_info as $color)
                <ul>
                    <li><a href="{{route('bycolor',[$color->id, $color->slug])}}"><span style="background:{{ $color->color }}"></span>{{ $color->color }}</a></li>
                </ul>
            @endforeach



        </div>

        <h3>SIZES</h3>
        <div class="checklist sizes">
            @foreach ($size_info as $size)
                <ul>
                    <li><a href="{{route('bysize',[$size->id, $size->slug])}}">{{ $size->size_name }}</a></li>
                </ul>
            @endforeach



        </div>

    </div>

    <div id="grid-selector">
        {{-- <div id="grid-menu">
            <ul>
                <li class="largeGrid"><a href=""></a></li>
                <li class="smallGrid"><a class="active" href=""></a></li>
            </ul>
        </div> --}}


    </div>

    <div id="grid">
        @foreach ($product_info as $product)
            <div class="product">
                <div class="make3D">
                    <div class="product-front">
                        <div class="shadow"></div>
                        <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/1.jpg" alt="" />
                        <div class="image_overlay"></div>
                        <div class="add_to_cart">
                            <a href="{{ route('detail', [$product->id, $product->slug]) }}"
                                style="text-decoration: none; color:white">View detail</a></div>
                        <div class="view_gallery">View gallery</div>
                        <div class="stats">
                            <div class="stats-container">
                                <span class="product_price">@money( $product->price)</span>
                                <span class="product_name">{{ $product->product_name }}</span>
                                <p>{{ $product->category_name }}</p>

                                <div class="product-options">
                                    <strong>SIZES</strong>
                                    <br>
                                    @foreach ($product['size'] as $size)
                                        {{ $size }}
                                    @endforeach
                                    <br>
                                    <strong>COLORS</strong>

                                    <div class="colors">
                                        @foreach ($product['color'] as $color)
                                            <div><span style="background:{{ $color }}"></span></div>
                                        @endforeach
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="product-back">
                        <div class="shadow"></div>
                        <div class="carousel">
                            <ul class="carousel-container">
                                <li><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/1.jpg" alt="" />
                                </li>
                                <li><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/2.jpg" alt="" />
                                </li>
                                <li><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/3.jpg" alt="" />
                                </li>
                            </ul>
                            <div class="arrows-perspective">
                                <div class="carouselPrev">
                                    <div class="y"></div>
                                    <div class="x"></div>
                                </div>
                                <div class="carouselNext">
                                    <div class="y"></div>
                                    <div class="x"></div>
                                </div>
                            </div>
                        </div>
                        <div class="flip-back">
                            <div class="cy"></div>
                            <div class="cx"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
