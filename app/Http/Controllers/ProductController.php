<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::getAllProduct();
        return view('backend.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = Brand::get();
        $categories = Category::where('is_parent', 1)->get();
        return view('backend.product.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'summary' => 'required|string',
            'description' => 'nullable|string',
            'photo' => 'required|string',
            'size' => 'nullable',
            'stock' => 'required|numeric',
            'cat_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'child_cat_id' => 'nullable|exists:categories,id',
            'is_featured' => 'sometimes|in:1',
            'status' => 'required|in:active,inactive',
            'condition' => 'required|in:default,new,hot',
            'price' => 'required|numeric|max:9999999999999.99',
            'discount' => 'nullable|numeric|max:9999999999999.99',
        ], [
            // Thông báo lỗi cho từng trường
            'title.required' => 'Tiêu đề là bắt buộc.',
            'title.string' => 'Tiêu đề phải là chuỗi ký tự.',
            'summary.required' => 'Tóm tắt là bắt buộc.',
            'summary.string' => 'Tóm tắt phải là chuỗi ký tự.',
            'photo.required' => 'Ảnh là bắt buộc.',
            'photo.string' => 'Ảnh phải là chuỗi ký tự.',
            'stock.required' => 'Số lượng tồn kho là bắt buộc.',
            'stock.numeric' => 'Số lượng tồn kho phải là số.',
            'cat_id.required' => 'Danh mục là bắt buộc.',
            'cat_id.exists' => 'Danh mục không tồn tại.',
            'brand_id.exists' => 'Thương hiệu không tồn tại.',
            'child_cat_id.exists' => 'Danh mục con không tồn tại.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái phải là "Hoạt động" hoặc "Không hoạt động".',
            'condition.required' => 'Tình trạng là bắt buộc.',
            'condition.in' => 'Tình trạng phải là "default", "new" hoặc "hot".',
            'price.required' => 'Giá là bắt buộc.',
            'price.numeric' => 'Giá phải là số.',
            'price.max' => 'Giá trị vượt quá giới hạn cho phép',
            'discount.numeric' => 'Giảm giá phải là số.',
            'discount.max' => 'Giảm giá vượt quá giới hạn cho phép',
        ]);

        $slug = generateUniqueSlug($request->title, Product::class);
        $validatedData['slug'] = $slug;
        $validatedData['is_featured'] = $request->input('is_featured', 0);

        if ($request->has('size')) {
            $validatedData['size'] = implode(',', $request->input('size'));
        } else {
            $validatedData['size'] = '';
        }

        $product = Product::create($validatedData);

        $message = $product
            ? 'Sản phẩm đã được thêm thành công'
            : 'Vui lòng thử lại!!';

        return redirect()->route('product.index')->with(
            $product ? 'success' : 'error',
            $message
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Implement if needed
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brands = Brand::get();
        $product = Product::findOrFail($id);
        $categories = Category::where('is_parent', 1)->get();
        $items = Product::where('id', $id)->get();

        return view('backend.product.edit', compact('product', 'brands', 'categories', 'items'));
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
        $product = Product::findOrFail($id);

        $validatedData = $request->validate([
            'title' => 'required|string',
            'summary' => 'required|string',
            'description' => 'nullable|string',
            'photo' => 'required|string',
            'size' => 'nullable',
            'stock' => 'required|numeric',
            'cat_id' => 'required|exists:categories,id',
            'child_cat_id' => 'nullable|exists:categories,id',
            'is_featured' => 'sometimes|in:1',
            'brand_id' => 'nullable|exists:brands,id',
            'status' => 'required|in:active,inactive',
            'condition' => 'required|in:default,new,hot',
            'price' => 'required|numeric|max:9999999999999.99',
            'discount' => 'nullable|numeric|max:9999999999999.99',
        ], [
            // Thông báo lỗi cho từng trường
            'title.required' => 'Tiêu đề là bắt buộc.',
            'title.string' => 'Tiêu đề phải là chuỗi ký tự.',
            'summary.required' => 'Tóm tắt là bắt buộc.',
            'summary.string' => 'Tóm tắt phải là chuỗi ký tự.',
            'photo.required' => 'Ảnh là bắt buộc.',
            'photo.string' => 'Ảnh phải là chuỗi ký tự.',
            'stock.required' => 'Số lượng tồn kho là bắt buộc.',
            'stock.numeric' => 'Số lượng tồn kho phải là số.',
            'cat_id.required' => 'Danh mục là bắt buộc.',
            'cat_id.exists' => 'Danh mục không tồn tại.',
            'brand_id.exists' => 'Thương hiệu không tồn tại.',
            'child_cat_id.exists' => 'Danh mục con không tồn tại.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái phải là "Hoạt động" hoặc "Không hoạt động".',
            'condition.required' => 'Tình trạng là bắt buộc.',
            'condition.in' => 'Tình trạng phải là "default", "new" hoặc "hot".',
            'price.required' => 'Giá là bắt buộc.',
            'price.numeric' => 'Giá phải là số.',
            'price.max' => 'Giá trị vượt quá giới hạn cho phép',
            'discount.numeric' => 'Giảm giá phải là số.',
            'discount.max' => 'Giảm giá vượt quá giới hạn cho phép',
        ]);

        $validatedData['is_featured'] = $request->input('is_featured', 0);

        if ($request->has('size')) {
            $validatedData['size'] = implode(',', $request->input('size'));
        } else {
            $validatedData['size'] = '';
        }

        $status = $product->update($validatedData);

        $message = $status
            ? 'Sản phẩm đã được cập nhật thành công'
            : 'Vui lòng thử lại!!';

        return redirect()->route('product.index')->with(
            $status ? 'success' : 'error',
            $message
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $status = $product->delete();

        $message = $status
            ? 'Sản phẩm đã được xóa thành công'
            : 'Lỗi khi xóa sản phẩm';

        return redirect()->route('product.index')->with(
            $status ? 'success' : 'error',
            $message
        );
    }
}
