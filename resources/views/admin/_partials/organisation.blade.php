<div class="global-organisation-wrap">
                <select name="global_organisation" id="global_organisation" class="form-control webadmin-select2-input" data-select2-url="{{route('admin.select2.main-organisations')}}">
                	@if(auth()->user()->current_organisation)
                    	<option value="{{auth()->user()->current_organisation->id}}" selected="selected">{{auth()->user()->current_organisation->name}}</option>
                    @endif             
                </select>
                <div class="m-2">
                    <a href="{{url('admin/main-organisations/create')}}" class="btn btn-sm btn-soft-primary w-100">Create New Organisation</a>
                </div> 
            </div>