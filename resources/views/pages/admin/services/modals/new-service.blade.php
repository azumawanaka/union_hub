<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Service</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-service" action="#" method="post">
                <div class="modal-body">
                    <div class="form-validation">
                        <div class="form-group row">
                            <label class="col-lg-12 col-form-label" for="name">Name <span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-12">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter a service name..">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-12 col-form-label" for="client_id">Client <span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-12">
                                <select class="form-control form-select selectpicker"
                                    id="client_id"
                                    name="client_id"
                                    data-live-search="true" title="Select a client">
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-12 col-form-label" for="service_type_id">Service Type <span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-12">
                                <select class="form-control" id="service_type_id" name="service_type_id">
                                    <option value="">Please select</option>
                                    @foreach ($serviceTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-12 col-form-label" for="description">Description</label>
                            <div class="col-lg-12">
                                <textarea class="form-control" id="descriptions" name="description" rows="5" placeholder="Write description here..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('assets/plugins/validation/jquery.validate.min.js') }}"></script>

    @vite(['resources/js/validator.js'])
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Bootstrap Select
            $('#client_id').selectpicker();
        });

        document.addEventListener('DOMContentLoaded', function() {
            const selectDropdown = document.getElementById('client_id');

            // Function to fetch data from the server using Axios
            const fetchData = async () => {
                try {
                    // Simulating fetching data (replace with your actual fetch logic)
                    let items = [];

                    window.axios.get('client/search').then(function(response) {
                        const items = response.data;

                        // Populate the dropdown with fetched data
                        items.forEach(item => {
                            const option = document.createElement('option');
                            option.value = item.id; // Set the value to the item or any unique identifier
                            option.text = item.name;  // Set the text to the item or any display text
                            selectDropdown.appendChild(option);
                        });

                        // Refresh Bootstrap Select after updating options
                        $('#client_id').selectpicker('refresh');
                    });
                } catch (error) {
                    console.error('Error fetching data:', error);
                }
            };

            // Call the fetchData function
            fetchData();
        });

        const selectDropdown = document.getElementById('client_id');

        // Event listener for when an option is selected
        selectDropdown.addEventListener('change', function() {
            // Get the selected option
            const selectedOption = $(this).find(':selected')[0];

            // Set the "selected" attribute for the chosen option
            selectedOption.setAttribute('selected', 'selected');

            // Refresh Bootstrap Select after updating options
            $('#client_id').selectpicker('refresh');
        });
    </script>
@endpush
