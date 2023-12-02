$(document).ready(function() {
    $(document).on('click', '#edit_service', function () {
        var editUrl = $(this).data('href');
        var serviceUrl = $(this).data('get');

        emptyFields();

        const form = $('#serviceModal form')
            form.attr('action', editUrl);

        getService(serviceUrl);

        $('#serviceModal').modal('show');
    });


    let serviceRoute = ''
    $(document).on('click', '#delete_service', function(e) {
        e.preventDefault();
        serviceRoute = $(this).attr('data-href');

        $('#deleteConfirmationModal form').attr('action', serviceRoute);

        $('#deleteConfirmationModal').modal('show');
    });

    $(document).on('click', '#add_service', function(e) {
        e.preventDefault();
        serviceRoute = $(this).attr('data-href');

        $('#serviceModal form').attr('action', serviceRoute);

        emptyFields();

        $('#serviceModal').modal('show');
    });

    function getService(route) {
        window.axios.get(route)
            .then(function(response) {
                const serviceResponseData = response.data;
                setUpFields(serviceResponseData);
            })
            .catch(function(error) {
                console.error('Error fetching data:', error);
            });
    }

    function emptyFields() {
        const emptyPayload = {
            'title': '',
            'service_type_id': '',
            'client_id': '',
            'description': '',
        };
        setUpFields(emptyPayload);
    }

    function setUpFields(v) {
        const form = $('#serviceModal form')

        form.find('#name').val(v.title).focus();
        form.find('#service_type_id').val(v.service_type_id);

        form.find('#client_id').val(v.client_id);
        $('#client_id').selectpicker('refresh');

        form.find('#descriptions').val(v.description);
    }

    $(document).on('click', '.close-modal', function () {
        $('.modal').modal('hide');
    });
});
