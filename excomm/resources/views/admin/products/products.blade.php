@extends('admin.layout.layout')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Products</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Products</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Products</h3>
                            @if($pagesModule['full_access']==1)
                            <a style="max-width: 150px; float: right;" href="{{url('admin/add-edit-product')}}" class="btn btn-block btn-primary">Add New Product</a>
                            @endif
                        </div>
                        <div class="card-body">
                            <table id="products" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Product Name</th>
                                        <th>Category</th>
                                        <th>Created On</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                    <tr>
                                        <td>{{$product['id']}}</td>
                                        <td>{{$product['name']}}</td>
                                        <td>
                                            @if(isset($product['category']))
                                            {{ $product['category']['category_name'] }}
                                            @endif
                                        </td>
                                        <td>{{ date("d-m-Y", strtotime($product['created_at'])) }}</td>
                                        <td>
                                            @if($pagesModule['edit_access']==1 || $pagesModule['full_access']==1)
                                            @if($product['status']==1)
                                            <a class="updateProductStatus" id="product-{{$product['id']}}" product_id="{{$product['id']}}" style='color:#3f6ed3' href="javascript:void(0)">
                                                <i class="fas fa-toggle-on" status="Active"></i>
                                            </a>
                                            @else
                                            <a class="updateProductStatus" id="product-{{$product['id']}}" product_id="{{$product['id']}}" style="color: grey;" href="javascript:void(0)">
                                                <i class="fas fa-toggle-off" status="Inactive"></i>
                                            </a>
                                            @endif

                                            &nbsp;&nbsp;
                                            @endif

                                            @if($pagesModule['edit_access']==1 || $pagesModule['full_access']==1)
                                            <a style="color: #3f6ed3;" href="{{ url('admin/add-edit-product/'.$product['id']) }}"><i class="fas fa-edit"></i></a>
                                            &nbsp;&nbsp;
                                            @endif

                                            @if($pagesModule['full_access']==1)
                                            <a style='color: #3f6ed3;' class="confirmDelete" name="Product" title="Delete Product" href="{{ url('admin/delete-product/'.$product['id']) }}">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection