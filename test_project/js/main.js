document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.tab-link');
    const contentDivs = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', function(event) {
            event.preventDefault();
            const targetId = this.getAttribute('data-target');

            // Hide all content divs and show the target one
            contentDivs.forEach(div => {
                if (div.id === targetId) {
                    div.style.display = 'block';
                } else {
                    div.style.display = 'none';
                }
            });

            // Based on the tab, call the appropriate data fetching script
            if (targetId === 'policies') {
                loadPolicies();  // This function will be in policies.js
            } else if (targetId === 'doctors') {
                loadDoctors();  // This function will be in doctors.js
            } else if (targetId === 'refund') {
                loadRefund();  // This function will be in refund.js
            }
        });
    });

    // Initially hide all content
    contentDivs.forEach(div => {
        div.style.display = 'none';
    });
});
