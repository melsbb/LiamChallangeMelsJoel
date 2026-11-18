<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';

$pdo = database();
$statusCounts = game_status_counts($pdo);
$activeStatus = request_string($_GET, 'status');
$platform = request_string($_GET, 'platform');
$genre = request_string($_GET, 'genre');
$statusFilter = request_string($_GET, 'status_filter');
$rating = request_string($_GET, 'rating');
$search = request_string($_GET, 'search');
$filterErrors = [];

if ($activeStatus !== '' && !in_array($activeStatus, GAME_STATUSES, true)) {
    $filterErrors[] = 'Ongeldige statusfilter.';
    $activeStatus = '';
}
if ($platform !== '' && !in_array($platform, GAME_PLATFORMS, true)) {
    $filterErrors[] = 'Ongeldig platformfilter.';
    $platform = '';
}
if ($statusFilter !== '' && !in_array($statusFilter, GAME_STATUSES, true)) {
    $filterErrors[] = 'Ongeldige statusfilter.';
    $statusFilter = '';
}
if ($genre !== '' && !in_array($genre, GAME_GENRES, true)) {
    $filterErrors[] = 'Ongeldig genrefilter.';
    $genre = '';
}
if ($rating !== '' && (!ctype_digit($rating) || (int) $rating < 1 || (int) $rating > 10)) {
    $filterErrors[] = 'Kies een beoordeling van 1 t/m 10.';
    $rating = '';
}
if (mb_strlen($search) > 150) {
    $filterErrors[] = 'De zoekterm mag maximaal 150 tekens bevatten.';
    $search = mb_substr($search, 0, 150);
}

$conditions = [];
$parameters = [];
foreach ([
    'platform' => $platform,
    'genre' => $genre,
    'rating' => $rating,
] as $field => $value) {
    if ($value !== '') {
        $conditions[] = "{$field} = :{$field}";
        $parameters[$field] = $field === 'rating' ? (int) $value : $value;
    }
    if ($activeStatus !== '') {
        $conditions[] = 'status = :nav_status';
        $parameters['nav_status'] = $activeStatus;
    }
    if ($statusFilter !== '') {
        $conditions[] = 'status = :status_filter';
        $parameters['status_filter'] = $statusFilter;
    }
}
if ($search !== '') {
    $conditions[] = 'name LIKE :search';
    $parameters['search'] = '%' . $search . '%';
}

$sql = 'SELECT * FROM games';
if ($conditions !== []) {
    $sql .= ' WHERE ' . implode(' AND ', $conditions);
}
$sql .= ' ORDER BY name ASC, release_year DESC';
$statement = $pdo->prepare($sql);
$statement->execute($parameters);
$games = $statement->fetchAll();

$pageTitle = $activeStatus !== '' ? $activeStatus : 'All Games';
$homeUrl = 'index.php';
$createUrl = 'games/create.php';
$cssPath = 'css/style.css';
$jsPath = 'js/app.js';
$flashMessage = take_flash_message();
require __DIR__ . '/includes/header.php';
?>
        <div class="page-content">
            <?php if ($flashMessage !== null): ?>
                <p class="notice notice-success" role="status"><?= escape_html($flashMessage) ?></p>
            <?php endif; ?>

            <?php foreach ($filterErrors as $error): ?>
                <p class="notice notice-error" role="alert"><?= escape_html($error) ?></p>
            <?php endforeach; ?>

            <form class="filter-bar" method="get" action="index.php">
                <?php if ($activeStatus !== ''): ?>
                    <input type="hidden" name="status" value="<?= escape_html($activeStatus) ?>">
                <?php endif; ?>
                <label class="sr-only" for="filter-platform">Platform</label>
                <select id="filter-platform" name="platform">
                    <option value="">All Platforms</option>
                    <?php foreach (GAME_PLATFORMS as $option): ?>
                        <option value="<?= escape_html($option) ?>"<?= $platform === $option ? ' selected' : '' ?>><?= escape_html($option) ?></option>
                    <?php endforeach; ?>
                </select>
                <label class="sr-only" for="filter-genre">Genre</label>
                <select id="filter-genre" name="genre">
                    <option value="">All Genres</option>
                    <?php foreach (GAME_GENRES as $option): ?>
                        <option value="<?= escape_html($option) ?>"<?= $genre === $option ? ' selected' : '' ?>><?= escape_html($option) ?></option>
                    <?php endforeach; ?>
                </select>
                <label class="sr-only" for="filter-status">Status</label>
                <select id="filter-status" name="status">
                    <option value="">All Statuses</option>
                    <?php foreach (GAME_STATUSES as $option): ?>
                        <option value="<?= escape_html($option) ?>"<?= $statusFilter === $option ? ' selected' : '' ?>><?= escape_html($option) ?></option>
                    <?php endforeach; ?>
                </select>
                <label class="sr-only" for="filter-rating">Beoordeling</label>
                <select id="filter-rating" name="rating">
                    <option value="">All Ratings</option>
                    <?php for ($score = 10; $score >= 1; $score--): ?>
                        <option value="<?= $score ?>"<?= $rating === (string) $score ? ' selected' : '' ?>><?= $score ?>/10</option>
                    <?php endfor; ?>
                </select>
                <label class="sr-only" for="filter-search">Zoeken op naam</label>
                <input id="filter-search" name="search" type="search" maxlength="150" value="<?= escape_html($search) ?>" placeholder="Search games...">
                <button class="filter-submit" type="submit"><i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i> Filter</button>
                <a class="reset-button" href="index.php">Reset Filters</a>
                <span class="game-total"><?= count($games) ?> <?= count($games) === 1 ? 'game' : 'games' ?></span>
            </form>

            <section class="game-grid" aria-label="Gamebibliotheek">
                <?php if ($games === []): ?>
                    <p class="empty-state">Geen games gevonden. Pas je filters aan of voeg een game toe.</p>
                <?php endif; ?>
                <?php foreach ($games as $game): ?>
                    <?php $detailsUrl = 'games/details.php?id=' . (int) $game['id']; ?>
                    <article class="game-card">
                        <a class="cover-link" href="<?= escape_html($detailsUrl) ?>" aria-label="Bekijk <?= escape_html($game['name']) ?>">
                            <img class="cover" src="<?= escape_html($game['image_url']) ?>" alt="Cover van <?= escape_html($game['name']) ?>" loading="lazy">
                        </a>
                        <div class="game-info">
                            <h2><a href="<?= escape_html($detailsUrl) ?>"><?= escape_html($game['name']) ?></a></h2>
                            <p><?= escape_html($game['platform']) ?> · <?= escape_html($game['genre']) ?></p>
                            <time datetime="<?= (int) $game['release_year'] ?>"><?= (int) $game['release_year'] ?></time>
                            <div class="game-card-footer">
                                <span class="status-badge"><?= escape_html($game['status']) ?></span>
                                <span class="game-rating" aria-label="Beoordeling <?= (int) $game['rating'] ?> uit 10"><i class="fa-solid fa-star" aria-hidden="true"></i> <?= (int) $game['rating'] ?>/10</span>
                            </div>
                            <div class="card-actions">
                                <a href="games/edit.php?id=<?= (int) $game['id'] ?>">Bewerken</a>
                                <a href="games/delete.php?id=<?= (int) $game['id'] ?>">Verwijderen</a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </section>
        </div>
<?php require __DIR__ . '/includes/footer.php'; ?>
