function loadDoctors() {
    fetch('./vendor/GetDoctors.php')  // Replace with your actual endpoint
        .then(response => response.json())
        .then(data => {
            console.log('Doctors data:', data);  // Log the response to check the structure

            if (data && data.DOCTORS_LIST) {  // Replace with the correct structure from API response
                let doctorsHtml = '<h2>Doctors List</h2>';
                data.DOCTORS_LIST.forEach(doctor => {
                    doctorsHtml += `<p>Doctor Name: ${doctor.name}</p>`;
                });
                document.getElementById('doctors').innerHTML = doctorsHtml;
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
