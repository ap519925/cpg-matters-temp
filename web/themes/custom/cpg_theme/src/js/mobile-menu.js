/**
 * Mobile Menu System
 * 
 * MOBILE NAV DRAWER — triggered by .mobile-nav-hamburger in the header
 * TOPIC SIDEBAR — toggle minimize/maximize + entrance animation
 * PHONE NUMBER — responsive relocation to mobile nav drawer
 */

// ── Mobile Nav Drawer ──
function initMobileNavDrawer() {
    const hamburger = document.querySelector('.mobile-nav-hamburger');
    const closeBtn = document.querySelector('.mobile-nav-drawer__close');
    const overlay = document.querySelector('.mobile-nav-overlay');
    const drawer = document.querySelector('.mobile-nav-drawer');

    if (!hamburger || !drawer) {
        return;
    }

    // Gather all animated items inside the drawer for staggered entrance
    const getAnimItems = () => drawer.querySelectorAll('.mobile-nav-list__item, .mobile-nav-drawer__search, .mobile-nav-drawer__phone, .mobile-nav-drawer__cta');

    const openDrawer = () => {
        document.body.classList.add('mobile-nav-open');
        hamburger.setAttribute('aria-expanded', 'true');

        // Staggered entrance animation
        const items = getAnimItems();
        items.forEach((item, i) => {
            item.style.opacity = '0';
            item.style.transform = 'translateX(25px)';
            item.style.transition = 'none';

            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    item.style.transition = `opacity 0.4s cubic-bezier(0.16, 1, 0.3, 1) ${i * 0.06}s, transform 0.4s cubic-bezier(0.16, 1, 0.3, 1) ${i * 0.06}s`;
                    item.style.opacity = '1';
                    item.style.transform = 'translateX(0)';
                });
            });
        });
    };

    const closeDrawer = () => {
        // Quick fade out
        const items = getAnimItems();
        items.forEach((item) => {
            item.style.transition = 'opacity 0.12s ease, transform 0.12s ease';
            item.style.opacity = '0';
            item.style.transform = 'translateX(15px)';
        });

        setTimeout(() => {
            document.body.classList.remove('mobile-nav-open');
            hamburger.setAttribute('aria-expanded', 'false');
        }, 100);
    };

    hamburger.addEventListener('click', () => {
        if (document.body.classList.contains('mobile-nav-open')) {
            closeDrawer();
        } else {
            openDrawer();
        }
    });
    if (closeBtn) closeBtn.addEventListener('click', closeDrawer);
    if (overlay) overlay.addEventListener('click', closeDrawer);

    // Close on ESC
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && document.body.classList.contains('mobile-nav-open')) {
            closeDrawer();
        }
    });

    // Active link highlighting
    const currentPath = window.location.pathname;
    drawer.querySelectorAll('.mobile-nav-list__link').forEach((link) => {
        if (link.getAttribute('href') === currentPath) {
            link.classList.add('is-active');
        }
    });
}

// ── Topic Sidebar: toggle + staggered entrance animation ──
function initTopicSidebar() {
    const sidebar = document.querySelector('.topic-sidebar');
    if (!sidebar) return;

    const icons = sidebar.querySelectorAll('.topic-sidebar__icon');

    // ── Dynamically wrap icons and add toggle button ──
    // Since sidebar HTML comes from a Drupal block, we inject the structure via JS
    if (!sidebar.querySelector('.topic-sidebar__icons-wrapper')) {
        const wrapper = document.createElement('div');
        wrapper.className = 'topic-sidebar__icons-wrapper';
        
        // Move all icon children into the wrapper
        const iconElements = Array.from(sidebar.querySelectorAll('.topic-sidebar__icon'));
        iconElements.forEach(icon => wrapper.appendChild(icon));
        
        // Insert wrapper and expand button
        const expandBtn = document.createElement('button');
        expandBtn.className = 'topic-sidebar__expand';
        expandBtn.setAttribute('aria-label', 'Expand topic sidebar');
        expandBtn.innerHTML = '<span class="topic-sidebar__expand-icon">▶</span>';
        sidebar.insertBefore(expandBtn, sidebar.firstChild);
        sidebar.insertBefore(wrapper, expandBtn.nextSibling);
    }

    if (!sidebar.querySelector('.topic-sidebar__toggle')) {
        const toggleBtn = document.createElement('button');
        toggleBtn.className = 'topic-sidebar__toggle';
        toggleBtn.setAttribute('aria-label', 'Minimize topic sidebar');
        toggleBtn.innerHTML = '<span class="topic-sidebar__toggle-icon">◀</span>';
        sidebar.appendChild(toggleBtn);
    }
    
    // Stagger the icons appearing on page load
    icons.forEach((icon, i) => {
        icon.style.opacity = '0';
        icon.style.transform = 'translateX(-12px)';
        
        setTimeout(() => {
            icon.style.transition = 'opacity 0.4s cubic-bezier(0.16, 1, 0.3, 1), transform 0.4s cubic-bezier(0.16, 1, 0.3, 1)';
            icon.style.opacity = '1';
            icon.style.transform = 'translateX(0)';
        }, 200 + (i * 50));
    });

    // ── Min/Max toggle button ──
    const toggle = sidebar.querySelector('.topic-sidebar__toggle');
    const expandBtn = sidebar.querySelector('.topic-sidebar__expand');
    if (!toggle || !expandBtn) return;

    // Restore collapsed state from localStorage
    const savedState = localStorage.getItem('cpg-topic-sidebar-collapsed');
    if (savedState === 'true') {
        sidebar.classList.add('topic-sidebar--collapsed');
    }

    toggle.addEventListener('click', () => {
        const isCollapsed = sidebar.classList.toggle('topic-sidebar--collapsed');
        if (isCollapsed) {
            sidebar.classList.remove('topic-sidebar--expanded');
            expandBtn.innerHTML = '<span class="topic-sidebar__expand-icon">▶</span>';
        }
        localStorage.setItem('cpg-topic-sidebar-collapsed', isCollapsed);
    });

    expandBtn.addEventListener('click', () => {
        const isExpanded = sidebar.classList.toggle('topic-sidebar--expanded');
        if (isExpanded) {
            sidebar.classList.remove('topic-sidebar--collapsed');
            localStorage.setItem('cpg-topic-sidebar-collapsed', 'false');
            expandBtn.innerHTML = '<span class="topic-sidebar__expand-icon">◀</span>';
        } else {
            expandBtn.innerHTML = '<span class="topic-sidebar__expand-icon">▶</span>';
        }
    });
}

// ── Phone Number: move to mobile nav drawer on mobile/tablet ──
function initPhoneRelocation() {
    const drawer = document.querySelector('.mobile-nav-drawer');
    if (!drawer) return;

    // Find the phone number in the header actions area
    const headerPhone = document.querySelector('.header-actions .header-phone');
    if (!headerPhone) return;

    // Check if a phone placeholder already exists in the drawer
    let phoneContainer = drawer.querySelector('.mobile-nav-drawer__phone');
    if (!phoneContainer) {
        // Create the phone slot in the drawer (after the header, before the nav list)
        phoneContainer = document.createElement('div');
        phoneContainer.className = 'mobile-nav-drawer__phone';

        // Insert after drawer header
        const drawerHeader = drawer.querySelector('.mobile-nav-drawer__header');
        if (drawerHeader && drawerHeader.nextSibling) {
            drawer.insertBefore(phoneContainer, drawerHeader.nextSibling);
        } else {
            drawer.appendChild(phoneContainer);
        }
    }

    // Clone the phone content into the drawer
    const phoneClone = headerPhone.cloneNode(true);
    phoneContainer.innerHTML = '';
    phoneContainer.appendChild(phoneClone);
}

// ── Export combined init ──
export function initMobileMenu() {
    initMobileNavDrawer();
    initTopicSidebar();
    initPhoneRelocation();
}
