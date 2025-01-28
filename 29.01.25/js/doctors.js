function loadDoctors() {
    fetch('./vendor/GetSpecialities.php')  // Endpoint for fetching specializations
        .then(response => response.json())
        .then(data => {
            console.log('Specialities data:', data);  // Log the response to check the structure

            if (data && data.SPECIALITIES) {
                const specialities = Array.isArray(data.SPECIALITIES) ?
                    data.SPECIALITIES :
                    [data.SPECIALITIES];  // Handle both array and single object case

                let specialitiesHtml = '<h2 class="doctors_desc">Həkimlər</h2> <br> <ul>';
                specialities.forEach(speciality => {
                    specialitiesHtml += `
                        <li class="doktor_list_speciality_element" data-speciality-id="${speciality.SPECIALITY_ID}">
                            <img src="https://a-group.az/assets/images/healthicons_doctor-male-outline.svg" alt="" srcset="">
                            <p>${speciality.SPECIALITY_NAME}</p>

                        </li>
                                                    Speciality ID: ${speciality.SPECIALITY_ID}
                    `;
                });
                specialitiesHtml += '</ul>';

                // Display the list of specialities
                document.getElementById('doctors').innerHTML = specialitiesHtml;

                // Add click event listener to each specialization
                document.querySelectorAll('#doctors li').forEach(item => {
                    item.addEventListener('click', function () {
                        const specialityId = this.getAttribute('data-speciality-id');
                        console.log('Specialization clicked with ID:', specialityId);  // Debug log
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
