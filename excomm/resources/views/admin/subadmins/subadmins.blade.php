@extends('admin.layout.layout')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Sub Admin</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Sub Admin</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Sub Admin</h3>
                            @if($pagesModule['full_access']==1)
                            <a style="max-width: 150px; float: right;" href="{{url('admin/add-edit-subadmin')}}" class="btn btn-block btn-primary">Add Sub Admin</a>
                            @endif
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="subadmins" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        <th>Email</th>
                                        <th>Type</th>
                                        <th>Created On</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subadmins as $subadmin)
                                    @if(Auth::guard('admin')->user()->type =='subadmin' && $subadmin['type'] =='admin')
                                    @continue

                                    @endif
                                    <tr>
                                        <td>{{ $subadmin['id'] }}</td>
                                        <td>{{ $subadmin['name'] }}</td>
                                        <td>{{ $subadmin['mobile'] }}</td>
                                        <td>{{ $subadmin['email'] }}</td>
                                        <td>{{ $subadmin['type'] }}</td>
                                        <td>{{ date("d-m-Y", strtotime($subadmin['created_at'])) }}</td>
                                        <td>
                                            @if (($pagesModule['edit_access'] == 1 || $pagesModule['full_access'] == 1) && $subadmin['status'] == 1)
                                            <a class="updateSubAdminStatus" id="admin-{{ $subadmin['id'] }}" subadmin_id="{{ $subadmin['id'] }}" style='color:#3f6ed3' href="javascript:void(0)">
                                                <i class="fas fa-toggle-on" data-status="Active"></i>
                                            </a>
                                            @else
                                            <a class="updateSubAdminStatus" id="admin-{{ $subadmin['id'] }}" subadmin_id="{{ $subadmin['id'] }}" style="color: grey;" href="javascript:void(0)">
                                                <i class="fas fa-toggle-off" data-status="Inactive"></i>
                                            </a>
                                            @endif


                                            &nbsp;&nbsp;
                                            @if($pagesModule['edit_access']==1 || $pagesModule['full_access']==1)
                                            <a style="color: #3f6ed3;" href="{{ url('admin/add-edit-subadmin/'.$subadmin['id']) }}"><i class="fas fa-edit"></i></a>
                                            &nbsp;&nbsp;
                                            @endif
                                            @if($pagesModule['full_access']==1)
                                            <a style='color: #3f6ed3;' class="confirmDelete" name="SubAdmin" title="Delete SubAdmin" href="{{ url('admin/delete-subadmin/'.$subadmin['id']) }}"><i class="fas fa-trash"></i></a>
                                            &nbsp;&nbsp;
                                            <a style="color: #3f6ed3;" href="{{ url('admin/update-role/'.$subadmin['id']) }}"><i class="fas fa-bars"></i></a>
                                            @endif
                                        </td>
                                    </tr>

                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection