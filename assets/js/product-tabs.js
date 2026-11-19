const productTabs = document.querySelector('[data-product-tabs]');

if (productTabs) {
    const tabList = productTabs.querySelector('[data-product-tab-list]');
    const tabs = [...tabList.querySelectorAll('a')];
    const panels = tabs.map((tab) => productTabs.querySelector(tab.hash));

    tabList.setAttribute('role', 'tablist');
    tabs.forEach((tab, index) => {
        const panel = panels[index];
        tab.setAttribute('role', 'tab');
        tab.setAttribute('aria-controls', panel.id);
        panel.setAttribute('role', 'tabpanel');
        panel.setAttribute('aria-labelledby', tab.id);
        panel.tabIndex = 0;
    });

    function selectTab(selected, updateUrl = false) {
        tabs.forEach((tab, index) => {
            const active = tab === selected;
            tab.setAttribute('aria-selected', String(active));
            tab.tabIndex = active ? 0 : -1;
            panels[index].hidden = !active;
        });

        if (updateUrl && location.hash !== selected.hash) {
            history.pushState(null, '', selected.hash);
        }
    }

    function selectFromUrl() {
        const linkedTab = tabs.find((tab) => tab.hash === location.hash);
        selectTab(linkedTab ?? tabs[0]);
        if (linkedTab) {
            tabList.scrollIntoView();
        }
    }

    tabs.forEach((tab, index) => {
        tab.addEventListener('click', (event) => {
            event.preventDefault();
            selectTab(tab, true);
        });

        tab.addEventListener('keydown', (event) => {
            const targetIndex = {
                ArrowLeft: (index - 1 + tabs.length) % tabs.length,
                ArrowRight: (index + 1) % tabs.length,
                Home: 0,
                End: tabs.length - 1,
                ' ': index,
            }[event.key];

            if (targetIndex === undefined) return;

            event.preventDefault();
            const nextTab = tabs[targetIndex];
            selectTab(nextTab, true);
            nextTab.focus();
        });
    });

    const reviewLink = document.querySelector('[data-product-review-link]');
    reviewLink.addEventListener('click', (event) => {
        event.preventDefault();
        const reviewTab = tabs.find((tab) => tab.hash === reviewLink.hash);
        selectTab(reviewTab, true);
        reviewTab.focus({ preventScroll: true });
        tabList.scrollIntoView();
    });

    window.addEventListener('hashchange', selectFromUrl);
    selectFromUrl();
}
