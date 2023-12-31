<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Services</h4>

                <div class="table-responsive">
                    <table id="service_tbl" class="table table-striped table-bordered"></table>
                </div>

            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        $(document).ready(function() {
            const dataTable = $('#service_tbl').DataTable({
                processing: true,
                serverSide: true,
                paging: true,
                searching: true,
                ordering: true,
                order: [[5, 'desc']],
                lengthMenu: [10, 25, 50, 100],
                pageLength: 10,
                ajax: {
                    url: 'services/all',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                },
                columns: [
                    { data: 's_id', name: 'services.id', title: 'ID' },
                    { data: 'title', name: 'title', title: 'Name' },
                    {
                        data: 's_rate',
                        name: 's_rate',
                        title: 'Rate',
                        orderable: false,
                        render: function (data, type, row) {
                            return `Php ${addCommasToNumber(data)}`;
                        }
                    },
                    { data: 's_name', name: 'service_types.name', title: 'Type' },
                    { data: 'c_name', name: 'clients.name', title: 'Client' },
                    { data: 'added_at', name: 'added_at', title: 'Added at' }
                ]
            });

            $(document).on('click', '.close-modal', function () {
                $('.modal').modal('hide');
            });

            function addCommasToNumber(number) {
                // Convert the number to a string
                let numberString = number.toString();

                // Split the integer and decimal parts (if any)
                let parts = numberString.split('.');
                let integerPart = parts[0];
                let decimalPart = parts.length > 1 ? '.' + parts[1] : '';

                // Add commas to the integer part
                let formattedIntegerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, ', ');

                // Concatenate the formatted integer part with the decimal part
                let formattedNumber = formattedIntegerPart + decimalPart;

                return formattedNumber;
            }
        });
    </script>
@endpush
