@extends('layouts.admin')

@section('title', 'Thêm sản phẩm mới')

@section('content')

    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3> Thêm Sản Phẩm Mới </h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 ">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Thêm Sản Phẩm </h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>

                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br />
                            <form action="{{ route('admin.product.add-post') }}" id="add-product" method="post"
                                class="form-horizontal form-label-left" enctype="multipart/form-data">
                                @csrf
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="product-name">Tên sản
                                        phẩm
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="product-name" required="required" name="name" value="{{ old('name') }}"
                                            class="form-control @error('name') is-invalid @enderror">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align"
                                        for="product-category-name">Danh mục
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <select name="category_id" id="product-category" required="required"
                                            class="form-control @error('category_id') is-invalid @enderror">
                                            <option value="">Chọn danh mục</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="product-description">Mô
                                        tả
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="product-description" name="description" required="required" value="{{ old('description') }}"
                                            class="form-control @error('description') is-invalid @enderror">
                                        @error('description')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="product-price">Giá tiền
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="product-price" name="price" required="required" value="{{ old('price') }}"
                                            class="form-control @error('price') is-invalid @enderror">
                                        @error('price')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="product-stock">Số lượng
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="product-stock" name="stock" required="required" value="{{ old('stock') }}"
                                            class="form-control @error('stock') is-invalid @enderror">
                                        @error('stock')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="product-unit">Đơn vị
                                        tính
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="product-unit" name="unit" required="required" value="{{ old('unit') }}"
                                            class="form-control @error('unit') is-invalid @enderror">
                                        @error('unit')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label for="product-images" class="col-form-label col-md-3 col-sm-3 label-align"> Hình
                                        ảnh </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <label for="product-images" class="custom-file-upload"> Chọn ảnh </label>
                                        <input type="file" name="images[]" id="product-images" accept="image/*" multiple
                                            class="form-control-file @error('images') is-invalid @enderror">
                                        <small class="text-muted">Có thể chọn nhiều ảnh cùng lúc.</small>
                                        @error('images')
                                            <div class="invalid-feedback d-block text-danger">{{ $message }}</div>
                                        @enderror
                                        @error('images.*')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                        <div id="image-preview-container" class="image-preview-container"></div>
                                    </div>
                                </div>

                                <div class="ln_solid"></div>

                                <div class="item form-group">
                                    <div class="col-md-6 col-sm-6 offset-md-3">
                                        <button class="btn btn-primary btn-reset btn-reset-form" type="reset">Reset</button>
                                        <button type="submit" class="btn btn-success">Thêm sản phẩm </button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection