@extends('admin._layouts.fileupload')
@section('header')
    @parent
    <style type="text/css">
        #add-new-image-container {
          color: black;
          border: 1px solid #e3ebf6;
          height: 260px;
          display: flex;
          justify-content: center;
          align-items: center;
        }

        #add-new-image-content {
            text-align: center;
            flex: 0 0 120px;
        }

        #add-new-image-content i{
            font-size: 40px;
        }

        .add-multiple-image .media-container {
              color: black;
              border: 1px solid #e3ebf6;
              height: 260px;
              display: flex;
              justify-content: center;
              align-items: center;
        }

        .add-multiple-image .media-content {
                text-align: center;
                flex: 0 0 120px;
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
                                            <h4 class="page-title">Edit Package</h4>
                                        @else
                                            <h4 class="page-title">Create new Package</h4>
                                        @endif
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Admin</a></li>
                                            <li class="breadcrumb-item"><a href="{{ route($route.'.index') }}">All Packages</a></li>
                                            <li class="breadcrumb-item active">@if($obj->id)Edit @else Create new @endif Package</li>
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
                                                            <div class="form-group col-md-6">
                                                                <label>Name</label>
                                                                <input type="text" name="name" class="form-control @if(!$obj->id) copy-name @endif" value="{{$obj->name}}" required="">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label class="">Slug (for url)</label>
                                                                <input type="text" name="slug" class="form-control" value="{{$obj->slug}}" id="slug">
                                                                <small class="text-muted">The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.</small>
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label>Title</label>
                                                                <input type="text" name="title" class="form-control" value="{{$obj->title}}" >
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label>Tagline</label>
                                                                <input type="text" name="tagline" class="form-control" value="{{$obj->tagline}}" >
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label>Total Activity Count</label>
                                                                <input type="text" name="total_activity_count" class="form-control" value="{{$obj->total_activity_count}}" >
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label>No. of Days</label>
                                                                <input type="text" name="no_of_days" class="form-control" value="{{$obj->no_of_days}}" >
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label>Whatsapp Number</label>
                                                                <input type="text" name="whatsapp_number" class="form-control" value="{{$obj->whatsapp_number}}" >
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label>Inclution Summary</label>
                                                                <input type="text" name="summary" class="form-control" value="{{$obj->summary}}" >
                                                                <small class="text-muted">Comma (,) separated</small>
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label>Short Description</label>
                                                                <textarea name="short_description" class="form-control" rows="2" id="short_description">{{$obj->short_description}}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>                                           
                                                </div><!--end card-body-->
                                            </div><!--end card-->
                                            <div class="card">
                                                <div class="card-header">
                                                    Attractions
                                                </div>
                                                <div class="card-body">
                                                    @php
                                                        $attractions = [];
                                                        if(count($obj->attractions))
                                                            $attractions = $obj->attractions->toArray();
                                                    @endphp
                                                    <x-attraction-select :selected="$attractions"></x-attraction-select>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header">
                                                    Medias
                                                </div>
                                                <div class="card-body">
                                                    <div class="row add-multiple-image">
                                                        @if(count($obj->medias)>0)
                                                            @foreach($obj->medias as $key=>$media)
                                                                @include('admin.packages.media', ['item'=>$media, 'package_media_id'=>$media->pivot->id])
                                                            @endforeach
                                                        @endif
                                                        <div class="col-md-4 mb-2">
                                                            @include('admin.media.set_file', ['file'=>null, 'title'=>'Package Media', 'popup_type'=>'single_image', 'type'=>'Image-Video', 'holder_attr'=>'rental_media[]', 'id'=>'rental_media_1'])
                                                        </div>
                                                        <div class="col-md-4 mb-2">
                                                            @include('admin.media.set_file', ['file'=>null, 'title'=>'Package Media', 'popup_type'=>'single_image', 'type'=>'Image-Video', 'holder_attr'=>'rental_media[]', 'id'=>'rental_media_2'])
                                                        </div>
                                                        <div class="col-md-4 mb-2" id="add-new-media-wrap">
                                                            <div style="display:none" id="image-clone-holder">
                                                                @include('admin.media.set_file', ['file'=>null, 'title'=>'Package Media', 'popup_type'=>'single_image', 'type'=>'Image-Video', 'holder_attr'=>'rental_media[]', 'id'=>'id_holder'])
                                                            </div>
                                                            <div id="add-new-image-container">
                                                              <div id="add-new-image-content">
                                                                <a href="javascript:void(0)" ><i class="fas fa-plus-circle text-primary" id="add-new-media"></i></a>
                                                              </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header">
                                                    SEO
                                                </div>
                                                <div class="card-body row">
                                                    <div class="form-group col-md-12">
                                                        <label>Bottom content</label>
                                                        <textarea name="bottom_description" class="form-control editor" id="bottom_description">{{$obj->bottom_description}}</textarea>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label>Browser title</label>
                                                        <input type="text" class="form-control" name="browser_title" id="browser_title" value="{{$obj->browser_title}}">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="">Meta Keywords</label>
                                                        <textarea name="meta_keywords" class="form-control" rows="3" id="meta_keywords">{{$obj->meta_keywords}}</textarea>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="">Meta description</label>
                                                        <textarea name="meta_description" class="form-control" rows="3" id="meta_description">{{$obj->meta_description}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header">
                                                    Extra Data
                                                </div>
                                                <div class="card-body row">
                                                    <div class="form-group col-md-12">
                                                        <label>OG Title</label>
                                                        <input type="text" class="form-control" name="og_title" id="og_title" value="{{$obj->og_title}}">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="">OG Description</label>
                                                        <textarea name="og_description" class="form-control" rows="3" id="og_description">{{$obj->og_description}}</textarea>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="">Extra Js</label>
                                                        <textarea name="extra_js" class="form-control" rows="3" id="extra_js">{{$obj->extra_js}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
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
                                                                <input type="checkbox" class="custom-control-input" value="1" id="is_featured" name="is_featured" @if($obj->is_featured == 1) checked="checked" @endif>
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
                                                    <div class="custom-control custom-switch switch-primary">
                                                        <input type="checkbox" class="custom-control-input" value="1" id="show_on_menu" name="show_on_menu" @if($obj->show_on_menu == 1) checked="checked" @endif>
                                                        <label class="custom-control-label" for="show_on_menu">Show on Menu</label>
                                                    </div>
                                                    <div class="custom-control custom-switch switch-primary">
                                                        <input type="checkbox" class="custom-control-input" value="1" id="show_on_accommodation_listing" name="show_on_accommodation_listing" @if($obj->show_on_accommodation_listing == 1) checked="checked" @endif>
                                                        <label class="custom-control-label" for="show_on_accommodation_listing">Show on Accommodation Listing</label>
                                                    </div>
                                                    <button class="btn btn-sm btn-primary float-right">Save</button>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header">
                                                    Accommodations
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group col-md-12">
                                                        @php
                                                            $selected_accommodations = [];
                                                            if($obj->id && count($obj->accommodations))
                                                                $selected_accommodations = $obj->accommodations->pluck('id')->toArray();
                                                        @endphp
                                                        <select name="accommodations[]" class="w-100 webadmin-select2-input" data-placeholder="Select Accommodation" multiple>
                                                            @foreach($accommodations as $accommodation)
                                                                <option value="{{$accommodation->id}}" @if(in_array($accommodation->id, $selected_accommodations)) selected="selected" @endif>{{$accommodation->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header">
                                                    Tags
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group col-md-12">
                                                        @php
                                                            $selected_tags = [];
                                                            if($obj->id && count($obj->tags))
                                                                $selected_tags = $obj->tags->pluck('id')->toArray();
                                                        @endphp
                                                        <select name="tags[]" class="w-100 webadmin-select2-input" data-placeholder="Select Tags" multiple>
                                                            @foreach($tags as $tag)
                                                                <option value="{{$tag->id}}" @if(in_array($tag->id, $selected_tags)) selected="selected" @endif>{{$tag->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header">
                                                    Listing
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group col-md-12">
                                                        <select name="listings_id" class="w-100 webadmin-select2-input form-control" data-select2-url="{{route('admin.select2.list')}}">
                                                            @if($obj->listings_id)
                                                                <option value="{{$obj->listing->id}}" selected >{{$obj->listing->listing_name}}</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header">
                                                    Priority
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group col-md-12">
                                                        <label>Priority</label>
                                                        <input type="number" name="priority" class="form-control numeric" value="{{$obj->priority}}" >
                                                    </div>
                                                </div>
                                            </div>
                                                @if($obj->id)
                                                <div class="card">
                                                    <div class="card-header">
                                                        FAQ
                                                    </div>
                                                    <div class="card-body text-center">
                                                        <a href="{{route('admin.faq.index', [$obj->id, 'Package'])}}" class="webadmin-open-ajax-popup btn btn-sm btn-warning" title="SET FAQ" data-popup-size="large">@if(count($obj->faq)>0) Update FAQ @else Add FAQ @endif</a>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-header">
                                                        SCHEDULES
                                                    </div>
                                                    <div class="card-body text-center">
                                                        <a href="{{route('admin.packages.schedule.index', [$obj->id])}}" class="btn btn-sm btn-warning" title="SCHEDULES" target="_blank">Schedules</a>
                                                    </div>
                                                </div>
                                                @endif
                                            <div class="card">
                                                <div class="card-header">
                                                    Featured Video
                                                </div>
                                                <div class="card-body">
                                                    @include('admin.media.set_file', ['file'=>$obj->featured_video, 'title'=>'Featured Video', 'popup_type'=>'single_image', 'type'=>'Video', 'holder_attr'=>'featured_video_id'])
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header">
                                                    Icon Image
                                                </div>
                                                <div class="card-body">
                                                    @include('admin.media.set_file', ['file'=>$obj->icon_image, 'title'=>'Icon Image', 'popup_type'=>'single_image', 'type'=>'Image', 'holder_attr'=>'icon_image_id'])
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header">
                                                    Featured Image
                                                </div>
                                                <div class="card-body">
                                                    @include('admin.media.set_file', ['file'=>$obj->featured_image, 'title'=>'Featured Image', 'popup_type'=>'single_image', 'type'=>'Image', 'holder_attr'=>'featured_image_id'])
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header">
                                                    Banner Image
                                                </div>
                                                <div class="card-body">
                                                    @include('admin.media.set_file', ['file'=>$obj->banner_image, 'title'=>'Banner Image', 'popup_type'=>'single_image', 'type'=>'Image', 'holder_attr'=>'banner_image_id'])
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header">
                                                    OG Image
                                                </div>
                                                <div class="card-body">
                                                    @include('admin.media.set_file', ['file'=>$obj->og_image, 'title'=>'OG Image', 'popup_type'=>'single_image', 'type'=>'Image', 'holder_attr'=>'og_image_id'])
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
    <script src="{{asset('admin/plugins/multiselect/multiselect.min.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
        var validator = $('#InputFrm').validate({
            ignore: [],
            rules: {
                "name": "required",
                "title": "required",
                slug: {
                  required: true,
                  remote: {
                      url: "{{route('admin.unique-slug')}}",
                      data: {
                        id: function() {
                          return $( "#inputId" ).val();
                        },
                        table: 'packages',
                    }
                  }
                },
              },
              messages: {
                "name": "Package name cannot be blank",
                "title": "Title cannot be blank",
                slug: {
                  required: "Slug cannot be blank",
                  remote: "Slug is already in use",
                },
              },
            });

            $(function(){
                $('#attractionmultiselect').multiselect({
                    search: {
                        left: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
                        right: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
                    },
                    fireSearch: function(value) {
                        return value.length > 2;
                    }
                });

                $('#activitymultiselect').multiselect({
                    search: {
                        left: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
                        right: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
                    },
                    fireSearch: function(value) {
                        return value.length > 2;
                    }
                });
            })

            var idInc = 3;
            $(function(){
                $(document).on('click', '#add-new-media', function(){
                    var html = $('#image-clone-holder').html();
                    var content = '<div class="col-md-4 mb-2">'+html+'</div>';

                    var img_id = 'rental_media_'+idInc;
                    content = content.replaceAll("id_holder", img_id);
                    $(content).insertBefore('#add-new-media-wrap');
                    idInc++;
                })

                $(document).on('click', '#gallery-media-update-form', function(){
                    if($('#galleryMediaUpdateForm #gallery-youtube-url').length){
                        if($('#galleryMediaUpdateForm #gallery-youtube-url').val() == ""){
                            miniweb_alert('Alert!', 'Youtube url cannot be null');
                            return;
                        }
                    }
                    var postData = new FormData( $('#galleryMediaUpdateForm')[0] );
                    $.ajax({
                        url : "{{route('admin.packages.media.update')}}",
                        type: "POST",
                        data : postData,
                        processData: false,
                        contentType: false,
                        success:function(response, textStatus, jqXHR){
                            if(typeof response.success != "undefined"){
                                $('#gallery-item-'+response.id).replaceWith(response.html);
                                miniweb_alert('Success!', 'Gallery successfully updated.');
                                $(".jconfirm-closeIcon").trigger("click");
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown){
                            //if fails     
                        }
                    });
                })

                $(document).on('click', '.gallery-item-remove', function(e){
                    e.preventDefault();
                    var that = $(this);
                    var delete_url = that.attr('href');
                    $.confirm({
                        title: 'Confirm!',
                        content: 'Are you sure to delete this?',
                        buttons: {
                            confirm:{
                                btnClass: 'btn-blue',
                                action: function(){
                                    that.parents('.gallery-item').remove();
                                    $.get(delete_url);
                                }
                            },
                            cancel: function () {
                            },
                        }
                    });
                })
            })

            $(function(){
                $(document).on('click', '#add-schedule-btn', function(){
                    var obj = $(this);
                    schedule_validate();
                    if($('#scheduleForm').valid())
                    {
                        obj.prop('disabled', true).text('Processing');
                        var url = $('#scheduleForm').attr('action');
                        var data = $('#scheduleForm').serialize();
                        $.post(url, data, function(result){
                            $('#schedule-form').html(result.form_html);
                            $('#schedule-listing').html(result.list_html);
                            $.alert(result.message);
                            obj.prop('disabled', false).text('Save');
                        })
                    }
                });

                $(document).on('click', '#schedule-create-new', function(e){
                    e.preventDefault();
                    var url = $(this).attr('href');
                    $.get(url, function(result){
                        $('#schedule-form').html(result);
                    })
                });

                $(document).on('click', '.edit-schedule-btn', function(e){
                    e.preventDefault();
                    var url = $(this).attr('href');
                    $.get(url, function(result){
                        $('#schedule-form').html(result);
                    })
                })

                $(document).on('click', '.delete-schedule-btn', function(e){
                    e.preventDefault();
                    var obj = $(this);
                    var message = obj.data('message');
                    var url = obj.attr('href');
                    $.confirm({
                            title: 'Warning',
                            content: message,
                            closeAnimation: 'scale',
                            opacity: 0.5,
                            buttons: {
                                'ok_button': {
                                    text: 'Proceed',
                                    btnClass: 'btn-blue',
                                    action: function(){
                                        var obj2 = this;
                                        obj2.buttons.ok_button.setText('Processing..'); // setText for 'hello' button
                                        obj2.buttons.ok_button.disable();
                                        $.get(url).done(function (data) {
                                            obj2.$$close_button.trigger('click');
                                            if(data.success)
                                                obj.parents('.schedules-item-card').remove();
                                            $.alert(data.message);
                                        });
                                        return false;
                                    }
                                },
                                close_button: {
                                    text: 'Cancel',
                                    action: function () {
                                    }
                                },
                            }
                        });
                })
            })

            var save_schedule_order = function()
            {
                var ids = [];
                $('#accordionSchedule .card').each(function(){
                    ids.push($(this).attr('id'));
                });
                $.post(base_url+'/packages/schedule/re-order', {ids: ids, '_token':_token}, function(){

                });
            }

            var schedule_validate = function(){
                $('#scheduleForm').validate({
                    ignore: [],
                    rules: {
                        "title": "required",
                    },
                    messages: {
                        "title": "Title cannot be blank",
                    },
                });
            };
    </script>
@parent
@endsection