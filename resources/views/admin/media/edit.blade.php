<div class="settings-item w-100 confirm-wrap" id="media-item-edit">
  <div class="row m-0">
  	<div class="col-md-7">
  		<div class="img-container-edit">
        @if($file->media_type == 'Image')
          <img  src="{{ asset($file->file_path) }}?ver={{time()}}" alt="{{$file->file_name}}" style="width: 100%">
        @elseif($file->media_type == 'Video')
          <div class="embed-responsive embed-responsive-16by9">
            <video class="embed-responsive-item" controls>
              <source src="{{ asset($file->file_path) }}?ver={{time()}}" type="{{$file->file_type}}">
              Your browser does not support the video tag.
            </video>
          </div>
        @elseif($file->media_type == 'Audio')
          <div>
             <audio controls>
              <source src="{{ asset($file->file_path) }}?ver={{time()}}" type="{{$file->file_type}}">
              Your browser does not support the audio element.
            </audio> 
          </div>
        @else
          <div>
            <img  src="{{ asset('public/'.$file->thumb_file_path) }}?ver={{time()}}" alt="{{$file->file_name}}">
          </div>
        @endif
      </div>
      @if(auth()->user()->can($permissions['edit']))
      <div class="media-change-file text-center"><input type="file" class="form-control" id="change-media" data-id="{{encrypt($file->id)}}" data-type="{{$file->media_type}}" /></div>
      <div id="media-change-file-message-{{$file->media_type}}" class="text-center"></div>
      @endif
      @if($file->media_type == 'Video')
        <div class="cover-image-holder">
            <div class="cover-image-inner">
              <img src="{{ asset($file->thumb_file_path) }}?ver={{time()}}"/>
            </div>
            @if(auth()->user()->can($permissions['edit']))
              <div class="media-change-file text-center"><input type="file" class="form-control" id="change-cover-media" data-id="{{encrypt($file->id)}}" data-type="Cover" /></div>
              <div id="media-change-file-message-Cover" class="text-center"></div>
            @endif
        </div>
      @endif
  	</div>
  	<div class="col-md-5 img-details-edit">
  		    @include('admin.media.image_details', ['file'=>$file])
  	</div>
  </div>
</div>