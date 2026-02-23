<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AdminProductController extends Controller
{
    //
    public function index()
    {
        $products = Product::select('id', 'name', 'description', 'category_id', 'price', 'slug', 'status', 'stock', 'unit')
            ->with('category', 'images')->get();
        $categories = Category::select('id', 'name', 'slug', 'description', 'image')->get();
        return view('admin.pages.products', compact('categories', 'products'));
    }

    public function showFormAddProduct()
    {
        $categories = Category::select('id', 'name')->get();
        return view('admin.pages.product-add', compact('categories'));
    }

    public function addProduct(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|min:5|max:255|unique:products,name',
            'category_id' => 'required|integer|exists:categories,id',
            'description' => 'required|string|min:10', //Mô tả tối thiểu 10 ký tự
            'price'       => 'required|numeric|min:0|max:9999999999', // Giới hạn giá trị tối đa tránh lỗi database
            'stock'       => 'required|integer|min:0|max:1000000', // Không nên để nullable nếu logic nghiệp vụ cần số lượng
            'unit'        => 'required|string|max:50', // Đơn vị tính (kg, cái, hộp...)
            'images'      => 'required|array|min:1|max:5', // Giới hạn tối thiểu 1 và tối đa 5 ảnh
            'images.*'    => 'image|mimes:jpeg,png,jpg,webp|max:2048', // Giới hạn định dạng và dung lượng
        ], [
            'name.required'        => 'Vui lòng nhập tên sản phẩm.',
            'name.min'             => 'Tên sản phẩm phải có ít nhất 5 ký tự.',
            'name.unique'          => 'Tên sản phẩm này đã tồn tại.',
            'category_id.required' => 'Vui lòng chọn danh mục sản phẩm.',
            'category_id.exists'   => 'Danh mục không hợp lệ.',
            'description.required' => 'Mô tả sản phẩm không được để trống.',
            'description.min'      => 'Mô tả phải chi tiết một chút (ít nhất 10 ký tự).',
            'price.required'       => 'Vui lòng nhập giá tiền.',
            'price.numeric'        => 'Giá tiền phải là con số.',
            'price.min'            => 'Giá tiền không thể âm.',
            'stock.required'       => 'Vui lòng nhập số lượng tồn kho.',
            'stock.integer'        => 'Số lượng phải là số nguyên.',
            'unit.required'        => 'Vui lòng nhập đơn vị tính.',
            'images.required'      => 'Sản phẩm phải có ít nhất một hình ảnh.',
            'images.array'         => 'Dữ liệu hình ảnh không đúng định dạng.',
            'images.max'           => 'Bạn chỉ được tải lên tối đa 5 hình ảnh.',
            'images.*.image'       => 'File tải lên phải là hình ảnh.',
            'images.*.mimes'       => 'Ảnh phải có định dạng: jpeg, png, jpg hoặc webp.',
            'images.*.max'         => 'Mỗi ảnh không được vượt quá 2MB.',
        ]);

        try {
            return DB::transaction(function () use ($request) {
                //Tạo sản phẩm
                $product = Product::create([
                    'name'        => $request->name,
                    'slug'        => Str::slug($request->name) . '-' . time(),
                    'category_id' => $request->category_id,
                    'description' => $request->description,
                    'price'       => $request->price,
                    'stock'       => $request->stock ?? 0,
                    'unit'        => $request->unit ?? "kg",
                    'status'      => "in_stock",
                ]);

                if ($request->hasFile('images')) {
                    $manager = new ImageManager(new Driver());

                    foreach ($request->file('images') as $image) {
                        $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                        $path = 'uploads/products/' . $imageName;

                        // Resize và tối ưu ảnh
                        $processedImage = $manager->read($image)
                            ->cover(600, 600)
                            ->encode();

                        Storage::disk('public')->put($path, (string)$processedImage); // => storage/public/path.

                        ProductImage::create([
                            'product_id' => $product->id,
                            'image' => $path,
                        ]);
                    }
                }

                $product->save();

                toastr()->success('Sản phẩm đã được thêm thành công!');
                return redirect()->route('admin.products.add');
            });
        } catch (\Exception $e) {
            // dd($e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
        }
    }

    public function updateProduct(Request $request)
    {
        // 1. Validate dữ liệu
        $validator = Validator::make($request->all(), [
            'product_id'  => 'required|exists:products,id',
            'name'        => [
                'required',
                'string',
                'min:5',
                'max:255',
                Rule::unique('products', 'name')->ignore($request->product_id)
            ],
            'category_id' => 'required|integer|exists:categories,id',
            'description' => 'required|string|min:10',
            'price'       => 'required|numeric|min:0|max:9999999999',
            'stock'       => 'required|integer|min:0|max:1000000',
            'unit'        => 'required|string|max:50',
            'images'      => 'nullable|array|max:5',
            'images.*'    => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'name.required'        => 'Vui lòng nhập tên sản phẩm',
            'name.unique'          => 'Tên sản phẩm này đã được sử dụng bởi sản phẩm khác.',
            'name.min'             => 'Tên sản phẩm phải có ít nhất 5 ký tự.',
            'category_id.required' => 'Vui lòng chọn danh mục sản phẩm.',
            'category_id.exists'   => 'Danh mục không hợp lệ.',
            'description.required' => 'Mô tả sản phẩm không được để trống.',
            'description.min'      => 'Mô tả phải chi tiết một chút (ít nhất 10 ký tự).',
            'price.required'       => 'Vui lòng nhập giá tiền.',
            'price.numeric'        => 'Giá tiền phải là con số.',
            'price.min'            => 'Giá tiền không thể âm.',
            'stock.required'       => 'Vui lòng nhập số lượng tồn kho.',
            'stock.integer'        => 'Số lượng phải là số nguyên.',
            'unit.required'        => 'Vui lòng nhập đơn vị tính.',
            'images.array'         => 'Dữ liệu hình ảnh không đúng định dạng.',
            'images.max'           => 'Bạn chỉ được tải lên tối đa 5 hình ảnh.',
            'images.*.image'       => 'File tải lên phải là hình ảnh.',
            'images.*.mimes'       => 'Ảnh phải có định dạng: jpeg, png, jpg hoặc webp.',
            'images.*.max'         => 'Mỗi ảnh không được vượt quá 2MB.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            return DB::transaction(function () use ($request) {
                $product = Product::findOrFail($request->product_id);

                if (!$product) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Sản phẩm không tồn tại!',
                    ], 404);
                }

                $product->update([
                    'name'        => $request->name,
                    'category_id' => $request->category_id,
                    'description' => $request->description,
                    'price'       => $request->price,
                    'stock'       => $request->stock,
                    'unit'        => $request->unit,
                    'status'      => $request->stock > 0 ? 'in_stock' : 'out_of_stock',
                ]);

                //Xử lý ảnh
                if ($request->hasFile('images')) {
                    foreach ($product->images as $oldImage) {
                        if (Storage::disk('public')->exists($oldImage->image)) {
                            Storage::disk('public')->delete($oldImage->image);
                        }
                        $oldImage->delete();
                    }

                    $manager = new ImageManager(new Driver());

                    foreach ($request->file('images') as $image) {
                        $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                        $path = 'uploads/products/' . $imageName;

                        $processedImage = $manager->read($image)
                            ->cover(600, 600)
                            ->encode();

                        Storage::disk('public')->put($path, (string)$processedImage);

                        ProductImage::create([
                            'product_id' => $product->id,
                            'image'      => $path,
                        ]);
                    }
                }

                $product->load('category', 'images');

                return response()->json([
                    'status'  => true,
                    'message' => 'Sản phẩm đã được cập nhật thành công!',
                    'data' => [
                        'id' => $product->id,
                        'name' => $product->name,
                        'slug' => $product->slug,
                        'description' => $product->description,
                        'price' => $product->price,
                        'stock' => $product->stock,
                        'unit' => $product->unit,
                        'status' => $product->status,
                        'category_name' => $product->category->name,
                        'image_first'   => $product->image_url,
                        'images' => $product->images->map(fn($img) => asset('storage/' . $img->image)),
                    ],
                ]);
            });
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteProduct(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        try {
            $product = Product::findOrFail($request->product_id);

            if(!$product) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Sản phẩm không tồn tại',
                ], 404);
            }

            $existsInOrder = OrderItem::where('product_id', $product->id)->exists();

            if ($existsInOrder) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Không thể xóa! Sản phẩm này đã có trong đơn hàng của khách.'
                ], 400);
            }

            return DB::transaction(function () use ($product) {
                // $product = Product::with('images')->findOrFail($request->product_id);

                foreach ($product->images as $image) {
                    if (Storage::disk('public')->exists($image->image)) {
                        Storage::disk('public')->delete($image->image);
                    }
                }

                $product->images()->delete();
                $product->delete();

                return response()->json([
                    'status'  => true,
                    'message' => 'Sản phẩm đã được xóa vĩnh viễn!'
                ]);
            });
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Lỗi hệ thống: ' . $e->getMessage()
            ], 500);
        }
    }
}
