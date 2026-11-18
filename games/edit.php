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
$pageTitle = 'Game bewerken';
$homeUrl = '../index.php';
$createUrl = 'create.php';
$cssPath = '../css/style.css';
$jsPath = '../js/app.js';
$values = [
    'name' => (string) $game['name'],
    'image_url' => (string) $game['image_url'],
    'platform' => (string) $game['platform'],
    'genre' => (string) $game['genre'],
    'release_year' => (string) $game['release_year'],
    'status' => (string) $game['status'],
    'rating' => (string) $game['rating'],
];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    [$values, $errors] = validate_game_input($_POST);

    if (!valid_csrf_token($_POST['csrf_token'] ?? null)) {
        http_response_code(403);
        $errors[] = 'Het formulier is verlopen. Probeer het opnieuw.';
    } elseif ($errors === []) {
        $year = (int) $values['release_year'];
        if (game_name_year_exists($pdo, $values['name'], $year, $id)) {
            $errors[] = 'Er bestaat al een andere game met deze naam en dit releasejaar.';
        } else {
            $statement = $pdo->prepare(
                'UPDATE games
                 SET name = :name, image_url = :image_url, platform = :platform, genre = :genre,
                     release_year = :release_year, status = :status, rating = :rating
                 WHERE id = :id'
            );

            try {
                $statement->execute([
                    'name' => $values['name'],
                    'image_url' => $values['image_url'],
                    'platform' => $values['platform'],
                    'genre' => $values['genre'],
                    'release_year' => $year,
                    'status' => $values['status'],
                    'rating' => (int) $values['rating'],
                    'id' => $id,
                ]);
                set_flash_message('De game is aangepast.');
                header('Location: details.php?id=' . $id);
                exit;
            } catch (PDOException $error) {
                if (is_duplicate_key_error($error)) {
                    $errors[] = 'Er bestaat al een andere game met deze naam en dit releasejaar.';
                } else {
                    throw $error;
                }
            }
        }
    }
}

require __DIR__ . '/../includes/header.php';
?>
        <div class="page-content form-page">
            <section class="form-panel">
                <h2><?= escape_html($game['name']) aanpassen</h2>
                <p class="form-intro">Pas de gegevens aan en sla je wijzigingen op.</p>
                <?php foreach ($errors as $error): ?>
                    <p class="notice notice-error" role="alert"><?= escape_html($error) ?></p>
                <?php endforeach; ?>
                <form class="game-form" method="post" action="edit.php?id=<?= $id ?>">
                    <input type="hidden" name="csrf_token" value="<?= escape_html(csrf_token()) ?>">
                    <?php require __DIR__ . '/../includes/game-form-fields.php'; ?>
                    <div class="form-actions">
                        <button class="primary-button" type="submit">Opslaan</button>
                        <a class="secondary-button" href="details.php?id=<?= $id ?>">Annuleren</a>
                    </div>
                </form>
            </section>
        </div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
