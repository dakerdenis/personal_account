function loadPolicies() {
    // Function to get insurance code descriptions
    const getInsuranceDescription = (code) => {
        const insuranceCodeDescriptions = {
            "AATPL": "Avtomobilin İcbari Sığortası",
            "AS": "Avtomobilin Kasko Sığortası",
            "VMI": "Avtomobilin Kasko Sığortası",
            "AS-A47-GD": "Avtomobilin Kasko Sığortası",
            "AS-FQ": "Avtomobilin Kasko Sığortası",
            "AS-F": "Avtomobilin Kasko Sığortası",
            "AS-H": "Avtomobilin Kasko Sığortası",
            "REVAS": "Avtomobilin Kasko Sığortası",
            "EE": "Elektron cihazların sığortası",
            "DETPL": "Əmlak İstismarın İcbari Sığortası",
            "DE": "Əmlakın İcbari Sığortası",
            "VHI": "Əmlakın könüllü sığortası",
            "VPI-FL": "Əmlakın könüllü sığortası",
            "VPI-F": "Əmlakın könüllü sığortası",
            "VPI-H": "Əmlakın könüllü sığortası",
            "VPI": "Əmlakın könüllü sığortası",
            "VPI-HN": "Əmlakın könüllü sığortası",
            "VPI-FN": "Əmlakın könüllü sığortası",
            "REVPI": "Əmlakın könüllü sığortası",
            "CPA": "Fərdi qəza sığortası",
            "PA": "Fərdi qəza sığortası",
            "CAR": "İnşaat risklərin sığortası",
            "EL": "İşəgötürənin məsuliyyətinin sığortası",
            "ELN": "İşəgötürənin məsuliyyətinin sığortası",
            "TPL": "Məsuliyyət sığortası",
            "TPLN": "Məsuliyyət sığortası",
            "CMMI": "Peşə Məsuliyyətinin sığortası",
            "PI": "Peşə Məsuliyyətinin sığortası",
            "CDOL": "Peşə Məsuliyyətinin sığortası",
            "CPM": "Podratçının maşın və avadanlığın sığortası",
            "TI": "Səyahət sığortası",
            "VPI-R": "Təkərlərin sığortası",
            "LI": "Tibbi Sığorta",
            "LE": "Tibbi Sığorta",
            "ONK-A47": "Tibbi Sığorta",
            "ONK": "Tibbi Sığorta",
            "TTU": "Tibbi Sığorta",
            "LE-D": "Tibbi Sığorta",
            "YK": "Yaşıl Kart",
            "YS-OC": "Yük sığortası",
            "YS": "Yük sığortası",
            "YSN": "Yük sığortası"
        };
        return insuranceCodeDescriptions[code] || code; // Return description or fallback to the code
    };

    // Function to get status descriptions
    const getStatusDescription = (status) => {
        const statusDescriptions = {
            "B": "Bitdi",
            "D": "Davam Edir",
            "E": "Sonlandırıldı"
        };
        return statusDescriptions[status] || status; // Return description or fallback to the status
    };

    // Fetch policies from the server
    fetch('./vendor/GetCustomerPolicies.php')
        .then(response => {
            if (!response.ok) {
                throw new Error(`Server error: ${response.status} ${response.statusText}`);
            }
            return response.json(); // Parse response as JSON
        })
        .then(policiesData => {
            if (policiesData && policiesData.POLICIES) {
                const policies = Array.isArray(policiesData.POLICIES) ? policiesData.POLICIES : [policiesData.POLICIES];
                const policiesHtml = policies.map(policy => {
                    const insuranceDescription = getInsuranceDescription(policy.INSURANCE_CODE);
                    const statusDescription = getStatusDescription(policy.STATUS);

                    return `
                        <li class="polis_single_element">
                            <p class="polis__single__name">${insuranceDescription}</p>
                            <div class="polis_line"></div>
                            <p class="policy_font policy_number">Policy Number: <span>${policy.POLICY_NUMBER}</span></p>
                            <p class="policy_font status_code">Status: <span>${statusDescription}</span></p>
                            <p class="policy_font policy_enddate">End Date: <span>${policy.INSURANCE_END_DATE}</span></p>
                            <button class="policy-details-button" data-policy-number="${policy.POLICY_NUMBER}">View Details</button>
                        </li>
                    `;
                }).join(''); // Join array of HTML strings into one string

                document.getElementById('policies').innerHTML = `<h3 class="polis__nam-desc">Polislər:</h3><ul>${policiesHtml}</ul>`;

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

                    // Identify policy type based on INSURANCE_CODE
                    const insuranceCode = policyInfo.INSURANCE_CODE;
                    const medicalCodes = ["LI", "LE", "ONK-A47", "ONK", "TTU", "LE-D", "YK", "YS-OC", "YS", "YSN"];
                    const carCodes = ["AATPL", "AS", "VMI", "AS-A47-GD", "AS-FQ", "AS-F", "AS-H", "REVAS"];

                    if (medicalCodes.includes(insuranceCode)) {
                        // Medical Policy Structure
                        popupHtml += `
                            <div class="policy__info-section">
                                ${policyInfo.INSURER_CUSTOMER_NAME ? `<p>Insurer Name: <span>${policyInfo.INSURER_CUSTOMER_NAME}</span></p>` : ''}
                                ${policyInfo.INSURED_CUSTOMER_NAME ? `<p>Insured Name: <span>${policyInfo.INSURED_CUSTOMER_NAME}</span></p>` : ''}
                                <p>Policy Sale Date: <span>${policyInfo.POLICY_SALE_DATE || 'N/A'}</span></p>
                                <p>Insurance Start Date: <span>${policyInfo.INSURANCE_START_DATE || 'N/A'}</span></p>
                                <p>End Date: <span>${policyInfo.END_DATE || 'N/A'}</span></p>
                                <p>Price: <span>${policyInfo.PRICE || 'N/A'} ${policyInfo.CURRENCY_CODE || ''}</span></p>
                                <p>Total Insurance Price: <span>${policyInfo.TOTAL_INSURANCE_PRICE || 'N/A'} ${policyInfo.CURRENCY_CODE || ''}</span></p>
                                ${policyInfo.PROGRAM_NAME ? `<p>Program Name: <span>${policyInfo.PROGRAM_NAME}</span></p>` : ''}
                                <p>Status: <span>${policyInfo.STATUS || 'N/A'}</span></p>
                            </div>
                        `;
                    } else if (carCodes.includes(insuranceCode)) {
                        // Car Policy Structure
                        popupHtml += `
                            <div class="policy__info-section">
                                <p>Policy Sale Date: <span>${policyInfo.POLICY_SALE_DATE || 'N/A'}</span></p>
                                <p>Insurance Start Date: <span>${policyInfo.INSURANCE_START_DATE || 'N/A'}</span></p>
                                <p>End Date: <span>${policyInfo.END_DATE || 'N/A'}</span></p>
                                ${policyInfo.BRAND_NAME ? `<p>Brand: <span>${policyInfo.BRAND_NAME}</span></p>` : ''}
                                ${policyInfo.MODEL_NAME ? `<p>Model: <span>${policyInfo.MODEL_NAME}</span></p>` : ''}
                                ${policyInfo.PLATE_NUMBER_FULL ? `<p>Plate Number: <span>${policyInfo.PLATE_NUMBER_FULL}</span></p>` : ''}
                                <p>Price: <span>${policyInfo.PRICE || 'N/A'} ${policyInfo.CURRENCY_CODE || ''}</span></p>
                                <p>Total Insurance Price: <span>${policyInfo.TOTAL_INSURANCE_PRICE || 'N/A'} ${policyInfo.CURRENCY_CODE || ''}</span></p>
                                <p>Status: <span>${policyInfo.STATUS || 'N/A'}</span></p>
                            </div>
                        `;
                    } else {
                        // Other Policy Structure
                        popupHtml += `
                            <div class="policy__info-section">
                                <p>Policy Sale Date: <span>${policyInfo.POLICY_SALE_DATE || 'N/A'}</span></p>
                                <p>Insurance Start Date: <span>${policyInfo.INSURANCE_START_DATE || 'N/A'}</span></p>
                                <p>End Date: <span>${policyInfo.END_DATE || 'N/A'}</span></p>
                                <p>Price: <span>${policyInfo.PRICE || 'N/A'} ${policyInfo.CURRENCY_CODE || ''}</span></p>
                                <p>Total Insurance Price: <span>${policyInfo.TOTAL_INSURANCE_PRICE || 'N/A'} ${policyInfo.CURRENCY_CODE || ''}</span></p>
                                <p>Status: <span>${policyInfo.STATUS || 'N/A'}</span></p>
                            </div>
                        `;
                    }
                }

                // Check for COLLATERAL_NAMES
                if (policyDetails.COLLATERAL_NAMES && Array.isArray(policyDetails.COLLATERAL_NAMES)) {
                    popupHtml += `
                        <div class="policy__collateral-section">
                            <div class="policy__collateral-line"></div>
                            <ul>
                    `;
                    policyDetails.COLLATERAL_NAMES.forEach(collateral => {
                        popupHtml += `<li><span>&#9679; </span> ${collateral.COLLATERAL_NAME || 'N/A'}</li>`;
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


