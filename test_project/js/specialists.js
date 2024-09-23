function loadSpecialists(specialityId) {
    // Fetch specialists based on the selected specialization
    fetch('./vendor/GetSpecialists.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `specialityId=${encodeURIComponent(specialityId)}`
    })
        .then(response => response.json())
        .then(data => {
            console.log('Specialists data:', data);  // Log the response to check the structure

            // Check if the expected specialists data exists
            if (data && data.SPECIALISTS) {
                let specialistsHtml = '<h2>Specialists List</h2><ul>';
                data.SPECIALISTS.forEach(specialist => {
                    specialistsHtml += `
                        <li>
                            <strong>Doctor Name: ${specialist.DOCTOR_NAME}</strong><br>
                            Doctor ID: ${specialist.DOCTOR_ID}
                        </li>
                    `;
                });
                specialistsHtml += '</ul>';

                // Display the specialists in the "Specialists" tab
                document.getElementById('specialists').innerHTML = specialistsHtml;

                // Show the "Specialists" tab and hide other content
                document.getElementById('specialists').style.display = 'block';
                document.getElementById('doctors').style.display = 'none';
            } else {
                console.error('Unexpected data structure:', data);
                document.getElementById('specialists').innerHTML = '<p>Error loading data: Invalid response structure.</p>';
            }
        })
        .catch(error => {
            console.error('Error fetching data:', error);
            document.getElementById('specialists').innerHTML = '<p>Error loading data.</p>';
        });
}
