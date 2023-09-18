@extends('admin._layouts.fileupload')
@section('header')
    @parent
    <style>
        .page-sidebar{
            z-index: 999 !important;
        }
    </style>
@endsection
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
                                        <h4 class="page-title">Edit Gallery</h4>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Admin</a></li>
                                            <li class="breadcrumb-item"><a href="{{route('admin.photo-galleries.index')}}">All Galleries</a></li>
                                            <li class="breadcrumb-item active">Edit Gallery</li>
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

                                   <form method="POST" action="{{ route($route.'.update', [encrypt($obj->id)]) }}" class="p-t-15" id="GalleryFrm" data-validate=true>
                                        @csrf
                                        <input type="hidden" name="id" @if($obj->id) value="{{encrypt($obj->id)}}" @endif id="inputId">
                                        <div class="row">
                                            <div class="col-12">
                                                <div data-simplebar>
                                                    <div class="tab-content chat-list" id="pills-tabContent" >
                                                        <div class="tab-pane fade show active" id="tab1">
                                                            <div class="row m-0">
                                                                <div class="form-group col-md-12">
                                                                    <label>Slider Name</label>
                                                                    <input type="text" name="gallery_name" class="form-control" value="{{$obj->gallery_name}}" >
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <label>Description</label>
                                                                    <textarea name="description" class="form-control">{{$obj->description}}</textarea>
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
                                                <a href="{{route('admin.media.popup', ['popup_type'=>'photogallery', 'type'=>'Image', 'holder_attr'=>'photo-gallery-list', 'title'=>'Gallery', 'related_id'=>encrypt($obj->id)])}}" class="webadmin-open-ajax-popup btn btn-warning" title="Media Images" data-popup-size="xlarge"><i class="fa fa-plus-sign"></i> Add Photos</a>

                                                <button type="submit" class="btn btn-primary">Update</button>
                                                <a href="{{ route($route.'.index') }}" class="btn btn-soft-primary">Cancel</a>
                                            </div>
                                        </div>
                                    </form>                                                                   
                                </div><!--end card-body-->
                            </div><!--end card-->
                            @endif
                            <div class="card">
                                <div class="card-body row" id="photo-gallery-list">
                                    @include('admin.photo_galleries.ajax_photos', ['photos' => $obj->photos, 'gallery'=>$obj->id])
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
      var validator = $('#GalleryFrm').validate({
            ignore: [],
            rules: {
                gallery_name: {
                  required: true,
                  remote: {
                      url: "{{route('admin.photo-galleries.unique-name')}}",
                      data: {
                        id: function() {
                          return $( "#inputId" ).val();
                        },
                    }
                  }
                },
              },
              messages: {
                gallery_name: {
                  required: "Gallery name cannot be blank",
                  remote: "Gallery name is already in use",
                },
              },
            });

    </script>
@parent
@endsection