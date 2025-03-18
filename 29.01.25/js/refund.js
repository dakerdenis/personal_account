function loadRefund () {
  const refundTab = document.getElementById('refund')
  const preloader = document.getElementById('preloader')

  // Show preloader
  preloader.style.display = 'flex'

  // Ensure preloader is visible for at least 1.5 seconds
  setTimeout(() => {
    fetch('./vendor/GetRefundPayment.php') // Replace with your actual endpoint
      .then(response => response.json())
      .then(data => {
        console.log('Refund payment data:', data) // Log the response to check the structure

        if (data && data.REFUND_PAYMENT) {
          let refundPayments = data.REFUND_PAYMENT

          // If REFUND_PAYMENT is not an array, convert it to an array
          if (!Array.isArray(refundPayments)) {
            refundPayments = [refundPayments]
          }

          let refundHtml =
            '<h2 class="complaints_medical-name">Geri ödəniş müraciyətlər</h2><ul>'
          refundPayments.forEach(refund => {
            refundHtml += `
                            <li class="complaints_medical-li">
                                <div class="complaints_medical-block">
                                    <p>Şəhədətnamə nömrəsi:</p> <span>${
                                      refund.CARD_NUMBER
                                    }</span>
                                </div> 
                                <div class="complaints_medical-block">
                                    <p>Hadisə baş verdi:</p> <span>
                                    ${new Date(
                                        refund.EVENT_OCCURRENCE_DATE
                                      ).toLocaleDateString()}
                                    </span>
                                </div>

                            </li>
                        `
          })
          refundHtml += '</ul>'

          // Display the refund payments in the "Refund" tab
          refundTab.innerHTML = refundHtml
        } else {
          throw new Error('Unexpected data structure')
        }
      })
      .catch(error => {
        console.error('Error fetching data:', error)
        refundTab.innerHTML = '<p>Məlumat tapılmadı.</p>'
      })
      .finally(() => {
        // Hide preloader after data is loaded or error occurs
        preloader.style.display = 'none'
      })
  }, 1500) // Minimum preloader time of 1.5 seconds
}
