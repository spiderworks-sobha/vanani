@if($obj->id)
    <form method="POST" action="{{ route('admin.packages.schedule.update') }}" class="p-t-15" id="scheduleForm" data-validate=true>
@else
    <form method="POST" action="{{ route('admin.packages.schedule.store') }}" class="p-t-15" id="scheduleForm" data-validate=true>
@endif
                                    @csrf
                                    <input type="hidden" name="id" @if($obj->id) value="{{encrypt($obj->id)}}" @endif>
                                    <input type="hidden" name="package_id" value="{{$package_id}}">
                                        <div class="row">
                                            <div class="col-12">
                                                <div data-simplebar>
                                                    <div class="tab-content chat-list" id="pills-tabContent" >
                                                        <div class="tab-pane fade show active" id="tab1">
                                                            <div class="row m-0">
                                                                <div class="form-group col-md-12">
                                                                    <label>Title</label>
                                                                    <input type="text" name="title" class="form-control" value="{{$obj->title}}" >
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <label>Description</label>
                                                                    <textarea name="description" class="form-control" >{{$obj->description}}</textarea>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    @include('admin.media.set_file', ['file'=>$obj->icon_image, 'title'=>'Icon Image', 'popup_type'=>'single_image', 'type'=>'Image', 'holder_attr'=>'schedule_icon_image_id'])
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    @include('admin.media.set_file', ['file'=>$obj->featured_image, 'title'=>'Featured Image', 'popup_type'=>'single_image', 'type'=>'Image', 'holder_attr'=>'schedule_featured_image_id'])
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr/>
                                        <div class="row">
                                            <div class="col-sm-6 text-left">
                                              @if($obj->id)
                                                <a href="{{route('admin.packages.schedule.create', [$package_id])}}" class="btn btn-sm btn-soft-primary" id="schedule-create-new">Create New</a>
                                              @endif
                                            </div>
                                            <div class="col-sm-6 text-right">
                                                <button type="button" id="add-schedule-btn" class="btn btn-primary btn-sm px-4">Save</button>
                                            </div>
                                        </div>
            </form> 