<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Coupon;
use Illuminate\Support\Str;
use Helper;

class CartController extends Controller
{
    protected $product = null;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function addToCart(Request $request)
    {
        if (empty($request->slug)) {
            request()->session()->flash('error', 'Sản phẩm không hợp lệ');
            return back();
        }
        $product = Product::where('slug', $request->slug)->first();
        if (empty($product)) {
            request()->session()->flash('error', 'Sản phẩm không hợp lệ');
            return back();
        }

        $already_cart = Cart::where('user_id', auth()->user()->id)->where('product_id', $product->id)->first();
        if ($already_cart) {
            $already_cart->quantity = $already_cart->quantity + 1;
            $already_cart->amount = $already_cart->amount + ($product->price - ($product->price * $product->discount / 100));
            if ($already_cart->product->stock < $already_cart->quantity || $already_cart->product->stock <= 0) {
                return back()->with('error', 'Không đủ hàng!');
            }
            $already_cart->save();
        } else {
            $cart = new Cart;
            $cart->user_id = auth()->user()->id;
            $cart->product_id = $product->id;
            $cart->price = ($product->price - ($product->price * $product->discount / 100));
            $cart->quantity = 1;
            $cart->amount = $cart->price * $cart->quantity;
            if ($cart->product->stock < $cart->quantity || $cart->product->stock <= 0) {
                return back()->with('error', 'Không đủ hàng!');
            }
            $cart->save();
        }

        // Cập nhật mã giảm giá
        $this->updateCoupon();

        request()->session()->flash('success', 'Sản phẩm đã được thêm vào giỏ hàng thành công.');
        return back();
    }

    public function singleAddToCart(Request $request)
    {
        $request->validate([
            'slug' => 'required',
            'quant' => 'required',
        ]);

        $product = Product::where('slug', $request->slug)->first();
        if ($product->stock < $request->quant[1]) {
            return back()->with('error', 'Không đủ hàng!');
        }
        if (($request->quant[1] < 1) || empty($product)) {
            request()->session()->flash('error', 'Sản phẩm không hợp lệ');
            return back();
        }

        $already_cart = Cart::where('user_id', auth()->user()->id)->where('product_id', $product->id)->first();
        if ($already_cart) {
            $already_cart->quantity = $already_cart->quantity + $request->quant[1];
            $already_cart->amount = $already_cart->amount + (($product->price - ($product->price * $product->discount / 100)) * $request->quant[1]);
            if ($already_cart->product->stock < $already_cart->quantity || $already_cart->product->stock <= 0) {
                return back()->with('error', 'Không đủ hàng!');
            }
            $already_cart->save();
        } else {
            $cart = new Cart;
            $cart->user_id = auth()->user()->id;
            $cart->product_id = $product->id;
            $cart->price = ($product->price - ($product->price * $product->discount / 100));
            $cart->quantity = $request->quant[1];
            $cart->amount = $cart->price * $cart->quantity;
            if ($cart->product->stock < $cart->quantity || $cart->product->stock <= 0) {
                return back()->with('error', 'Không đủ hàng!');
            }
            $cart->save();
        }

        // Cập nhật mã giảm giá
        $this->updateCoupon();

        request()->session()->flash('success', 'Sản phẩm đã được thêm vào giỏ hàng thành công.');
        return back();
    }

    public function confirmCartDelete(Request $request, $id)
    {
        $cart = Cart::find($id);
        if ($cart) {
            // Lưu thông tin sản phẩm cần xóa vào session
            $request->session()->flash('confirm_delete', [
                'id' => $id,
                'title' => $request->query('title')
            ]);
            return back();
        }

        $request->session()->flash('error', 'Sản phẩm không tồn tại trong giỏ hàng.');
        return back();
    }

    public function cartDelete(Request $request, $id)
    {
        $cart = Cart::find($id);
        if ($cart) {
            $cart->delete();

            // Cập nhật mã giảm giá
            $this->updateCoupon();

            $request->session()->flash('success', 'Sản phẩm đã được xóa khỏi giỏ hàng thành công');
            return redirect()->route('cart');
        }

        $request->session()->flash('error', 'Lỗi, vui lòng thử lại.');
        return redirect()->route('cart');
    }

    public function cartUpdate(Request $request)
    {
        if ($request->quant) {
            $error = [];
            $success = '';
            foreach ($request->quant as $k => $quant) {
                $id = $request->qty_id[$k];
                $cart = Cart::find($id);
                if ($quant > 0 && $cart) {
                    if ($cart->product->stock < $quant) {
                        request()->session()->flash('error', 'Không đủ hàng!');
                        return back();
                    }
                    $cart->quantity = ($cart->product->stock > $quant) ? $quant : $cart->product->stock;
                    if ($cart->product->stock <= 0) continue;
                    $cart->amount = $cart->price * $quant;
                    $cart->save();
                    $success = 'Cập nhật giỏ hàng thành công!';
                } else {
                    $error[] = 'Giỏ hàng không hợp lệ!';
                }
            }

            // Cập nhật mã giảm giá
            $this->updateCoupon();

            return back()->with($error)->with('success', $success);
        } else {
            return back()->with('error', 'Giỏ hàng không hợp lệ!');
        }
    }

    protected function updateCoupon()
    {
        // Kiểm tra giỏ hàng
        $cartItems = Cart::where('user_id', auth()->id())->count();
        if ($cartItems === 0) {
            session()->forget('coupon');
            return;
        }

        // Cập nhật mã giảm giá nếu có
        if (session()->has('coupon')) {
            $coupon = Coupon::find(session('coupon')['id']);
            if ($coupon && (!$coupon->expired_at || $coupon->expired_at >= now())) {
                $total_price = Cart::where('user_id', auth()->id())->sum('amount');
                session()->put('coupon', [
                    'id' => $coupon->id,
                    'code' => $coupon->code,
                    'value' => $coupon->discount($total_price)
                ]);
            } else {
                session()->forget('coupon');
                session()->flash('info', 'Mã giảm giá không hợp lệ hoặc đã hết hạn và đã được xóa.');
            }
        }
    }
}
