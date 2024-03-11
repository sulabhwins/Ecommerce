@extends('admin.layout.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $title }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">{{ $title }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ $title }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <form name="categoryForm" id="categoryForm" @if(empty($category['id'])) action="{{ url('admin/add-edit-category') }}" @else action="{{ url('admin/add-edit-category/'.$category['id']) }}" @endif method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="parent_id">Parent Category</label>
                                <select class="form-control" id="parent_id" name="parent_id">
                                    <option value="">Select Parent Category</option>
                                    @foreach($allCategories as $cat)
                                    <option value="{{ $cat->id }}" @if($category->parent_id == $cat->id) selected @endif>
                                        {{ $cat->category_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>



                            <div class="form-group">
                                <label for="category_name">Category Name*</label>
                                <input type="text" class="form-control" id="category_name" name="category_name" placeholder="Enter Category Name" @if(!empty($category['category_name'])) value="{{ $category['category_name'] }}" @endif>
                            </div>

                            <div class="form-group">
                                <label for="images">Images</label>
                                <input type="file" class="form-control" id="images" name="category_image">
                                <div>
                                    @if(!empty($category['category_image']))
                                    @php
                                    $imagePaths = $category['category_image'];
                                    @endphp
                                    <div>
                                     
                                        <img style="width: 100px;" src="{{ asset('storage/images/' . $imagePaths) }}">

                                        &nbsp;&nbsp;
                                        <a style='color: #3f6ed3;' class="confirmDeleteArray" href="javascript:;" name="Category_Image" catid="{{ $category['id'] }}" title="Delete Category Image" url-attr="{{ $imagePaths }}">
                                            <i class="fas fa-trash"></i>
                                        </a>

                                        &nbsp;&nbsp;
                                        <span>{{ $imagePaths }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="category_discount">Category Discount</label>
                                <input type="text" class="form-control" id="category_discount" name="category_discount" placeholder="Enter Category Discount" @if(!empty($category['category_discount'])) value="{{ $category['category_discount'] }}" @endif>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" rows="3" id="description" name="description" placeholder="Enter Description">@if(!empty($category['description'])){{ $category['description'] }}@endif</textarea>
                            </div>

                            <div class="form-group">
                                <label for="url">URL*</label>
                                <input type="text" class="form-control" id="url" name="url" placeholder="Enter Category URL" @if(!empty($category['url'])) value="{{ $category['url'] }}" @endif>
                            </div>

                            <div class="form-group">
                                <label for="meta_title">Meta Title</label>
                                <input type="text" class="form-control" id="meta_title" name="meta_title" placeholder="Enter Meta Title" @if(!empty($category['meta_title'])) value="{{ $category['meta_title'] }}" @endif>
                            </div>

                            <div class="form-group">
                                <label for="meta_description">Meta Description</label>
                                <input type="text" class="form-control" id="meta_description" name="meta_description" placeholder="Enter Meta Description" @if(!empty($category['meta_description'])) value="{{ $category['meta_description'] }}" @endif>
                            </div>

                            <div class="form-group">
                                <label for="meta_keywords">Meta Keywords</label>
                                <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" placeholder="Enter Meta Keywords" @if(!empty($category['meta_keywords'])) value="{{ $category['meta_keywords'] }}" @endif>
                            </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection