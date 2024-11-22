document.addEventListener('DOMContentLoaded', function () {
    const tabs = document.querySelectorAll('.tab-link');
    const contentDivs = document.querySelectorAll('.tab-content');

    // Function to hide all tabs
    function hideAllTabs() {
        contentDivs.forEach(div => {
            div.style.display = 'none';
        });
    }

    // Function to show a specific tab
    function showTab(tabId) {
        hideAllTabs(); // First hide all tabs
        const targetDiv = document.getElementById(tabId);
        if (targetDiv) {
            targetDiv.style.display = 'block';
        }
    }

    // Function to handle data loading for each tab
    function loadTabData(tabId) {
        if (tabId === 'policies') {
            loadPolicies(); // This function will be in policies.js
        } else if (tabId === 'doctors') {
            loadDoctors(); // This function will be in doctors.js
        } else if (tabId === 'refund') {
            loadRefund(); // This function will be in refund.js
        } else if (tabId === 'complaints') {
            loadComplaints(); // This function will be in complaints.js
        } else if (tabId === 'complaints_not_medical') { // Corrected from `targetId` to `tabId`
            loadNonMedicalComplaints(); // This function will be in complaints_not_medical.js
        }
    }

    // Function to handle tab clicks
    function handleTabClick(event) {
        event.preventDefault();
        const targetId = this.getAttribute('data-target');
        showTab(targetId);
        loadTabData(targetId);
    }

    // Function to initialize the default tab (policies)
    function initializeDefaultTab() {
        const defaultTabId = 'policies'; // ID of the tab to open by default
        showTab(defaultTabId);
        loadTabData(defaultTabId); // Automatically load data for the default tab
    }

    // Attach event listeners to tabs
    tabs.forEach(tab => {
        tab.addEventListener('click', handleTabClick);
    });

    // Initialize the default tab when the page loads
    initializeDefaultTab();
});
