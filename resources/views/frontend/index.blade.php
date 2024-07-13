@extends('layouts.app')

@section('title' , 'Petzone')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/algolia.css') }} ">

@inject('basketAtViews', 'App\Support\Basket\BasketAtViews')

@section('content')

{{-- searchbar with algolia --}}
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

<!-- Offer books start -->
<section id="special-offer" class="bookshelf">
    <div class="section-header align-center">
        <div class="title">
            <span>Paws, Purrs, and Beyond: Where Every Pet's Tale Begins!</span>
        </div>
        <h2 class="section-title">Discounted Pet Books</h2>
    </div>
    <div class="container">
        <div class="row">
            <div class="inner-content">
                <div class="product-list" data-aos="fade-up">
                    <div class="grid product-grid">
                        @foreach ($discountedBooks as $book)
                        <figure class="product-style">
                            <img src="images/products/{{ $book->demo_url }}" alt="Books" class="product-item">
                            <a href="{{ route('shop.basket.add' , $book->id) }}"><button type="button"
                                    class="add-to-cart" data-product-tile="add-to-cart">Add to Cart</button></a>
                            <figcaption>
                                <h3><a href="{{ route('shop.products.show' , $book->id ) }}">{{ $book->title }}</a></h3>
                                <p>{{ $book->author }}</p>
                                <div class="item-price">
                                    <span class="prev-price">${{number_format($basketAtViews->beforeDiscount($book->id))
                                        }}</span>${{ $book->price }}
                                </div>
                                @if($basketAtViews->hasQuantity($book->id))
                                <div>
                                    <a href="{{ route('shop.basket.add' , $book->id)}}" class="increase">+</a>
                                    <span class="quantity">{{ $basketAtViews->getQuantity($book->id) }}</span>
                                    <a href="{{ route('shop.basket.remove' , $book->id )}}" class="decrease">-</a>
                                </div>
                                @endif
                            </figcaption>
                        </figure>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Offer books end -->

<!-- quote of the day start -->
<section id="quotation" class="align-center">
    <div class="inner-content" id="margin-t-200">
        <h2 class="section-title divider">Inspirational Insight</h2>
        <blockquote data-aos="fade-up">
            <q>Animals are such agreeable friends—they ask no questions; they pass no criticisms.</q>
            <div class="author-name">George Eliot</div>
        </blockquote>
    </div>
</section>
<!-- quote of the day end -->

<!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
<script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
<script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
<script src="{{ asset('js/algolia.js') }}"></script>

@endsection


