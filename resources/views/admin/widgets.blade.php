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
                                        <h4 class="page-title">All Widgets</h4>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="{{url('admin')}}">Admin</a></li>
                                            <li class="breadcrumb-item active">All Widgets</li>
                                        </ol>
                                    </div><!--end col-->
                                </div><!--end row-->                                                              
                            </div><!--end page-title-box-->
                        </div><!--end col-->
                    </div><!--end row-->
                    <!-- end page title end breadcrumb -->
                    @include('admin._partials.notifications')
                    <div class="row">
                        <div class="col-6">
                            <form method="POST" action="{{ route('admin.widgets.save') }}" class="p-t-15" id="InputFrm" data-validate=true>
                                @csrf
                                <input type="hidden" name="id" value="1">
                                            
                                <div class="card">
                                    <div class="card-header">
                                        Testimonials
                                    </div>
                                    <div class="card-body row">
                                        <div class="form-group col-md-12">
                                            <label>Text (Left)</label>
                                            <input type="text" name="section[text_left]" class="form-control" @if(isset($data['testimonials']['text_left'])) value="{{$data['testimonials']['text_left']}}" @endif>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Tag Line (Right)</label>
                                            <input type="text" name="section[tag_line_right]" class="form-control" @if(isset($data['testimonials']['tag_line_right'])) value="{{$data['testimonials']['tag_line_right']}}" @endif>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Text (Right)</label>
                                            <input type="text" name="section[text_right]" class="form-control" @if(isset($data['testimonials']['text_right'])) value="{{$data['testimonials']['text_right']}}" @endif>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button class="btn btn-sm btn-primary">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-6">
                            <form method="POST" action="{{ route('admin.widgets.save') }}" class="p-t-15" id="InputFrm" data-validate=true>
                                @csrf
                                <input type="hidden" name="id" value="2">
                                            
                                <div class="card">
                                    <div class="card-header">
                                        Bottom Banner
                                    </div>
                                    <div class="card-body row">
                                        <div class="form-group col-md-6">
                                            <label>Tag Line</label>
                                            <input type="text" name="section[tag_line]" class="form-control" @if(isset($data['bottom-banner']['tag_line'])) value="{{$data['bottom-banner']['tag_line']}}" @endif>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Title</label>
                                            <input type="text" name="section[title]" class="form-control" @if(isset($data['bottom-banner']['title'])) value="{{$data['bottom-banner']['title']}}" @endif>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Description</label>
                                            <textarea name="section[description]" class="form-control">@if(isset($data['bottom-banner']['description'])) {{$data['bottom-banner']['description']}} @endif</textarea>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Button Text</label>
                                            <input type="text" name="section[button_text]" class="form-control" @if(isset($data['bottom-banner']['button_text'])) value="{{$data['bottom-banner']['button_text']}}" @endif>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Button Url</label>
                                            <input type="text" name="section[button_url]" class="form-control" @if(isset($data['bottom-banner']['button_url'])) value="{{$data['bottom-banner']['button_url']}}" @endif>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Button Target</label>
                                            <select name="section[button_target]" class="form-control" >
                                                <option value="" @if(isset($data['bottom-banner']['button_target']) && $data['bottom-banner']['button_target'] == "") selected="selected" @endif></option>
                                                <option value="_blank" @if(isset($data['bottom-banner']['button_target']) && $data['bottom-banner']['button_target'] == "_blank") selected="selected" @endif>_blank</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button class="btn btn-sm btn-primary">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-6">
                            <form method="POST" action="{{ route('admin.widgets.save') }}" class="p-t-15" id="InputFrm" data-validate=true>
                                @csrf
                                <input type="hidden" name="id" value="3">
                                            
                                <div class="card">
                                    <div class="card-header">
                                        Join Us
                                    </div>
                                    <div class="card-body row">
                                        <div class="form-group col-md-12">
                                            <label>Member Count</label>
                                            <input type="text" name="section[member_count]" class="form-control" @if(isset($data['join-us']['member_count'])) value="{{$data['join-us']['member_count']}}" @endif>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Title</label>
                                            <input type="text" name="section[title]" class="form-control" @if(isset($data['join-us']['title'])) value="{{$data['join-us']['title']}}" @endif>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Title Continue</label>
                                            <input type="text" name="section[title_continue]" class="form-control" @if(isset($data['join-us']['title_continue'])) value="{{$data['join-us']['title_continue']}}" @endif>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Follow us Text</label>
                                            <input type="text" name="section[follow_us_text]" class="form-control" @if(isset($data['join-us']['follow_us_text'])) value="{{$data['join-us']['follow_us_text']}}" @endif>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button class="btn btn-sm btn-primary">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div> 

                </div><!-- container -->

                @include('admin._partials.footer')
            </div>
            <!-- end page content -->
@endsection
@section('footer')

@endsection