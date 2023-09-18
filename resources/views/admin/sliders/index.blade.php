@extends('admin._layouts.fileupload')
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
                                        <h4 class="page-title">All Sliders</h4>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Admin</a></li>
                                            <li class="breadcrumb-item active">All Menus</li>
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
                            @if(auth()->user()->can($permissions['create']))
                            <div class="card">
                                <div class="card-body">

                                   <form method="POST" action="{{ route($route.'.store') }}" class="p-t-15" id="SliderFrm" data-validate=true>
        
                                    @csrf
                                        <div class="row">
                                            <div class="col-12">
                                                <div data-simplebar>
                                                    <div class="tab-content chat-list" id="pills-tabContent" >
                                                        <div class="tab-pane fade show active" id="tab1">
                                                            <div class="row m-0">
                                                                <div class="form-group col-md-6">
                                                                    <label>Slider Name</label>
                                                                    <input type="text" name="slider_name" class="form-control" value="" >
                                                                </div>
                                                                <div class="form-group col-md-3">
                                                                    <label>Width</label>
                                                                    <input type="text" name="width" class="form-control" value="" maxLength="4" >
                                                                </div>
                                                                <div class="form-group col-md-3">
                                                                    <label>Height</label>
                                                                    <input type="text" name="height" class="form-control" value="" maxLength="4" >
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr/>
                                        <div class="row">
                                            <div class="col-sm-12 text-right">
                                                <button type="submit" class="btn btn-primary px-4">Create new Slider</button>
                                            </div>
                                        </div>
                                    </form>                                                                   
                                </div><!--end card-body-->
                            </div><!--end card-->
                            @endif
                            <div class="card">
                                <div class="card-body">
                                    <table class="table table-hover demo-table-search table-responsive-block" id="datatable"
                                           data-datatable-ajax-url="{{ route($route.'.index') }}" >
                                        <thead id="column-search">
                                        <tr>
                                            <th class="nosort nosearch span1" width="30">Slno</th>
                                            <th>Slider Name</th>
                                            <th>Width</th>
                                            <th>Height</th>
                                            <th class="nosort nosearch" width="30">Manage</th>
                                            <th class="nosort nosearch" width="30">Delete</th>
                                        </tr>



                                        </thead>

                                        <tbody>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div><!--end col-->
                    </div><!--end row-->

                </div><!-- container -->

                @include('admin._partials.footer')
            </div>
            <!-- end page content -->
@endsection
@section('footer')
<script>
      var my_columns = [
          {data: null, name: 'slno'},
          {data: 'slider_name', name: 'slider_name'},
          {data: 'width', name: 'width'},
          {data: 'height', name: 'height'},
          {data: 'action_edit', name: 'action_edit'},
          {data: 'action_delete', name: 'action_delete'}
      ];
      var slno_i = 0;
      var order = [0, 'desc'];

      var validator = $('#SliderFrm').validate({
            ignore: [],
            rules: {
                "width": "required",
                "height": "required",
                slider_name: {
                  required: true,
                  remote: {
                      url: "{{route('admin.sliders.unique-name')}}",
                      data: {
                        id: function() {
                          return $( "#inputId" ).val();
                        },
                    }
                  }
                },
              },
              messages: {
                "width": "Slider width cannot be blank",
                "height": "Slider height cannot be blank",
                slider_name: {
                  required: "Slider name cannot be blank",
                  remote: "Slider name is already in use",
                },
              },
            });

    </script>
@parent
@endsection