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
                        <form name="productForm" id="productForm" @if(empty($product['id'])) action="{{ url('admin/add-edit-product') }}" @else action="{{ url('admin/add-edit-product/'.$product['id']) }}" @endif method="post" enctype="multipart/form-data">
                            @csrf

                            <!-- ... (your existing form fields) ... -->

                            <div class="form-group">
                                <!-- set the dropdown to show only that category where parent id is 0 -->
                                <label for="category_name">Category Name</label>
                                <select class="form-control" id="category_name" name="category_id">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                    @if($category['parent_id'] == 0)
                                    <option value="{{ $category['id'] }}">{{ $category['category_name'] }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <!-- set the dropdown to show only that category where parent id is selected in the category dropdown -->
                                <label for="sub_category_name">Sub Category Name</label>
                                <select class="form-control" id="sub_category_name" name="subcategory_id">
                                    <option value="">Select Sub Category</option>
                                </select>
                                <!-- Add the hidden input field for subcategory_id -->
                                <input type="hidden" id="hidden_subcategory_id" name="subcategory_id" value="">
                            </div>


                            <div class="form-group">
                                <!-- auto-fill where admin is login and hide this field -->
                                <label for="vender_id">Vendor_id</label>
                                <input type="text" class="form-control" id="vender_id" name="vender_id" value="{{ Auth::guard('admin')->user()->id }}" readonly>
                            </div>

                            <div class="form-group">
                                <label for="product_name">Product Name*</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Product Name" @if(!empty($product['name'])) value="{{ $product['name'] }}" @endif>
                            </div>
                            <div class="form-group">
                                <label for="color">Color</label>
                                <select class="form-control" id="color" name="color">
                                    <option value="red" @if(!empty($product['color']) && $product['color']=='red' ) selected @endif>Red</option>
                                    <option value="blue" @if(!empty($product['color']) && $product['color']=='blue' ) selected @endif>Blue</option>
                                    <option value="green" @if(!empty($product['color']) && $product['color']=='green' ) selected @endif>Green</option>
                                    <option value="black" @if(!empty($product['color']) && $product['color']=='black' ) selected @endif>Black</option>
                                    <option value="yellow" @if(!empty($product['color']) && $product['color']=='yellow' ) selected @endif>Yellow</option>
                                    <option value="white" @if(!empty($product['color']) && $product['color']=='white' ) selected @endif>White</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="product_name">Product titel*</label>
                                <input type="text" class="form-control" id="product_titel" name="titel" placeholder="Enter Product titel" @if(!empty($product['titel'])) value="{{ $product['product_titel'] }}" @endif>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" rows="3" id="description" name="description" placeholder="Enter Description">@if(!empty($category['description'])){{ $category['description'] }}@endif</textarea>
                            </div>

                            <div class="form-group">
                                <label for="selling_price">Selling Price</label>
                                <input type="text" class="form-control" id="selling_price" name="saling_price" placeholder="Enter Selling Price" @if(!empty($product['saling_price'])) value="{{ $product['saling_price'] }}" @endif>
                            </div>

                            <div class="form-group">
                                <label for="images">Product Image</label>
                                <input type="file" class="form-control" id="product_image" name="product_image">

                                <div>
                                    @if(!empty($product['product_image']))
                                    @php
                                    $imagePaths = $product['product_image'];
                                    @endphp
                                    <div>
                                        <img style="width: 100px;" src="{{ asset('storage/images/'.$imagePaths) }}">
                                        &nbsp;&nbsp;
                                        <a style='color: #3f6ed3;' class="confirmDeleteArrayI" href="javascript:;" name="Product_Image" protid="{{ $product['id'] }}" title="Delete Category Image" url-attr="{{ $imagePaths }}">
                                            <i class="fas fa-trash"></i>
                                        </a>

                                        &nbsp;&nbsp;
                                        <span>{{ $imagePaths }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input type="numder" class="form-control" id="quintity" name="quintity" placeholder="Enter Quantity" @if(!empty($product['quintity'])) value="{{ $product['quintity'] }}" @endif>
                            </div>

                            <div class="form-group">
                                <label for="url">URL*</label>
                                <input type="text" class="form-control" id="url" name="url" placeholder="Enter Product URL" @if(!empty($product['url'])) value="{{ $product['url'] }}" @endif>
                            </div>

                            <div class="form-group">
                                <label for="meta_title">Meta Title</label>
                                <input type="text" class="form-control" id="meta_title" name="meta_title" placeholder="Enter Meta Title" @if(!empty($product['meta_title'])) value="{{ $product['meta_title'] }}" @endif>
                            </div>

                            <div class="form-group">
                                <label for="meta_description">Meta Description</label>
                                <input type="text" class="form-control" id="meta_description" name="meta_description" placeholder="Enter Meta Description" @if(!empty($product['meta_description'])) value="{{ $product['meta_description'] }}" @endif>
                            </div>

                            <div class="form-group">
                                <label for="meta_keywords">Meta Keywords</label>
                                <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" placeholder="Enter Meta Keywords" @if(!empty($product['meta_keywords'])) value="{{ $product['meta_keywords'] }}" @endif>
                            </div>

                            <div class="form-group">
                                <label for="is_featured">Is Featured</label>
                                <!-- set the radio button for yes or no -->
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_featured" id="is_featured_yes" value="1" @if(!empty($product['is_featured']) && $product['is_featured']==1) checked @endif>
                                    <label class="form-check-label" for="is_featured_yes">
                                        Yes
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_featured" id="is_featured_no" value="0" @if(!empty($product['is_featured']) && $product['is_featured']==0) checked @endif>
                                    <label class="form-check-label" for="is_featured_no">
                                        No
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="1" @if(!empty($product['status']) && $product['status']==1) selected @endif>Active</option>
                                    <option value="0" @if(!empty($product['status']) && $product['status']==0) selected @endif>Inactive</option>
                                </select>
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