/**
 * @file
 * Search results (SERP) page interactions.
 *
 * Handles:
 * - View toggle (Table / Grid / List) — switches the CSS class on the results container
 * - Filter drawer collapse/expand
 * - Active filter badge removal (delegated to Drupal exposed form reset)
 *
 * All content is still driven by Drupal Views; this script only manages
 * the UI presentation layer.
 */

(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', function () {
    // ── View Toggle Buttons ──
    const viewBtns = document.querySelectorAll('.cpg-serp__view-btn');
    const resultsContainer = document.querySelector('.cpg-serp__results');

    if (viewBtns.length && resultsContainer) {
      viewBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
          // Remove active state from all
          viewBtns.forEach(function (b) {
            b.classList.remove('cpg-serp__view-btn--active');
          });

          // Activate clicked button
          btn.classList.add('cpg-serp__view-btn--active');

          // Swap CSS class on results
          var viewMode = btn.getAttribute('data-view') || 'table';
          resultsContainer.className = 'cpg-serp__results cpg-serp__results--' + viewMode;
        });
      });
    }

    // ── Filter Drawer Collapse/Expand ──
    const filterHeader = document.querySelector('.cpg-serp__filters-header');
    const filterBody = document.querySelector('.cpg-serp__filters-body');

    if (filterHeader && filterBody) {
      filterHeader.addEventListener('click', function (e) {
        e.preventDefault();
        var isExpanded = filterHeader.getAttribute('aria-expanded') === 'true';
        filterHeader.setAttribute('aria-expanded', String(!isExpanded));
        filterBody.style.display = isExpanded ? 'none' : 'block';
      });

      // Keyboard accessibility
      filterHeader.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          filterHeader.click();
        }
      });
    }

    // ── "Clear All" link — reset all exposed filters ──
    const clearAllLink = document.querySelector('.cpg-serp__filters-clear');
    if (clearAllLink) {
      clearAllLink.addEventListener('click', function (e) {
        e.preventDefault();
        // Reset all form inputs within the filter drawer
        var form = document.querySelector('.cpg-serp__filters-body form');
        if (form) {
          form.reset();
          // Submit the cleared form to reload results
          form.submit();
        }
      });
    }
  });
})();
