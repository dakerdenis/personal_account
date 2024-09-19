        // JavaScript to handle the tab switching logic
        document.addEventListener('DOMContentLoaded', function() {
            const tabLinks = document.querySelectorAll('.tab-link');
            const tabContents = document.querySelectorAll('.tab-content');

            tabLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault(); // Prevent the default anchor behavior
                    const target = this.getAttribute('data-target');

                    // Hide all tab contents
                    tabContents.forEach(content => {
                        content.classList.remove('active');
                    });

                    // Show the selected tab content
                    const activeTab = document.getElementById(target);
                    if (activeTab) {
                        activeTab.classList.add('active');
                    }
                });
            });
        });