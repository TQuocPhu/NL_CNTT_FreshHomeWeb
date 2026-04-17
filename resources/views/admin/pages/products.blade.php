@extends('layouts.admin')

@section('title', 'Sản phẩm')

@section('content')

    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3> Quản Lý Sản Phẩm </h3> <small>Danh sách tất cả sản phẩm </small>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 ">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Danh Sách Sản Phẩm </h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>

                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card-box table-responsive">
                                        <p class="text-muted font-13 m-b-30">
                                            Trang quản lý sản phẩm cho phép admin thêm, sửa, xóa và quản lý các
                                            sản phẩm một cách hiệu quả.
                                            Dữ liệu hiển thị dưới dạng bảng với các chức năng tìm kiếm, phân trang và thao
                                            tác nhanh chóng.
                                        </p>
                                        <table id="datatable-buttons" class="table table-striped table-bordered"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Hình ảnh</th>
                                                    <th>Tên sản phẩm</th>
                                                    <th>Danh mục</th>
                                                    <th>Slug</th>
                                                    <th>Mô tả</th>
                                                    <th>Số lượng</th>
                                                    <th>Giá (đ)</th>
                                                    <th>Đơn vị</th>
                                                    <th>Trạng thái</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($products as $product)
                                                    <tr id="product-row-{{ $product->id }}">
                                                        <td>
                                                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="image-product" width="80">
                                                        </td>
                                                        <td>{{ $product->name }}</td>
                                                        <td><strong>{{ $product->category->name }}</strong></td>
                                                        <td>{{ $product->slug }}</td>
                                                        {{-- <td>{{ $product->description }}</td> --}}
                                                        <td>
                                                            <div class="description-wrapper">
                                                                <span class="short-desc">
                                                                    {{ Str::words($product->description, 50, '...') }}
                                                                </span>

                                                                @if (str_word_count($product->description) > 50)
                                                                    <span class="full-desc" style="display: none;">
                                                                        {{ $product->description }}
                                                                    </span>
                                                                    <br>
                                                                    <a href="javascript:void(0);" class="btn-read-more text-primary" style="font-size: 11px; font-weight: bold;">
                                                                        Xem thêm
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td>{{ $product->stock }}</td>
                                                        <td data-order="{{ $product->price }}">
                                                            {{ $product->formatted_price_not_unit }}
                                                        </td>
                                                        <td>{{ $product->unit }}</td>
                                                        <td>{{ $product->status == 'in_stock' ? 'Còn hàng' : 'Hết hàng' }}</td>
                                                        <td><a href="#" class="btn-app btn btn-primary btn-sm" data-toggle="modal" data-target="#modalUpdate-{{ $product->id }}"><i class="fa fa-edit"></i>Chỉnh sửa</a></td>
                                                        <td><a href="#" class="btn-app btn btn-danger btn-sm btn-delete-submit-product" data-id="{{ $product->id }}"><i class="fa fa-trash"></i>Xóa</a></td>
                                                    </tr>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="modalUpdate-{{ $product->id }}" tabindex="-1" aria-labelledby="productModelLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="productModelLabel">Chỉnh sửa</h5>
                                                                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="" id="update-product" method="post" class="form-horizontal form-label-left" enctype="multipart/form-data">
                                                                        @csrf
                                                                        <div class="item form-group">
                                                                            <label class="col-form-label col-lg-3 col-sm-3 label-align" for="product-name">Tên sản phẩm
                                                                                <span class="required">*</span>
                                                                            </label>
                                                                            <div class="col-lg-8 col-sm-6 ">
                                                                                <input type="text" id="product-name" required name="name"
                                                                                    class="form-control @error('name') is-invalid @enderror" value="{{ $product->name }}">
                                                                                    @error('name')
                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                    @enderror
                                                                            </div>
                                                                        </div>

                                                                        <div class="item form-group">
                                                                            <label class="col-form-label col-lg-3 col-sm-3 label-align" for="product-category">Danh mục
                                                                                <span class="required">*</span>
                                                                            </label>
                                                                            <div class="col-lg-8 col-sm-6 ">
                                                                                <select name="category_id" id="category_id" required class="form-control @error('category_id') is-invalid @enderror">
                                                                                    <option value="">Chọn danh mục</option>
                                                                                    @foreach ($categories as $category)
                                                                                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id  ? 'selected' : ''}}>
                                                                                            {{ $category->name }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                                @error('category_id')
                                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>

                                                                        <div class="item form-group">
                                                                            <label class="col-form-label col-lg-3 col-sm-3 label-align"
                                                                                for="product-description">Mô tả
                                                                                <span class="required">*</span>
                                                                            </label>
                                                                            <div class="col-lg-8 col-sm-6 ">
                                                                                <input type="text" id="product-description" name="description"
                                                                                    required class="form-control @error('description') is-invalid @enderror" value="{{ $product->description }}">
                                                                                @error('description')
                                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>

                                                                        <div class="item form-group">
                                                                            <label class="col-form-label col-lg-3 col-sm-3 label-align" for="product-stock">Số lượng
                                                                                <span class="required">*</span>
                                                                            </label>
                                                                            <div class="col-lg-8 col-sm-6 ">
                                                                                <input type="number" id="product-stock" required name="stock"
                                                                                    class="form-control @error('stock') is-invalid @enderror" value="{{ $product->stock }}">
                                                                                @error('stock')
                                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>

                                                                        <div class="item form-group">
                                                                            <label class="col-form-label col-lg-3 col-sm-3 label-align" for="product-price">Giá tiền
                                                                                <span class="required">*</span>
                                                                            </label>
                                                                            <div class="col-lg-8 col-sm-6 ">
                                                                                <input type="number" id="product-price" required name="price"
                                                                                    class="form-control @error('price') is-invalid @enderror" value="{{ $product->price }}">
                                                                                @error('price')
                                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>

                                                                        <div class="item form-group">
                                                                            <label class="col-form-label col-lg-3 col-sm-3 label-align" for="product-unit">Đơn vị
                                                                                <span class="required">*</span>
                                                                            </label>
                                                                            <div class="col-lg-8 col-sm-6 ">
                                                                                <input type="text" id="product-unit" required name="unit"
                                                                                    class="form-control @error('unit') is-invalid @enderror" value="{{ $product->unit }}">
                                                                                @error('unit')
                                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="item form-group">
                                                                            <label for="product-images" class="col-form-label col-lg-3 col-sm-3 label-align"> Hình
                                                                                ảnh </label>
                                                                            <div class="col-lg-8 col-sm-6 ">
                                                                                <label for="product-images-{{ $product->id }}" class="custom-file-upload"> Chọn ảnh </label>
                                                                                <input type="file" name="images[]" id="product-images-{{ $product->id }}" class="product-images form-control-file @error('images') is-invalid @enderror" data-id="{{ $product->id }}" accept="image/*" multiple>
                                                                                @error('images')
                                                                                    <div class="invalid-feedback d-block text-danger">{{ $message }}</div>
                                                                                @enderror
                                                                                @error('images.*')
                                                                                    <div class="text-danger small">{{ $message }}</div>
                                                                                @enderror
                                                                                <div id="image-preview-container-{{ $product->id }}" class="image-preview-container image-preview-listproduct flex-wrap" data-id={{ $product->id }}="">
                                                                                    @foreach ($product->images as $image)
                                                                                        <img src="{{ asset('storage/' . $image->image) }}" alt="{{ $product->name }} Image" id="image-preview" class="image-preview">
                                                                                    @endforeach
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                    </form>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Quay lại</button>
                                                                    <button type="button" class="btn btn-primary btn-update-submit-product" data-id="{{ $product->id }}">Chỉnh sửa</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection