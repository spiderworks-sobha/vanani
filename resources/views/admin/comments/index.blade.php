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
                                        <h4 class="page-title">All Comments</h4>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Admin</a></li>
                                            <li class="breadcrumb-item active">All Comments</li>
                                        </ol>
                                    </div><!--end col-->
                                </div><!--end row-->                                                              
                            </div><!--end page-title-box-->
                        </div><!--end col-->
                    </div><!--end row-->
                    <!-- end page title end breadcrumb -->
                    @include('admin._partials.search_settings', ['search_settings'=>$search_settings])
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table table-hover demo-table-search table-responsive-block" id="datatable"
                                           data-datatable-ajax-url="{{ route($route.'.index') }}" >
                                        <thead id="column-search">
                                        <tr>
                                            <th class="nodisplay"></th>
                                            <th class="table-width-10">ID</th>
                                            <th class="table-width-120">Name</th>
                                            <th class="table-width-120">Email</th>
                                            <th class="table-width-120">Comment</th>
                                            <th class="table-width-120">Last Updated On</th>
                                            <th class="nosort nosearch table-width-10">Status</th>
                                            <th class="nosort nosearch table-width-10">Reply</th>
                                            <th class="nosort nosearch table-width-10">Delete</th>
                                        </tr>



                                        </thead>

                                        <tbody>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> 

                </div><!-- container -->

                @include('admin._partials.footer')
            </div>
            <!-- end page content -->
@endsection
@section('footer')
    <script>
        var my_columns = [
            {data: 'updated_at', name: 'updated_at'},
            {data: null, name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'comment', name: 'comment'},
            {data: 'date', name: 'updated_at'},
            {data: 'status', name: 'status'},
            {data: 'action_reply', name: 'action_reply'},
            {data: 'action_delete_comment', name: 'action_delete_comment'}
        ];
        var slno_i = 0;
        var order = [0, 'desc'];

        function validate()
        {
            $('#SettingsFrm').validate({
                ignore: [],
                rules: {
                    comment: "required",
                  },
                  messages: {
                    comment: "Reply cannot be blank",
                  },
            });
        }
    </script>
    @parent
@endsection