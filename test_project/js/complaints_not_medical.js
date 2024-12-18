function loadNonMedicalComplaints() {
    const complaintsTab = document.getElementById('complaints_not_medical');
    const preloader = document.getElementById('preloader');

    // Show preloader
    preloader.style.display = 'flex';

    // Ensure preloader is visible for at least 1.5 seconds
    setTimeout(() => {
        fetch('./vendor/GetNonMedicalClaimInformations.php') // Replace with your actual endpoint
            .then(response => {
                console.log('Raw Response:', response);
                return response.json();
            })
            .then(data => {
                console.log('Non-Medical Complaints Data:', data); // Log the response to check the structure

                // Check if data is valid
                if (data && data.CLM_NOTICE_DISPETCHER) {
                    const complaints = Array.isArray(data.CLM_NOTICE_DISPETCHER)
                        ? data.CLM_NOTICE_DISPETCHER
                        : [data.CLM_NOTICE_DISPETCHER];

                    // Check if complaints are empty
                    if (complaints.length === 0 || Object.keys(complaints[0]).length === 0) {
                        complaintsTab.innerHTML = '<p>You don\'t have complaints.</p>';
                        return;
                    }

                    // Create HTML for complaints
                    let complaintsHtml = '<h2>Non-Medical Complaints</h2><ul>';
                    complaints.forEach(complaint => {
                        complaintsHtml += `
                            <li>
                                <p><strong>PIN Code:</strong> ${complaint.PIN_CODE || 'N/A'}</p>
                                <p><strong>Clinic Name:</strong> ${complaint.CLINIC_NAME || 'N/A'}</p>
                                <p><strong>Event Date:</strong> ${
                                    complaint.EVENT_OCCURRENCE_DATE
                                        ? new Date(complaint.EVENT_OCCURRENCE_DATE).toLocaleString()
                                        : 'N/A'
                                }</p>
                            </li>
                        `;
                    });
                    complaintsHtml += '</ul>';

                    // Render complaints in the tab
                    complaintsTab.innerHTML = complaintsHtml;
                } else {
                    // Handle completely empty responses
                    complaintsTab.innerHTML = '<p>You don\'t have complaints.</p>';
                }
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                complaintsTab.innerHTML = `<p>Error loading non-medical complaints data: ${error.message || 'Unknown error'}.</p>`;
            })
            .finally(() => {
                // Hide preloader after data is loaded or error occurs
                preloader.style.display = 'none';
            });
    }, 1500); // Minimum preloader time of 1.5 seconds
}
