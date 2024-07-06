@extends('layouts.app')

@section('title', 'Shop')

@inject('basketAtViews', 'App\Support\Basket\BasketAtViews')

@section('content')
    <!-- Shop page start -->
    <section class="padding-large">
        <div class="container">
            <div class="searchbar">
                <form action="{{ route('shop.products.index') }}" method="GET">
                    <input name="search" class="search_input" id="prepare-search" value="{{ app('request')->input('search') }}" type="text" placeholder="Search...">
                    <button hidden type="submit"></button>
                </form>
            </div>
        </div>
        <ul class="tabs">
            @foreach ($paginated as $categoryName => $products)
                <li data-tab-target="#{{$categoryName}}" class="{{ ($categoryName == 'All') ? 'active tab' : 'tab' }}">{{$categoryName}}</li>
            @endforeach
        </ul>
        <div class="container">
            @foreach ($paginated as $categoryName => $products)
                <div id="{{$categoryName}}" data-tab-content class="{{ ($categoryName == 'All') ? 'active' : '' }}">
                    <div class="row">
                        <div class="products-grid grid" id="product-grid">
                            @foreach ($products as $product)
                            <figure class="product-style">
                                <img src="images/products/{{ $product->demo_url }}" alt="Books" class="product-item">
                                <a href="{{ route('shop.basket.add' , $product->id) }}"><button type="button" class="add-to-cart" data-product-tile="add-to-cart">Add to Cart</button></a>
                                <figcaption>
                                    <h3><a href="{{ route('shop.products.show' , $product->id ) }}">{{ $product->title }}</a></h3>
                                    <p>{{ $product->author }}</p>
                                    <div class="item-price">${{ $product->price }}</div>
                                    @if($basketAtViews->hasQuantity($product->id))
                                        <div>
                                            <a href="{{ route('shop.basket.add' , $product->id)}}" class="increase">+</a>
                                            <span class="quantity">{{ $basketAtViews->getQuantity($product->id) }}</span>
                                            <a href="{{ route('shop.basket.remove' , $product->id) }}" class="decrease">-</a>
                                        </div>
                                    @endif
                                </figcaption>
                            </figure>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Placeholder for infinite scroll -->
        <div id="infinite-scroll-placeholder"></div>
    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        var currentPage = 1;
        var loading = false;
        var lastPage = false;
        var scrollUpThreshold = 100; // Pixels from bottom where scroll-up will trigger

        $(window).scroll(function() {
            if ($(window).scrollTop() <= scrollUpThreshold) {
                // Reset to first page when scrolling up
                currentPage = 1;
                lastPage = false;
                $('#infinite-scroll-placeholder').empty(); // Clear existing products
            }

            if ($(window).scrollTop() + $(window).height() >= $(document).height() - scrollUpThreshold && !loading && !lastPage) {
                loading = true;
                currentPage++;

                $.ajax({
                    url: "{{ route('shop.products.index') }}",
                    data: { page: currentPage },
                    success: function(response) {
                        if (response.trim()) {
                            $('#infinite-scroll-placeholder').append(response);
                            loading = false;
                        } else {
                            lastPage = true;
                        }
                    }
                });
            }
        });
    </script>


@endsection

