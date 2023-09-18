<div class="settings-item w-100 confirm-wrap">
  <div class="row m-0">
    <form id="inputForm" data-validate=true class="w-100" method="POST" @if($obj->id) action="{{ route($route.'.update') }}" @else action="{{ route($route.'.store') }}" @endif enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" @if($obj->id) value="{{encrypt($obj->id)}}" @endif />
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="listing_name" name="listing_name" value="{{$obj->listing_name}}">
        </div>
        <button type="button" id="webadmin-ajax-form-submit-btn" class="btn btn-primary float-right">Submit</button>
    </form>
  </div>
</div>