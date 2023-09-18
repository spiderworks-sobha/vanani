@if($obj->id)
    <form method="POST" action="{{ route('admin.faq.update') }}" class="p-t-15" id="faqForm" data-validate=true>
@else
    <form method="POST" action="{{ route('admin.faq.store') }}" class="p-t-15" id="faqForm" data-validate=true>
@endif
                                    @csrf
                                    <input type="hidden" name="linkable_id" value="{{$obj->linkable_id}}">
                                    <input type="hidden" name="linkable_type" value="{{$obj->linkable_type}}">
                                    <input type="hidden" name="id" @if($obj->id) value="{{encrypt($obj->id)}}" @endif>
                                    <input type="hidden" name="type" value="{{$type}}">
                                        <div class="row">
                                            <div class="col-12">
                                                <div data-simplebar>
                                                    <div class="tab-content chat-list" id="pills-tabContent" >
                                                        <div class="tab-pane fade show active" id="tab1">
                                                            <div class="row m-0">
                                                                <div class="form-group col-md-12">
                                                                    <label>Question</label>
                                                                    <input type="text" name="question" class="form-control" value="{{$obj->question}}" >
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <label>Answer</label>
                                                                    <textarea name="answer" class="form-control editor" id="answer">{{$obj->answer}}</textarea>
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
                                                <a href="{{route('admin.faq.create', [$obj->linkable_id, $type])}}" class="btn btn-sm btn-soft-primary" id="faq-create-new">Create New</a>
                                              @endif
                                            </div>
                                            <div class="col-sm-6 text-right">
                                                <button type="button" id="add-faq-btn" class="btn btn-primary btn-sm px-4">Save</button>
                                            </div>
                                        </div>
            </form> 