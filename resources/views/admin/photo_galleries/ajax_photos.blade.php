@if(count($photos)>0)
	@foreach($photos as $photo)
		@php
			$file = $photo->media;
		@endphp
		<div class="col-md-3 media-preview-wrap parent">
			<div class="thumbnail text-center" >
				<div class="card" style="width: 18rem;">
				@if($file->media_type == 'Image')
			  		<a href="{{route('admin.media.show', [encrypt($file->id)])}}" class="webadmin-open-ajax-popup item-meida" title="View Image Details" data-popup-size="large"><img src="{{ asset($file->thumb_file_path) }}?ver={{time()}}"></a>
			  	@else
			  		<a href="{{asset($file->file_path)}}" class="item-meida" target="_blank"><img src="{{ asset($file->thumb_file_path) }}"></a>
			  	@endif
			  <div class="card-body">
			    <p class="card-text">File: {{$file->file_name}}</p>
			    <p class="card-text">Size: {{BladeHelper::formatBytes($file->file_size)}}</p>
			    <hr/>
			    <div class="text-center">
			    	<a href="{{route($route.'.photo_edit', array('id'=>$photo->id, 'gallery_id'=>$gallery, 'type'=>'Gallery'))}}" class="webadmin-open-ajax-popup" title="update Image Details" data-popup-size="xlarge"><i class="fas fa-pencil-alt"></i></a>
			    	<a href="{{route($route.'.photo-delete',[$gallery, $photo->id, 'Gallery'])}}" class="webadmin-btn-warning-popup" data-message="Are you sure to delete?  Associated data will be removed if it is deleted." data-redirect-url="{{route($route.'.edit', [encrypt($gallery)])}}"><i class="fas fa-trash"></i></a>
			    </div>
			    
			  </div>
			</div>
			</div>
		</div>
	@endforeach
@endif