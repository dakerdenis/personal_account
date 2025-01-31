async function loadDoctorDetails(doctorId) {
    const doctorDetailsTab = document.getElementById('doctor-details');
    const preloader = document.getElementById('preloader');

    // Show preloader and doctor details tab
    preloader.style.display = 'flex';
    doctorDetailsTab.style.display = 'block';

    try {
        const response = await fetch('./vendor/GetDoctorCareer.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `doctorId=${encodeURIComponent(doctorId)}`,
        });

        const doctorDetails = await response.json();

        if (doctorDetails && doctorDetails.DOCTOR_CAREER) {
            let detailsHtml = `<h2>Doctor Career Details</h2><ul>`;
            
            // Iterate over the career details array
            doctorDetails.DOCTOR_CAREER.forEach((career) => {
                detailsHtml += `
                    <li>
                        <p><strong>Speciality:</strong> ${career.SPECIALITY_AZ || 'N/A'}</p>
                        <p><strong>Institution:</strong> ${career.ENTERPRISE_AZ || 'N/A'}</p>
                        <p><strong>Location:</strong> ${career.PLACE_AZ || 'N/A'}</p>
                        <p><strong>Start Year:</strong> ${career.START_YEAR || 'N/A'}</p>
                        ${career.END_YEAR ? `<p><strong>End Year:</strong> ${career.END_YEAR}</p>` : ''}
                    </li>
                `;
            });

            detailsHtml += `</ul>`;

            // Render the career details
            doctorDetailsTab.innerHTML = detailsHtml;
        } else {
            throw new Error('No career details found for this doctor.');
        }
    } catch (error) {
        console.error('Error loading doctor details:', error);
        doctorDetailsTab.innerHTML = `<p>Error loading doctor details: ${error.message || 'Unknown error'}</p>`;
    } finally {
        // Hide preloader
        preloader.style.display = 'none';
    }
}
