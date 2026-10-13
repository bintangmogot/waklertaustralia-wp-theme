document.addEventListener('DOMContentLoaded', () => {
    // Mobile Menu Toggle
    const menuOpen = document.getElementById('mobile-menu-open');
    const menuClose = document.getElementById('mobile-menu-close');
    const menuDrawer = document.getElementById('mobile-menu-drawer');
    const menuOverlay = document.getElementById('mobile-menu-overlay');

    function openMenu() {
        if (!menuDrawer || !menuOverlay) return;
        
        // Show overlay
        menuOverlay.classList.remove('hidden');
        menuOverlay.classList.add('block');
        
        // Slide in drawer
        menuDrawer.classList.remove('-translate-x-full');
        menuDrawer.classList.add('translate-x-0');
        
        // Prevent body scroll
        document.body.style.overflow = 'hidden';
    }

    function closeMenu() {
        if (!menuDrawer || !menuOverlay) return;
        
        // Hide overlay
        menuOverlay.classList.add('hidden');
        menuOverlay.classList.remove('block');
        
        // Slide out drawer
        menuDrawer.classList.add('-translate-x-full');
        menuDrawer.classList.remove('translate-x-0');
        
        // Restore body scroll
        document.body.style.overflow = '';
    }

    if (menuOpen) menuOpen.addEventListener('click', openMenu);
    if (menuClose) menuClose.addEventListener('click', closeMenu);
    if (menuOverlay) menuOverlay.addEventListener('click', closeMenu);

    // Mobile Navigation Submenu Accordion
    document.querySelectorAll('.mobile-nav .menu-item-has-children').forEach((item) => {
        const toggleBtn = item.querySelector('.mobile-submenu-toggle');
        const subMenu = item.querySelector('.sub-menu');
        const link = item.querySelector('a');

        if (!subMenu) return;

        function toggleSubmenu(e) {
            if (e) {
                e.preventDefault();
                e.stopPropagation();
            }
            const isOpen = subMenu.classList.contains('is-open');
            if (isOpen) {
                subMenu.classList.remove('is-open');
                if (toggleBtn) {
                    toggleBtn.classList.remove('is-active');
                    toggleBtn.setAttribute('aria-expanded', 'false');
                }
            } else {
                subMenu.classList.add('is-open');
                if (toggleBtn) {
                    toggleBtn.classList.add('is-active');
                    toggleBtn.setAttribute('aria-expanded', 'true');
                }
            }
        }

        if (toggleBtn) {
            toggleBtn.addEventListener('click', toggleSubmenu);
        }

        // If parent link href is "#" or empty, clicking the link also toggles the submenu
        if (link) {
            const href = link.getAttribute('href');
            if (!href || href === '#' || href === 'javascript:void(0)') {
                link.addEventListener('click', toggleSubmenu);
            }
        }
    });

    document.querySelectorAll('[data-product-description-toggle]').forEach((button) => {
        const description = document.getElementById(button.getAttribute('aria-controls'));
        if (!description) return;

        description.classList.add('line-clamp-2');
        button.addEventListener('click', () => {
            const expanded = button.getAttribute('aria-expanded') === 'true';
            description.classList.toggle('line-clamp-2', expanded);
            button.setAttribute('aria-expanded', String(!expanded));
            button.textContent = expanded ? 'Read more' : 'Read less';
        });
    });
});
