<div class="settings-item w-100 confirm-wrap">
        <form method="POST" action="{{ route($route.'.update') }}" class="p-t-15" id="SettingsFrm" enctype="multipart/form-data" data-validate=true>
                    @csrf
            <input type="hidden" name="id" value="{{encrypt($obj->id)}}">
            <div class="row m-0">
                <div class="form-group col-md-12">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" value="{{$obj->name}}">
                </div>
                <div class="form-group col-md-12">
                    <label for="name">Route</label>
                    <input type="text" class="form-control" name="route" id="route" value="{{$obj->route}}">
                </div>
            </div>               
            <div class="row bottom-btn m-0">
                <div class="col-md-12" align="right">
                    <button type="button" id="webadmin-ajax-form-submit-btn" class="btn btn-primary">Submit</button>
                </div>
             </div>
        </form>               
</div>
