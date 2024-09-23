function loadSpecialists(specialityId) {
    console.log(`Fetching specialists for speciality ID: ${specialityId}`);

    fetch('./vendor/GetDoctorsBySpeciality.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `specialityId=${encodeURIComponent(specialityId)}`
    })
        .then(response => {
            // Check for HTTP errors
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json(); // Ensure response is JSON
        })
        .then(data => {
            console.log('Specialists data:', data);  // Log the response to check the structure

            if (data && data.DOCTORS) {
                let doctorsHtml = '<h2>Specialists List</h2><ul>';
                data.DOCTORS.forEach(doctor => {
                    doctorsHtml += `<br>
                        <li>
                            <strong>Doctor Name: ${doctor.NAME}</strong><br>
                            Workplace: ${doctor.WORKPLACE_NAME}<br>
                            <img src="data:image/jpeg;base64,${doctor.FILE_CONTENT}" alt="Doctor's image" style="width:100px; height:100px;" /><br>
                        </li>
                    `;
                });
                doctorsHtml += '</ul>';

                // Display the specialists in the "Specialists" tab
                document.getElementById('specialists').innerHTML = doctorsHtml;
                document.getElementById('specialists').style.display = 'block';
                document.getElementById('doctors').style.display = 'none';
            } else {
                throw new Error('Unexpected data structure');
            }
        })
        .catch(error => {
            console.error('Error fetching data:', error);
            document.getElementById('specialists').innerHTML = '<p>Error loading data.</p>';
        });
}
