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
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
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
                        <form name="subAdminForm" id="subAdminForm" action="{{ url('admin/update-role/'.$id) }}" method="post">
                            @csrf
                            <div class="card-body">
                                <input type="hidden" name="subadmin_id" value="{{ $id }}">
                                @php
                                $viewCMSPages = $editCMSPages = $fullCMSPages = '';
                                $viewAdminRoles = $editAdminRoles = $fullAdminRoles = '';
                                $viewCategories = $editCategories = $fullCategories = '';
                                $viewProduct = $editProduct = $fullProduct='';
                                @endphp
                                @if(!empty($subadminRoles))
                                @foreach($subadminRoles as $role)
                                @if($role['module']=="cms_pages")
                                @php
                                $viewCMSPages = ($role['view_access'] == 1) ? 'checked' : '';
                                $editCMSPages = ($role['edit_access'] == 1) ? 'checked' : '';
                                $fullCMSPages = ($role['full_access'] == 1) ? 'checked' : '';
                                @endphp
                                @endif
                                @if($role['module']=="admin_roles")
                                @php
                                $viewAdminRoles = ($role['view_access'] == 1) ? 'checked' : '';
                                $editAdminRoles = ($role['edit_access'] == 1) ? 'checked' : '';
                                $fullAdminRoles = ($role['full_access'] == 1) ? 'checked' : '';
                                @endphp
                                @endif
                                @if($role['module']=="admin_category")
                                @php
                                $viewCategories = ($role['view_access'] == 1) ? 'checked' : '';
                                $editCategories = ($role['edit_access'] == 1) ? 'checked' : '';
                                $fullCategories = ($role['full_access'] == 1) ? 'checked' : '';
                                @endphp
                                @endif

                                @if($role['module']=="admin_product")
                                @php
                                $viewProduct = ($role['view_access'] == 1) ? 'checked' : '';
                                $editProduct = ($role['edit_access'] == 1) ? 'checked' : '';
                                $fullProduct = ($role['full_access'] == 1) ? 'checked' : '';
                                @endphp
                                @endif

                                @if($role['module']=="admin_orders")
                                @php
                                $viewOrder = ($role['view_access'] == 1) ? 'checked' : '';
                                $editOrder = ($role['edit_access'] == 1) ? 'checked' : '';
                                $fullOrder = ($role['full_access'] == 1) ? 'checked' : '';
                                @endphp
                                @endif


                                @endforeach
                                @endif

                                <div class="form-group">
                                    <label for="cms_pages">CMS Pages: &nbsp;&nbsp;</label>
                                    <input type="checkbox" name="access[cms_pages][view]" value="1" {{ $viewCMSPages }}>&nbsp;&nbsp;View Access &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="access[cms_pages][edit]" value="1" {{ $editCMSPages }}>&nbsp;&nbsp;View/Edit Access &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="access[cms_pages][full]" value="1" {{ $fullCMSPages }}>&nbsp;&nbsp;Full Access &nbsp;&nbsp;&nbsp;&nbsp;
                                </div>
                                <div class="form-group">
                                    <label for="admin_roles">Admin Roles: &nbsp;&nbsp;</label>
                                    <input type="checkbox" name="access[admin_roles][view]" value="1" {{ $viewAdminRoles }}>&nbsp;&nbsp;View Access &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="access[admin_roles][edit]" value="1" {{ $editAdminRoles }}>&nbsp;&nbsp;View/Edit Access &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="access[admin_roles][full]" value="1" {{ $fullAdminRoles }}>&nbsp;&nbsp;Full Access &nbsp;&nbsp;&nbsp;&nbsp;
                                </div>

                                <div class="form-group">
                                    <label for="admin_category">Categories: &nbsp;&nbsp;</label>
                                    <input type="checkbox" name="access[admin_category][view]" value="1" {{ $viewCategories }}>&nbsp;&nbsp;View Access &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="access[admin_category][edit]" value="1" {{ $editCategories }}>&nbsp;&nbsp;View/Edit Access &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="access[admin_category][full]" value="1" {{ $fullCategories }}>&nbsp;&nbsp;Full Access &nbsp;&nbsp;&nbsp;&nbsp;
                                </div>

                                <div class="form-group">
                                    <label for="admin_category">Product: &nbsp;&nbsp;</label>
                                    <input type="checkbox" name="access[admin_product][view]" value="1" {{ $viewProduct }}>&nbsp;&nbsp;View Access &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="access[admin_product][edit]" value="1" {{ $editProduct }}>&nbsp;&nbsp;View/Edit Access &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="access[admin_product][full]" value="1" {{ $fullProduct }}>&nbsp;&nbsp;Full Access &nbsp;&nbsp;&nbsp;&nbsp;
                                </div>

                                <div class="form-group">
                                    <label for="admin_orders">Product Details: &nbsp;&nbsp;</label>
                                    <input type="checkbox" name="access[admin_orders][view]" value="1" {{ $viewProduct }}>&nbsp;&nbsp;View Access &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="access[admin_orders][edit]" value="1" {{ $editProduct }}>&nbsp;&nbsp;View/Edit Access &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="access[admin_orders][full]" value="1" {{ $fullProduct }}>&nbsp;&nbsp;Full Access &nbsp;&nbsp;&nbsp;&nbsp;
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
