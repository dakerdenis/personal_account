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
                console.log('Specialists data:', data); // Log the response to check the structure

                if (data && data.DOCTORS) {
                    let doctorsHtml = '<h2>Specialists List</h2><ul><br>';
                    data.DOCTORS.forEach(doctor => {
                        doctorsHtml += `
                            <li class="doktor_single_element">
                                <div>
                                    <p><strong>Doctor Name: ${doctor.NAME}</strong></p>
                                    <p>Workplace: ${doctor.WORKPLACE_NAME}</p>
                                    <p>Doctor ID: ${doctor.CUSTOMER_ID}</p>
                                </div>
                                <img src="data:image/jpeg;base64,${doctor.FILE_CONTENT}" alt="Doctor's image" style="width:100px; height:100px;" /><br>
                                <button class="doctor-details-button" data-doctor-id="${doctor.CUSTOMER_ID}" data-doctor-image="data:image/jpeg;base64,${doctor.FILE_CONTENT}">Write to doctor</button>
                                <button class="register-doctor-button" data-doctor-id="${doctor.CUSTOMER_ID}">Записаться к доктору</button>
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
                            loadDoctorDetails(doctorId, doctorImage); // Fetch doctor's career details
                        });
                    });

                    // Attach click event listeners to "Записаться к доктору" buttons
                    const registerButtons = document.querySelectorAll('.register-doctor-button');
                    registerButtons.forEach(button => {
                        button.addEventListener('click', async (event) => {
                            const doctorId = event.target.getAttribute('data-doctor-id');
                            console.log(`Register button clicked for Doctor ID: ${doctorId}`);

                            // Fetch the medical policies
                            const medicalPolicy = await fetchMedicalPolicies();

                            if (!medicalPolicy) {
                                alert('You do not have a valid medical policy to register with a doctor.');
                                return;
                            }

                            // Proceed to register for the doctor
                            registerForDoctor(doctorId, medicalPolicy);
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
    }, 1500); // Minimum preloader time of 1.5 seconds
}

// Helper function to fetch medical policies
// Helper function to fetch medical policies
async function fetchMedicalPolicies() {
    try {
        // Check if medical policy number is cached
        const cachedPolicy = await fetch('./vendor/GetCachedPolicy.php');
        const cachedPolicyData = await cachedPolicy.json();

        if (cachedPolicyData && cachedPolicyData.medicalPolicyNumber) {
            console.log('Using cached medical policy:', cachedPolicyData.medicalPolicyNumber);
            return cachedPolicyData.medicalPolicyNumber;
        }

        // Fallback: Fetch policies dynamically if not cached
        const response = await fetch('./vendor/GetCustomerPolicies.php');
        const data = await response.json();

        if (data && data.POLICIES) {
            const policies = Array.isArray(data.POLICIES) ? data.POLICIES : [data.POLICIES];
            const medicalPolicy = policies.find(policy => policy.INSURANCE_NAME === 'Tibbi sığorta');

            if (medicalPolicy) {
                return medicalPolicy.CARD_NUMBER; // Return the card number
            }
        }
        return null; // No medical policy found
    } catch (error) {
        console.error('Error fetching policies:', error);
        return null;
    }
}


// Helper function to register for a doctor
async function registerForDoctor(doctorId, cardNumber) {
    try {
        const response = await fetch('./vendor/RegisterForDoctor.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `doctorId=${encodeURIComponent(doctorId)}&cardNumber=${encodeURIComponent(cardNumber)}`
        });

        const data = await response.json();
        console.log('Doctor Registration Response:', data);

        if (data && data.success) {
            alert('You have successfully registered with the doctor.');
        } else {
            alert('Registration failed. Please try again later.');
        }
    } catch (error) {
        console.error('Error registering for doctor:', error);
        alert('An error occurred while registering. Please try again later.');
    }
}
