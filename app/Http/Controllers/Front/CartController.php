<?php

namespace App\Http\Controllers\Front;

use AllowDynamicProperties;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\Cart\CartModelRepository;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


class CartController extends Controller
{
//    protected $cartRepository;
//
//    public function __construct(CartRepository $cartRepository)
//    {
//        $this->cartRepository = $cartRepository;
//    }
    /**
     * Display a listing of the resource.
     */
    public function index(CartRepository $cart)
    {
        $repository = App::make('Cart');
        $items = $repository->get();
        return view('front.cart', [
            'cart' => $items,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, CartRepository $cart)
    {
        $request->validate([
            'product_id' => ['required', 'int', 'exists:products,id'],
            'quantity' => ['nullable', 'int', 'min:1'],
        ]);
        $product = Product::findOrFail($request->post('product_id'));
        $cart->add($product, $request->post('quantity'));

        return redirect()->route('cart.index')
            ->with('success', 'Product added to cart successfully!');

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CartRepository $cart)
    {
        $request->validate([
            'product_id' => ['required', 'int', 'exists:products,id'],
            'quantity' => ['nullable', 'int', 'min:1'],
        ]);
        $product = Product::findOrFail($request->post('product_id'));
        $cart->update($product, $request->post('quantity'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CartRepository $cart, $id)
    {
        $cart->delete($id);
    }
}
