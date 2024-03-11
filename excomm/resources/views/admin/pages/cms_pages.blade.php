@extends('admin.layout.layout')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Cms Pages</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Cms Pages</li>
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
                            <h3 class="card-title">CMS Pages</h3>
                            @if($pagesModule['full_access']==1)
                            <a style="max-width: 150px; float: right;  " href="{{url('admin/add-edit-cms-page')}}" class="btn btn-block btn-primary">Add Cms Page</a>
                            @endif
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="cmspages" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>URL</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($CmsPages as $page)
                                    <tr>
                                        <td>{{$page['id']}}</td>
                                        <td>{{$page['title']}}</td>
                                        <td>{{$page['url']}}</td>
                                        <td>{{ date("d-m-Y", strtotime($page ['created_at'])) }}</td>
                                        <td>
                                            @if($pagesModule['edit_access']==1 || $pagesModule['full_access']==1)
                                            @if($page['status']==1)
                                            <a class="updateCmsPageStatus" id="page-{{$page['id']}}" page_id="{{$page['id']}}" style='color:#3f6ed3' href="javascript:void(0)">
                                                <i class="fas fa-toggle-on" status="Active"></i>
                                            </a>
                                            @else
                                            <a class="updateCmsPageStatus" id="page-{{$page['id']}}" page_id="{{$page['id']}}" style="color: grey;" href="javascript:void(0)">
                                                <i class="fas fa-toggle-off" status="Inactive"></i>
                                            </a>
                                            @endif
                                            &nbsp;&nbsp;
                                            @endif

                                            @if($pagesModule['edit_access']==1 || $pagesModule['full_access']==1)
                                            <a style="color: #3f6ed3;" href="{{ url('admin/add-edit-cms-page/'.$page['id']) }}"><i class="fas fa-edit"></i></a>
                                            &nbsp;&nbsp;
                                            @endif

                                            @if($pagesModule['full_access']==1)
                                            <a style='color: #3f6ed3;' class="confirmDelete" name="CMS Page" title="Delete CMS Page" href="{{ url('admin/delete-cms-page/'.$page['id']) }}"><i class="fas fa-trash"></i></a>
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