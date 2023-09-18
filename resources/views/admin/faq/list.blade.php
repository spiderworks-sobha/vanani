@if(count($faq)>0)
<p class="text-secondary mr-2 text-right">Re-arrange the questions to order tham.</p>
<div class="accordion" id="accordionExample">
    @foreach($faq as $key=> $item)
            <div class="card faq-item-card" id="{{$item->id}}">
              <div class="card-header p-1" id="heading{{$item->id}}">
                <h2 class="m-0 float-left">
                  <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse{{$item->id}}" aria-expanded="true" aria-controls="collapseOne">
                    {{ $item->question }}
                    
                  </button>

                </h2>
                <p class="float-right m-2">
                      <a href="{{route('admin.faq.edit', [encrypt($item->id), $type])}}" class="mr-1 edit-faq-btn"><i class="fa fa-pencil-alt"></i></a>
                      <a href="{{route('admin.faq.destroy', [encrypt($item->id)])}}" class="delete-faq-btn" data-message="Are you sure to delete?  Associated data will be removed if it is deleted." data-target="#faq-listing"><i class="fa fa-trash"></i></a>
                    </p>
              </div>

              <div id="collapse{{$item->id}}" class="collapse" aria-labelledby="heading{{$item->id}}" data-parent="#accordionExample">
                <div class="card-body">
                  {!! $item->answer !!}
                </div>
              </div>
            </div>
    @endforeach
          </div>
@endif