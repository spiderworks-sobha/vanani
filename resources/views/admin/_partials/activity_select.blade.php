<div class="row">
        <div class="col-sm-5">
            <select name="activity[]" id="activitymultiselect" class="form-control" multiple="multiple">
                @foreach($activities as $activity)
                    <option value="{{$activity->id}}">{{$activity->name}}</option>
                @endforeach
            </select>
        </div>
        
        <div class="col-sm-2">
            <button type="button" id="activitymultiselect_rightAll" class="btn btn-block"><i class="fas fa-forward"></i></button>
            <button type="button" id="activitymultiselect_rightSelected" class="btn btn-block"><i class="fas fa-angle-double-right"></i></button>
            <button type="button" id="activitymultiselect_leftSelected" class="btn btn-block"><i class="fas fa-angle-double-left"></i></button>
            <button type="button" id="activitymultiselect_leftAll" class="btn btn-block"><i class="fas fa-backward"></i></button>
        </div>
        
        <div class="col-sm-5">
            <select name="activity_to[]" id="activitymultiselect_to" class="form-control" multiple="multiple">
                @if(count($selected))
                    @foreach($selected as $selected_activity)
                        <option value="{{$selected_activity['id']}}">{{$selected_activity['name']}}</option>
                    @endforeach
                @endif
            </select>
     
            <div class="row">
                <div class="col-sm-6">
                    <button type="button" id="activitymultiselect_move_up" class="btn btn-block"><i class="fas fa-arrow-up"></i></button>
                </div>
                <div class="col-sm-6">
                    <button type="button" id="activitymultiselect_move_down" class="btn btn-block col-sm-6"><i class="fas fa-arrow-down"></i></button>
                </div>
            </div>
        </div>
    </div>