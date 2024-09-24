document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.tab-link');
    const contentDivs = document.querySelectorAll('.tab-content');

    // Function to show the default tab (policies)
    function showDefaultTab() {
        const defaultTabId = 'policies'; // ID of the tab to open by default
        contentDivs.forEach(div => {
            if (div.id === defaultTabId) {
                div.style.display = 'block';
            } else {
                div.style.display = 'none';
            }
        });

        // Automatically load data for the default tab (policies)
        loadPolicies();
    }

    // Show the default tab and load its content when the page loads
    showDefaultTab();

    // Handle tab clicks
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
});
