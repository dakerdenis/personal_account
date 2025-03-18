function loadNonMedicalComplaints() {
    const complaintsTab = document.getElementById('complaints_not_medical');
    const preloader = document.getElementById('preloader');

    preloader.style.display = 'flex';

    setTimeout(() => {
        fetch('./vendor/GetNonMedicalClaimInformations.php')
            .then(response => response.json())
            .then(data => {
                console.log('Complaints data:', data);
                console.log('Debug:', data.debug);

                // If API returned an error
                if (data.error) {
                    console.error('API Error:', data.error);
                    complaintsTab.innerHTML = `<p>Error: ${data.error}</p>`;
                    return;
                }

                // Parse the debug XML response if CLM_NOTICE_DISPETCHER is empty
                let complaints = [];
                if (data.CLM_NOTICE_DISPETCHER && data.CLM_NOTICE_DISPETCHER.length > 0) {
                    complaints = data.CLM_NOTICE_DISPETCHER;
                } else if (data.debug) {
                    // Parse the `debug` property XML
                    const parser = new DOMParser();
                    const xmlDoc = parser.parseFromString(data.debug, 'application/xml');
                    const notices = xmlDoc.getElementsByTagName('CLM_NOTICES');

                    for (let i = 0; i < notices.length; i++) {
                        const notice = notices[i];
                        complaints.push({
                            PIN_CODE: notice.getElementsByTagName('PIN_CODE')[0]?.textContent || 'N/A',
                            POLICY_NUMBER: notice.getElementsByTagName('POLICY_NUMBER')[0]?.textContent || 'N/A',
                            INSURANCE_CODE: notice.getElementsByTagName('INSURANCE_CODE')[0]?.textContent || 'N/A',
                            EVENT_OCCURRENCE_DATE: notice.getElementsByTagName('EVENT_OCCURRENCE_DATE')[0]?.textContent || 'N/A',
                            STATUS_NAME: notice.getElementsByTagName('STATUS_NAME')[0]?.textContent || 'N/A',
                        });
                    }
                }

                // Render the complaints
                if (complaints.length === 0) {
                    complaintsTab.innerHTML = '<p>Məlumat tapilmadı.</p>';
                    return;
                }

                let complaintsHtml = '<h2 class="complaints_medical-name">Qeyri-Tibbi müraciyətlərim</h2><ul>';
                complaints.forEach(complaint => {
                    complaintsHtml += `
                        <li class="complaints_medical-li">
                            <div class="complaints_medical-div"><p>FİN kodu:</p> <span>${complaint.PIN_CODE}</span></div>
                            <div class="complaints_medical-div"><p>Şəhədətnamə nömrəsi:</p> <span>${complaint.POLICY_NUMBER}</span></div>
                            <div class="complaints_medical-div"><p>Hadisə baş verdi:</p> <span>${
                                complaint.EVENT_OCCURRENCE_DATE
                                    ? new Date(complaint.EVENT_OCCURRENCE_DATE).toLocaleString()
                                    : 'N/A'
                            }</span></div>
                            <div class="complaints_medical-div"><p>Status:</p> <span>${complaint.STATUS_NAME}</span></div>
                        </li>
                    `;
                });
                complaintsHtml += '</ul>';
                complaintsTab.innerHTML = complaintsHtml;
            })
            .catch(error => {
                console.error('Məlumat tapilmadı.', error);
                /// ${error.message || ''}
                complaintsTab.innerHTML = `<p>Məlumat tapilmadı.</p>`;
            })
            .finally(() => {
                preloader.style.display = 'none';
            });
    }, 1500);
}
