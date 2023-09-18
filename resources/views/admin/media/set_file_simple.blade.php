<input type="hidden" name="media_id" value="{{$file->id}}" />
<div class="img-container-edit box" id="simple-media-{{$file->id}}">
            @if($file->media_type == 'Image')
                <img  src="{{ asset($file->file_path) }}?ver={{time()}}" alt="{{$file->file_name}}" style="width: auto;">
            @elseif($file->media_type == 'Video')
            <div class="embed-responsive embed-responsive-16by9">
                <video class="embed-responsive-item" controls>
                <source src="{{ asset($file->file_path) }}?ver={{time()}}" type="{{$file->file_type}}">
                Your browser does not support the video tag.
                </video>
            </div>
            @endif
            <a href="{{route('admin.media.popup', ['popup_type'=>'set_file_simple', 'type'=>$type, 'holder_attr'=>'simple-media-'.$file->id, 'title'=>$title, 
                'related_id'=>$file->id, 'media_id'=>'simple-media-'.$file->id])}}" class="webadmin-open-ajax-popup direction" title="Media Images" 
                data-popup-size="xlarge"><i class="fas fa-pencil-alt"></i></a>
</div>