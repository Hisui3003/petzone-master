@extends('layouts.app')

@section('title', 'Shop')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/algolia.css') }} ">

@inject('basketAtViews', 'App\Support\Basket\BasketAtViews')

@section('content')
<!-- Shop page start -->
<section class="padding-large">
    <div class="container">

        <div class="searchbar-container">
            {{-- algolia search --}}
            <div class="aa-input-container" id="aa-input-container">
                <form action="{{ route('shop.products.index') }}" method="GET">
                    <input type="search" id="aa-search-input" class="aa-input-search" name="search" class="search_input"
                        id="prepare-search" value="{{ app('request')->input('search') }}" placeholder="Search..."
                        autocomplete="on" />

                    {{-- <button type="submit"></button> --}}

                    {{-- <svg class="aa-input-icon" viewBox="654 -372 1664 1664">
                        <path
                            d="M1806,332c0-123.3-43.8-228.8-131.5-316.5C1586.8-72.2,1481.3-116,1358-116s-228.8,43.8-316.5,131.5  C953.8,103.2,910,208.7,910,332s43.8,228.8,131.5,316.5C1129.2,736.2,1234.7,780,1358,780s228.8-43.8,316.5-131.5  C1762.2,560.8,1806,455.3,1806,332z M2318,1164c0,34.7-12.7,64.7-38,90s-55.3,38-90,38c-36,0-66-12.7-90-38l-343-342  c-119.3,82.7-252.3,124-399,124c-95.3,0-186.5-18.5-273.5-55.5s-162-87-225-150s-113-138-150-225S654,427.3,654,332  s18.5-186.5,55.5-273.5s87-162,150-225s138-113,225-150S1262.7-372,1358-372s186.5,18.5,273.5,55.5s162,87,225,150s113,138,150,225  S2062,236.7,2062,332c0,146.7-41.3,279.7-124,399l343,343C2305.7,1098.7,2318,1128.7,2318,1164z" />
                    </svg> --}}
                </form>
            </div>
        </div>



        {{-- <div class="searchbar">
            <form action="{{ route('shop.products.index') }}" method="GET">
                <input name="search" class="search_input" id="prepare-search"
                    value="{{ app('request')->input('search') }}" type="text" placeholder="Search...">
                <button hidden type="submit"></button>
            </form>
        </div> --}}
    </div>

    <ul class="tabs">
        @foreach ($paginated as $categoryName => $products)
        <li data-tab-target="#{{$categoryName}}" class="{{ ($categoryName == 'All') ? 'active tab' : 'tab' }}">
            {{$categoryName}}</li>
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
                        <a href="{{ route('shop.basket.add' , $product->id) }}"><button type="button"
                                class="add-to-cart" data-product-tile="add-to-cart">Add to Cart</button></a>
                        <figcaption>
                            <h3><a href="{{ route('shop.products.show' , $product->id ) }}">{{ $product->title }}</a>
                            </h3>
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

<!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
<script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
<script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
<script src="{{ asset('js/algolia.js') }}"></script>

@endsection

{{-- @section('extra-js')
<!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
<script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
<script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
<script src="{{ asset('js/algolia.js') }}"></script>

<!-- Place this script at the end of your HTML, just before </body> -->

@endsection --}}
