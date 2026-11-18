<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Library</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/app.js" defer></script>
</head>
<body>
    <aside class="sidebar" aria-label="Gamefilters">
        <nav class="sidebar-nav">
            <button class="nav-item active" type="button" data-filter="all" aria-pressed="true">
                <span class="nav-icon" aria-hidden="true"><i class="fa-regular fa-window-maximize"></i></span>
                <span class="nav-label">All Games</span>
                <span class="nav-count">0</span>
            </button>

            <button class="nav-item" type="button" data-filter="wishlist" aria-pressed="false">
                <span class="nav-icon heart" aria-hidden="true"><i class="fa-regular fa-heart"></i></span>
                <span class="nav-label">Wishlist</span>
                <span class="nav-count">0</span>
            </button>

            <button class="nav-item" type="button" data-filter="complete" aria-pressed="false">
                <span class="nav-icon trophy" aria-hidden="true"><i class="fa-solid fa-trophy"></i></span>
                <span class="nav-label">100% Complete</span>
                <span class="nav-count">0</span>
            </button>

            <button class="nav-item" type="button" data-filter="story" aria-pressed="false">
                <span class="nav-icon check" aria-hidden="true"><i class="fa-solid fa-check"></i></span>
                <span class="nav-label">Beat Main Story</span>
                <span class="nav-count">0</span>
            </button>

            <button class="nav-item" type="button" data-filter="playing" aria-pressed="false">
                <span class="nav-icon playing" aria-hidden="true"><i class="fa-solid fa-play"></i></span>
                <span class="nav-label">Currently Playing</span>
                <span class="nav-count">0</span>
            </button>

            <button class="nav-item" type="button" data-filter="up-next" aria-pressed="false">
                <span class="nav-icon next" aria-hidden="true"><i class="fa-solid fa-forward"></i></span>
                <span class="nav-label">Up Next</span>
                <span class="nav-count">0</span>
            </button>

            <button class="nav-item" type="button" data-filter="backlog" aria-pressed="false">
                <span class="nav-icon backlog" aria-hidden="true"><i class="fa-solid fa-angles-up"></i></span>
                <span class="nav-label">Backlog</span>
                <span class="nav-count">0</span>
            </button>

            <button class="nav-item" type="button" data-filter="paused" aria-pressed="false">
                <span class="nav-icon paused" aria-hidden="true"><i class="fa-solid fa-pause"></i></span>
                <span class="nav-label">Paused</span>
                <span class="nav-count">0</span>
            </button>

            <button class="nav-item" type="button" data-filter="retired" aria-pressed="false">
                <span class="nav-icon retired" aria-hidden="true"><i class="fa-regular fa-circle-xmark"></i></span>
                <span class="nav-label">Retired</span>
                <span class="nav-count">0</span>
            </button>
        </nav>
    </aside>

    <main class="main-content">
        <header class="page-header">
            <h1>All Games</h1>
            <div class="view-actions" aria-label="Weergaveopties">
                <button type="button" data-view="list" aria-label="Lijstweergave" aria-pressed="false"><i class="fa-solid fa-list"></i></button>
                <button type="button" class="active" data-view="grid" aria-label="Vaste rasterweergave" aria-pressed="true"><i class="fa-solid fa-table-cells"></i></button>
                <button type="button" data-view="large" aria-label="Grote rasterweergave" aria-pressed="false"><i class="fa-solid fa-th"></i></button>
                <button type="button" data-view="extra-large" aria-label="Extra grote rasterweergave" aria-pressed="false"><i class="fa-solid fa-grip"></i></button>
            </div>
        </header>

        <section class="filter-bar" aria-label="Spelfilters">
            <select aria-label="Platform" id="platform-filter">
                <option value="">All Platforms</option>
                <option value="pc">PC</option>
                <option value="playstation">PlayStation</option>
                <option value="xbox">Xbox</option>
                <option value="nintendo-switch">Nintendo Switch</option>
            </select>
            <select aria-label="Categorie" id="genre-filter">
                <option value="">All Genres</option>
                <option value="action-adventure">Action-Adventure</option>
                <option value="battle-royale">Battle Royale</option>
                <option value="sandbox">Sandbox</option>
                <option value="shooter">Shooter</option>
            </select>
            <select aria-label="Status" id="status-filter">
                <option value="">All Statuses</option>
                <option value="playing">Currently Playing</option>
                <option value="up-next">Up Next</option>
                <option value="backlog">Backlog</option>
                <option value="paused">Paused</option>
                <option value="retired">Retired</option>
            </select>
            <button class="star-button" type="button" aria-label="Alleen favorieten tonen" aria-pressed="false"><i class="fa-regular fa-star" aria-hidden="true"></i></button>
            <button class="search-button" type="button" aria-label="Zoeken openen" aria-expanded="false"><i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i></button>
            <input class="search-input" type="search" aria-label="Games zoeken" placeholder="Search games..." hidden>
            <button class="sort-button" type="button" aria-label="Sorteren op naam, oplopend" title="Sorteren op naam, oplopend"><i class="fa-solid fa-arrow-up-wide-short" aria-hidden="true"></i></button>
            <span class="game-total">6 games</span>
            <button class="reset-button" type="button">Reset Filters</button>
        </section>

        <section class="game-grid" id="game-grid" aria-label="Gamebibliotheek" data-view="grid">
            <article class="game-card" data-platforms="pc,nintendo-switch" data-genre="sandbox" data-status="playing" data-complete="true" data-story="true" data-played="128">
                <img class="cover" src="https://store-images.s-microsoft.com/image/apps.60323.14294656681058683.4d17bdd8-7026-429a-846f-cf7836bc9e56.a69e6905-8926-4a48-b243-14a039b97aae?mode=scale&amp;q=90&amp;h=1080&amp;w=1920&amp;format=jpg" alt="Cover van Minecraft" loading="lazy">
                <div class="game-info">
                    <div class="game-title-row"><h2>Minecraft</h2><button class="game-favorite" type="button" aria-label="Minecraft toevoegen aan favorieten" aria-pressed="false"><i class="fa-regular fa-star" aria-hidden="true"></i></button></div><p>Mojang Studios</p><time>Nov 18, 2011</time>
                    <div class="game-stats"><span><b>128 h</b>Played</span><span><b>80 h</b>Main</span><span><b>100%</b></span></div>
                </div>
            </article>

            <article class="game-card" data-platforms="pc,playstation,xbox" data-genre="action-adventure" data-status="backlog" data-complete="true" data-story="true" data-played="86">
                <img class="cover" src="https://thumb.wikimedia.org/wikipedia/en/thumb/a/a5/Grand_Theft_Auto_V.png/250px-Grand_Theft_Auto_V.png" alt="Cover van Grand Theft Auto V" loading="lazy">
                <div class="game-info">
                    <div class="game-title-row"><h2>GTA 5</h2><button class="game-favorite" type="button" aria-label="GTA 5 toevoegen aan favorieten" aria-pressed="false"><i class="fa-regular fa-star" aria-hidden="true"></i></button></div><p>Rockstar Games</p><time>Sep 17, 2013</time>
                    <div class="game-stats"><span><b>86 h</b>Played</span><span><b>31 h</b>Main</span><span><b>100%</b></span></div>
                </div>
            </article>

            <article class="game-card" data-platforms="pc,playstation,xbox,nintendo-switch" data-genre="battle-royale" data-status="playing" data-complete="true" data-story="true" data-played="72">
                <img class="cover" src="https://gmedia.playstation.com/is/image/SIEPDC/fortnite-keyart-01-en-30nov23?$facebook$" alt="Coverafbeelding van Fortnite" loading="lazy">
                <div class="game-info">
                    <div class="game-title-row"><h2>Fortnite</h2><button class="game-favorite" type="button" aria-label="Fortnite toevoegen aan favorieten" aria-pressed="false"><i class="fa-regular fa-star" aria-hidden="true"></i></button></div><p>Epic Games</p><time>Jul 21, 2017</time>
                    <div class="game-stats"><span><b>72 h</b>Played</span><span><b>12 h</b>Main</span><span><b>100%</b></span></div>
                </div>
            </article>

            <article class="game-card" data-platforms="pc,playstation,xbox" data-genre="action-adventure" data-status="playing" data-complete="true" data-story="true" data-played="94">
                <img class="cover" src="https://thumb.wikimedia.org/wikipedia/en/thumb/4/44/Red_Dead_Redemption_II.jpg/250px-Red_Dead_Redemption_II.jpg" alt="Cover van Red Dead Redemption 2" loading="lazy">
                <div class="game-info">
                    <div class="game-title-row"><h2>Red Dead Redemption 2</h2><button class="game-favorite" type="button" aria-label="Red Dead Redemption 2 toevoegen aan favorieten" aria-pressed="false"><i class="fa-regular fa-star" aria-hidden="true"></i></button></div><p>Rockstar Games</p><time>Oct 26, 2018</time>
                    <div class="game-stats"><span><b>94 h</b>Played</span><span><b>50 h</b>Main</span><span><b>100%</b></span></div>
                </div>
            </article>

            <article class="game-card" data-platforms="pc,playstation,xbox" data-genre="shooter" data-status="up-next" data-complete="true" data-story="true" data-played="42">
                <img class="cover" src="https://thumb.wikimedia.org/wikipedia/en/thumb/f/f6/MWIII_Cover_Art.png/250px-MWIII_Cover_Art.png" alt="Cover van Call of Duty: Modern Warfare III" loading="lazy">
                <div class="game-info">
                    <div class="game-title-row"><h2>Call of Duty: Modern Warfare III</h2><button class="game-favorite" type="button" aria-label="Call of Duty: Modern Warfare III toevoegen aan favorieten" aria-pressed="false"><i class="fa-regular fa-star" aria-hidden="true"></i></button></div><p>Activision</p><time>Nov 10, 2023</time>
                    <div class="game-stats"><span><b>42 h</b>Played</span><span><b>18 h</b>Main</span><span><b>100%</b></span></div>
                </div>
            </article>

            <article class="game-card" data-platforms="pc,playstation,xbox,nintendo-switch" data-genre="action-adventure" data-status="up-next" data-complete="true" data-story="true" data-played="51">
                <img class="cover" src="https://thumb.wikimedia.org/wikipedia/en/thumb/2/28/Assassin%27s_Creed_IV_-_Black_Flag_cover.jpg/250px-Assassin%27s_Creed_IV_-_Black_Flag_cover.jpg" alt="Cover van Assassin's Creed IV: Black Flag" loading="lazy">
                <div class="game-info">
                    <div class="game-title-row"><h2>Assassin's Creed IV: Black Flag</h2><button class="game-favorite" type="button" aria-label="Assassin's Creed IV: Black Flag toevoegen aan favorieten" aria-pressed="false"><i class="fa-regular fa-star" aria-hidden="true"></i></button></div><p>Ubisoft</p><time>Oct 29, 2013</time>
                    <div class="game-stats"><span><b>51 h</b>Played</span><span><b>23 h</b>Main</span><span><b>100%</b></span></div>
                </div>
            </article>
            <p class="empty-state" hidden>Geen games gevonden. Pas je filters aan of reset ze.</p>
        </section>
    </main>
</body>
</html>