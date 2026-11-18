(() => {
    'use strict';

    const gameGrid = document.querySelector('.game-grid');
    const viewButtons = Array.from(document.querySelectorAll('[data-view]'));

    if (!gameGrid || viewButtons.length === 0) {
        return;
    }

    viewButtons.forEach(button => {
        button.addEventListener('click', () => {
            gameGrid.dataset.view = button.dataset.view;
            viewButtons.forEach(viewButton => {
                const isActive = viewButton === button;
                viewButton.classList.toggle('active', isActive);
                viewButton.setAttribute('aria-pressed', String(isActive));
            });
        });
    });
})();
