/**
 * Main JavaScript File
 * 
 * @package Job_Board_Pro
 */

(function() {
    'use strict';

    // Job Search Form Handler
    const searchForm = document.getElementById('job-search-form');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            performSearch(1);
        });
    }

    /**
     * Perform Job Search via AJAX
     */
    function performSearch(page = 1) {
        const search = document.getElementById('search-keyword').value || '';
        const category = document.getElementById('search-category').value || '';
        const location = document.getElementById('search-location').value || '';

        const formData = new FormData();
        formData.append('action', 'job_board_search_jobs');
        formData.append('search', search);
        formData.append('category', category);
        formData.append('location', location);
        formData.append('paged', page);
        formData.append('nonce', jobBoardData.nonce);

        fetch(jobBoardData.ajaxUrl, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const resultsContainer = document.getElementById('job-results');
                if (resultsContainer) {
                    resultsContainer.innerHTML = data.data.html;
                }
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        })
        .catch(error => console.error('Error:', error));
    }

    /**
     * Smooth scroll to elements
     */
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href !== '#' && document.querySelector(href)) {
                e.preventDefault();
                document.querySelector(href).scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });

    /**
     * Filter Jobs by Category
     */
    const categoryFilter = document.getElementById('search-category');
    if (categoryFilter) {
        categoryFilter.addEventListener('change', function() {
            performSearch(1);
        });
    }

    /**
     * Mobile Menu Toggle
     */
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const siteNav = document.querySelector('.site-nav');
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', function() {
            siteNav.classList.toggle('active');
        });
    }

    /**
     * Format Currency
     */
    window.formatCurrency = function(amount) {
        return new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD'
        }).format(amount);
    };

    /**
     * Initialize on document ready
     */
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializePage);
    } else {
        initializePage();
    }

    function initializePage() {
        // Add any initialization code here
        console.log('Job Board Theme Initialized');
    }

})();
