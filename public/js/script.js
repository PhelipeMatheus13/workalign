(function initGlobalMenuSystem() {
    console.log('Global Menu System - Starting initialization');

    // Config - MODULES
    const MODULES = ['dashboard', 'employees', 'departments', 'reports'];

    // Detects module from URL
    function getModuleFromPathname(pathname = window.location.pathname) {
        if (!pathname) return null;

        const segments = pathname.split('/').filter(Boolean);

        for (const seg of segments) {
            const lower = seg.toLowerCase();
            if (MODULES.includes(lower)) {
                // Found a matching module
                return lower;
            }
        }

        console.log('No module detected from URL');
        return null;
    }
    
    // Visually activate a menu.
    function activateMenu(key) {
        const finalKey = key || 'dashboard';

        const menuItems = document.querySelectorAll('.menu-item, #navbarMobileMenu .nav-link');
        menuItems.forEach(i => i.classList.remove('active'));

        const targets = document.querySelectorAll(`[data-menu="${finalKey}"]`);
        targets.forEach(i => i.classList.add('active'));
    }

    function setupMenuEventListeners() {
        const menuItems = document.querySelectorAll('.menu-item, #navbarMobileMenu .nav-link');
        if (!menuItems) return;

        menuItems.forEach(item => {
            item.addEventListener('click', function (e) {
                const href = this.getAttribute('href');

                if (href === '#' || !href) {
                    e.preventDefault();
                }

                let menuKey = this.getAttribute('data-menu');

                if (!menuKey && href) {
                    try {
                        const url = new URL(href, window.location.origin);
                        menuKey = getModuleFromPathname(url.pathname);
                        console.log('Menu inferred from href:', menuKey);
                    } catch (err) {
                        console.warn('Could not parse href:', href);
                    }
                }

                console.log('Menu clicked:', {
                    menuKey,
                    href
                });

                activateMenu(menuKey);

                if (menuKey) {
                    localStorage.setItem('activeMenu', menuKey);
                    console.log('Saved menu to localStorage:', menuKey);
                }

                if (window.jQuery && $('#navbarMobileMenu').length && $('#navbarMobileMenu').hasClass('show')) {
                    console.log('Closing mobile menu');
                    $('#navbarMobileMenu').collapse('hide');
                }

                if (href && href !== '#' && href !== window.location.pathname) {
                    console.log('Navigating to:', href);
                    window.location.href = href;
                }
            });
        });
    }

    function determineAndActivateFromUrlOrCache() {
        console.log('Current pathname:', window.location.pathname);

        const moduleFromUrl = getModuleFromPathname();

        if (moduleFromUrl) {
            console.log('Using menu from URL:', moduleFromUrl);
            activateMenu(moduleFromUrl);
            localStorage.setItem('activeMenu', moduleFromUrl);
            return;
        }

        const saved = localStorage.getItem('activeMenu');
        if (saved) {
            activateMenu(saved);
            return;
        }

        console.log('No URL or cache found — defaulting to dashboard');
        activateMenu('dashboard');
        localStorage.setItem('activeMenu', 'dashboard');
    }

    document.addEventListener('DOMContentLoaded', function () {
        determineAndActivateFromUrlOrCache();
        setupMenuEventListeners();

        window.addEventListener('popstate', function () {
            determineAndActivateFromUrlOrCache();
        });
    });

    window.clearSavedMenu = function () {
        localStorage.removeItem('activeMenu');
        console.log('localStorage.activeMenu cleared');
    };
})();
