<div class="settings-item w-100 confirm-wrap" id="media-item-edit">
  <div class="row m-0">
  	<div class="card w-100">
        <div class="card-body" id="schedule-form">
            @include('admin.package_schedules.form', ['obj'=>$obj, 'package_id'=>$package_id])                                                                  
        </div><!--end card-body-->
      </div><!--end card-->
      <div class="card w-100">
        <div class="card-body" id="schedule-listing">
          @include('admin.package_schedules.list', ['schedules'=>$schedules])
        </div>
      </div>
  </div>
</div>