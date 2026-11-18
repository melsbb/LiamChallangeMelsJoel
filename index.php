<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Library</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <aside class="sidebar" aria-label="Gamefilters">
        <nav class="sidebar-nav">
            <a class="nav-item active" href="#" aria-current="page">
                <span class="nav-icon" aria-hidden="true"><i class="fa-regular fa-window-maximize"></i></span>
                <span class="nav-label">All Games</span>
                <span class="nav-count">7</span>
            </a>

            <a class="nav-item" href="#">
                <span class="nav-icon heart" aria-hidden="true"><i class="fa-regular fa-heart"></i></span>
                <span class="nav-label">Wishlist</span>
                <span class="nav-count">0</span>
            </a>

            <a class="nav-item" href="#">
                <span class="nav-icon trophy" aria-hidden="true"><i class="fa-solid fa-trophy"></i></span>
                <span class="nav-label">100% Complete</span>
                <span class="nav-count">16</span>
            </a>

            <a class="nav-item" href="#">
                <span class="nav-icon check" aria-hidden="true"><i class="fa-solid fa-check"></i></span>
                <span class="nav-label">Beat Main Story</span>
                <span class="nav-count">0</span>
            </a>

            <a class="nav-item" href="#">
                <span class="nav-icon playing" aria-hidden="true"><i class="fa-solid fa-play"></i></span>
                <span class="nav-label">Currently Playing</span>
                <span class="nav-count">3</span>
            </a>

            <a class="nav-item" href="#">
                <span class="nav-icon next" aria-hidden="true"><i class="fa-solid fa-forward"></i></span>
                <span class="nav-label">Up Next</span>
                <span class="nav-count">2</span>
            </a>

            <a class="nav-item" href="#">
                <span class="nav-icon backlog" aria-hidden="true"><i class="fa-solid fa-angles-up"></i></span>
                <span class="nav-label">Backlog</span>
                <span class="nav-count">38</span>
            </a>

            <a class="nav-item" href="#">
                <span class="nav-icon paused" aria-hidden="true"><i class="fa-solid fa-pause"></i></span>
                <span class="nav-label">Paused</span>
                <span class="nav-count">3</span>
            </a>

            <a class="nav-item" href="#">
                <span class="nav-icon retired" aria-hidden="true"><i class="fa-regular fa-circle-xmark"></i></span>
                <span class="nav-label">Retired</span>
                <span class="nav-count">8</span>
            </a>
        </nav>
    </aside>

    <main class="main-content">
        <header class="page-header">
            <h1>All Games</h1>
            <div class="view-actions" aria-label="Weergaveopties">
                <button type="button" aria-label="Lijstweergave"><i class="fa-solid fa-list"></i></button>
                <button type="button" class="active" aria-label="Vaste rasterweergave"><i class="fa-solid fa-table-cells"></i></button>
                <button type="button" aria-label="Grote rasterweergave"><i class="fa-solid fa-th"></i></button>
                <button type="button" aria-label="Extra grote rasterweergave"><i class="fa-solid fa-grip"></i></button>
            </div>
        </header>

        <section class="filter-bar" aria-label="Spelfilters">
            <select aria-label="Platform"><option>All Platforms</option></select>
            <select aria-label="Categorie"><option>All Games</option></select>
            <select aria-label="Status"><option>Status</option></select>
            <button class="star-button" type="button" aria-label="Favorieten"><i class="fa-regular fa-star"></i></button>
            <button class="search-button" type="button" aria-label="Zoeken"><i class="fa-solid fa-magnifying-glass"></i></button>
            <button class="sort-button" type="button" aria-label="Sorteren"><i class="fa-solid fa-arrow-up-wide-short"></i></button>
            <span class="game-total">7 games</span>
            <button class="reset-button" type="button">Reset Filters</button>
        </section>

        <section class="game-grid" aria-label="Gamebibliotheek">
            <article class="game-card">
                <div class="cover cover-minecraft"><i class="fa-solid fa-cube"></i><strong>MINECRAFT</strong></div>
                <div class="game-info">
                    <h2>Minecraft</h2><p>Mojang Studios</p><time>Nov 18, 2011</time>
                    <div class="game-stats"><span><b>128 h</b>Played</span><span><b>80 h</b>Main</span><span><b>100%</b></span></div>
                </div>
            </article>

            <article class="game-card">
                <div class="cover cover-gta"><i class="fa-solid fa-city"></i><strong>V</strong></div>
                <div class="game-info">
                    <h2>GTA 5</h2><p>Rockstar Games</p><time>Sep 17, 2013</time>
                    <div class="game-stats"><span><b>86 h</b>Played</span><span><b>31 h</b>Main</span><span><b>100%</b></span></div>
                </div>
            </article>

            <article class="game-card">
                <div class="cover cover-fortnite"><i class="fa-solid fa-fort-awesome"></i><strong>FORTNITE</strong></div>
                <div class="game-info">
                    <h2>Fortnite</h2><p>Epic Games</p><time>Jul 21, 2017</time>
                    <div class="game-stats"><span><b>72 h</b>Played</span><span><b>12 h</b>Main</span><span><b>100%</b></span></div>
                </div>
            </article>

            <article class="game-card">
                <div class="cover cover-rdr"><i class="fa-solid fa-horse"></i><strong>RED DEAD<br>REDEMPTION II</strong></div>
                <div class="game-info">
                    <h2>Red Dead Redemption 2</h2><p>Rockstar Games</p><time>Oct 26, 2018</time>
                    <div class="game-stats"><span><b>94 h</b>Played</span><span><b>50 h</b>Main</span><span><b>100%</b></span></div>
                </div>
            </article>

            <article class="game-card">
                <div class="cover cover-cod"><i class="fa-solid fa-crosshairs"></i><strong>MW4</strong></div>
                <div class="game-info">
                    <h2>Call of Duty MW4</h2><p>Activision</p><time>Nov 10, 2023</time>
                    <div class="game-stats"><span><b>42 h</b>Played</span><span><b>18 h</b>Main</span><span><b>100%</b></span></div>
                </div>
            </article>

            <article class="game-card">
                <div class="cover cover-ac"><i class="fa-solid fa-skull-crossbones"></i><strong>BLACK FLAG</strong></div>
                <div class="game-info">
                    <h2>Assassin's Creed IV: Black Flag</h2><p>Ubisoft</p><time>Oct 29, 2013</time>
                    <div class="game-stats"><span><b>51 h</b>Played</span><span><b>23 h</b>Main</span><span><b>100%</b></span></div>
                </div>
            </article>

            <article class="game-card">
                <div class="cover cover-resynced"><i class="fa-solid fa-robot"></i><strong>RESYNCED</strong></div>
                <div class="game-info">
                    <h2>Resynced</h2><p>Behaviour Interactive</p><time>2026</time>
                    <div class="game-stats"><span><b>18 h</b>Played</span><span><b>9 h</b>Main</span><span><b>100%</b></span></div>
                </div>
            </article>
        </section>
    </main>
</body>
<script>
document.querySelectorAll('.nav-item').forEach(item => {
    item.onclick = event => {
        event.preventDefault();
        document.querySelectorAll('.nav-item').forEach(nav =>
            nav.classList.remove('active'));
        item.classList.add('active');
    };
});
</script>
</html>