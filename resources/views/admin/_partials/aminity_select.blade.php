<div class="row">
        <div class="col-sm-5">
            <select name="amenity[]" id="amenitymultiselect" class="form-control" multiple="multiple">
                @foreach($amenities as $amenity)
                    <option value="{{$amenity->id}}">{{$amenity->name}}</option>
                @endforeach
            </select>
        </div>
        
        <div class="col-sm-2">
            <button type="button" id="amenitymultiselect_rightAll" class="btn btn-block"><i class="fas fa-forward"></i></button>
            <button type="button" id="amenitymultiselect_rightSelected" class="btn btn-block"><i class="fas fa-angle-double-right"></i></button>
            <button type="button" id="amenitymultiselect_leftSelected" class="btn btn-block"><i class="fas fa-angle-double-left"></i></button>
            <button type="button" id="amenitymultiselect_leftAll" class="btn btn-block"><i class="fas fa-backward"></i></button>
        </div>
        
        <div class="col-sm-5">
            <select name="amenity_to[]" id="amenitymultiselect_to" class="form-control" multiple="multiple">
                @if(count($selected))
                    @foreach($selected as $selected_amenity)
                        <option value="{{$selected_amenity['id']}}">{{$selected_amenity['name']}}</option>
                    @endforeach
                @endif
            </select>
     
            <div class="row">
                <div class="col-sm-6">
                    <button type="button" id="amenitymultiselect_move_up" class="btn btn-block"><i class="fas fa-arrow-up"></i></button>
                </div>
                <div class="col-sm-6">
                    <button type="button" id="amenitymultiselect_move_down" class="btn btn-block col-sm-6"><i class="fas fa-arrow-down"></i></button>
                </div>
            </div>
        </div>
    </div>