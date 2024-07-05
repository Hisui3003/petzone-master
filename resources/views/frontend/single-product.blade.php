VIEWING NG SINGLE PRODUCT

@extends('layouts.app')

@section('title', 'Show Product')

@inject('basketAtViews', 'App\Support\Basket\BasketAtViews')

@section('content')
<!-- Single product start -->
<section class="bg-sand padding-large">
    <div class="container">
        <div class="row">
            <div class="col-md-6" id="middle" style="padding-top: 30px;">
                <a class="product-image"><img id="product-show-zoom" src="/images/products/{{ $product->demo_url }}"></a>
            </div>
            <div class="col-md-6 pl-5">
                <div class="product-detail">
                    <h1>{{ $product->title }}</h1>
                    <h3 id="custom-gray">{{ $product->author }}</h3>
                    <h4 id="custom-gray">{{ $product->category->title }}</h4>
                    <h2 id="custom-orange">${{ $product->price }}</h2>
                    <p>
                        {{ $product->description }}
                    </p>
                    @if($basketAtViews->hasQuantity($product->id))
                    <div>
                        <a href="{{ route('shop.basket.add', $product->id)}}" class="increase" id="increase-s">+</a>
                        <span class="quantity" id="quantity-s">{{ $basketAtViews->getQuantity($product->id) }}</span>
                        <a href="{{ route('shop.basket.remove', $product->id) }}" class="decrease" id="decrease-s">-</a>
                    </div>
                    @else
                    <a href="{{ route('shop.basket.add', $product->id) }}"><button type="submit" name="add-to-cart" value="27545" class="button">Add to cart</button></a>
                    @endif
                </div>
            </div>
        </div>
        <br>

        <!-- Display reviews/feedback -->
<div class="reviews" style="border: 1px solid #ccc; padding: 10px; margin-bottom: 20px;">
    <h2 style="color: #333;">Reviews and Feedbacks</h2>
    @foreach ($reviews as $review)
        <div class="review" style="border-bottom: 1px solid #ddd; padding: 10px 0;">
            <h4 style="color: #616161;">{{ $review->comment }}</h4>
            <small>Posted by <strong>{{ $review->user_email }}</strong> on {{ $review->created_at }}</small>
        </div>
    @endforeach
</div>

<!-- Add review form -->
<div class="add-review" style="border: 1px solid #ccc; padding: 10px;">
    <h3 style="color: #333;">Add a Review</h3>
    <form method="POST" action="{{ route('reviews.store') }}">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <textarea name="comment" placeholder="Write your review here" style="width: 100%; padding: 5px; margin-bottom: 10px;"></textarea>
        <button type="submit" style="background-color: #ff6600; color: #fff; padding: 5px 10px; border: none; cursor: pointer;">Submit Review</button>
    </form>
</div>

    </div>


</section>
<!-- Single product end -->

@endsection