function loadNonMedicalComplaints() {
    const complaintsTab = document.getElementById('complaints_not_medical');
    const preloader = document.getElementById('preloader');

    // Show preloader
    preloader.style.display = 'flex';

    // Ensure preloader is visible for at least 1.5 seconds
    setTimeout(() => {
        fetch('./vendor/GetNonMedicalClaimInformations.php') // Replace with your actual endpoint
            .then(response => response.json())
            .then(data => {
                console.log('Non-Medical Complaints Data:', data); // Log the response to check the structure

                if (data && data.CLM_NOTICE_DISPETCHER) {
                    const complaints = Array.isArray(data.CLM_NOTICE_DISPETCHER)
                        ? data.CLM_NOTICE_DISPETCHER
                        : [data.CLM_NOTICE_DISPETCHER];

                    let complaintsHtml = '<h2>Non-Medical Complaints</h2><ul>';
                    complaints.forEach(complaint => {
                        complaintsHtml += `
                            <li>
                                <p><strong>PIN Code:</strong> ${complaint.PIN_CODE || 'N/A'}</p>
                                <p><strong>Clinic Name:</strong> ${complaint.CLINIC_NAME || 'N/A'}</p>
                                <p><strong>Event Date:</strong> ${new Date(complaint.EVENT_OCCURRENCE_DATE).toLocaleString()}</p>
                            </li>
                        `;
                    });
                    complaintsHtml += '</ul>';

                    // Display the complaints in the tab
                    complaintsTab.innerHTML = complaintsHtml;
                } else {
                    throw new Error('Invalid non-medical complaints data structure.');
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
