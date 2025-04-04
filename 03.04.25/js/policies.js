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
  const imageMapping = {
    AATPL: "M5zN/asdasdasdsad.png",
    AS: "M5zN/asdasdasdsad.png",
    VMI: "M5zN/asdasdasdsad.png",
    "AS-A47-GD": "M5zN/asdasdasdsad.png",
    "AS-FQ": "M5zN/asdasdasdsad.png",
    "AS-F": "M5zN/asdasdasdsad.png",
    "AS-H": "M5zN/asdasdasdsad.png",
    REVAS: "M5zN/asdasdasdsad.png",

    DETPL: "5cfU/emlak.png",
    DE: "5cfU/emlak.png",
    VHI: "5cfU/emlak.png",
    "VPI-FL": "5cfU/emlak.png",
    "VPI-F": "5cfU/emlak.png",
    "VPI-H": "5cfU/emlak.png",
    VPI: "5cfU/emlak.png",
    "VPI-HN": "5cfU/emlak.png",
    "VPI-FN": "5cfU/emlak.png",
    REVPI: "5cfU/emlak.png",

    CPA: "jz0Q/ferdi_geza.png",
    PA: "jz0Q/ferdi_geza.png",

    CAR: "iSyo/insaat.png",

    EL: "GU1A/isegoturen.png",
    ELN: "GU1A/isegoturen.png",

    TPL: "3dAN/mesulyet.png",
    TPLN: "3dAN/mesulyet.png",

    CMMI: "CHdP/profesional_resp.png",
    PI: "CHdP/profesional_resp.png",
    CDOL: "CHdP/profesional_resp.png",

    CPM: "O9In/masin_avadanliq.png",

    TI: "aLil/seyahat.png",

    "VPI-R": "9hMk/asdasdasd.png",

    LI: "5NBV/tibbi.png",
    LE: "5NBV/tibbi.png",
    "ONK-A47": "5NBV/tibbi.png",
    ONK: "5NBV/tibbi.png",
    TTU: "5NBV/tibbi.png",
    "LE-D": "5NBV/tibbi.png",

    "YS-OC": "tQZW/yuk.png",
    YS: "tQZW/yuk.png",
    YSN: "tQZW/yuk.png",
  };
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

        // Collect active medical policy numbers (status "D")
        let activeMedicalPolicies = policies
          .filter(
            policy =>
              medicalCodes.includes(policy.INSURANCE_CODE) &&
              policy.STATUS === 'D'
          )
          .map(policy => policy.POLICY_NUMBER)

        // Send the active medical policies to the session
        if (activeMedicalPolicies.length > 0) {
          fetch('./vendor/storeMedicalPolicies.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({ medicalPolicies: activeMedicalPolicies })
          })
            .then(response => response.json())
            .then(data => console.log('Stored in session:', data))
            .catch(error =>
              console.error('Error storing policies in session:', error)
            )
        }

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
 // Get the correct image based on the insurance code
 const policyImage = imageMapping[policy.INSURANCE_CODE] || "default.png";
            return `
                    <li class="polis_single_element" style="justify-content: space-between; display: flex; align-items: center;">
                        <div>
                            <p class="polis__single__name">${insuranceDescription}</p>
                            <div class="polis_line"></div>
                            <p class="policy_font policy_number">Şəhədətnamə nömrəsi: <span>${policy.POLICY_NUMBER}</span></p>
                            <p class="policy_font status_code">Status: <span>${statusDescription}</span></p>
                            <p class="policy_font policy_enddate">Bitmə tarixi: <span>${formattedEndDate}</span></p>
                            <button class="policy-details-button" data-policy-number="${policy.POLICY_NUMBER}">Ətraflı Məlumat</button>
                        </div>
                        <div style="width: 307px; height: 122px; margin-right: 125px;">
                             <img style="width: 100%; height: 100%; object-fit: contain;" src="https://a-group.az/storage/uploaded_files/${policyImage}">
                        </div>
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
                    <div class="policy__popup-name">Şəhədətnamə haqqında</div>
                    <div class="policy__popup-line"></div>
                    <div class="policy__popup-number"><p>Şəhədətnamə nömrəsi:</p> <span>${fullPolicyData.POLICY_NUMBER}</span></div>
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
                  <div>
                                      <p>Sığortalı: <span>${
                                        fullPolicyData.INSURER_CUSTOMER_NAME ||
                                        'N/A'
                                      }</span></p>
                    <p>Sığorta olunan: <span>${
                      fullPolicyData.INSURED_CUSTOMER_NAME || 'N/A'
                    }</span></p>
                    <p>Buraxılış tarixi: <span>${
                      fullPolicyData.POLICY_SALE_DATE
                        ? fullPolicyData.POLICY_SALE_DATE.split('T')[0]
                        : 'N/A'
                    }</span></p>
                    <p>Başlama tarixi: <span>${
                      fullPolicyData.INSURANCE_START_DATE
                        ? fullPolicyData.INSURANCE_START_DATE.split('T')[0]
                        : 'N/A'
                    }</span></p>
                    <p>Bitmə tarixi: <span>${
                      fullPolicyData.INSURANCE_END_DATE
                        ? fullPolicyData.INSURANCE_END_DATE.split('T')[0]
                        : 'N/A'
                    }</span></p>
                    <p>Sığorta məbləği: <span>${formatPrice(fullPolicyData.PRICE)} ${
            fullPolicyData.CURRENCY_CODE || ''
          }</span></p>
                    <p>Sığorta haqqı: <span>${formatPrice(
                      fullPolicyData.TOTAL_INSURANCE_PRICE
                    )} ${fullPolicyData.CURRENCY_CODE || ''}</span></p>
                    <p>Status: <span>${getStatusDescription2(
                      fullPolicyData.STATUS
                    )}</span></p>
                  </div>

                </div>
            `
        } else if (carCodes.includes(fullPolicyData.INSURANCE_CODE)) {
          // Car Policy
          popupHtml += `
                <div class="policy__info-section">
                    <p>Buraxılış tarixi: <span>${
                      fullPolicyData.POLICY_SALE_DATE
                        ? fullPolicyData.POLICY_SALE_DATE.split('T')[0]
                        : 'N/A'
                    }</span></p>
                    <p>Başlama tarixi: <span>${
                      fullPolicyData.INSURANCE_START_DATE
                        ? fullPolicyData.INSURANCE_START_DATE.split('T')[0]
                        : 'N/A'
                    }</span></p>
                    <p>Bitmə tarixi: <span>${
                      fullPolicyData.INSURANCE_END_DATE
                        ? fullPolicyData.INSURANCE_END_DATE.split('T')[0]
                        : 'N/A'
                    }</span></p>
                    <p>Marka: <span>${
                      fullPolicyData.BRAND_NAME || 'N/A'
                    }</span></p>
                    <p>Model: <span>${
                      fullPolicyData.MODEL_NAME || 'N/A'
                    }</span></p>
                    <p>Qeydiyyat nişanı: <span>${
                      fullPolicyData.PLATE_NUMBER_FULL || 'N/A'
                    }</span></p>
                    <p>Sığorta məbləği: <span>${formatPrice(fullPolicyData.PRICE)} ${
            fullPolicyData.CURRENCY_CODE || ''
          }</span></p>
                    <p>Sığorta haqqı: <span>${formatPrice(
                      fullPolicyData.TOTAL_INSURANCE_PRICE
                    )} ${fullPolicyData.CURRENCY_CODE || ''}</span></p>
                    <p>Status: <span>${getStatusDescription2(
                      fullPolicyData.STATUS
                    )}</span></p>

                </div>
            `
        } else {
          // Other Policy
          popupHtml += `
                <div class="policy__info-section">
                    <p>Buraxılış tarixi: <span>${
                      fullPolicyData.POLICY_SALE_DATE
                        ? fullPolicyData.POLICY_SALE_DATE.split('T')[0]
                        : 'N/A'
                    }</span></p>
                    <p>Başlama tarixi: <span>${
                      fullPolicyData.INSURANCE_START_DATE
                        ? fullPolicyData.INSURANCE_START_DATE.split('T')[0]
                        : 'N/A'
                    }</span></p>
                    <p>Bitmə tarixi: <span>${
                      fullPolicyData.INSURANCE_END_DATE
                        ? fullPolicyData.INSURANCE_END_DATE.split('T')[0]
                        : 'N/A'
                    }</span></p>
                    <p>Sığorta məbləği: <span>${formatPrice(fullPolicyData.PRICE)} ${
            fullPolicyData.CURRENCY_CODE || ''
          }</span></p>
                    <p>Sığorta haqqı: <span>${formatPrice(
                      fullPolicyData.TOTAL_INSURANCE_PRICE
                    )} ${fullPolicyData.CURRENCY_CODE || ''}</span></p>
                    <p>Status: <span>${getStatusDescription2(
                      fullPolicyData.STATUS
                    )}</span></p>

                </div>
            `
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

        popupHtml += `<button id="close-popup">Bağlamaq</button></div>`
        popupContent.innerHTML = popupHtml

        document.getElementById('close-popup').addEventListener('click', () => {
          popup.style.display = 'none'
        })
      } else {
        throw new Error('Məlumat tapılmadı ')
      }
    })
    .catch(error => {
      popupContent.innerHTML = `<p>Məlumat tapılmadı ${
        error.message || ' '
      }.</p>`
    })
    .finally(() => {
      preloader.style.display = 'none'
    })
}
