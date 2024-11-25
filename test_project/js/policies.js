function loadPolicies() {
    fetch('./vendor/GetCustomerInformation.php')
        .then(response => {
            if (!response.ok) {
                throw new Error(`Server error: ${response.status} ${response.statusText}`);
            }
            return response.text(); // Read as text first to debug malformed JSON
        })
        .then(responseText => {
            try {
                // Parse the JSON from the response text
                return JSON.parse(responseText);
            } catch (error) {
                console.error('Failed to parse JSON:', responseText); // Log the raw response
                throw new Error('Invalid JSON response from server.');
            }
        })
        .then(customerData => {
            if (customerData && customerData.CUSTOMER_INFORMATION) {
                const customerInfoHtml = `
                    <h2>${customerData.CUSTOMER_INFORMATION.NAME} ${customerData.CUSTOMER_INFORMATION.SURNAME}</h2>
                    <p>Company name: ${customerData.CARD_INFORMATION.INSURER_CUSTOMER_NAME}</p>
                    <p>Card name: ${customerData.CARD_INFORMATION.CARD_NUMBER}</p>
                    <p>Have Casco or mandatory: ${customerData.CUSTOMER_INFORMATION.HAVE_CASCO_OR_MANDATORY}</p>
                `;
                document.getElementById('policies').innerHTML = customerInfoHtml;
                return fetch('./vendor/GetCustomerPolicies.php');
            } else {
                throw new Error('Invalid customer data structure.');
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Server error: ${response.status} ${response.statusText}`);
            }
            return response.text(); // Read as text first
        })
        .then(responseText => {
            try {
                // Parse the JSON from the response text
                return JSON.parse(responseText);
            } catch (error) {
                console.error('Failed to parse JSON:', responseText); // Log the raw response
                throw new Error('Invalid JSON response from server.');
            }
        })
        .then(policiesData => {
            if (policiesData && policiesData.POLICIES) {
                const policies = Array.isArray(policiesData.POLICIES) ? policiesData.POLICIES : [policiesData.POLICIES];
                let policiesHtml = '<h3 class="polis__nam-desc">Polislər:</h3><ul>';
                policies.forEach(policy => {
                    policiesHtml += `
                        <li class="polis_single_element">
                            <p class="polis__single__name">${policy.INSURANCE_NAME}</p>
                            <p>Policy Number: ${policy.POLICY_NUMBER}</p>
                            <p>Insurance Code: ${policy.INSURANCE_CODE}</p>
                            <p>Status: ${policy.STATUS}</p>
                            <p>End Date: ${policy.INSURANCE_END_DATE}</p>
                            <button class="policy-details-button" data-policy-number="${policy.POLICY_NUMBER}">View Details</button>
                        </li>
                    `;
                });
                policiesHtml += '</ul>';
                document.getElementById('policies').innerHTML += policiesHtml;

                // Attach click event listeners to "View Details" buttons
                document.querySelectorAll('.policy-details-button').forEach(button => {
                    button.addEventListener('click', event => {
                        const policyNumber = event.target.getAttribute('data-policy-number');
                        openPolicyDetailsPopup(policyNumber);
                    });
                });
            } else {
                throw new Error('Invalid policies data structure.');
            }
        })
        .catch(error => {
            console.error('Error loading policies data:', error);
            document.getElementById('policies').innerHTML = `<p>Error loading policies data: ${error.message || 'Unknown error'}.</p>`;
        });
}


// Function to open popup and fetch policy details
function openPolicyDetailsPopup(policyNumber) {
    const popup = document.getElementById('policy-popup');
    const popupContent = document.getElementById('policy-popup-content');
    const preloader = document.getElementById('preloader');

    // Show preloader and popup
    preloader.style.display = 'flex';
    popup.style.display = 'block';

    fetch('./vendor/GetPolicyInformations.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `policyNumber=${encodeURIComponent(policyNumber)}`,
    })
        .then(response => response.json())
        .then(policyDetails => {
            if (policyDetails) {
                popupContent.innerHTML = `
                    <h3>Policy Details</h3>
                    <p>Policy Number: ${policyNumber}</p>
                    <p>${JSON.stringify(policyDetails)}</p>
                    <button id="close-popup">Close</button>
                `;

                // Add close button functionality
                document.getElementById('close-popup').addEventListener('click', () => {
                    popup.style.display = 'none';
                });
            } else {
                throw new Error('Failed to load policy details.');
            }
        })
        .catch(error => {
            popupContent.innerHTML = `<p>Error loading policy details: ${error.message || 'Unknown error'}.</p>`;
        })
        .finally(() => {
            preloader.style.display = 'none';
        });
}
