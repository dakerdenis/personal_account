function loadRefund() {
    const refundTab = document.getElementById('refund');
    const preloader = document.getElementById('preloader');

    // Show preloader
    preloader.style.display = 'flex';

    // Ensure preloader is visible for at least 1.5 seconds
    setTimeout(() => {
        fetch('./vendor/GetRefundPayment.php')  // Replace with your actual endpoint
            .then(response => response.json())
            .then(data => {
                console.log('Refund payment data:', data);  // Log the response to check the structure

                if (data && data.REFUND_PAYMENT) {
                    let refundPayments = data.REFUND_PAYMENT;

                    // If REFUND_PAYMENT is not an array, convert it to an array
                    if (!Array.isArray(refundPayments)) {
                        refundPayments = [refundPayments];
                    }

                    let refundHtml = '<h2>Refund Payments</h2><ul>';
                    refundPayments.forEach(refund => {
                        refundHtml += `
                            <li>
                                <strong>Card Number: ${refund.CARD_NUMBER}</strong><br>
                                Event Occurrence Date: ${new Date(refund.EVENT_OCCURRENCE_DATE).toLocaleDateString()}<br>
                            </li>
                        `;
                    });
                    refundHtml += '</ul>';

                    // Display the refund payments in the "Refund" tab
                    refundTab.innerHTML = refundHtml;
                } else {
                    throw new Error('Unexpected data structure');
                }
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                refundTab.innerHTML = '<p>Error loading data.</p>';
            })
            .finally(() => {
                // Hide preloader after data is loaded or error occurs
                preloader.style.display = 'none';
            });
    }, 1500);  // Minimum preloader time of 1.5 seconds
}
