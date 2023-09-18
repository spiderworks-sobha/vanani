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
                                        <h4 class="page-title">@if($parent_data) Sub-categories of {{$parent_data->name}} @else All Categories @endif</h4>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Admin</a></li>
                                            @if($parent_data)
                                            <li class="breadcrumb-item"><a href="{{ route($route.'.index', [$parent_data->parent_id]) }}">{{$parent_data->name}}</a></li>
                                            @endif
                                            <li class="breadcrumb-item active">List Categories</li>
                                        </ol>
                                    </div><!--end col-->
                                    @if(auth()->user()->can($permissions['create']))
                                     <div class="col-auto align-self-center">
                                        <a class=" btn btn-sm btn-primary" href="{{route($route.'.create', [$parent])}}" role="button"><i class="fas fa-plus mr-2"></i>Create New</a>
                                    </div>
                                    @endif
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
                                           data-datatable-ajax-url="{{ route($route.'.index', [$parent]) }}" >
                                        <thead id="column-search">
                                        <tr>
                                            <th class="nodisplay"></th>
                                            <th class="table-width-10">ID</th>
                                            <th class="table-width-120">Name</th>
                                            @if(Config('admin.category_types'))
                                                <th class="table-width-120 @fieldshow(categories-category_type) @else nodisplay @endfieldshow">Type</th>
                                            @else
                                                <th class="nodisplay"></th>
                                            @endif
                                            <th class="table-width-120">Last Updated On</th>
                                            <th class="nosort nosearch table-width-10 @fieldshow(categories-parent_id) @else nodisplay @endfieldshow">Sub Categories</th>
                                            <th class="nosort nosearch table-width-10 @fieldshow(categories-priority) @else nodisplay @endfieldshow">Priority</th>
                                            <th class="nosort nosearch table-width-10">Status</th>
                                            <th class="nosort nosearch table-width-10">Edit</th>
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
            {data: 'category_type', name: 'category_type'},
            {data: 'date', name: 'updated_at'},
            {data: 'sub-categories', name: 'sub-categories'},
            {data: 'priority', name: 'priority'},
            {data: 'status', name: 'status'},
            {data: 'action_edit', name: 'action_edit'},
            {data: 'action_delete_category', name: 'action_delete_category'}
        ];
        var slno_i = 0;
        var order = [0, 'desc'];

        $(function(){
            $(document).on('click', '.delete_have_child', function(){
                $.alert('Sorry! You cannot delete this category, to delete it please delete all its sub categories.');
            })
        })
    </script>
    @parent
@endsection