<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use function Symfony\Component\Clock\now;

class AdminCategoryController extends Controller
{
    public function index()
    {
        return view('admin.pages.categories');
    }

    public function showFormAddCategory()
    {
        return view('admin.pages.category-add');
    }

    public function addCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'name.required' => 'Vui lòng nhập tên danh mục.',
            'name.unique' => 'Tên danh mục này đã tồn tại.',
            'name.max' => 'Tên danh mục không được vượt quá 255 ký tự.',
            'description.required' => 'Vui lòng nhập mô tả danh mục.',
            'description.min' => 'Mô tả phải có ít nhất 10 ký tự.',
            'image.image' => 'File tải lên phải là hình ảnh.',
            'image.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif, svg.',
            'image.max' => 'Kích thước ảnh không được vượt quá 2MB.',
        ]);

        $imagePath = null;
        
        if($request->hasFile('image')) {
            $imagePath = $request->file('image');
            $fileName = time() . '_' . uniqid() . '.' . $imagePath->getClientOriginalExtension();
            $imagePath = $imagePath->storeAs('uploads/categories', $fileName, 'public'); //lưu vào thư mục categories trong public
        }

        Category::create([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name')), // Tạo slug từ name
            'description' => $request->input('description'),
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.categories.add')->with('success', 'Thêm danh mục sản phẩm thành công!');
    }
}
