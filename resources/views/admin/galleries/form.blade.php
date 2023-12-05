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

        .box {
            position: relative;
         }
         .direction {
            position: absolute;
            top: 10px;
            right: 19px;
            font-size: 13px;
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
                                            <h4 class="page-title">Edit Gallery</h4>
                                        @else
                                            <h4 class="page-title">Create new Gallery</h4>
                                        @endif
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Admin</a></li>
                                            <li class="breadcrumb-item"><a href="{{ route($route.'.index') }}">All Galleries</a></li>
                                            <li class="breadcrumb-item active">@if($obj->id)Edit @else Create new @endif Gallery</li>
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
                                                            @fieldshow(galleries-title)
                                                            <div class="form-group col-md-6">
                                                                <label>Heading</label>
                                                                <input type="text" name="title" class="form-control" value="{{$obj->title}}" >
                                                            </div>
                                                            @endfieldshow
                                                            @fieldshow(galleries-title)
                                                            <div class="form-group col-md-6">
                                                                <label>Type</label>
                                                                <select name="type" class="form-control" id="gallery-type">
                                                                    <option value=""></option>
                                                                    <option value="Image">Image</option>
                                                                    <option value="Video">Video</option>
                                                                </select>
                                                            </div>
                                                            @endfieldshow
                                                            @fieldshow(galleries-short_description)
                                                            <div class="form-group col-md-12">
                                                                <label>Short Description</label>
                                                                <textarea name="short_description" class="form-control" rows="2" id="short_description">{{$obj->short_description}}</textarea>
                                                            </div>
                                                            @endfieldshow
                                                            @fieldshow(galleries-content)
                                                            <div class="form-group col-md-12">
                                                                <label>Content</label>
                                                                <textarea name="content" class="form-control editor" id="content">{{$obj->content}}</textarea>
                                                            </div>
                                                            @endfieldshow
                                                        </div>
                                                    </div>                                           
                                                </div><!--end card-body-->
                                            </div><!--end card-->
                                            @fieldshow(galleries-media)
                                            <div class="card">
                                                <div class="card-header">
                                                    Media
                                                </div>
                                                <div class="card-body">
                                                    <div class="row add-multiple-image">
                                                        @if(count($obj->gallery)>0)
                                                            @php
                                                                $media_type = "Image-Video";
                                                                if($obj->type == "Image")
                                                                    $media_type = "Image";
                                                                elseif($obj->type == "Video")
                                                                    $media_type = "Video";
                                                            @endphp
                                                            @foreach($obj->gallery as $key=>$item)
                                                                @include('admin.galleries.media', ['item'=>$item, 'type'=>$media_type])
                                                            @endforeach
                                                        @endif
                                                        <div class="col-md-4 mb-2" id="add-new-image-wrap">
                                                            <div style="display:none" id="media-clone-holder">
                                                                @include('admin.media.set_file', ['file'=>null, 'title'=>'Gallery Medias', 'popup_type'=>'single_image', 'type'=>'Image-Video', 'holder_attr'=>'gallery_medias[]', 'id'=>'media_id_holder'])
                                                            </div>
                                                            <div style="display:none" id="image-clone-holder">
                                                                @include('admin.media.set_file', ['file'=>null, 'title'=>'Gallery Images', 'popup_type'=>'single_image', 'type'=>'Image', 'holder_attr'=>'gallery_medias[]', 'id'=>'image_id_holder'])
                                                            </div>
                                                            <div style="display:none" id="video-clone-holder">
                                                                @include('admin.media.set_file', ['file'=>null, 'title'=>'Gallery Video', 'popup_type'=>'single_image', 'type'=>'Video', 'holder_attr'=>'gallery_medias[]', 'id'=>'video_holder'])
                                                            </div>
                                                            <div id="add-new-image-container">
                                                              <div id="add-new-image-content">
                                                                <a href="javascript:void(0)" class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ><i class="fas fa-plus-circle text-primary" ></i></a>
                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                    <a class="dropdown-item" id="add-new-image" href="javascript:void(0)" @if(!$obj->id || $obj->type != "Image") style="display:none" @endif>Upload Image</a>
                                                                    <a class="dropdown-item" id="add-new-video" href="javascript:void(0)" @if(!$obj->id || $obj->type != "Video") style="display:none" @endif>Upload Video From Machine</a>
                                                                    <a class="dropdown-item" id="add-new-media" href="javascript:void(0)" @if($obj->id && ($obj->type == "Image" || $obj->type == "Video")) style="display:none" @endif>Upload Media From Machine</a>
                                                                    <a class="dropdown-item" id="add-youtube-video" href="javascript:void(0)" data-toggle="modal" data-target="#youtubeModal" @if($obj->type == "Image") style="display:none" @endif>Add youtube link</a>
                                                                </div>
                                                              </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endfieldshow
                                            @fieldshow(galleries-seo)
                                            <div class="card">
                                                <div class="card-header">
                                                    SEO
                                                </div>
                                                <div class="card-body row">
                                                    @fieldshow(galleries-bottom_description)
                                                    <div class="form-group col-md-12">
                                                        <label>Bottom content</label>
                                                        <textarea name="bottom_description" class="form-control editor" id="bottom_description">{{$obj->bottom_description}}</textarea>
                                                    </div>
                                                    @endfieldshow
                                                    @fieldshow(galleries-browser_title)
                                                    <div class="form-group col-md-12">
                                                        <label>Browser title</label>
                                                        <input type="text" class="form-control" name="browser_title" id="browser_title" value="{{$obj->browser_title}}">
                                                    </div>
                                                    @endfieldshow
                                                    @fieldshow(galleries-meta_keywords)
                                                    <div class="form-group col-md-6">
                                                        <label class="">Meta Keywords</label>
                                                        <textarea name="meta_keywords" class="form-control" rows="3" id="meta_keywords">{{$obj->meta_keywords}}</textarea>
                                                    </div>
                                                    @endfieldshow
                                                    @fieldshow(galleries-meta_description)
                                                    <div class="form-group col-md-6">
                                                        <label class="">Meta description</label>
                                                        <textarea name="meta_description" class="form-control" rows="3" id="meta_description">{{$obj->meta_description}}</textarea>
                                                    </div>
                                                    @endfieldshow
                                                </div>
                                            </div>
                                            @endfieldshow
                                            @fieldshow(galleries-extra_data)
                                            <div class="card">
                                                <div class="card-header">
                                                    Extra Data
                                                </div>
                                                <div class="card-body row">
                                                    @fieldshow(galleries-og_title)
                                                    <div class="form-group col-md-12">
                                                        <label>OG Title</label>
                                                        <input type="text" class="form-control" name="og_title" id="og_title" value="{{$obj->og_title}}">
                                                    </div>
                                                    @endfieldshow
                                                    @fieldshow(galleries-og_description)
                                                    <div class="form-group col-md-6">
                                                        <label class="">OG Description</label>
                                                        <textarea name="og_description" class="form-control" rows="3" id="og_description">{{$obj->og_description}}</textarea>
                                                    </div>
                                                    @endfieldshow
                                                    @fieldshow(galleries-extra_js)
                                                    <div class="form-group col-md-6">
                                                        <label class="">Extra Js</label>
                                                        <textarea name="extra_js" class="form-control" rows="3" id="extra_js">{{$obj->extra_js}}</textarea>
                                                    </div>
                                                    @endfieldshow
                                                </div>
                                            </div>
                                            @endfieldshow
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
                                                            @fieldshow(galleries-is_featured)
                                                            <div class="custom-control custom-switch switch-primary float-right">
                                                                <input type="checkbox" class="custom-control-input" value="1" id="is_featured" name="is_featured" @if($obj->is_featured == 1) checked="checked" @endif>
                                                                <label class="custom-control-label" for="is_featured">Featured</label>
                                                            </div>
                                                            @endfieldshow
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
                                                    <button class="btn btn-sm btn-primary float-right">Save</button>
                                                </div>
                                            </div>
                                            @fieldshow(galleries-category_id)
                                            <div class="card">
                                                <div class="card-header">
                                                    Category
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group col-md-12">
                                                        <label class="">Category</label>
                                                        <select name="category_id" class="w-100 webadmin-select2-input" data-placeholder="Select a Category">
                                                            <option value="0">-- Select --</option>
                                                            @foreach($categories as $category)
                                                                <option value="{{$category->id}}" @if($category->id == $obj->category_id) selected="selected" @endif>{{$category->name}}</option>
                                                                @include('admin._partials.category', ['category'=>$category, 'depth'=>1, 'selected'=>$obj->category_id])
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            @endfieldshow
                                            @fieldshow(galleries-priority)
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
                                            @endfieldshow
                                            @fieldshow(galleries-faq)
                                                @if($obj->id)
                                                <div class="card">
                                                    <div class="card-header">
                                                        FAQ
                                                    </div>
                                                    <div class="card-body text-center">
                                                        <a href="{{route('admin.faq.index', [$obj->id, 'Event'])}}" class="webadmin-open-ajax-popup btn btn-sm btn-warning" title="SET FAQ" data-popup-size="large">@if(count($obj->faq)>0) Update FAQ @else Add FAQ @endif</a>
                                                    </div>
                                                </div>
                                                @endif
                                            @endfieldshow
                                            @fieldshow(galleries-featured_image_id)
                                            <div class="card">
                                                <div class="card-header">
                                                    Featured Image
                                                </div>
                                                <div class="card-body">
                                                    @include('admin.media.set_file', ['file'=>$obj->featured_image, 'title'=>'Featured Image', 'popup_type'=>'single_image', 'type'=>'Image', 'holder_attr'=>'featured_image_id'])
                                                </div>
                                            </div>
                                            @endfieldshow
                                            @fieldshow(galleries-banner_image_id)
                                            <div class="card">
                                                <div class="card-header">
                                                    Banner Image
                                                </div>
                                                <div class="card-body">
                                                    @include('admin.media.set_file', ['file'=>$obj->banner_image, 'title'=>'Banner Image', 'popup_type'=>'single_image', 'type'=>'Image', 'holder_attr'=>'banner_image_id'])
                                                </div>
                                            </div>
                                            @endfieldshow
                                            @fieldshow(galleries-og_image_id)
                                            <div class="card">
                                                <div class="card-header">
                                                    OG Image
                                                </div>
                                                <div class="card-body">
                                                    @include('admin.media.set_file', ['file'=>$obj->og_image, 'title'=>'OG Image', 'popup_type'=>'single_image', 'type'=>'Image', 'holder_attr'=>'og_image_id'])
                                                </div>
                                            </div>
                                            @endfieldshow
                                        </div>    
                                    </div>
                            </form> 
                        </div><!--end col-->
                    </div><!--end row-->

                </div><!-- container -->
                <!-- Modal -->
<div class="modal fade" id="youtubeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Youtube Video</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
        <div class="form-group">
            <label for="youTubeUrl">Youtube Url</label>
            <input type="orl" class="form-control" id="youTubeUrl">
        </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="youTubeUrlAdd">Add</button>
      </div>
    </div>
  </div>
</div>
                @include('admin._partials.footer')
            </div>
            <!-- end page content -->
@endsection
@section('footer')
    <script type="text/javascript">


        var idInc = "{{count($obj->gallery)}}";
        $(function(){

            $(document).on('change', '#gallery-type', function(){
                var id = $(this).val();
                if(id == 'Image'){
                    $('#add-new-image').show();
                    $('#add-new-video').hide();
                    $('#add-new-media').hide();
                    $('#add-youtube-video').hide();
                }
                else if(id == 'Video'){
                    $('#add-new-image').hide();
                    $('#add-new-video').show();
                    $('#add-new-media').hide();
                    $('#add-youtube-video').show();
                }
                else{
                    $('#add-new-image').hide();
                    $('#add-new-video').hide();
                    $('#add-new-media').show();
                    $('#add-youtube-video').show();
                }
            })

            $(document).on('click', '#add-new-image', function(){
                var html = $('#image-clone-holder').html();
                var content = '<div class="col-md-4 mb-2">'+html+'</div>';

                var img_id = 'gallery_image_'+idInc;
                content = content.replaceAll("image_id_holder", img_id);
                $(content).insertBefore('#add-new-image-wrap');
                idInc++;
            })

            $(document).on('click', '#add-new-video', function(){
                var html = $('#video-clone-holder').html();
                var content = '<div class="col-md-4 mb-2">'+html+'</div>';

                var img_id = 'gallery_video_'+idInc;
                content = content.replaceAll("video_id_holder", img_id);
                $(content).insertBefore('#add-new-image-wrap');
                idInc++;
            })

            $(document).on('click', '#add-new-media', function(){
                var html = $('#media-clone-holder').html();
                var content = '<div class="col-md-4 mb-2">'+html+'</div>';

                var img_id = 'gallery_media_'+idInc;
                content = content.replaceAll("media_id_holder", img_id);
                $(content).insertBefore('#add-new-image-wrap');
                idInc++;
            })

            $(document).on('click', '#youTubeUrlAdd', function(){
                var url = $('#youTubeUrl').val();
                if (url != undefined || url != '') {        
                    var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;
                    var match = url.match(regExp);
                    if (match && match[2].length == 11) {
                        var thumb = Youtube.thumb(url, 'big');
                        var html = '<div class="col-md-4 mb-2 youtube-item"><div id="project_image_'+idInc+'"><input type="hidden" name="youtube_url[]" value="https://www.youtube.com/embed/' + match[2]+'"><input type="hidden" name="youtube_preview[]" value="'+thumb+'"><div class="thumbnail text-center"><div class="card"><img src="'+thumb+'" class="w-100"><div class="card-body"><p class="card-text">Embed Url: https://www.youtube.com/embed/' + match[2]+'</p><hr><div class="text-center"><a href="javascript:void(0);" class="youtube-remove ml-2"><i class="fas fa-trash"></i></a></div></div></div></div></div></div></div>';                    $('#videoObject').attr('src', 'https://www.youtube.com/embed/' + match[2] + '?autoplay=1&enablejsapi=1');
                        $(html).insertBefore('#add-new-image-wrap');
                        idInc++;
                        $('#youTubeUrl').val('');
                        $('#youtubeModal').modal('hide')
                    } else {
                        $.alert('Please enter a valid youtube url');
                        // Do anything for not being valid
                    }
                }
                else
                {
                    $.alert('Please enter a youtube url');
                }
            });

            $(document).on('click', '.youtube-remove', function(){
                var that = $(this);
                $.confirm({
                    title: 'Confirm!',
                    content: 'Are you sure to delete this?',
                    buttons: {
                        confirm:{
                            btnClass: 'btn-blue',
                            action: function(){
                                that.parents('.youtube-item').remove();
                            }
                        },
                        cancel: function () {
                        },
                    }
                });
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
                    url : "{{route('admin.galleries.media.update')}}",
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
                        table: 'events',
                    }
                  }
                },
              },
              messages: {
                "name": "Blog name cannot be blank",
                "title": "Blog heading cannot be blank",
                slug: {
                  required: "Slug cannot be blank",
                  remote: "Slug is already in use",
                },
              },
            });

    </script>
@parent
@endsection