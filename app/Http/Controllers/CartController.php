<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Knife;

class CartController extends Controller
{
    public function index()
    {
        return view('cart.index');
    }

    public function add($id)
    {
        $knife = Knife::findOrFail($id);

        $cart = session()->get('cart', []);
        $cart[$id] = [
            'id' => $knife->id,
            'title' => $knife->title,
            'price' => $knife->price,
            'image' => $knife->image,
        ];

        session()->put('cart', $cart);

        $total = collect($cart)->sum('price');
        session()->put('cart_total', $total);

        return redirect()->back()->with('success', 'Нож добавлен в корзину!');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);

        session()->put('cart', $cart);

        $total = collect($cart)->sum('price');
        session()->put('cart_total', $total);

        return redirect()->back()->with('success', 'Товар удалён из корзины.');
    }
}
