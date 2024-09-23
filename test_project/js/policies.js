function loadPolicies() {
    // First, fetch customer information
    fetch('./vendor/GetCustomerInformation.php')
        .then(response => response.json())
        .then(customerData => {
            console.log('Customer Information data:', customerData); // Log the response to check the structure

            // Check if the expected customer information exists
            if (customerData && customerData.CUSTOMER_INFORMATION) {
                // Prepare customer information HTML
                const customerInfoHtml = `
                    <h2>${customerData.CUSTOMER_INFORMATION.NAME} ${customerData.CUSTOMER_INFORMATION.SURNAME}</h2>
                    <p>Company name: ${customerData.CARD_INFORMATION.INSURER_CUSTOMER_NAME}</p>
                    <p>Card name: ${customerData.CARD_INFORMATION.CARD_NUMBER}</p>
                    <p>Have Casco or mandatory: ${customerData.CUSTOMER_INFORMATION.HAVE_CASCO_OR_MANDATORY}</p>
                `;

                // Display the customer information initially
                document.getElementById('policies').innerHTML = customerInfoHtml;

                // Now fetch the customer policies from the second API
                return fetch('./vendor/GetCustomerPolicies.php'); // Second API call
            } else {
                throw new Error('Invalid customer data structure.');
            }
        })
        .then(response => response.json())
        .then(policiesData => {
            console.log('Policies data:', policiesData); // Log the response to check the structure

            // Check if the expected policies data exists
            if (policiesData && policiesData.POLICIES) {
                const policies = Array.isArray(policiesData.POLICIES) ? 
                                 policiesData.POLICIES : 
                                 [policiesData.POLICIES];

                // Create HTML for policies list
                let policiesHtml = '<h3>Policies:</h3><ul>';
                policies.forEach(policy => {
                    policiesHtml += `
                        <li>
                            <strong>${policy.INSURANCE_NAME}</strong><br>
                            Policy Number: ${policy.POLICY_NUMBER}<br>
                            Insurance Code: ${policy.INSURANCE_CODE}<br>
                            Status: ${policy.STATUS}<br>
                            End Date: ${policy.INSURANCE_END_DATE}
                        </li>
                    `;
                });
                policiesHtml += '</ul>';

                // Append the policies to the existing customer information
                document.getElementById('policies').innerHTML += policiesHtml;
            } else {
                throw new Error('Invalid policies data structure.');
            }
        })
        .catch(error => {
            console.error('Error fetching data:', error);
            document.getElementById('policies').innerHTML = '<p>Error loading data.</p>';
        });
}