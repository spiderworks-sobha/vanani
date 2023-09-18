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
                                        <h4 class="page-title">Edit Slider</h4>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Admin</a></li>
                                            <li class="breadcrumb-item"><a href="{{route('admin.sliders.index')}}">All Sliders</a></li>
                                            <li class="breadcrumb-item active">Edit Slider</li>
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

                                   <form method="POST" action="{{ route($route.'.update', [encrypt($obj->id)]) }}" class="p-t-15" id="SliderFrm" data-validate=true>
                                        @csrf
                                        <input type="hidden" name="id" @if($obj->id) value="{{encrypt($obj->id)}}" @endif id="inputId">
                                        <div class="row">
                                            <div class="col-12">
                                                <div data-simplebar>
                                                    <div class="tab-content chat-list" id="pills-tabContent" >
                                                        <div class="tab-pane fade show active" id="tab1">
                                                            <div class="row m-0">
                                                                <div class="form-group col-md-6">
                                                                    <label>Slider Name</label>
                                                                    <input type="text" name="slider_name" class="form-control" value="{{$obj->slider_name}}" >
                                                                </div>
                                                                <div class="form-group col-md-3">
                                                                    <label>Width</label>
                                                                    <input type="text" name="width" class="form-control" value="{{$obj->width}}" maxLength="4" >
                                                                </div>
                                                                <div class="form-group col-md-3">
                                                                    <label>Height</label>
                                                                    <input type="text" name="height" class="form-control" value="{{$obj->height}}" maxLength="4" >
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
                                                <a href="{{route('admin.media.popup', ['popup_type'=>'slider', 'type'=>'Image-Video', 'holder_attr'=>'slider-list', 'title'=>'Gallery', 'related_id'=>encrypt($obj->id)])}}" class="webadmin-open-ajax-popup btn btn-warning" title="Media Files" data-popup-size="xlarge"><i class="fa fa-plus-sign"></i> Add Medias</a>

                                                <button type="submit" class="btn btn-primary">Update</button>
                                                <a href="{{ route($route.'.index') }}" class="btn btn-soft-primary">Cancel</a>
                                            </div>
                                        </div>
                                    </form>                                                                   
                                </div><!--end card-body-->
                            </div><!--end card-->
                            @endif
                            <div class="card">
                                <div class="card-body" >
                                    @if(count($obj->photos)>0)
                                    <div class="mb-3">
                                        <a href="javascript:void(0);" class="btn btn-success reorder-sliders">Reorder Sliders</a>
                                        <a href="javascript:void(0);" class="btn btn-primary save-reorder-sliders" style="display:none;">Save Slider Order</a>
                                    </div>
                                    @endif
                                    <div class="row" id="slider-list">
                                        @include('admin.sliders.ajax_photos', ['photos' => $obj->photos, 'slider'=>$obj->id])
                                    </div
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
    $(function(){
        $(document).on('click', '.reorder-sliders', function(){
            $(this).hide();
            $('.save-reorder-sliders').show();
            $("div#slider-list").sortable({ tolerance: 'pointer' });
        })

        $(document).on('click', '.save-reorder-sliders', function(){
            var that = $(this);
            var ids = [];
            $("div#slider-list .media-preview-wrap").each(function(){
                ids.push($(this).attr('id'));
            });
            that.text('Saving...');
            $.ajax({
                    type: "POST",
                    url: "{{route('admin.sliders.update-order')}}",
                    data: {
                        ids: ids,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(){
                       window.location.reload();
                    }
                });	
        })
        
    })
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