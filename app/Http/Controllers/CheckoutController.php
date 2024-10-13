<?php

namespace App\Http\Controllers;

use App\Helpers\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\OrderItem;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();
        $customer = $user->customer;

        if (!$customer->billingAddress || !$customer->shippingAddress) {
            return redirect()->route('profile')->with('error', 'Please provide your address details first.');
        }

        [$products, $cartItems] = Cart::getProductsAndCartItems(); // Now returns arrays

        $orderItems = [];
        $totalPrice = 0;

        DB::beginTransaction();

        foreach ($products as $product) {
            $quantity = $cartItems[$product['id']]['quantity']; // Access with array notation
            if ($product['quantity'] !== null && $product['quantity'] < $quantity) {
                $message = match ($product['quantity']) {
                    0 => 'The product "' . $product['title'] . '" is out of stock',
                    1 => 'There is only one item left for product "' . $product['title'] . '"',
                    default => 'There are only ' . $product['quantity'] . ' items left for product "' . $product['title'] . '"',
                };
                return redirect()->back()->with('error', $message);
            }
        }

        foreach ($products as $product) {
            $quantity = $cartItems[$product['id']]['quantity']; // Access with array notation
            $totalPrice += $product['price'] * $quantity;
            $orderItems[] = [
                'product_id' => $product['id'],
                'quantity' => $quantity,
                'unit_price' => $product['price']
            ];

            if ($product['quantity'] !== null) {
                $product['quantity'] -= $quantity;
                Product::find($product['id'])->update(['quantity' => $product['quantity']]); // Update the product quantity directly
            }
        }

        try {
            // Create Order
            $orderData = [
                'total_price' => $totalPrice,
                'status' => OrderStatus::Unpaid,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ];
            $order = Order::create($orderData);

            // Create Order Items
            foreach ($orderItems as $orderItem) {
                $orderItem['order_id'] = $order->id;
                OrderItem::create($orderItem);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            Log::critical(__METHOD__ . ' method does not work. ' . $e->getMessage());
            session()->flash('error', 'An error occurred while processing your order. Please try again.');
            return redirect()->back();
        }

        DB::commit();
        CartItem::where(['user_id' => $user->id])->delete();

        session()->flash('flash_message', 'Order was successfully placed.');
        return redirect()->route('checkout.success'); // Adjust to your success route
    }


    public function success(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();
        
        /** @var \App\Models\Customer $customer */
        $customer = $user->customer; // Get the customer's details

        return view('checkout.success', compact('customer')); // Pass the customer to the view
    }

    public function failure(Request $request)
    {
        return view('checkout.failure', ['message' => 'Payment failed or cancelled.']);
    }
}