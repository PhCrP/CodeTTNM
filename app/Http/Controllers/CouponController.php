<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Models\Cart;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupon = Coupon::orderBy('id', 'DESC')->paginate('10');
        return view('backend.coupon.index')->with('coupons', $coupon);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $this->validate($request, [
            'code' => 'string|required',
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric',
            'status' => 'required|in:active,inactive'
        ]);
        $data = $request->all();
        $status = Coupon::create($data);
        if ($status) {
            request()->session()->flash('success', 'Đã thêm Mã giảm giá thành công');
        } else {
            request()->session()->flash('error', 'Vui lòng thử lại!!');
        }
        return redirect()->route('coupon.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $coupon = Coupon::find($id);
        if ($coupon) {
            return view('backend.coupon.edit')->with('coupon', $coupon);
        } else {
            return view('backend.coupon.index')->with('error', 'Không tìm thấy Mã giảm giá');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $coupon = Coupon::find($id);
        $this->validate($request, [
            'code' => 'string|required',
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric',
            'status' => 'required|in:active,inactive'
        ]);
        $data = $request->all();

        $status = $coupon->fill($data)->save();
        if ($status) {
            request()->session()->flash('success', 'Mã giảm giá đã cập nhật thành côngd');
        } else {
            request()->session()->flash('error', 'Vui lòng thử lại!!');
        }
        return redirect()->route('coupon.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $coupon = Coupon::find($id);
        if ($coupon) {
            $status = $coupon->delete();
            if ($status) {
                request()->session()->flash('success', 'Mã giảm giá đã được xóa thành công');
            } else {
                request()->session()->flash('error', 'Lỗi, vui lòng thử lại');
            }
            return redirect()->route('coupon.index');
        } else {
            request()->session()->flash('error', 'Không tìm thấy Mã giảm giá');
            return redirect()->back();
        }
    }

    public function couponStore(Request $request)
    {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!auth()->check()) {
            session()->flash('error', 'Vui lòng đăng nhập để sử dụng mã giảm giá');
            return back();
        }

        // Kiểm tra xem mã giảm giá có được cung cấp không
        if (empty($request->code)) {
            session()->flash('error', 'Vui lòng nhập mã giảm giá');
            return back();
        }

        // Kiểm tra giỏ hàng
        $cartItems = Cart::where('user_id', auth()->id())->count();
        if ($cartItems === 0) {
            // Xóa session coupon nếu giỏ hàng rỗng
            session()->forget('coupon');
            session()->flash('error', 'Giỏ hàng của bạn đang trống. Vui lòng thêm sản phẩm trước khi áp dụng mã giảm giá.');
            return back();
        }

        // Tìm mã giảm giá
        $coupon = Coupon::where('code', $request->code)->first();
        if (!$coupon) {
            session()->flash('error', 'Mã giảm giá không hợp lệ, vui lòng thử lại');
            return back();
        }

        // Tính tổng giá trị giỏ hàng
        $total_price = Cart::where('user_id', auth()->user()->id)->sum('price');

        // Lưu thông tin mã giảm giá vào session
        session()->put('coupon', [
            'id' => $coupon->id,
            'code' => $coupon->code,
            'value' => $coupon->discount($total_price)
        ]);

        session()->flash('success', 'Mã giảm giá đã được áp dụng thành công');
        return redirect()->back();
    }
}
