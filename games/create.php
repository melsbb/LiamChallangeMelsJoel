<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/bootstrap.php';

$pdo = database();
$statusCounts = game_status_counts($pdo);
$activeStatus = null;
$pageTitle = 'Game toevoegen';
$homeUrl = '../index.php';
$createUrl = 'create.php';
$cssPath = '../css/style.css';
$jsPath = '../js/app.js';
$values = [
    'name' => '',
    'image_url' => '',
    'platform' => '',
    'genre' => '',
    'release_year' => '',
    'status' => '',
    'rating' => '',
];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    [$values, $errors] = validate_game_input($_POST);

    if (!valid_csrf_token($_POST['csrf_token'] ?? null)) {
        http_response_code(403);
        $errors[] = 'Het formulier is verlopen. Probeer het opnieuw.';
    } elseif ($errors === []) {
        $year = (int) $values['release_year'];
        if (game_name_year_exists($pdo, $values['name'], $year)) {
            $errors[] = 'Er bestaat al een game met deze naam en dit releasejaar.';
        } else {
            $statement = $pdo->prepare(
                'INSERT INTO games (name, image_url, platform, genre, release_year, status, rating)
                 VALUES (:name, :image_url, :platform, :genre, :release_year, :status, :rating)'
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
                ]);
                set_flash_message('De game is toegevoegd.');
                header('Location: ../index.php');
                exit;
            } catch (PDOException $error) {
                if (is_duplicate_key_error($error)) {
                    $errors[] = 'Er bestaat al een game met deze naam en dit releasejaar.';
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
                <h2>Nieuwe game</h2>
                <p class="form-intro">Vul de gegevens van de game in om deze aan je bibliotheek toe te voegen.</p>
                <?php foreach ($errors as $error): ?>
                    <p class="notice notice-error" role="alert"><?= escape_html($error) ?></p>
                <?php endforeach; ?>
                <form class="game-form" method="post" action="create.php">
                    <input type="hidden" name="csrf_token" value="<?= escape_html(csrf_token()) ?>">
                    <?php require __DIR__ . '/../includes/game-form-fields.php'; ?>
                    <div class="form-actions">
                        <button class="primary-button" type="submit">Toevoegen</button>
                        <a class="secondary-button" href="../index.php">Annuleren</a>
                    </div>
                </form>
            </section>
        </div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
