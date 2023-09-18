<div class="settings-item w-100 confirm-wrap">
        <form method="POST" action="{{ route($route.'.store') }}" class="p-t-15" id="SettingsFrm" enctype="multipart/form-data" data-validate=true>
                    @csrf
            <input type="hidden" name="id" value="{{encrypt($parent->id)}}">
            <p>{{$parent->comment}}</p>
            <div class="column-seperation padding-5 text-field">
                <div class="form-group form-group-default required">
                    <label>Reply</label>
                    <textarea name="comment" class="form-control" rows="3" ></textarea>
                </div>
            </div>

            <div class="row bottom-btn m-0">
                <div class="col-md-12" align="right">
                    <button type="button" id="webadmin-ajax-form-submit-btn" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>               
</div>
