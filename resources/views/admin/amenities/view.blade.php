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
                                        @if($obj->id)
                                            <h4 class="page-title">Edit Testimonial</h4>
                                        @else
                                            <h4 class="page-title">Create new Testimonial</h4>
                                        @endif
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Admin</a></li>
                                            <li class="breadcrumb-item"><a href="{{ route($route.'.index') }}">All Testimonials</a></li>
                                            <li class="breadcrumb-item active">@if($obj->id)Edit @else Create new @endif Testimonial</li>
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
                    
                    <div class="row">
                        <div class="col-lg-12">
                            @include('admin._partials.notifications')
                            @if($obj->id)
                                        <form method="POST" action="{{ route($route.'.update') }}" class="p-t-15" id="InputFrm" data-validate=true>
                                    @else
                                        <form method="POST" action="{{ route($route.'.store') }}" class="p-t-15" id="InputFrm" data-validate=true>
                                    @endif
                                    @csrf
                                    <input type="hidden" name="id" @if($obj->id) value="{{encrypt($obj->id)}}" @endif id="inputId">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="card">
                                                <div class="card-header">
                                                    Basic Details
                                                </div>
                                                <div class="card-body">
                                                    <div data-simplebar>
                                                        <div class="row m-0">
                                                            <div class="form-group col-md-12">
                                                                <label>Name</label>
                                                                <input type="text" name="name" class="form-control" value="{{$obj->name}}">
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label>Designation</label>
                                                                <textarea class="form-control" name="designation">{{$obj->designation}}</textarea>
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label>Type</label>
                                                                <select name="comment_type" class="full-width webadmin-select2-input" id="type-select">
                                                                    <option value="Text" @if($obj->comment_type == 'Text') selected="selected" @endif>Text</option>
                                                                    <option value="Youtube Video" @if($obj->comment_type == 'Youtube Video') selected="selected" @endif>Youtube Video</option>
                                                                    <option value="Video from Computer" @if($obj->comment_type == 'Video from Computer') selected="selected" @endif>Video from Computer</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-12" id="text-div" @if($obj->comment_type == 'Youtube Video' || $obj->comment_type == 'Video from Computer') style="display:none;" @endif>
                                                                <label>Comment</label>
                                                                <textarea class="form-control" name="comment">{{$obj->comment}}</textarea>
                                                            </div>
                                                            <div class="form-group col-md-12" id="youtube-div" @if(!$obj->id || $obj->comment_type == 'Text' || $obj->comment_type == 'Video from Computer') style="display:none;" @endif>
                                                                <label>Youtube Link</label>
                                                                <input type="text" name="youtube_link" class="form-control" value="{{$obj->youtube_link}}">
                                                            </div>
                                                            <div class="form-group col-md-12" id="video-div" @if(!$obj->id || $obj->comment_type == 'Text' || $obj->comment_type == 'Youtube Video') style="display:none;" @endif>
                                                                <label>Youtube Link</label>
                                                                @include('admin.media.set_file', ['file'=>$obj->video, 'title'=>'Videos', 'popup_type'=>'single_image', 'type'=>'Video', 'holder_attr'=>'video_link_id'])
                                                            </div>
                                                        </div>
                                                    </div>                                           
                                                </div><!--end card-body-->
                                            </div><!--end card-->
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card">
                                                <div class="card-header">
                                                    Publish
                                                </div>
                                                <div class="card-body">
                                                    <div class="row m-0">
                                                        <div class="form-group w-100  mb-2">
                                                            <div class="custom-control custom-switch switch-primary float-left">
                                                                <input type="checkbox" class="custom-control-input" id="customSwitchPrimary" checked="">
                                                                <label class="custom-control-label" for="customSwitchPrimary">Status</label>
                                                            </div>
                                                            <div class="custom-control custom-switch switch-primary float-right">
                                                                <input type="checkbox" class="custom-control-input" id="customSwitchPrimary" checked="">
                                                                <label class="custom-control-label" for="customSwitchPrimary">Featured</label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group w-100 mb-1">
                                                            <label for="name">Created On: </label>
                                                            @if(!$obj->id)
                                                                {{date('d M, Y h:i A')}}
                                                            @else
                                                                {{date('d M, Y h:i A', strtotime($obj->created_by))}}
                                                            @endif
                                                        </div>
                                                        <div class="form-group w-100  mb-1">
                                                            <label for="name">Last Updated On: </label>
                                                            @if(!$obj->id)
                                                                {{date('d M, Y h:i A')}}
                                                            @else
                                                                {{date('d M, Y h:i A', strtotime($obj->updated_by))}}
                                                            @endif
                                                        </div>
                                                        <div class="form-group w-100  mb-1">
                                                            <label for="name">Created By: </label>
                                                            @if(!$obj->id)
                                                                {{auth()->user()->name}}
                                                            @else
                                                                {{$obj->created_user->name}}
                                                            @endif
                                                        </div>
                                                        <div class="form-group w-100  mb-1">
                                                            <label for="name">Last Updated By: </label>
                                                            @if(!$obj->id)
                                                                {{auth()->user()->name}}
                                                            @else
                                                                {{$obj->updated_user->name}}
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer text-muted">
                                                    <a href="" class="btn btn-sm btn-soft-primary">Preview</a>
                                                    <button class="btn btn-sm btn-primary float-right">Save</button>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header">
                                                    User Image
                                                </div>
                                                <div class="card-body">
                                                    @include('admin.media.set_file', ['file'=>$obj->featured_image, 'title'=>'User Image', 'popup_type'=>'single_image', 'type'=>'Image', 'holder_attr'=>'featured_image_id'])
                                                </div>
                                            </div>
                                        </div>    
                                    </div>
                            </form> 
                        </div><!--end col-->
                    </div><!--end row-->

                </div><!-- container -->

                @include('admin._partials.footer')
            </div>
            <!-- end page content -->
@endsection
@section('footer')
    <script type="text/javascript">
        var validator = $('#InputFrm').validate({
              rules: 
              {
                "name": "required",
              },
              messages: 
              {
                "name": "Name cannot be blank",
              },
        });

        $(document).ready(function(){
            $('#type-select').change(function(){
                if($(this).val() == 'Text')
                {
                    $('#text-div').show();
                    $('#youtube-div').hide();
                    $('#video-div').hide();
                }
                else if($(this).val() == 'Youtube Video')
                {   
                    $('#text-div').hide();
                    $('#video-div').hide();
                    $('#youtube-div').show();
                }
                else{
                    $('#text-div').hide();
                    $('#video-div').show();
                    $('#youtube-div').hide();
                }
            })
        })
    </script>
@parent
@endsection