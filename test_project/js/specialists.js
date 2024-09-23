function loadSpecialists(specialityId) {
    console.log(`Fetching specialists for speciality ID: ${specialityId}`);

    const preloader = document.getElementById('preloader');
    const specialistsTab = document.getElementById('specialists');
    const doctorsTab = document.getElementById('doctors');
    const doctorDetailsTab = document.getElementById('doctor-details');

    // Show preloader
    preloader.style.display = 'flex';

    // Ensure preloader is visible for at least 1.5 seconds
    setTimeout(() => {
        fetch('./vendor/GetDoctorsBySpeciality.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `specialityId=${encodeURIComponent(specialityId)}`
        })
        .then(response => response.json())
        .then(data => {
            console.log('Specialists data:', data);  // Log the response to check the structure

            if (data && data.DOCTORS) {
                let doctorsHtml = '<h2>Specialists List</h2><ul><br>';
                data.DOCTORS.forEach(doctor => {
                    doctorsHtml += `
                        <li class="doktor_single_element">
                            <div>
                                <p>
                                    <strong>Doctor Name: ${doctor.NAME}</strong>
                                </p>
                                <p>
                                    Workplace: ${doctor.WORKPLACE_NAME}
                                </p>
                                <p>Doctor ID:  ${doctor.CUSTOMER_ID} </p>
                            </div>
                            <img src="data:image/jpeg;base64,${doctor.FILE_CONTENT}" alt="Doctor's image" style="width:100px; height:100px;" /><br>
                            <button class="doctor-details-button" data-doctor-id="${doctor.CUSTOMER_ID}" data-doctor-image="data:image/jpeg;base64,${doctor.FILE_CONTENT}">Write to doctor</button>
                        </li>
                    `;
                });
                doctorsHtml += '</ul>';

                // Display the specialists in the "Specialists" tab
                specialistsTab.innerHTML = doctorsHtml;
                specialistsTab.style.display = 'block';
                doctorsTab.style.display = 'none';

                // Attach click event listeners to each "Write to doctor" button
                const doctorButtons = document.querySelectorAll('.doctor-details-button');
                doctorButtons.forEach(button => {
                    button.addEventListener('click', (event) => {
                        const doctorId = event.target.getAttribute('data-doctor-id');
                        const doctorImage = event.target.getAttribute('data-doctor-image');
                        console.log(`Doctor ID clicked: ${doctorId}`);
                        loadDoctorDetails(doctorId, doctorImage);  // Fetch doctor's career details
                    });
                });
            } else {
                throw new Error('Unexpected data structure');
            }
        })
        .catch(error => {
            console.error('Error fetching data:', error);
            specialistsTab.innerHTML = '<p>Error loading data.</p>';
        })
        .finally(() => {
            // Hide preloader after data is loaded or error occurs
            preloader.style.display = 'none';
        });
    }, 1500);  // Minimum preloader time of 1.5 seconds
}

// Function to load doctor details including their career
// Function to load doctor details including their career
function loadDoctorDetails(doctorId, doctorImage) {
    console.log(`Fetching career details for doctor ID: ${doctorId}`);

    const preloader = document.getElementById('preloader');
    const doctorDetailsTab = document.getElementById('doctor-details');
    const specialistsTab = document.getElementById('specialists');

    // Show preloader
    preloader.style.display = 'flex';

    // Ensure preloader is visible for at least 1.5 seconds
    setTimeout(() => {
        fetch('./vendor/GetDoctorCareer.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `doctorId=${encodeURIComponent(doctorId)}`
        })
        .then(response => response.json())
        .then(data => {
            console.log('Doctor Career data:', data);  // Log the response to check the structure

            if (data && data.DOCTOR_CAREER) {
                let careerHtml = `
                    <h2>Doctor Career</h2>
                    <img src="${doctorImage}" alt="Doctor's image" style="width:150px; height:150px;" /><br>
                    <ul>
                `;
                
                data.DOCTOR_CAREER.forEach(career => {
                    const speciality = career.SPECIALITY_AZ && typeof career.SPECIALITY_AZ === 'string' ? career.SPECIALITY_AZ : '';
                    const institution = career.ENTERPRISE_AZ && typeof career.ENTERPRISE_AZ === 'string' ? career.ENTERPRISE_AZ : '';
                    const location = career.PLACE_AZ && typeof career.PLACE_AZ === 'string' ? career.PLACE_AZ : '';
                    const startYear = career.START_YEAR ? career.START_YEAR : 'N/A';
                    const endYear = career.END_YEAR ? career.END_YEAR : 'Present';

                    // Only show the fields if they are not empty
                    careerHtml += '<li>';
                    if (speciality) {
                        careerHtml += `<strong>Specialty: ${speciality}</strong><br>`;
                    }
                    if (institution) {
                        careerHtml += `Institution: ${institution}<br>`;
                    }
                    if (location) {
                        careerHtml += `Location: ${location}<br>`;
                    }
                    careerHtml += `Period: ${startYear} - ${endYear}<br>`;
                    careerHtml += '</li>';
                });
                careerHtml += '</ul>';

                // Display doctor details in the "Doctor Details" tab
                doctorDetailsTab.innerHTML = careerHtml;
                doctorDetailsTab.style.display = 'block';
                specialistsTab.style.display = 'none';
            } else {
                throw new Error('Unexpected data structure');
            }
        })
        .catch(error => {
            console.error('Error fetching doctor career:', error);
            doctorDetailsTab.innerHTML = '<p>Error loading doctor details.</p>';
        })
        .finally(() => {
            // Hide preloader after data is loaded or error occurs
            preloader.style.display = 'none';
        });
    }, 1500);  // Minimum preloader time of 1.5 seconds
}
