function loadPolicies () {
  // Function to get insurance code descriptions
  const getInsuranceDescription = code => {
    const insuranceCodeDescriptions = {
      AATPL: 'Avtomobilin İcbari Sığortası',
      AS: 'Avtomobilin Kasko Sığortası',
      VMI: 'Avtomobilin Kasko Sığortası',
      'AS-A47-GD': 'Avtomobilin Kasko Sığortası',
      'AS-FQ': 'Avtomobilin Kasko Sığortası',
      'AS-F': 'Avtomobilin Kasko Sığortası',
      'AS-H': 'Avtomobilin Kasko Sığortası',
      REVAS: 'Avtomobilin Kasko Sığortası',
      EE: 'Elektron cihazların sığortası',
      DETPL: 'Əmlak İstismarın İcbari Sığortası',
      DE: 'Əmlakın İcbari Sığortası',
      VHI: 'Əmlakın könüllü sığortası',
      'VPI-FL': 'Əmlakın könüllü sığortası',
      'VPI-F': 'Əmlakın könüllü sığortası',
      'VPI-H': 'Əmlakın könüllü sığortası',
      VPI: 'Əmlakın könüllü sığortası',
      'VPI-HN': 'Əmlakın könüllü sığortası',
      'VPI-FN': 'Əmlakın könüllü sığortası',
      REVPI: 'Əmlakın könüllü sığortası',
      CPA: 'Fərdi qəza sığortası',
      PA: 'Fərdi qəza sığortası',
      CAR: 'İnşaat risklərin sığortası',
      EL: 'İşəgötürənin məsuliyyətinin sığortası',
      ELN: 'İşəgötürənin məsuliyyətinin sığortası',
      TPL: 'Məsuliyyət sığortası',
      TPLN: 'Məsuliyyət sığortası',
      CMMI: 'Peşə Məsuliyyətinin sığortası',
      PI: 'Peşə Məsuliyyətinin sığortası',
      CDOL: 'Peşə Məsuliyyətinin sığortası',
      CPM: 'Podratçının maşın və avadanlığın sığortası',
      TI: 'Səyahət sığortası',
      'VPI-R': 'Təkərlərin sığortası',
      LI: 'Tibbi Sığorta',
      LE: 'Tibbi Sığorta',
      'ONK-A47': 'Tibbi Sığorta',
      ONK: 'Tibbi Sığorta',
      TTU: 'Tibbi Sığorta',
      'LE-D': 'Tibbi Sığorta',
      YK: 'Yaşıl Kart',
      'YS-OC': 'Yük sığortası',
      YS: 'Yük sığortası',
      YSN: 'Yük sığortası'
    }
    return insuranceCodeDescriptions[code] || code // Return description or fallback to the code
  }

  // Function to get status descriptions
  const getStatusDescription = status => {
    const statusDescriptions = {
      B: 'Bitdi',
      D: 'Davam Edir',
      E: 'Sonlandırıldı'
    }
    return statusDescriptions[status] || status // Return description or fallback to the status
  }

  // Placeholder to store all fetched policies for later use
  let policiesCache = {}

  // Fetch policies from the server
  fetch('./vendor/GetCustomerPolicies.php')
    .then(response => {
      if (!response.ok) {
        throw new Error(
          `Server error: ${response.status} ${response.statusText}`
        )
      }
      return response.json() // Parse response as JSON
    })
    .then(policiesData => {
      if (policiesData && policiesData.POLICIES) {
        const policies = Array.isArray(policiesData.POLICIES)
          ? policiesData.POLICIES
          : [policiesData.POLICIES]
        policiesCache = policies // Store policies in the cache for later use

        const policiesHtml = policies
          .map(policy => {
            const insuranceDescription = getInsuranceDescription(
              policy.INSURANCE_CODE
            )
            const statusDescription = getStatusDescription(policy.STATUS)

            // Format the end date
            const formattedEndDate = policy.INSURANCE_END_DATE
              ? policy.INSURANCE_END_DATE.split('T')[0]
              : 'N/A'

            return `
                        <li class="polis_single_element">
                            <p class="polis__single__name">${insuranceDescription}</p>
                            <div class="polis_line"></div>
                            <p class="policy_font policy_number">Policy Number: <span>${policy.POLICY_NUMBER}</span></p>
                            <p class="policy_font status_code">Status: <span>${statusDescription}</span></p>
                            <p class="policy_font policy_enddate">End Date: <span>${formattedEndDate}</span></p>
                            <button class="policy-details-button" data-policy-number="${policy.POLICY_NUMBER}">View Details</button>
                        </li>
                    `
          })
          .join('')

        document.getElementById(
          'policies'
        ).innerHTML = `<h3 class="polis__nam-desc">Polislər:</h3><ul>${policiesHtml}</ul>`

        // Attach click event listeners to "View Details" buttons
        document.querySelectorAll('.policy-details-button').forEach(button => {
          button.addEventListener('click', event => {
            const policyNumber = event.target.getAttribute('data-policy-number')
            const cachedPolicy = policiesCache.find(
              p => p.POLICY_NUMBER === policyNumber
            ) // Find the matching policy
            openPolicyDetailsPopup(cachedPolicy) // Pass the cached policy data
          })
        })
      } else {
        throw new Error('Invalid policies data structure.')
      }
    })
    .catch(error => {
      console.error('Error loading policies data:', error)
      document.getElementById(
        'policies'
      ).innerHTML = `<p>Error loading policies data: ${
        error.message || 'Unknown error'
      }.</p>`
    })
}

// Function to open popup and fetch policy details
function openPolicyDetailsPopup (cachedPolicy) {
  const popup = document.getElementById('policy-popup')
  const popupContent = document.getElementById('policy-popup-content')
  const preloader = document.getElementById('preloader')

  // Show preloader and popup
  preloader.style.display = 'flex'
  popup.style.display = 'block'

  fetch('./vendor/GetPolicyInformations.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: `policyNumber=${encodeURIComponent(cachedPolicy.POLICY_NUMBER)}`
  })
    .then(response => response.json())
    .then(policyDetails => {
      if (policyDetails) {
        // Merge cached data with fetched details
        const fullPolicyData = {
          ...cachedPolicy,
          ...policyDetails.POLICY_INFORMATION
        }

        let popupHtml = `
                <div class="policy__popup-wrapper">
                    <div class="policy__popup-name">Policy Details</div>
                    <div class="policy__popup-line"></div>
                    <div class="policy__popup-number"><p>Policy Number:</p> <span>${fullPolicyData.POLICY_NUMBER}</span></div>
                `

        // Identify policy type
        const medicalCodes = [
          'LI',
          'LE',
          'ONK-A47',
          'ONK',
          'TTU',
          'LE-D',
          'YK',
          'YS-OC',
          'YS',
          'YSN'
        ]
        const carCodes = [
          'AATPL',
          'AS',
          'VMI',
          'AS-A47-GD',
          'AS-FQ',
          'AS-F',
          'AS-H',
          'REVAS'
        ]

        // Function to format prices (e.g., 15000.000000 -> 15000.00)
        const formatPrice = price => {
          return price ? `${parseFloat(price).toFixed(2)}` : 'N/A'
        }
  // Function to get status descriptions
  const getStatusDescription2 = status => {
    const statusDescriptions = {
      B: 'Bitdi',
      D: 'Davam Edir',
      E: 'Sonlandırıldı'
    }
    return statusDescriptions[status] || status // Return description or fallback to the status
  }
        if (medicalCodes.includes(fullPolicyData.INSURANCE_CODE)) {
            // Medical Policy
            popupHtml += `
                <div class="policy__info-section">
                    <p>Insurer Name: <span>${fullPolicyData.INSURER_CUSTOMER_NAME || 'N/A'}</span></p>
                    <p>Insured Name: <span>${fullPolicyData.INSURED_CUSTOMER_NAME || 'N/A'}</span></p>
                    <p>Policy Sale Date: <span>${fullPolicyData.POLICY_SALE_DATE ? fullPolicyData.POLICY_SALE_DATE.split('T')[0] : 'N/A'}</span></p>
                    <p>Insurance Start Date: <span>${fullPolicyData.INSURANCE_START_DATE ? fullPolicyData.INSURANCE_START_DATE.split('T')[0] : 'N/A'}</span></p>
                    <p>End Date: <span>${fullPolicyData.INSURANCE_END_DATE ? fullPolicyData.INSURANCE_END_DATE.split('T')[0] : 'N/A'}</span></p>
                    <p>Price: <span>${formatPrice(fullPolicyData.PRICE)} ${fullPolicyData.CURRENCY_CODE || ''}</span></p>
                    <p>Total Insurance Price: <span>${formatPrice(fullPolicyData.TOTAL_INSURANCE_PRICE)} ${fullPolicyData.CURRENCY_CODE || ''}</span></p>
                    <p>Status: <span>${getStatusDescription2(fullPolicyData.STATUS)}</span></p>
                </div>
            `;
        } else if (carCodes.includes(fullPolicyData.INSURANCE_CODE)) {
            // Car Policy
            popupHtml += `
                <div class="policy__info-section">
                    <p>Policy Sale Date: <span>${fullPolicyData.POLICY_SALE_DATE ? fullPolicyData.POLICY_SALE_DATE.split('T')[0] : 'N/A'}</span></p>
                    <p>Insurance Start Date: <span>${fullPolicyData.INSURANCE_START_DATE ? fullPolicyData.INSURANCE_START_DATE.split('T')[0] : 'N/A'}</span></p>
                    <p>End Date: <span>${fullPolicyData.INSURANCE_END_DATE ? fullPolicyData.INSURANCE_END_DATE.split('T')[0] : 'N/A'}</span></p>
                    <p>Brand: <span>${fullPolicyData.BRAND_NAME || 'N/A'}</span></p>
                    <p>Model: <span>${fullPolicyData.MODEL_NAME || 'N/A'}</span></p>
                    <p>Plate Number: <span>${fullPolicyData.PLATE_NUMBER_FULL || 'N/A'}</span></p>
                    <p>Price: <span>${formatPrice(fullPolicyData.PRICE)} ${fullPolicyData.CURRENCY_CODE || ''}</span></p>
                    <p>Total Insurance Price: <span>${formatPrice(fullPolicyData.TOTAL_INSURANCE_PRICE)} ${fullPolicyData.CURRENCY_CODE || ''}</span></p>
                    <p>Status: <span>${getStatusDescription2(fullPolicyData.STATUS)}</span></p>
                </div>
            `;
        } else {
            // Other Policy
            popupHtml += `
                <div class="policy__info-section">
                    <p>Policy Sale Date: <span>${fullPolicyData.POLICY_SALE_DATE ? fullPolicyData.POLICY_SALE_DATE.split('T')[0] : 'N/A'}</span></p>
                    <p>Insurance Start Date: <span>${fullPolicyData.INSURANCE_START_DATE ? fullPolicyData.INSURANCE_START_DATE.split('T')[0] : 'N/A'}</span></p>
                    <p>End Date: <span>${fullPolicyData.INSURANCE_END_DATE ? fullPolicyData.INSURANCE_END_DATE.split('T')[0] : 'N/A'}</span></p>
                    <p>Price: <span>${formatPrice(fullPolicyData.PRICE)} ${fullPolicyData.CURRENCY_CODE || ''}</span></p>
                    <p>Total Insurance Price: <span>${formatPrice(fullPolicyData.TOTAL_INSURANCE_PRICE)} ${fullPolicyData.CURRENCY_CODE || ''}</span></p>
                    <p>Status: <span>${getStatusDescription2(fullPolicyData.STATUS)}</span></p>
                </div>
            `;
        }

        // Collateral Names
        if (
          policyDetails.COLLATERAL_NAMES &&
          Array.isArray(policyDetails.COLLATERAL_NAMES)
        ) {
          popupHtml += `<div class="policy__collateral-section"><ul>`
          policyDetails.COLLATERAL_NAMES.forEach(collateral => {
            popupHtml += `<li><span>&#9679; </span>${
              collateral.COLLATERAL_NAME || 'N/A'
            }</li>`
          })
          popupHtml += `</ul></div>`
        }

        popupHtml += `<button id="close-popup">Close</button></div>`
        popupContent.innerHTML = popupHtml

        document.getElementById('close-popup').addEventListener('click', () => {
          popup.style.display = 'none'
        })
      } else {
        throw new Error('Failed to load policy details.')
      }
    })
    .catch(error => {
      popupContent.innerHTML = `<p>Error loading policy details: ${
        error.message || 'Unknown error'
      }.</p>`
    })
    .finally(() => {
      preloader.style.display = 'none'
    })
}
