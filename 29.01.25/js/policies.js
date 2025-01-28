function loadPolicies() {
    fetch('./vendor/GetCustomerPolicies.php')
        .then(response => {
            if (!response.ok) {
                throw new Error(`Server error: ${response.status} ${response.statusText}`);
            }
            return response.text(); // Read as text to handle unexpected responses
        })
        .then(responseText => {
            try {
                // Parse JSON from response text
                return JSON.parse(responseText);
            } catch (error) {
                console.error('Failed to parse JSON:', responseText); // Log raw response for debugging
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
                            <div class="polis_line"></div>
                            <p class="policy_font policy_number">Policy Number: <span>${policy.POLICY_NUMBER}</span></p>
                            <p class="policy_font insurance_code">Insurance Code: <span>${policy.INSURANCE_CODE}</span></p>
                            <p class="policy_font status_code">Status: <span>${policy.STATUS}</span></p>
                            <p class="policy_font policy_enddate">End Date: <span>${policy.INSURANCE_END_DATE}</span></p>
                            <button class="policy-details-button" data-policy-number="${policy.POLICY_NUMBER}">View Details</button>
                        </li>
                    `;
                });
                policiesHtml += '</ul>';
                document.getElementById('policies').innerHTML = policiesHtml;

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
                // Start building the popup content
                let popupHtml = `
                <div class="policy__popup-wrapper">
                    <div class="policy__popup-name">Policy Details</div>
                    <div class="policy__popup-line"></div>
                    <div class="policy__popup-number"><p>Policy Number:</p> <span>${policyNumber}</span></div>
                `;

                // Check for POLICY_INFORMATION
                if (policyDetails.POLICY_INFORMATION) {
                    const policyInfo = policyDetails.POLICY_INFORMATION;
                    popupHtml += `
                        <div class="policy__info-section">
                            <p>Insurance Start Date: <span>${policyInfo.INSURANCE_START_DATE || 'N/A'}</span></p>
                            <p>Policy Sale Date: <span>${policyInfo.POLICY_SALE_DATE || 'N/A'}</span></p>
                            <p>Price: <span>${policyInfo.PRICE || 'N/A'} ${policyInfo.CURRENCY_CODE || ''}</span></p>
                            <p>Total Insurance Price: <span>${policyInfo.TOTAL_INSURANCE_PRICE || 'N/A'} ${policyInfo.CURRENCY_CODE || ''}</span></p>
                            ${policyInfo.INSURER_CUSTOMER_NAME ? `<p>Insurer Name: <span>${policyInfo.INSURER_CUSTOMER_NAME}</span></p>` : ''}
                            ${policyInfo.INSURED_CUSTOMER_NAME ? `<p>Insured Name: <span>${policyInfo.INSURED_CUSTOMER_NAME}</span></p>` : ''}
                            ${policyInfo.PROGRAM_NAME ? `<p>Program Name: <span>${policyInfo.PROGRAM_NAME}</span></p>` : ''}
                            ${policyInfo.PLATE_NUMBER_FULL ? `<p>Plate Number: <span>${policyInfo.PLATE_NUMBER_FULL}</span></p>` : ''}
                            ${policyInfo.BRAND_NAME ? `<p>Brand: <span>${policyInfo.BRAND_NAME}</span></p>` : ''}
                            ${policyInfo.MODEL_NAME ? `<p>Model: <span>${policyInfo.MODEL_NAME}</span></p>` : ''}
                        </div>
                    `;
                }

                // Check for COLLATERAL_NAMES
                if (policyDetails.COLLATERAL_NAMES && Array.isArray(policyDetails.COLLATERAL_NAMES)) {
                    popupHtml += `
                        <div class="policy__collateral-section">
                            <h4>Строковые параметры:</h4>
                            <ul>
                    `;
                    policyDetails.COLLATERAL_NAMES.forEach(collateral => {
                        popupHtml += `<li>${collateral.COLLATERAL_NAME || 'N/A'}</li>`;
                    });
                    popupHtml += `</ul></div>`;
                }

                // Close the popup wrapper
                popupHtml += `
                    <button id="close-popup">Close</button>
                </div>
                `;

                // Set the popup content
                popupContent.innerHTML = popupHtml;

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
