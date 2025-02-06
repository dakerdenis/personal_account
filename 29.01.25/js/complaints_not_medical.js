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
            
                if (complaints.length === 0 || Object.keys(complaints[0]).length === 0) {
                    complaintsTab.innerHTML = '<p>You don\'t have complaints.</p>';
                    return;
                }

                    // Create HTML for complaints
                    let complaintsHtml = '<h2  class="complaints_medical-name">Non-Medical Complaints</h2><ul>';
                    complaints.forEach(complaint => {
                        complaintsHtml += `
                            <li class="complaints_medical-li">
                                <div><p>PIN Code:</p> <span>${complaint.PIN_CODE || 'N/A'}</span></div>
                                <div><p>Policy Number:</p> <span>${complaint.POLICY_NUMBER || 'N/A'}</span></div>
                                <div><p>Event Date:</p><span> ${
                                    complaint.EVENT_OCCURRENCE_DATE
                                        ? new Date(complaint.EVENT_OCCURRENCE_DATE).toLocaleString()
                                        : 'N/A'
                                }</span></div>
                                <div><p>Status:</p> <span>${complaint.STATUS_NAME || 'N/A'}</span></div>
                            </li>
                        `;
                    });
                    complaintsHtml += '</ul>';
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
