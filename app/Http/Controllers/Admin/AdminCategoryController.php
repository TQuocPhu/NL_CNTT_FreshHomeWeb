<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use function Symfony\Component\Clock\now;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::select('id', 'name', 'slug', 'description', 'image')->latest()->get();
        return view('admin.pages.categories', compact('categories'));
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

        if ($request->hasFile('image')) {
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

    public function updateCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255|unique:categories,name,' . $request->category_id,
            'description' => 'required|string|min:10',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'name.required' => 'Tên danh mục không được để trống.',
            'name.unique'   => 'Tên danh mục này đã tồn tại.',
            'description.required' => 'Mô tả không được để trống.',
            'description.min' => 'Mô tả phải có ít nhất 10 ký tự.',
            'image.image'   => 'File tải lên phải là hình ảnh.',
            'image.max'     => 'Kích thước ảnh không được vượt quá 2MB.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            $category = Category::findOrFail($request->category_id);

            if (!$category) {
                return response()->json([
                    'status' => false,
                    'message' => 'Danh mục sản phẩm không tồn tại',
                ], 404);
            }

            $category->name = $request->name;
            $category->slug = Str::slug($request->name); // Tự động cập nhật lại slug khi đổi tên
            $category->description = $request->description;

            //Xử lý ảnh
            if ($request->hasFile('image')) {
                if ($category->image && Storage::disk('public')->exists($category->image)) {
                    Storage::disk('public')->delete($category->image);
                }

                $file = $request->file('image');
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $imagePath = $file->storeAs('uploads/categories', $fileName, 'public');

                $category->image = $imagePath;
            }

            $category->save();

            return response()->json([
                'status'  => true,
                'message' => 'Cập nhật danh mục thành công!',
                'data'    => [
                    'id'          => $category->id,
                    'name'        => $category->name,
                    'slug'        => $category->slug,
                    'description' => $category->description,
                    'image'       => asset('storage/' . $category->image),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Lỗi hệ thống: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function deleteCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
        ], [
            'category_id.required' => 'Thiếu ID danh mục.',
            'category_id.exists'   => 'Danh mục không tồn tại trên hệ thống.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        try {
            $category = Category::withCount('products')->findOrFail($request->category_id);

            if (!$category) {
                return response()->json([
                    'status' => false,
                    'message' => 'Danh mục không tồn tại.',
                ], 404);
            }

            if ($category->products_count > 0) {
                return response()->json([
                    'status'  => false,
                    'message' => "Không thể xóa! Danh mục này đang chứa {$category->products_count} sản phẩm.",
                ], 400);
            }

            $oldImagePath = $category->image;

            $category->delete();

            if ($oldImagePath && Storage::disk('public')->exists($oldImagePath)) {
                Storage::disk('public')->delete($oldImagePath);
            }

            return response()->json([
                'status'  => true,
                'message' => 'Đã xóa danh mục thành công!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Lỗi hệ thống khi xóa: ' . $e->getMessage(),
            ], 500);
        }
    }
}
