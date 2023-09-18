<div class="col-md-3 media-preview-wrap parent" id="media-item-list-{{$file->id}}">
	<input type="checkbox" name="ids[]" class="bulk-selet-media"  value="{{$file->id}}">
	<div class="card" style="width: 18rem;">
		@if($file->media_type == 'Image')
			@if(auth()->user()->can($permissions['edit']))
	  			<a href="{{route($route.'.edit', [encrypt($file->id)])}}" class="webadmin-open-ajax-popup item-meida" title="Edit Image Details" data-popup-size="large"><img src="{{ asset($file->file_path) }}?ver={{time()}}" width="200px"></a>
	  		@else
	  			<a href="{{route($route.'.show', [encrypt($file->id)])}}" class="webadmin-open-ajax-popup item-meida" title="View Image Details" data-popup-size="large"><img src="{{ asset($file->file_path) }}?ver={{time()}}" width="200px"></a>
	  		@endif
	  	@else
	  		<a href="{{asset($file->file_path)}}" class="item-meida" target="_blank"><img src="{{ asset($file->thumb_file_path) }}"></a>
	  	@endif
	  <div class="card-body">
	    <p class="card-text">File: {{$file->file_name}}</p>
	    <p class="card-text">Size: {{BladeHelper::formatBytes($file->file_size)}}</p>
	    <hr/>
	    <div class="text-center">
	    	@if(auth()->user()->can($permissions['edit']))
	    	<a href="{{route($route.'.edit', [encrypt($file->id)])}}" class="webadmin-open-ajax-popup item-meida" title="Edit Image Details" data-popup-size="large"><i class="fas fa-pencil-alt"></i></a>
	    	@endif
	    	@if(auth()->user()->can($permissions['delete']))
	    	<a href="{{route($route.'.index.post')}}" data-id="{{$file->id}}" class="media-delete ml-2"><i class="fas fa-trash"></i></a>
	    	@endif
	    </div>
	    
	  </div>
	</div>
</div>