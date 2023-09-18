<div class="settings-item w-100 confirm-wrap" id="media-item-edit">
  <div class="row m-0">
  	<div class="card w-100">
        <div class="card-body" id="faq-form">
            @include('admin.faq.form', ['obj'=>$obj, 'type'=>$type])                                                                  
        </div><!--end card-body-->
      </div><!--end card-->
      <div class="card w-100">
        <div class="card-body" id="faq-listing">
          @include('admin.faq.list', ['faq'=>$faq])
        </div>
      </div>
  </div>
</div>