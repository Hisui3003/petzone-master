<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\Shop\Traits\HasProduc as ShopHasProduct; // Fixed typo in trait import
use App\Models\Review; // Import the Review model
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Support\Basket\BasketAtViews;

class ProductController extends Controller{
    use ShopHasProduct; // Import the corrected trait

    /**
     * Display all of the products
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        // Fetch all products organized by category
        $all = $this->organizeProductsByCategory($request);

        // Paginate products
        $perPage = 6;
        $page = $request->query('page', 1); // Get current page from query string, default to 1
        $paginated = [];

        foreach ($all as $categoryName => $products) {
            $currentPageItems = Collection::make($products)
                ->slice(($page - 1) * $perPage, $perPage)
                ->values();

            $paginated[$categoryName] = new LengthAwarePaginator(
                $currentPageItems,
                count($products),
                $perPage,
                $page,
                ['path' => LengthAwarePaginator::resolveCurrentPath()]
            );
        }

        if ($request->ajax()) {
            return view('frontend.partials.products-list')->with('paginated', $paginated)->render();
        }

        // Return the view with the paginated products
        return view('frontend.shop', compact('paginated'));
    }


    /**
     * Display the specified product.
     *
     * @param  \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product){
        // Fetch reviews for the current product
        $reviews = Review::where('product_id', $product->id)->get();

        // Return the view with the product and its reviews
        return view('frontend.single-product', compact('product', 'reviews'));
    }
}
