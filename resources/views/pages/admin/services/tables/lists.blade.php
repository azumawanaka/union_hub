<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Services</h4>
                <button type="button"
                    class="btn mb-1 btn-info btn-xs"
                    data-toggle="modal"
                    data-target="#exampleModal"
                    data-whatever="@getbootstrap">
                    Add Service <span class="btn-icon-right"><i class="fa fa-plus"></i></span>
                </button>

                @include('pages.admin.services.modals.new-service')

                <div class="table-responsive">
                    <table id="service_tbl" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Type</th>
                                <th>Name</th>
                                <th width="350">Description</th>
                                <th>Client</th>
                                <th>Added At</th>
                                <th width="30">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($services as $service)
                                <tr>
                                    <td>{{ $service->id }}</td>
                                    <td><span class="badge badge-primary px-2">{{ $service->title }}</span></td>
                                    <td>{{ $service->serviceType->name }}</td>
                                    <td>{!! $service->description ?? '----' !!}</td>
                                    <td>{{ $service->client->name }}</td>
                                    <td>{{ $service->created_at->diffForHumans() }}</td>
                                    <td class="text-center">
                                        <span>
                                            <a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
                                                <i class="fa fa-pencil color-muted m-r-5"></i>
                                            </a>
                                                <a tabindex="0"
                                                    role="button"
                                                    data-toggle="popover"
                                                    data-trigger="focus"
                                                    data-html="true"
                                                    title="Confirm Delete"
                                                    data-content="Do you want to continue delete this service?
                                                        <div class='mt-2 text-center'>
                                                            <span class='btn btn-xs btn-default'>Cancel</span>
                                                            <a href='' class='btn btn-xs btn-info'>Yes</a>
                                                        </div>">
                                                    <i class="fa fa-close color-danger"></i>
                                                </a>
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
