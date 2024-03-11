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
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
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
                        <form name="subAdminForm" id="subAdminForm" enctype="multipart/form-data" @if(empty($subadmin['id'])) action="{{ url('admin/add-edit-subadmin') }}" @else action="{{ url('admin/add-edit-subadmin/'.$subadmin['id']) }}" @endif method="post">
                            @csrf

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Name*</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter SubAdmin Name" value="{{ $subadmin['name'] ?? '' }}">
                                </div>

                                <div class="form-group">
                                    <label for="type">Type*</label>
                                    <input type="text" class="form-control" id="type" name="type" placeholder="Enter SubAdmin Type" value="{{ $subadmin['type'] ?? '' }}">
                                </div>

                                <div class="form-group">
                                    <label for="mobile">Mobile*</label>
                                    <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter SubAdmin Mobile" value="{{ $subadmin['mobile'] ?? '' }}">
                                </div>

                                <div class="form-group">
                                    <label for="email">Email*</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter SubAdmin Email" value="{{ $subadmin['email'] ?? '' }}">
                                </div>

                                <div class="form-group">
                                    <label for="password">Password*</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter SubAdmin Password">
                                </div>

                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <input type="file" class="form-control" id="image" name="image">
                                </div>

                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="1" @if(!empty($subadmin['status']) && $subadmin['status']==1) selected @endif>Active</option>
                                        <option value="0" @if(!empty($subadmin['status']) && $subadmin['status']==0) selected @endif>Inactive</option>
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
@endsection