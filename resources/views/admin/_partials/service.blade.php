@if ($service->children()->count() > 0 )
       
    @foreach($service->children as $service)
    	<option value="{{$service->id}}" @if($service->id == $selected) selected="selected" @endif>
    		@for($i=0; $i<$depth; $i++)
	    		&nbsp;-
	    	@endfor
    		&nbsp;{{$service->name}}
    	</option>
        @include('admin._partials.service', ['service'=>$service, 'depth'=>++$depth, 'selected'=>$selected])
    @endforeach

@endif