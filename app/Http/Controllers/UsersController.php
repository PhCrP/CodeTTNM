<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('id', 'ASC')->paginate(7);
        return view('backend.users.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'string|required|max:30',
                'email' => 'string|required|unique:users',
                'password' => 'string|required',
                'role' => 'required|in:admin,user',
                'status' => 'required|in:active,inactive',
                'photo' => 'nullable|string',
            ],
            [
                // Thông báo lỗi cho từng trường
                'name.required' => 'Tên là bắt buộc.',
                'name.string' => 'Tên phải là chuỗi ký tự.',
                'name.max' => 'Tên không được vượt quá 30 ký tự.',
                'email.required' => 'Email là bắt buộc.',
                'email.string' => 'Email phải là chuỗi ký tự.',
                'email.unique' => 'Email đã được sử dụng.',
                'password.required' => 'Mật khẩu là bắt buộc.',
                'password.string' => 'Mật khẩu phải là chuỗi ký tự.',
                'role.required' => 'Vai trò là bắt buộc.',
                'role.in' => 'Vai trò phải là "admin" hoặc "user".',
                'status.required' => 'Trạng thái là bắt buộc.',
                'status.in' => 'Trạng thái phải là "Hoạt động" hoặc "Không hoạt động".',
                'photo.string' => 'Ảnh phải là chuỗi ký tự.',
            ]
        );
        // dd($request->all());
        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        // dd($data);
        $status = User::create($data);
        // dd($status);
        if ($status) {
            request()->session()->flash('success', 'Đã thêm người dùng thành công');
        } else {
            request()->session()->flash('error', 'Đã xảy ra lỗi khi thêm người dùng');
        }
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('backend.users.edit')->with('user', $user);
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
        $user = User::findOrFail($id);
        $this->validate(
            $request,
            [
                'name' => 'string|required|max:30',
                'email' => 'string|required',
                'role' => 'required|in:admin,user',
                'status' => 'required|in:active,inactive',
                'photo' => 'nullable|string',
            ],
            [
                // Thông báo lỗi cho từng trường
                'name.required' => 'Tên là bắt buộc.',
                'name.string' => 'Tên phải là chuỗi ký tự.',
                'name.max' => 'Tên không được vượt quá 30 ký tự.',
                'email.required' => 'Email là bắt buộc.',
                'email.string' => 'Email phải là chuỗi ký tự.',
                'email.unique' => 'Email đã được sử dụng.',
                'password.required' => 'Mật khẩu là bắt buộc.',
                'password.string' => 'Mật khẩu phải là chuỗi ký tự.',
                'role.required' => 'Vai trò là bắt buộc.',
                'role.in' => 'Vai trò phải là "admin" hoặc "user".',
                'status.required' => 'Trạng thái là bắt buộc.',
                'status.in' => 'Trạng thái phải là "Hoạt động" hoặc "Không hoạt động".',
                'photo.string' => 'Ảnh phải là chuỗi ký tự.',
            ]
        );
        // dd($request->all());
        $data = $request->all();
        // dd($data);

        $status = $user->fill($data)->save();
        if ($status) {
            request()->session()->flash('success', 'Đã cập nhật thành công');
        } else {
            request()->session()->flash('error', 'Đã xảy ra lỗi khi cập nhật');
        }
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = User::findorFail($id);
        $status = $delete->delete();
        if ($status) {
            request()->session()->flash('success', 'Đã xóa người dùng thành công');
        } else {
            request()->session()->flash('error', 'Lỗi khi xóa người dùng');
        }
        return redirect()->route('users.index');
    }
}
