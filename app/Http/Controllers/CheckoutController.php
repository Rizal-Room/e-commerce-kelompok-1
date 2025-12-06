<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Buyer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Display checkout page
     */
    public function index()
    {
        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        return view('checkout.index', compact('cart', 'subtotal'));
    }

    /**
     * Process checkout
     */
    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'shipping_type' => 'required|in:regular,express,same_day',
        ]);

        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        // Get or create buyer profile
        $buyer = Buyer::firstOrCreate(
            ['user_id' => auth()->id()],
            ['profile_picture' => null, 'phone_number' => null]
        );

        // Calculate shipping cost based on type
        $shippingCosts = [
            'regular' => 10000,
            'express' => 25000,
            'same_day' => 50000,
        ];
        $shippingCost = $shippingCosts[$request->shipping_type];

        // Group cart items by store
        $itemsByStore = [];
        foreach ($cart as $item) {
            $storeId = $item['store_id'];
            if (!isset($itemsByStore[$storeId])) {
                $itemsByStore[$storeId] = [];
            }
            $itemsByStore[$storeId][] = $item;
        }

        $createdTransactions = [];

        // Create transaction for each store
        foreach ($itemsByStore as $storeId => $items) {
            $subtotal = 0;
            foreach ($items as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }

            $tax = $subtotal * 0.11; // 11% tax
            $grandTotal = $subtotal + $shippingCost + $tax;

            // Create transaction
            $transaction = Transaction::create([
                'code' => 'TRX-' . strtoupper(Str::random(10)),
                'buyer_id' => $buyer->id,
                'store_id' => $storeId,
                'address_id' => 1, // Placeholder address ID
                'address' => $request->address,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'shipping' => 'JNE', // Placeholder shipping courier
                'shipping_type' => $request->shipping_type,
                'shipping_cost' => $shippingCost,
                'tracking_number' => null,
                'tax' => $tax,
                'grand_total' => $grandTotal,
                'payment_status' => 'unpaid',
            ]);

            // Create transaction details
            foreach ($items as $item) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['product_id'],
                    'qty' => $item['quantity'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);

                // Reduce product stock
                $product = Product::find($item['product_id']);
                if ($product) {
                    $product->decrement('stock', $item['quantity']);
                }
            }

            $createdTransactions[] = $transaction;
        }

        // Clear cart
        session()->forget('cart');

        // Redirect to success page with first transaction
        return redirect()->route('checkout.success', $createdTransactions[0]->id)
            ->with('success', 'Order placed successfully!');
    }

    /**
     * Display success page
     */
    public function success(Transaction $transaction)
    {
        // Ensure user owns this transaction
        if ($transaction->buyer->user_id !== auth()->id()) {
            abort(403);
        }

        return view('checkout.success', compact('transaction'));
    }
}
