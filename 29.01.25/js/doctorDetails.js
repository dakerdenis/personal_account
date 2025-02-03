async function loadDoctorDetails(doctorId) {
    const doctorPopup = document.getElementById('doctor-popup');
    const doctorPopupContent = document.getElementById('doctor-popup-content');
    const preloader = document.getElementById('preloader');

    // Show preloader
    preloader.style.display = 'flex';

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
            let detailsHtml = `<h2 class="single_doctor-name">Doctor Career Details</h2><ul>`;

            // Iterate over the career details array
            doctorDetails.DOCTOR_CAREER.forEach((career) => {
                let careerHtml = '<li class="single_doctor-block">';

                // Validate and add each field if valid
                if (career.SPECIALITY_AZ && typeof career.SPECIALITY_AZ === 'string') {
                    careerHtml += `<p>${career.SPECIALITY_AZ}</p>`;
                }
                if (career.ENTERPRISE_AZ && typeof career.ENTERPRISE_AZ === 'string') {
                    careerHtml += `<p> ${career.ENTERPRISE_AZ}</p>`;
                }
                if (career.PLACE_AZ && typeof career.PLACE_AZ === 'string') {
                    careerHtml += `<p> ${career.PLACE_AZ}</p>`;
                }
                if (career.START_YEAR && career.START_YEAR !== '0') {
                    careerHtml += `<p><strong>Başlama ili:</strong> ${career.START_YEAR}</p>`;
                }
                if (career.END_YEAR && career.END_YEAR !== '0') {
                    careerHtml += `<p><strong>Bitmə ili:</strong> ${career.END_YEAR}</p>`;
                }

                careerHtml += '</li>';
                detailsHtml += careerHtml;
            });

            detailsHtml += `</ul>`;

            // Render the career details in the popup
            doctorPopupContent.innerHTML = detailsHtml;

            // Show the popup
            doctorPopup.style.display = 'block';
        } else {
            throw new Error('No career details found for this doctor.');
        }
    } catch (error) {
        console.error('Error loading doctor details:', error);
        doctorPopupContent.innerHTML = `<p>Error loading doctor details: ${
            error.message || 'Unknown error'
        }</p>`;
        doctorPopup.style.display = 'block';
    } finally {
        // Hide preloader
        preloader.style.display = 'none';
    }
}

// Close the popup when the "Close" button is clicked
document.getElementById('close-doctor-popup').addEventListener('click', () => {
    const doctorPopup = document.getElementById('doctor-popup');
    doctorPopup.style.display = 'none';
});
