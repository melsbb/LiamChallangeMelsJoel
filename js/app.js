(() => {
    'use strict';

    const gameGrid = document.querySelector('#game-grid');
    const cards = Array.from(gameGrid.querySelectorAll('.game-card'));
    const navItems = Array.from(document.querySelectorAll('.nav-item'));
    const platformFilter = document.querySelector('#platform-filter');
    const genreFilter = document.querySelector('#genre-filter');
    const statusFilter = document.querySelector('#status-filter');
    const favoriteFilter = document.querySelector('.star-button');
    const searchButton = document.querySelector('.search-button');
    const searchInput = document.querySelector('.search-input');
    const sortButton = document.querySelector('.sort-button');
    const resetButton = document.querySelector('.reset-button');
    const viewButtons = Array.from(document.querySelectorAll('[data-view]'));
    const totalLabel = document.querySelector('.game-total');
    const pageTitle = document.querySelector('.page-header h1');
    const emptyState = document.querySelector('.empty-state');
    const originalOrder = new Map(cards.map((card, index) => [card, index]));
    const sortModes = ['original', 'title-asc', 'title-desc', 'played-desc', 'played-asc'];
    const sortLabels = {
        original: 'Oorspronkelijke volgorde',
        'title-asc': 'Naam, oplopend',
        'title-desc': 'Naam, aflopend',
        'played-desc': 'Speeltijd, hoog naar laag',
        'played-asc': 'Speeltijd, laag naar hoog'
    };

    let activeFilter = 'all';
    let sortMode = 'original';
    let favoriteOnly = false;

    function matchesNavigationFilter(card) {
        switch (activeFilter) {
            case 'wishlist':
                return card.querySelector('.game-favorite').getAttribute('aria-pressed') === 'true';
            case 'complete':
                return card.dataset.complete === 'true';
            case 'story':
                return card.dataset.story === 'true';
            case 'playing':
            case 'up-next':
            case 'backlog':
            case 'paused':
            case 'retired':
                return card.dataset.status === activeFilter;
            default:
                return true;
        }
    }

    function matchesFilters(card) {
        const platforms = card.dataset.platforms.split(',');
        const searchTerm = searchInput.value.trim().toLocaleLowerCase();
        const searchableText = card.textContent.toLocaleLowerCase();

        return matchesNavigationFilter(card)
            && (!platformFilter.value || platforms.includes(platformFilter.value))
            && (!genreFilter.value || card.dataset.genre === genreFilter.value)
            && (!statusFilter.value || card.dataset.status === statusFilter.value)
            && (!favoriteOnly || card.querySelector('.game-favorite').getAttribute('aria-pressed') === 'true')
            && (!searchTerm || searchableText.includes(searchTerm));
    }

    function compareCards(first, second) {
        const firstTitle = first.querySelector('h2').textContent.trim();
        const secondTitle = second.querySelector('h2').textContent.trim();

        switch (sortMode) {
            case 'title-asc':
                return firstTitle.localeCompare(secondTitle);
            case 'title-desc':
                return secondTitle.localeCompare(firstTitle);
            case 'played-desc':
                return Number(second.dataset.played) - Number(first.dataset.played);
            case 'played-asc':
                return Number(first.dataset.played) - Number(second.dataset.played);
            default:
                return originalOrder.get(first) - originalOrder.get(second);
        }
    }

    function updateNavigationCounts() {
        const counts = {
            all: cards.length,
            wishlist: cards.filter(card => card.querySelector('.game-favorite').getAttribute('aria-pressed') === 'true').length,
            complete: cards.filter(card => card.dataset.complete === 'true').length,
            story: cards.filter(card => card.dataset.story === 'true').length,
            playing: cards.filter(card => card.dataset.status === 'playing').length,
            'up-next': cards.filter(card => card.dataset.status === 'up-next').length,
            backlog: cards.filter(card => card.dataset.status === 'backlog').length,
            paused: cards.filter(card => card.dataset.status === 'paused').length,
            retired: cards.filter(card => card.dataset.status === 'retired').length
        };

        navItems.forEach(item => {
            item.querySelector('.nav-count').textContent = counts[item.dataset.filter];
        });
    }

    function render() {
        const visibleCards = cards.filter(matchesFilters).sort(compareCards);
        const visibleSet = new Set(visibleCards);

        visibleCards.forEach(card => gameGrid.insertBefore(card, emptyState));
        cards.filter(card => !visibleSet.has(card)).forEach(card => gameGrid.insertBefore(card, emptyState));
        cards.forEach(card => {
            card.hidden = !visibleSet.has(card);
        });

        const count = visibleCards.length;
        totalLabel.textContent = `${count} ${count === 1 ? 'game' : 'games'}`;
        emptyState.hidden = count > 0;
        updateNavigationCounts();
    }

    navItems.forEach(item => {
        item.addEventListener('click', () => {
            activeFilter = item.dataset.filter;
            navItems.forEach(navItem => {
                const isActive = navItem === item;
                navItem.classList.toggle('active', isActive);
                navItem.setAttribute('aria-pressed', String(isActive));
            });
            pageTitle.textContent = item.querySelector('.nav-label').textContent;
            render();
        });
    });

    [platformFilter, genreFilter, statusFilter].forEach(filter => {
        filter.addEventListener('change', render);
    });

    document.querySelectorAll('.game-favorite').forEach(button => {
        button.addEventListener('click', () => {
            const isFavorite = button.getAttribute('aria-pressed') !== 'true';
            const gameName = button.closest('.game-card').querySelector('h2').textContent.trim();
            const icon = button.querySelector('i');

            button.setAttribute('aria-pressed', String(isFavorite));
            button.setAttribute('aria-label', `${gameName} ${isFavorite ? 'verwijderen uit' : 'toevoegen aan'} favorieten`);
            icon.classList.toggle('fa-solid', isFavorite);
            icon.classList.toggle('fa-regular', !isFavorite);
            render();
        });
    });

    favoriteFilter.addEventListener('click', () => {
        favoriteOnly = !favoriteOnly;
        favoriteFilter.setAttribute('aria-pressed', String(favoriteOnly));
        favoriteFilter.classList.toggle('active', favoriteOnly);
        render();
    });

    searchButton.addEventListener('click', () => {
        const isOpen = searchInput.hidden;
        searchInput.hidden = !isOpen;
        searchButton.setAttribute('aria-expanded', String(isOpen));
        searchButton.setAttribute('aria-label', isOpen ? 'Zoeken sluiten' : 'Zoeken openen');
        if (isOpen) {
            searchInput.focus();
        } else {
            searchInput.value = '';
            render();
        }
    });
    searchInput.addEventListener('input', render);

    sortButton.addEventListener('click', () => {
        const nextIndex = (sortModes.indexOf(sortMode) + 1) % sortModes.length;
        sortMode = sortModes[nextIndex];
        sortButton.setAttribute('aria-label', `Sorteren op ${sortLabels[sortMode]}`);
        sortButton.title = `Sorteren op ${sortLabels[sortMode]}`;
        render();
    });

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

    resetButton.addEventListener('click', () => {
        platformFilter.value = '';
        genreFilter.value = '';
        statusFilter.value = '';
        activeFilter = 'all';
        favoriteOnly = false;
        sortMode = 'original';
        searchInput.value = '';
        searchInput.hidden = true;
        searchButton.setAttribute('aria-expanded', 'false');
        searchButton.setAttribute('aria-label', 'Zoeken openen');
        favoriteFilter.setAttribute('aria-pressed', 'false');
        favoriteFilter.classList.remove('active');
        sortButton.setAttribute('aria-label', `Sorteren op ${sortLabels[sortMode]}`);
        sortButton.title = `Sorteren op ${sortLabels[sortMode]}`;
        gameGrid.dataset.view = 'grid';
        viewButtons.forEach(button => {
            const isActive = button.dataset.view === 'grid';
            button.classList.toggle('active', isActive);
            button.setAttribute('aria-pressed', String(isActive));
        });
        navItems.forEach(item => {
            const isActive = item.dataset.filter === 'all';
            item.classList.toggle('active', isActive);
            item.setAttribute('aria-pressed', String(isActive));
        });
        pageTitle.textContent = 'All Games';
        render();
    });

    render();
})();
