<div class="row">
        <div class="col-sm-5">
            <select name="attraction[]" id="attractionmultiselect" class="form-control" multiple="multiple">
                @foreach($attractions as $attraction)
                    <option value="{{$attraction->id}}">{{$attraction->name}}</option>
                @endforeach
            </select>
        </div>
        
        <div class="col-sm-2">
            <button type="button" id="attractionmultiselect_rightAll" class="btn btn-block"><i class="fas fa-forward"></i></button>
            <button type="button" id="attractionmultiselect_rightSelected" class="btn btn-block"><i class="fas fa-angle-double-right"></i></button>
            <button type="button" id="attractionmultiselect_leftSelected" class="btn btn-block"><i class="fas fa-angle-double-left"></i></button>
            <button type="button" id="attractionmultiselect_leftAll" class="btn btn-block"><i class="fas fa-backward"></i></button>
        </div>
        
        <div class="col-sm-5">
            <select name="attraction_to[]" id="attractionmultiselect_to" class="form-control" multiple="multiple">
                @if(count($selected))
                    @foreach($selected as $selected_attraction)
                        <option value="{{$selected_attraction['id']}}">{{$selected_attraction['name']}}</option>
                    @endforeach
                @endif
            </select>
     
            <div class="row">
                <div class="col-sm-6">
                    <button type="button" id="attractionmultiselect_move_up" class="btn btn-block"><i class="fas fa-arrow-up"></i></button>
                </div>
                <div class="col-sm-6">
                    <button type="button" id="attractionmultiselect_move_down" class="btn btn-block col-sm-6"><i class="fas fa-arrow-down"></i></button>
                </div>
            </div>
        </div>
    </div>