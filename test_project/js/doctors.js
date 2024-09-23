function loadDoctors() {
    fetch('./vendor/GetSpecialities.php')  // Endpoint for fetching specializations
        .then(response => response.json())
        .then(data => {
            console.log('Specialities data:', data);  // Log the response to check the structure

            if (data && data.SPECIALITIES) {
                const specialities = Array.isArray(data.SPECIALITIES) ? 
                                     data.SPECIALITIES : 
                                     [data.SPECIALITIES];  // Handle both array and single object case

                let specialitiesHtml = '<h2>Specialities List</h2><ul>';
                specialities.forEach(speciality => {
                    specialitiesHtml += `
                        <li data-speciality-id="${speciality.SPECIALITY_ID}">
                            <strong>Speciality Name: ${speciality.SPECIALITY_NAME}</strong><br>
                            Speciality ID: ${speciality.SPECIALITY_ID}
                        </li>
                    `;
                });
                specialitiesHtml += '</ul>';

                // Display the list of specialities
                document.getElementById('doctors').innerHTML = specialitiesHtml;

                // Add click event listener to each specialization
                document.querySelectorAll('#doctors li').forEach(item => {
                    item.addEventListener('click', function () {
                        const specialityId = this.getAttribute('data-speciality-id');
                        loadSpecialists(specialityId); // Call function to load specialists
                    });
                });
            } else {
                console.error('Unexpected data structure:', data);
                document.getElementById('doctors').innerHTML = '<p>Error loading data: Invalid response structure.</p>';
            }
        })
        .catch(error => {
            console.error('Error fetching data:', error);
            document.getElementById('doctors').innerHTML = '<p>Error loading data.</p>';
        });
}
