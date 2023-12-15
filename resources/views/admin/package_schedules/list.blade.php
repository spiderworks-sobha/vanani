@if(count($schedules)>0)
<p class="text-secondary mr-2 text-right">Re-arrange the schedules to order tham.</p>
<div class="accordion" id="accordionSchedule">
    @foreach($schedules as $key=> $item)
            <div class="card schedules-item-card" id="{{$item->id}}">
              <div class="card-header p-1" id="heading{{$item->id}}">
                <h2 class="m-0 float-left">
                  <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse{{$item->id}}" aria-expanded="true" aria-controls="collapseOne">
                    {{ $item->title }}
                    
                  </button>

                </h2>
                <p class="float-right m-2">
                      <a href="{{route('admin.packages.schedule.edit', [encrypt($item->id)])}}" class="mr-1 edit-schedule-btn"><i class="fa fa-pencil-alt"></i></a>
                      <a href="{{route('admin.packages.schedule.destroy', [encrypt($item->id)])}}" class="delete-schedule-btn" data-message="Are you sure to delete?  Associated data will be removed if it is deleted." data-target="#schedule-listing"><i class="fa fa-trash"></i></a>
                    </p>
              </div>

              <div id="collapse{{$item->id}}" class="collapse" aria-labelledby="heading{{$item->id}}" data-parent="#accordionSchedule">
                <div class="card-body">
                  {!! $item->description !!}
                </div>
              </div>
            </div>
    @endforeach
          </div>
@endif