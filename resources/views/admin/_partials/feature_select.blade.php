<div class="row">
        <div class="col-sm-5">
            <select name="feature[]" id="featuremultiselect" class="form-control" multiple="multiple">
                @foreach($features as $feature)
                    <option value="{{$feature->id}}">{{$feature->name}}</option>
                @endforeach
            </select>
        </div>
        
        <div class="col-sm-2">
            <button type="button" id="featuremultiselect_rightAll" class="btn btn-block"><i class="fas fa-forward"></i></button>
            <button type="button" id="featuremultiselect_rightSelected" class="btn btn-block"><i class="fas fa-angle-double-right"></i></button>
            <button type="button" id="featuremultiselect_leftSelected" class="btn btn-block"><i class="fas fa-angle-double-left"></i></button>
            <button type="button" id="featuremultiselect_leftAll" class="btn btn-block"><i class="fas fa-backward"></i></button>
        </div>
        
        <div class="col-sm-5">
            <select name="feature_to[]" id="featuremultiselect_to" class="form-control" multiple="multiple">
                @if(count($selected))
                    @foreach($selected as $selected_feature)
                        <option value="{{$selected_feature['id']}}">{{$selected_feature['name']}}</option>
                    @endforeach
                @endif
            </select>
     
            <div class="row">
                <div class="col-sm-6">
                    <button type="button" id="featuremultiselect_move_up" class="btn btn-block"><i class="fas fa-arrow-up"></i></button>
                </div>
                <div class="col-sm-6">
                    <button type="button" id="featuremultiselect_move_down" class="btn btn-block col-sm-6"><i class="fas fa-arrow-down"></i></button>
                </div>
            </div>
        </div>
    </div>