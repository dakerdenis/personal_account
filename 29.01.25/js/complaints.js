function loadComplaints() {
    const complaintsTab = document.getElementById('complaints');
    const preloader = document.getElementById('preloader');

    // Show preloader
    preloader.style.display = 'flex';

    // Ensure preloader is visible for at least 1.5 seconds
    setTimeout(() => {
        fetch('./vendor/GetMedicalClaimInformations.php') // Replace with your actual endpoint
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Complaints data:', data); // Log the response to check the structure

                if (data && data.COMPLAINTS) {
                    let complaintsHtml = '<h2 class="complaints_medical-name">Complaints List</h2><ul>';
                    data.COMPLAINTS.forEach(complaint => {
                        complaintsHtml += `
                            <li class="complaints_medical-li">
                                <div class="complaints_medical-block"><p>PIN Code:</p> <span>${complaint.PIN_CODE}</span></div>
                                <div class="complaints_medical-block"><p>Clinic Name:</p> <span>${complaint.CLINIC_NAME}</span></div>
                                <div class="complaints_medical-block"><p>Event Occurrence Date:</p> <span>${new Date(complaint.EVENT_OCCURRENCE_DATE).toLocaleDateString()}</span></div>
                            </li>
                        `;
                    });
                    complaintsHtml += '</ul>';
                    complaintsTab.innerHTML = complaintsHtml;
                } else {
                    throw new Error('Invalid complaints data structure');
                }
            })
            .catch(error => {
                console.error('Error fetching complaints data:', error);
                complaintsTab.innerHTML = `<p>Error loading complaints data: ${error.message || 'Unknown error'}.</p>`;
            })
            .finally(() => {
                // Hide preloader after data is loaded or error occurs
                preloader.style.display = 'none';
            });
    }, 1500); // Minimum preloader time of 1.5 seconds
}
