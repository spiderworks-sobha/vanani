<div class="settings-item w-100 confirm-wrap">
    <hr/>
    @php
        $data = json_decode($obj->data, true);
    @endphp
    <div class="row m-0">
        <div class="col-12">
            <div data-simplebar>
                <div class="tab-content chat-list" id="pills-tabContent" >
                    <div class="tab-pane fade show active" id="tab1">
                        <div class="row m-0">
                            @foreach($data as $key=>$val)
                            <div class="form-group col-md-12">
                                <label for="name">{{$key}}: </label>
                                <b>{!! $val !!}</b>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>              
</div>
