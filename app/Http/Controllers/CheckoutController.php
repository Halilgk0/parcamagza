<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Part;
use App\Services\StockNotificationService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Ödeme sayfasını göster
     */
    public function index()
    {
        // Sepeti al
        $cart = auth()->user()->cart;
        
        // Sepet yoksa veya boşsa sepet sayfasına yönlendir
        if (!$cart || $cart->items->count() === 0) {
            return redirect()->route('cart.index')
                ->with('error', 'Sepetiniz boş. Önce sepetinize ürün ekleyin.');
        }
        
        // İlişkileri yükle
        $cart->load('items.part.category', 'items.part.brand');
        
        // Kullanıcının adreslerini getir
        $addresses = auth()->user()->addresses;
        
        return view('checkout.index', compact('cart', 'addresses'));
    }
    
    /**
     * Siparişi tamamla
     */
    public function processOrder(Request $request)
    {
        // Sepeti al
        $cart = auth()->user()->cart;
        
        // Sepet yoksa veya boşsa sepet sayfasına yönlendir
        if (!$cart || $cart->items->count() === 0) {
            return redirect()->route('cart.index')
                ->with('error', 'Sepetiniz boş. Önce sepetinize ürün ekleyin.');
        }
        
        // Form verilerini doğrula
        $validatedData = $request->validate([
            'address_id' => 'required|exists:addresses,id',
            'payment_method' => 'required|in:credit_card,bank_transfer',
            'card_number' => 'required_if:payment_method,credit_card',
            'card_holder' => 'required_if:payment_method,credit_card',
            'card_expiry' => 'required_if:payment_method,credit_card',
            'card_cvv' => 'required_if:payment_method,credit_card',
            'terms' => 'required|accepted',
        ]);
        
        // Yeni sipariş oluştur
        $order = Order::create([
            'user_id' => auth()->id(),
            'address_id' => $validatedData['address_id'],
            'total_amount' => $cart->total() + 30, // Sepet toplamı + kargo ücreti
            'status' => 'pending',
            'payment_method' => $validatedData['payment_method'],
            'payment_status' => 'pending',
            'notes' => $request->notes,
        ]);
        
        // Sepet öğelerini sipariş öğelerine çevir
        foreach ($cart->items as $item) {
            // Stok kontrolü
            $part = Part::find($item->part_id);
            if ($part && $part->stock_quantity >= $item->quantity) {
                // Stok miktarını güncelle
                $newStockQuantity = $part->stock_quantity - $item->quantity;
                $part->update([
                    'stock_quantity' => $newStockQuantity
                ]);
                
                // Stok bittiğinde veya azaldığında bildirim gönder
                if ($newStockQuantity == 0) {
                    StockNotificationService::sendStockDepletedNotification($part);
                } elseif ($newStockQuantity <= 5) {
                    StockNotificationService::sendLowStockNotification($part);
                }
                
                // Sipariş öğesini oluştur
                OrderItem::create([
                    'order_id' => $order->id,
                    'part_id' => $item->part_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ]);
            }
        }
        
        // Sepeti temizle
        $cart->items()->delete();
        
        // Ödeme tipine göre işlem yap
        if ($validatedData['payment_method'] === 'credit_card') {
            // Kredi kartı işlemi simüle ediyor olacağız
            // Gerçek bir uygulamada burada ödeme geçidi entegrasyonu olurdu
            $order->update([
                'payment_status' => 'completed',
                'status' => 'processing'
            ]);
        } else {
            // Banka havalesi
            $order->update([
                'payment_status' => 'pending',
                'status' => 'awaiting_payment'
            ]);
        }
        
        // Ana sayfaya yönlendir ve başarı mesajı göster
        return redirect()->route('home')
            ->with('success', 'Siparişiniz başarıyla oluşturuldu! Sipariş ID: #' . $order->id);
    }
} 