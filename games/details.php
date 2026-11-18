<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/bootstrap.php';

$pdo = database();
$id = game_id_from_request();
if ($id === null) {
    http_response_code(400);
    exit('Ongeldig game-ID.');
}

$game = find_game($pdo, $id);
if ($game === null) {
    http_response_code(404);
    exit('Game niet gevonden.');
}

$statusCounts = game_status_counts($pdo);
$activeStatus = null;
$pageTitle = (string) $game['name'];
$homeUrl = '../index.php';
$createUrl = 'create.php';
$cssPath = '../css/style.css';
$jsPath = '../js/app.js';
$flashMessage = take_flash_message();
require __DIR__ . '/../includes/header.php';
?>
        <div class="page-content">
            <?php if ($flashMessage !== null): ?>
                <p class="notice notice-success" role="status"><?= escape_html($flashMessage) ?></p>
            <?php endif; ?>
            <article class="details-panel">
                <img class="details-cover" src="<?= escape_html($game['image_url']) ?>" alt="Cover van <?= escape_html($game['name']) ?>">
                <div class="details-content">
                    <h2><?= escape_html($game['name']) ?></h2>
                    <dl class="details-list">
                        <div><dt>Platform</dt><dd><?= escape_html($game['platform']) ?></dd></div>
                        <div><dt>Genre</dt><dd><?= escape_html($game['genre']) ?></dd></div>
                        <div><dt>Releasejaar</dt><dd><?= (int) $game['release_year'] ?></dd></div>
                        <div><dt>Status</dt><dd><span class="status-badge"><?= escape_html($game['status']) ?></span></dd></div>
                        <div><dt>Beoordeling</dt><dd><span class="game-rating"><i class="fa-solid fa-star" aria-hidden="true"></i> <?= (int) $game['rating'] ?>/10</span></dd></div>
                    </dl>
                    <div class="form-actions">
                        <a class="primary-button" href="edit.php?id=<?= $id ?>">Bewerken</a>
                        <a class="danger-button" href="delete.php?id=<?= $id ?>">Verwijderen</a>
                        <a class="secondary-button" href="../index.php">Terug naar overzicht</a>
                    </div>
                </div>
            </article>
        </div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
