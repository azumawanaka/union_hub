document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap Select
    $('.client-id').selectpicker();
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
