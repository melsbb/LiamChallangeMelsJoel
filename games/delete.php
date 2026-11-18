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

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!valid_csrf_token($_POST['csrf_token'] ?? null)) {
        http_response_code(403);
        $errors[] = 'Het formulier is verlopen. Vernieuw de pagina en probeer het opnieuw.';
    } elseif (request_string($_POST, 'confirmation') !== 'yes') {
        header('Location: details.php?id=' . $id);
        exit;
    } else {
        $statement = $pdo->prepare('DELETE FROM games WHERE id = :id');
        $statement->execute(['id' => $id]);
        set_flash_message('De game is verwijderd.');
        header('Location: ../index.php');
        exit;
    }
}

$statusCounts = game_status_counts($pdo);
$activeStatus = null;
$pageTitle = 'Game verwijderen';
$homeUrl = '../index.php';
$createUrl = 'create.php';
$cssPath = '../css/style.css';
$jsPath = '../js/app.js';
require __DIR__ . '/../includes/header.php';
?>
        <div class="page-content form-page">
            <section class="form-panel confirmation-panel">
                <h2>Game verwijderen</h2>
                <?php foreach ($errors as $error): ?>
                    <p class="notice notice-error" role="alert"><?= escape_html($error) ?></p>
                <?php endforeach; ?>
                <p>Weet je zeker dat je <strong><?= escape_html($game['name']) ?></strong> wilt verwijderen?</p>
                <form method="post" action="delete.php?id=<?= $id ?>">
                    <input type="hidden" name="csrf_token" value="<?= escape_html(csrf_token()) ?>">
                    <div class="form-actions">
                        <button class="danger-button" type="submit" name="confirmation" value="yes">Ja, verwijderen</button>
                        <a class="secondary-button" href="details.php?id=<?= $id ?>">Annuleren</a>
                    </div>
                </form>
            </section>
        </div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
