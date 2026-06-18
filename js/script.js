document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('iala-jobs-search');
    const categoryFilter = document.getElementById('iala-filter-category');
    const typeFilter = document.getElementById('iala-filter-type');
    const jobCards = document.querySelectorAll('.iala-job-card');
    const noJobsMessage = document.getElementById('iala-no-jobs-found');

    if (!searchInput || jobCards.length === 0) {
        return; // Not on the jobs board page
    }

    function filterJobs() {
        const searchQuery = searchInput.value.toLowerCase().trim();
        const selectedCategory = categoryFilter.value;
        const selectedType = typeFilter.value;
        let visibleCount = 0;

        jobCards.forEach(card => {
            // Retrieve card attributes
            const title = card.getAttribute('data-title') || '';
            const company = card.getAttribute('data-company') || '';
            const content = card.getAttribute('data-content') || '';
            const categories = (card.getAttribute('data-categories') || '').split(',');
            const types = (card.getAttribute('data-types') || '').split(',');

            // Check Search match
            const matchesSearch = searchQuery === '' || 
                                  title.includes(searchQuery) || 
                                  company.includes(searchQuery) || 
                                  content.includes(searchQuery);

            // Check Category match
            const matchesCategory = selectedCategory === 'all' || categories.includes(selectedCategory);

            // Check Type match
            const matchesType = selectedType === 'all' || types.includes(selectedType);

            // Toggle visibility
            if (matchesSearch && matchesCategory && matchesType) {
                card.style.display = 'flex';
                // Add entry animation trigger
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
                visibleCount++;
            } else {
                card.style.display = 'none';
                card.style.opacity = '0';
            }
        });

        // Toggle "No jobs found" message
        if (visibleCount === 0) {
            noJobsMessage.style.display = 'block';
        } else {
            noJobsMessage.style.display = 'none';
        }
    }

    // Bind event listeners
    searchInput.addEventListener('input', filterJobs);
    categoryFilter.addEventListener('change', filterJobs);
    typeFilter.addEventListener('change', filterJobs);

    // Initial check (in case browser auto-filled fields on reload)
    filterJobs();
});
