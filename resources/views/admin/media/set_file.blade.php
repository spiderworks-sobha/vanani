@php
	$media_id = isset($id)?$id:$holder_attr;
	$display = isset($display)?$display:'vertical';
@endphp
<div  id="{{$media_id}}">
	<input type="hidden" name="{{$holder_attr}}" @if($file) value="{{$file->id}}" @endif>
@if($file)
	@if(isset($display) && $display == 'horizontal')
		<div class="thumbnail text-center" >
			<div class="card">
				<div class="row no-gutters">
	                <div class="col-sm-5">
	                    @if($file->media_type == 'Image')
					  		<a href="{{route('admin.media.show', [encrypt($file->id)])}}" class="webadmin-open-ajax-popup item-meida" title="View Image Details" data-popup-size="large"><img src="{{ asset($file->file_path) }}?ver={{time()}}" width="200px"></a>
					  	@else
					  		<a href="{{asset($file->file_path)}}" class="item-meida" target="_blank"><img src="{{ asset($file->thumb_file_path) }}"></a>
					  	@endif
	                </div>
	                <div class="col-sm-7">
	                    <div class="card-body">
						    <p class="card-text">File: {{$file->file_name}}</p>
						    <p class="card-text">Size: {{BladeHelper::formatBytes($file->file_size)}}</p>
						    <hr/>
						    <div class="text-center">
						    	<a href="{{route('admin.media.popup', ['popup_type'=>$popup_type, 'type'=>$type, 'holder_attr'=>$holder_attr, 'title'=>$title, 'related_id'=>$file->id, 'media_id'=>$media_id, 'display'=>$display])}}" class="webadmin-open-ajax-popup" title="Media Images" data-popup-size="xlarge"><i class="fas fa-pencil-alt"></i></a>
						    	<a href="javascript:void(0);" data-id="{{$file->id}}" data-holder-id="{{$media_id}}" class="image-remove ml-2"><i class="fas fa-trash"></i></a>
						    </div>
						    
						  </div>
	                </div>
	            </div>
			</div>
		</div>
	@else
		<div class="thumbnail text-center" >
			<div class="card">
			@if($file->media_type == 'Image')
		  		<a href="{{route('admin.media.show', [encrypt($file->id)])}}" class="webadmin-open-ajax-popup item-meida" title="View Image Details" data-popup-size="large"><img src="{{ asset($file->file_path) }}?ver={{time()}}" width="200px"></a>
		  	@else
		  		<a href="{{asset($file->file_path)}}" class="item-meida" target="_blank"><img src="{{ asset($file->thumb_file_path) }}"></a>
		  	@endif
		  <div class="card-body">
		    <p class="card-text">File: {{$file->file_name}}</p>
		    <p class="card-text">Size: {{BladeHelper::formatBytes($file->file_size)}}</p>
		    <hr/>
		    <div class="text-center">
		    	<a href="{{route('admin.media.popup', ['popup_type'=>$popup_type, 'type'=>$type, 'holder_attr'=>$holder_attr, 'title'=>$title, 'related_id'=>$file->id, 'media_id'=>$media_id, 'display'=>$display])}}" class="webadmin-open-ajax-popup" title="Media Images" data-popup-size="xlarge"><i class="fas fa-pencil-alt"></i></a>
		    	<a href="javascript:void(0);" data-id="{{$file->id}}" data-holder-id="{{$media_id}}" class="image-remove ml-2"><i class="fas fa-trash"></i></a>
		    </div>
		    
		  </div>
		</div>
		</div>
	@endif
@endif
	<div class="media-container" @if($file) style="display: none;" @endif id="add-new-{{$media_id}}">
		<p class="media-content text-center" ><a href="{{route('admin.media.popup', ['popup_type'=>$popup_type, 'type'=>$type, 'holder_attr'=>$holder_attr, 'title'=>$title, 'related_id'=>0, 'media_id'=>$media_id, 'display'=>$display])}}" class="webadmin-open-ajax-popup" title="Media Images" data-popup-size="xlarge" >{{--<img src="{{asset('admin/assets/images/add_image.png')}}" style="width:150px;">--}} Set {{$title}}</a></p>
	</div>
</div>
