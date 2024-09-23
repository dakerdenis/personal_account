function loadRefund() {
    fetch('./vendor/GetRefundInfo.php')  // Replace with your actual endpoint
        .then(response => response.json())
        .then(data => {
            console.log('Refund data:', data);  // Log the response to check the structure

            if (data && data.REFUND_INFO) {  // Replace with the correct structure from API response
                let refundHtml = '<h2>Refund Information</h2>';
                refundHtml += `<p>Refund Status: ${data.REFUND_INFO.status}</p>`;
                document.getElementById('refund').innerHTML = refundHtml;
            } else {
                console.error('Unexpected data structure:', data);
                document.getElementById('refund').innerHTML = '<p>Error loading data: Invalid response structure.</p>';
            }
        })
        .catch(error => {
            console.error('Error fetching data:', error);
            document.getElementById('refund').innerHTML = '<p>Error loading data.</p>';
        });
}
