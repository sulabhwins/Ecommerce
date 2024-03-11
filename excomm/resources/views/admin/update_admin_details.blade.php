@extends('admin.layout.layout')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard v2</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Update Password v2</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Update Details </h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        @if($errors->any())
                        {!! implode('', $errors->all('<div style="color:red">:message</div>')) !!}
                        @endif
                        <form method="post" enctype="multipart/form-data" action="{{ route('admin.processUpdateDetails') }}">
                            @csrf

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="admin_email">Email address</label>
                                    <input type="email" class="form-control" id="admin_email" value="{{Auth::guard('admin')->user()->email}}" readonly="" style="background-color: #666;">
                                </div>

                                <div class="form-group">
                                    <label for="admin_name">Name</label>
                                    <input type="text" class="form-control" id="admin_name" name="admin_name" placeholder="Name">
                                    <span id="verifyCurrentPwd"></span>
                                </div>

                                <div class="form-group">
                                    <label for="mobile">Mobile</label>
                                    <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile">
                                </div>

                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <input type="file" name="image" id="image" class="form-control">
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
                <!--/.col (left) -->
            </div>
        </div>
        <!-- /.card-body -->
    </section>
</div>
<!-- /.content-wrapper -->
@endsection