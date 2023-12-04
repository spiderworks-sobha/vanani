@extends('admin._layouts.fileupload')

@section('header')
    @parent
    <style type="text/css">
        #video-div p a{
            border: 1px solid #1761fd;
            padding: 10px 20px;
            background: #1761fd;
            color: #fff;
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
                                        @if($obj->id)
                                            <h4 class="page-title">Edit Review</h4>
                                        @else
                                            <h4 class="page-title">Create new Review</h4>
                                        @endif
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Admin</a></li>
                                            <li class="breadcrumb-item"><a href="{{ route($route.'.index', [$type, $reviewable->id]) }}">All Reviews of {{$reviewable->name}} ({{ucfirst($type)}})</a></li>
                                            <li class="breadcrumb-item active">@if($obj->id)Edit @else Create new @endif Review</li>
                                        </ol>
                                    </div><!--end col-->
                                    @if(auth()->user()->can($permissions['create']))
                                    <div class="col-auto align-self-center">
                                        <a class=" btn btn-sm btn-primary" href="{{route($route.'.create', [$type, $reviewable->id])}}" role="button"><i class="fas fa-plus mr-2"></i>Create New</a>
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
                                        <form method="POST" action="{{ route($route.'.update') }}" class="p-t-15" id="InputFrm" enctype="multipart/form-data" data-validate=true>
                                    @else
                                        <form method="POST" action="{{ route($route.'.store') }}" class="p-t-15" id="InputFrm" enctype="multipart/form-data" data-validate=true>
                                    @endif
                                    @csrf
                                    <input type="hidden" name="id" @if($obj->id) value="{{encrypt($obj->id)}}" @endif id="inputId">
                                    <input type="hidden" name="type" value="{{$type}}" />
                                    <input type="hidden" name="reviewable_model_id" value="{{$reviewable->id}}" />
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="card">
                                                <div class="card-header">
                                                    Basic Details
                                                </div>
                                                <div class="card-body">
                                                    <div data-simplebar>
                                                        <div class="row m-0">
                                                            <div class="form-group col-md-6">
                                                                <label>Name</label>
                                                                <input type="text" name="name" class="form-control" value="{{$obj->name}}">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label>Priority</label>
                                                                <input type="number" name="priority" class="form-control numeric" value="{{$obj->priority}}" >
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label>Title</label>
                                                                <input type="text" name="title" class="form-control" value="{{$obj->title}}">
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label>Type</label>
                                                                <select name="review_type" class="w-100 webadmin-select2-input" id="type-select">
                                                                    <option value="Text" @if($obj->review_type == 'Text') selected="selected" @endif>Text</option>
                                                                    <option value="Video" @if($obj->review_type == 'Video') selected="selected" @endif>Video</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-12" id="text-div" @if($obj->review_type == 'Video') style="display:none;" @endif>
                                                                <label>Review</label>
                                                                <textarea class="form-control" name="text_review">
                                                                    @if($obj->review_type == 'Text') {{$obj->review}} @endif
                                                                </textarea>
                                                            </div>
                                                            <div class="form-group col-md-12" id="video-div" @if(!$obj->id || $obj->review_type == 'Text') style="display:none;" @endif>
                                                                <label>Review Video</label>
                                                                <input type="file" class="form-control" name="video_review" />
                                                                <input type="hidden" @if($obj->review_type == 'Video') value="1" @endif id="video-exist" name="video_exist" />
                                                                @if($obj->review_type == 'Video')
                                                                    <a href="{{asset($obj->review)}}" target="_blank">Watch</a>
                                                                @endif
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
                                                                <input type="checkbox" class="custom-control-input" value="1" id="status" name="status" @if(!$obj->id || $obj->status == 1) checked="" @endif>
                                                                <label class="custom-control-label" for="status">Status</label>
                                                            </div>
                                                            <div class="custom-control custom-switch switch-primary float-right">
                                                                <input type="checkbox" class="custom-control-input" value="1" id="is_featured" name="is_featured" @if($obj->is_featured == 1) checked="" @endif>
                                                                <label class="custom-control-label" for="is_featured">Featured</label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group w-100 mb-1">
                                                            <label for="name">Created On: </label>
                                                            @if(!$obj->id)
                                                                {{date('d M, Y h:i A')}}
                                                            @else
                                                                {{date('d M, Y h:i A', strtotime($obj->created_at))}}
                                                            @endif
                                                        </div>
                                                        <div class="form-group w-100  mb-1">
                                                            <label for="name">Last Updated On: </label>
                                                            @if(!$obj->id)
                                                                {{date('d M, Y h:i A')}}
                                                            @else
                                                                {{date('d M, Y h:i A', strtotime($obj->updated_at))}}
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
                                                    <div class="custom-control custom-switch switch-primary float-left">
                                                        <input type="checkbox" class="custom-control-input" value="1" id="show_on_main_page" name="show_on_main_page" @if($obj->show_on_main_page == 1) checked="" @endif>
                                                        <label class="custom-control-label" for="show_on_main_page">Show on Main Page</label>
                                                    </div>
                                                    <button class="btn btn-sm btn-primary float-right">Save</button>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header">
                                                    User Image
                                                </div>
                                                <div class="card-body">
                                                    @if($obj->photo)
                                                        <div id="image-holder">
                                                            <img src="{{asset($obj->photo)}}" width="200"  />
                                                            <a href="javascript:void(0)" id="remove_photo">Remove</a>
                                                        </div>
                                                    @endif
                                                    <input type="hidden" name="is_photo_removed" id="is_photo_removed" />
                                                    <input type="file" class="form-control" name="image" />
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
                text_review: {
                    required: function() {
                        return $('#type-select').val() == "Text";
                    }
                },
                video_review: {
                    required: function() {
                        return ($('#type-select').val() == "Video" && $('#video-exist').val() != 1);
                    }
                },
              },
              messages: 
              {
                "name": "Name cannot be blank",
                "text_review": "Review cannot be blank",
                "video_review": "Review cannot be blank"
              },
        });

        $(document).ready(function(){
            $('#type-select').change(function(){
                if($(this).val() == 'Text')
                {
                    $('#text-div').show();
                    $('#video-div').hide();
                }
                else{
                    $('#text-div').hide();
                    $('#video-div').show();
                }
            })

            $(document).on('click', '#remove_photo', function(){
                $('#image-holder').remove();
                $('#is_photo_removed').val(1);
            })
        })
    </script>
@parent
@endsection