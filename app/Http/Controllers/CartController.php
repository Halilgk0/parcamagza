<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Part;
use App\Services\StockNotificationService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Controller constructor
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Sepeti görüntüle
     */
    public function index()
    {
        $cart = auth()->user()->cart;
        
        if (!$cart) {
            $cart = Cart::create(['user_id' => auth()->id()]);
        }
        
        $cart->load('items.part.category', 'items.part.brand');
        
        return view('cart.index', compact('cart'));
    }

    /**
     * Sepete ürün ekle
     */
    public function addItem(Request $request, Part $part)
    {
        // Stokta yoksa eklemeyi reddet
        if ($part->stock_quantity <= 0) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bu parça stokta bulunmuyor.'
                ], 400);
            }
            
            return back()->with('error', 'Bu parça stokta bulunmuyor.');
        }
        
        // Kullanıcının sepetini al veya oluştur
        $cart = auth()->user()->cart ?? Cart::create(['user_id' => auth()->id()]);
        
        // Parça zaten sepette mi kontrol et
        $cartItem = $cart->items()->where('part_id', $part->id)->first();
        
        if ($cartItem) {
            // Miktarı güncelle
            $quantity = $cartItem->quantity + ($request->quantity ?? 1);
            
            // Stok miktarını aşmayacak şekilde kontrol et
            if ($quantity > $part->stock_quantity) {
                $quantity = $part->stock_quantity;
            }
            
            $cartItem->update([
                'quantity' => $quantity,
                'price' => $part->price // Fiyat güncellenmiş olabilir
            ]);
        } else {
            // Yeni sepet öğesi oluştur
            $cart->items()->create([
                'part_id' => $part->id,
                'quantity' => min($request->quantity ?? 1, $part->stock_quantity),
                'price' => $part->price
            ]);
        }
        
        // AJAX isteği mi kontrol et
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Parça sepete eklendi.',
                'cart_count' => $cart->itemCount()
            ]);
        }
        
        return back()->with('success', 'Parça sepete eklendi.');
    }

    /**
     * Sepetteki ürün miktarını güncelle
     */
    public function updateItem(Request $request, CartItem $cartItem)
    {
        // Kullanıcının yetkinliğini kontrol et
        if ($cartItem->cart->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        // Stok miktarını kontrol et
        $part = $cartItem->part;
        $quantity = min($request->quantity, $part->stock_quantity);

        $cartItem->update([
            'quantity' => $quantity
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Miktar güncellendi.',
                'subtotal' => $cartItem->subtotal(),
                'cart_total' => $cartItem->cart->total()
            ]);
        }

        return back()->with('success', 'Sepet güncellendi.');
    }

    /**
     * Sepetten ürün çıkar
     */
    public function removeItem(Request $request, CartItem $cartItem)
    {
        // Kullanıcının yetkinliğini kontrol et
        if ($cartItem->cart->user_id !== auth()->id()) {
            abort(403);
        }

        $cartItem->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Ürün sepetten kaldırıldı.',
                'cart_total' => $cartItem->cart->total(),
                'cart_count' => $cartItem->cart->itemCount()
            ]);
        }

        return back()->with('success', 'Ürün sepetten kaldırıldı.');
    }

    /**
     * Sepeti temizle
     */
    public function clear()
    {
        $cart = auth()->user()->cart;
        
        if ($cart) {
            $cart->items()->delete();
        }

        return back()->with('success', 'Sepetiniz temizlendi.');
    }
} 