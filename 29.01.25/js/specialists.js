function loadSpecialists (specialityId) {
  console.log(`Fetching specialists for speciality ID: ${specialityId}`)

  const preloader = document.getElementById('preloader')
  const specialistsTab = document.getElementById('specialists')
  const doctorsTab = document.getElementById('doctors')
  const doctorDetailsTab = document.getElementById('doctor-details')

  // Show preloader
  preloader.style.display = 'flex'

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
        console.log('Specialists data:', data) // Log the response to check the structure

        if (data && data.DOCTORS) {
          let doctorsHtml =
            '<h2 class="complaints_medical-name">Specialists List</h2><ul><br>'
          data.DOCTORS.forEach(doctor => {
            doctorsHtml += `
                            <li class="complaints_medical-li doctors__single">
                                <div  class="doctors__single-text">
                                    <p  class="doctors__single-name"><strong> ${doctor.NAME}</strong></p>
                                    <p  class="doctors__single-work">İş yeri: ${doctor.WORKPLACE_NAME}</p>
                                    <p  class="doctors__single-id">Doctor ID: ${doctor.CUSTOMER_ID}</p>
                                </div>
                                <div class="doctors__single-image">
<img src="data:image/jpeg;base64,${doctor.FILE_CONTENT}" alt="Doctor's image"  /><br>
                                </div>
                                
                                <button class="doctor-details-button" data-doctor-id="${doctor.CUSTOMER_ID}">Подробно о докторе</button>
                                <!--Запись к доктору--->
                                <button class="register-doctor-button" data-doctor-id="${doctor.CUSTOMER_ID}">Записаться к доктору</button>
                            </li>
                        `
          })
          doctorsHtml += '</ul>'

          // Display the specialists in the "Specialists" tab
          specialistsTab.innerHTML = doctorsHtml
          specialistsTab.style.display = 'block'
          doctorsTab.style.display = 'none'

          // Attach click event listeners to each "Write to doctor" button
          // Attach click event listeners to each "Подробно о докторе" button
          const doctorButtons = document.querySelectorAll(
            '.doctor-details-button'
          )
          doctorButtons.forEach(button => {
            button.addEventListener('click', event => {
              const doctorId = event.target.getAttribute('data-doctor-id')
              console.log(`Doctor ID clicked: ${doctorId}`)
              loadDoctorDetails(doctorId) // Call the new function from doctorDetails.js
            })
          })

          // Attach click event listeners to "Записаться к доктору" buttons
          const registerButtons = document.querySelectorAll(
            '.register-doctor-button'
          );
          registerButtons.forEach(button => {
            button.addEventListener("click", async event => {
                const doctorId = event.target.getAttribute("data-doctor-id");
                console.log(`Register button clicked for Doctor ID: ${doctorId}`);
        
                // Open the popup to select a policy before proceeding
                openRegisterDoctorPopup(doctorId);
            });
        });
        } else {
          throw new Error('Unexpected data structure')
        }

        
      })
      .catch(error => {
        console.error('Error fetching data:', error)
        specialistsTab.innerHTML = '<p>Error loading data.</p>'
      })
      .finally(() => {
        // Hide preloader after data is loaded or error occurs
        preloader.style.display = 'none'
      })
  }, 1000) // Minimum preloader time of 1.5 seconds
}

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
          console.log('Fetched policies:', policies);

          // List of valid medical policy codes
          const validMedicalCodes = ['LI', 'LE', 'ONK-A47', 'ONK', 'TTU', 'LE-D', 'YK', 'YS-OC', 'YS', 'YSN'];

          // Check for a valid medical policy
          const medicalPolicy = policies.find(policy => validMedicalCodes.includes(policy.INSURANCE_CODE));

          if (medicalPolicy) {
              console.log('Medical policy found:', medicalPolicy);
              return medicalPolicy.CARD_NUMBER || medicalPolicy.POLICY_NUMBER; // Return card or policy number
          }
      }

      console.warn('No valid medical policy found.');
      return null; // No valid medical policy found
  } catch (error) {
      console.error('Error fetching policies:', error);
      return null;
  }
}



// Helper function to register for a doctor
async function registerForDoctor(doctorId, cardNumber) {
  try {
      console.log(`Registering for doctor: ${doctorId} with card number: ${cardNumber}`);

      const response = await fetch('./vendor/RegisterForDoctor.php', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: `doctorId=${encodeURIComponent(doctorId)}&cardNumber=${encodeURIComponent(cardNumber)}`,
      });

      const data = await response.json();
      console.log('Doctor Registration Response:', data);

      if (data.success) {
        alert('Siz uğurla həkimə qeydiyyatdan keçdiniz.');
      } else {
        alert('Qeydiyyat uğursuz oldu. Zəhmət olmasa bir az sonra yenidən cəhd edin.');
          console.error('Error:', data.error || 'Unknown error');
      }
  } catch (error) {
      console.error('Error registering for doctor:', error);
      alert('Həkimə qeydiyyatdan keçərkən bir xəta baş verdi. Zəhmət olmasa bir az sonra yenidən cəhd edin.');
  }
}


