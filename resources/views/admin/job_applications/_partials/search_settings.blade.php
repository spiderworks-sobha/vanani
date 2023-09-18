<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="filter-form" id="searchForm">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="username">Date</label>
                                <input type="text" class="form-control datatable-advanced-search date-range-picker" name="date_between-job_applications.created_at">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="useremail">Status</label>
                                <select name="job_applications.status" class="form-control datatable-advanced-search webadmin-select2-input">
                                    <option value="">All</option>
                                    <option value="Open">Open</option>
                                    <option value="Processing">Processing</option>
                                    <option value="Selected">Selected</option>
                                    <option value="Rejected">Rejected</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="subject">Job</label>
                                
                                <select name="job_applications.careers_id" class="form-control datatable-advanced-search webadmin-select2-input">
                                    <option value="">All</option>
                                    @if(isset($search_settings['jobs']))
                                        @foreach($search_settings['jobs'] as $job)
                                            <option value="{{$job->id}}">{{$job->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group mt-4">
                                <button type="button" class="btn btn-primary px-4" onclick="dt();">Filter</button>
                                <button type="button" class="btn btn-secondary px-4" id="search-table-clear-btn">Clear</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>