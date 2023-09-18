@extends('admin._layouts.default')
@section('content')
<!-- Top Bar Start -->
            <div class="topbar">            
                <!-- Navbar -->
                <nav class="navbar-custom">    
                    @include('admin._partials.profile_menu')
        
                    <ul class="list-unstyled topbar-nav mb-0">                        
                        <li>
                            <button class="nav-link button-menu-mobile">
                                <i data-feather="menu" class="align-self-center topbar-icon"></i>
                            </button>
                        </li>                          
                    </ul>
                </nav>
                <!-- end navbar-->
            </div>
            <!-- Top Bar End -->

            <!-- Page Content-->
            <div class="page-content">
                <div class="container-fluid">
                    <!-- Page-Title -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title-box">
                                <div class="row">
                                    <div class="col">
                                        <h4 class="page-title">Change Password</h4>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Admin</a></li>
                                            <li class="breadcrumb-item active">Change Password</li>
                                        </ol>
                                    </div><!--end col-->                                    
                                </div><!--end row-->                                                              
                            </div><!--end page-title-box-->
                        </div><!--end col-->
                    </div><!--end row-->
                    <!-- end page title end breadcrumb -->
                    
                    <div class="row">
                        <div class="col-lg-12">
                            @include('admin._partials.notifications')
                            <div class="card">
                                <div class="card-body">
                                    <form method="POST" action="{{ route('admin.update-password') }}" style="padding: 40px;">

                                        @csrf

                  

                                        <div class="form-group row">

                                            <label for="password" class="col-md-4 col-form-label text-md-right">Current Password</label>

                  

                                            <div class="col-md-6">

                                                <input id="password" type="password" class="form-control" name="current_password" autocomplete="current-password">

                                            </div>

                                        </div>

                  

                                        <div class="form-group row">

                                            <label for="password" class="col-md-4 col-form-label text-md-right">New Password</label>

                  

                                            <div class="col-md-6">

                                                <input id="new_password" type="password" class="form-control" name="new_password" autocomplete="current-password">

                                            </div>

                                        </div>

                  

                                        <div class="form-group row">

                                            <label for="password" class="col-md-4 col-form-label text-md-right">New Confirm Password</label>

                    

                                            <div class="col-md-6">

                                                <input id="new_confirm_password" type="password" class="form-control" name="new_confirm_password" autocomplete="current-password">

                                            </div>

                                        </div>

                   

                                        <div class="form-group row mb-0">

                                            <div class="col-md-8 offset-md-4">

                                                <button type="submit" class="btn btn-soft-primary">

                                                    Update Password

                                                </button>

                                            </div>

                                        </div>

                                    </form>
                                </div><!--end card-body-->
                            </div><!--end card-->
                        </div><!--end col-->
                    </div><!--end row-->

                </div><!-- container -->

                @include('admin._partials.footer')
            </div>
            <!-- end page content -->
@endsection