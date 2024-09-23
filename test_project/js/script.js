document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.tab-link');
    const contentDivs = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', function(event) {
            event.preventDefault();
            const targetId = this.getAttribute('data-target');

            // Hide all content divs and show the target one
            contentDivs.forEach(div => {
                if (div.id === targetId) {
                    div.style.display = 'block';
                } else {
                    div.style.display = 'none';
                }
            });

            // Fetch data from the server
            fetch('./vendor/GetCustomerInformation.php')
                .then(response => response.json())
                .then(data => {
                    console.log('Response data:', data); // Log the response to check the structure

                    // Check if the expected data exists
                    if (data && data.CUSTOMER_INFORMATION) {
                        document.getElementById(targetId).innerHTML = `
                            <h2>${data.CUSTOMER_INFORMATION.NAME} ${data.CUSTOMER_INFORMATION.SURNAME}</h2>
                            <p>Details here...</p>
                        `;
                    } else {
                        console.error('Unexpected data structure:', data);
                        document.getElementById(targetId).innerHTML = '<p>Error loading data: Invalid response structure.</p>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    document.getElementById(targetId).innerHTML = '<p>Error loading data.</p>';
                });
        });
    });

    // Initially hide all content
    contentDivs.forEach(div => {
        div.style.display = 'none';
    });
});
