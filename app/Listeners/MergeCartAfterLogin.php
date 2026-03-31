<?php

namespace App\Listeners;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

// Em dùng Login Event Listener để merge cart, có transaction để đảm bảo tính toàn vẹn dữ liệu, đồng thời validate lại product từ DB để tránh session cũ gây lỗi.
class MergeCartAfterLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        // $user = $event->user;
        $user = User::find($event->user->getAuthIdentifier());
        if (!$user) return;

        $sessionCart = Session::get('cart', []);

        if (empty($sessionCart)) {
            return;
        }

        DB::transaction(function () use ($user, $sessionCart) {
            //Lấy toàn bộ products và cartItem
            $products = Product::whereIn('id', array_keys($sessionCart))
                ->pluck('id')
                ->toArray();

            $existingCartItems = CartItem::where('user_id', $user->id)
                ->whereIn('product_id', $products)
                ->get()
                ->keyBy('product_id');

            foreach ($sessionCart as $productId => $cartItem) {
                //product không tồn tại => continue (skip)
                if (!in_array($productId, $products)) {
                    continue;
                }

                if (isset($existingCartItems[$productId])) {
                    $existingCartItems[$productId]->increment(
                        'quantity',
                        $cartItem['quantity']
                    );
                } else {
                    CartItem::create([
                        'user_id'    => $user->id,
                        'product_id' => $productId,
                        'quantity'  => $cartItem['quantity'],
                    ]);
                }
            }
        });

        //Xóa session cart sau khi merge
        Session::forget('cart');

        $cartItems = $user->cartItems()->get();
    }
}
