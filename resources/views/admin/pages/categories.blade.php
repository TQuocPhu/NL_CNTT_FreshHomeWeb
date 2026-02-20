@extends('layouts.admin')

@section('title', 'Danh mục sản phẩm')

@section('content')

    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3> Quản Lý Danh Mục Sản Phẩm </h3> <small>Danh sách tất cả danh mục </small>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 ">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Danh Sách Danh Mục </h2>
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
                                            Trang quản lý danh mục sản phẩm cho phép admin thêm, sửa, xóa và quản lý các
                                            danh mục sản phẩm một cách hiệu quả.
                                            Các danh mục giúp tổ chức sản phẩm theo từng nhóm, dễ dàng tìm kiếm và quản lý.
                                            Dữ liệu hiển thị dưới dạng bảng với các chức năng tìm kiếm, phân trang và thao
                                            tác nhanh chóng.
                                        </p>
                                        <table id="datatable-buttons" class="table table-striped table-bordered"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Hình ảnh</th>
                                                    <th>Tên danh mục</th>
                                                    <th>Slug</th>
                                                    <th>Mô tả</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($categories as $category)
                                                    <tr id="category-row-{{ $category->id }}">
                                                        <td>
                                                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="category-image" width="100">
                                                        </td>
                                                        <td>{{ $category->name }}</td>
                                                        <td>{{ $category->slug }}</td>
                                                        <td>{{ $category->description }}</td>
                                                        <td><a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalUpdate-{{ $category->id }}"><i class="fa fa-edit"></i> Chỉnh sửa</a></td>
                                                        <td><a href="#" class="btn btn-danger btn-sm btn-delete-submit-category" data-id="{{ $category->id }}"><i class="fa fa-trash"></i> Xóa</a></td>
                                                    </tr>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="modalUpdate-{{ $category->id }}" tabindex="-1" aria-labelledby="categoryModelLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="categoryModelLabel">Chỉnh sửa</h5>
                                                                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="" id="update-category" method="post" class="form-horizontal form-label-left" enctype="multipart/form-data">
                                                                        @csrf
                                                                        <div class="item form-group">
                                                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="category-name">Tên danh mục
                                                                                <span class="required">*</span>
                                                                            </label>
                                                                            <div class="col-md-6 col-sm-6 ">
                                                                                <input type="text" id="category-name" required="required" name="name"
                                                                                    class="form-control" value="{{ $category->name }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="item form-group">
                                                                            <label class="col-form-label col-md-3 col-sm-3 label-align"
                                                                                for="category-description">Mô tả
                                                                                <span class="required">*</span>
                                                                            </label>
                                                                            <div class="col-md-6 col-sm-6 ">
                                                                                <input type="text" id="category-description" name="description"
                                                                                    required="required" class="form-control" value="{{ $category->description }}">
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="item form-group">
                                                                            <label for="category-image" class="col-form-label col-md-3 col-sm-3 label-align"> Hình
                                                                                ảnh </label>
                                                                            <div class="col-md-6 col-sm-6 ">
                                                                                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" id="image-preview" class="image-preview">
                                                                                <label for="category-image-{{ $category->id }}" class="custom-file-upload"> Chọn ảnh </label>
                                                                                <input type="file" name="image" id="category-image-{{ $category->id }}" class="category-image-input" data-id="{{ $category->id }}" accept="image/*">
                                                                            </div>
                                                                        </div>
                                                                        
                                                                    </form>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Quay lại</button>
                                                                    <button type="button" class="btn btn-primary btn-update-submit-category" data-id="{{ $category->id }}">Chỉnh sửa</button>
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