@extends('admin.layout.layout')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Categories</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Categories</li>
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
                            <h3 class="card-title">Categories</h3>
                            @if($pagesModule['full_access']==1)
                            <a style="max-width: 150px; float: right;" href="{{url('admin/add-edit-category')}}" class="btn btn-block btn-primary">Add New Categories</a>
                            @endif
                        </div>
                        <div class="card-body">
                            <table id="categories" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Category Name</th>
                                        <th>Parent Category</th>
                                        <th>URL</th>
                                        <th>Created On</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $category)
                                    <tr>
                                        <td>{{$category['id']}}</td>
                                        <td>{{$category['category_name']}}</td>
                                        <td>
                                            @if(isset($category['parentcategory']))
                                            {{ $category['parentcategory']['category_name'] }}
                                            @endif
                                        </td>
                                        <td>{{$category['url']}}</td>
                                        <td>{{ date("d-m-Y", strtotime($category['created_at'])) }}</td>
                                        <td>
                                            @if($pagesModule['edit_access']==1 || $pagesModule['full_access']==1)
                                            @if ($category['status'] == 1)
                                            <a class="updateCategoriesStatus" id="category-{{$category['id']}}" data-category-id="{{$category['id']}}" style='color:#3f6ed3' href="javascript:void(0)">
                                                <i class="fas fa-toggle-on" data-status="Active"></i>
                                            </a>
                                            @else
                                            <a class="updateCategoriesStatus" id="category-{{$category['id']}}" data-category-id="{{$category['id']}}" style="color: grey;" href="javascript:void(0)">
                                                <i class="fas fa-toggle-off" data-status="Inactive"></i>
                                            </a>
                                            @endif
                                            &nbsp;&nbsp;
                                            @endif

                                            @if($pagesModule['edit_access']==1 || $pagesModule['full_access']==1)
                                            <a style="color: #3f6ed3;" href="{{ url('admin/add-edit-category/'.$category['id']) }}"><i class="fas fa-edit"></i></a>
                                            &nbsp;&nbsp;
                                            @endif

                                            @if($pagesModule['full_access']==1)
                                            <a style='color: #3f6ed3;' class="confirmDelete" name="Category" title="Delete Category" href="{{ url('admin/delete-category/'.$category['id']) }}">
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