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
  	</div>
  	<div class="col-md-5 img-details-edit">
  		    <div class="img-details">
            <p><b>File Path: </b> {{ asset('public/'.$file->file_path) }} </p>
            <p><b>File Name: </b> {{$file->file_name}}</p>
            <p><b>File Size: </b> {{BladeHelper::formatBytes($file->file_size)}} </p>
            <p><b>Last updated On: </b> <?php echo date('d M, Y h:i A', strtotime($file->updated_at));?></p>
            <p><b>File Type: </b> {{$file->file_type}}</p>
            @if($file->media_type == 'Image')
              <p><b>File Dimensions: </b> {{$file->dimensions}}</p>
            @endif
          </div>
  	</div>
  </div>
</div>