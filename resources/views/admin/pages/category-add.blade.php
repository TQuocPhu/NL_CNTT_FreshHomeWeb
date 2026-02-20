@extends('layouts.admin')

@section('title', 'Tạo danh mục sản phẩm mới')

@section('content')

    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3> Tạo Danh Mục Sản Phẩm Mới </h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 ">
                    <div class="x_panel disabled-form-panel">
                        <div class="x_title">
                            <h2>Thêm Danh Mục Mới <small style="color:red;">(Hiện tại đã có 5 danh mục sản phẩm và không cần
                                    thiết phải thêm mới.)</small></h2>
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
                            <form action="{{ route('admin.categories.add-post') }}" id="add-category" method="post"
                                class="form-horizontal form-label-left" enctype="multipart/form-data">
                                @csrf
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="category-name">Tên danh
                                        mục
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="category-name" required="required" name="name"
                                            class="form-control ">
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align"
                                        for="category-description">Mô tả
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="category-description" name="description" required="required"
                                            class="form-control">
                                        @error('description')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label for="category-image" class="col-form-label col-md-3 col-sm-3 label-align"> Hình
                                        ảnh </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <label for="category-image" class="custom-file-upload"> Chọn ảnh </label>
                                        <input type="file" name="image" id="category-image" accept="image/*">
                                        @error('image')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                        <img src="" alt="Ảnh xem trước" id="image-preview" class="image-preview">
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="item form-group">
                                    <div class="col-md-6 col-sm-6 offset-md-3">
                                        <button class="btn btn-primary btn-reset" type="reset">Reset</button>
                                        <button type="submit" class="btn btn-success">Thêm danh mục </button>
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