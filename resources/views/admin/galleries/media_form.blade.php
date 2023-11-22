<div class="settings-item w-100 confirm-wrap" id="media-item-edit">
    <form method="POST" action="{{ route('admin.galleries.media.update', ['id'=>$file->id]) }}" id="galleryMediaUpdateForm" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="gallery_media_id" value="{{encrypt($file->id)}}" />
        <div class="row m-0">
            <div class="col-md-7">
                @if($file->media)
                    @include('admin.media.set_file_simple', ['file'=>$file->media, 'title'=>'Update Gallery', 'type'=>$type])
                @else
                    @if($file->youtube_preview)
                        <div class="img-container-edit box" id="simple-media-{{$file->id}}">
                            <img src="{{$file->youtube_preview}}"/>
                            <a href="{{route('admin.media.popup', ['popup_type'=>'set_file_simple', 'type'=>'Image', 'holder_attr'=>'simple-media-'.$file->id, 'title'=>'Update Youtube Cover', 
                'related_id'=>$file->id, 'media_id'=>'simple-media-'.$file->id])}}" class="webadmin-open-ajax-popup direction" title="Media Images" 
                data-popup-size="xlarge"><i class="fas fa-pencil-alt"></i></a>
                        </div>
                    @endif
                @endif
                @if($file->media && $file->media->media_type == "Video")
                <div class="video-cover-image-holder">
                    <p class="mt-2">Video Preview Image</p>
                    <div class="video-cover-image">
                        <img id="video-cover-image" @if($file->video_preview_image) src="{{asset($file->video_preview_image)}}" @endif/>
                    </div>
                    <div class="video-cover-upload">
                        <input type="file" class="form-control" name="video_cover" accept="image/*" onchange="loadFile(event)" />
                    </div>
                </div>
                @endif
            </div>
            <div class="col-md-5 img-details-edit">
                @if($file->upload_type == "Youtube")
                    <div class="form-group required">
                        <label>Youtube Url</label>
                        <input type="text" name="youtube_url" id="gallery-youtube-url" class="form-control" value="{{$file->youtube_url}}" >
                    </div>
                @endif
                <div class="form-group required">
                    <label>Title</label>
                    <input type="text" name="media_title" class="form-control" value="{{$file->title}}" >
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="media_description" class="form-control" rows="3" >{{$file->description}}</textarea>
                </div>
            </div>
            <div class="col-md-12 text-right">
                <button type="button" class="btn btn-soft-primary" id="gallery-media-update-form">Save</button> 
            </div>
        </div>
    </form>
</div>