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
                                        <h4 class="page-title">All Leads</h4>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Admin</a></li>
                                            <li class="breadcrumb-item active">All Leads</li>
                                        </ol>
                                    </div><!--end col-->
                                    @if(auth()->user()->can($permissions['create']))
                                     <div class="col-auto align-self-center">
                                        <a class=" btn btn-sm btn-primary" href="{{route($route.'.create')}}" role="button"><i class="fas fa-plus mr-2"></i>Create New</a>
                                    </div>
                                    @endif
                                </div><!--end row-->                                                              
                            </div><!--end page-title-box-->
                        </div><!--end col-->
                    </div><!--end row-->
                    <!-- end page title end breadcrumb -->
                    @include('admin.leads._partials.search_settings', ['search_settings'=>$search_settings])
                    <div class="row  float-right m-2">
                            <button type="button" class="btn btn-success" id="export-to-excel">
                                <i class="fas fa-download"></i> Export to Excel
                            </button>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table table-hover demo-table-search table-responsive-block" id="datatable"
                                           data-datatable-ajax-url="{{ route($route.'.index') }}" >
                                        <thead id="column-search">
                                        <tr>
                                            <th class="nodisplay"></th>
                                            <th class="table-width-10 text-center">ID</th>
                                            <th class="table-width-120">Name</th>
                                            <th class="table-width-120">Phone</th>
                                            <th class="table-width-120">Type</th>
                                            <th class="table-width-120">Received On</th>
                                            <th class="nosort nosearch table-width-10 text-center">Status</th>
                                            <th class="nosort nosearch table-width-10 text-center">@if(auth()->user()->can($permissions['edit'])) Edit @else View @endif</th>
                                            <th class="nosort nosearch table-width-10 text-center">Delete</th>
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
            {data: 'created_at', name: 'created_at'},
            {data: null, name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'phone_number', name: 'phone_number'},
            {data: 'lead_type', name: 'lead_type'},
            {data: 'date', name: 'date'},
            {data: 'status', name: 'status'},
            {data: 'action_edit', name: 'action_edit'},
            {data: 'action_delete', name: 'action_delete'}
        ];
        var slno_i = 0;
        var order = [0, 'desc'];

        $(function(){
            $(document).on('click', '#export-to-excel', function(){
                var form_action = "{{route('admin.leads.export')}}"
                $('#searchForm').attr('action', form_action);
                $('#searchForm').submit();
            })
        })
    </script>
    @parent
@endsection