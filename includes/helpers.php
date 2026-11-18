<?php
declare(strict_types=1);

const GAME_PLATFORMS = ['PC', 'PlayStation', 'Xbox', 'Nintendo Switch'];
const GAME_GENRES = [
    'Action',
    'Action-Adventure',
    'Adventure',
    'Battle Royale',
    'RPG',
    'Sandbox',
    'Shooter',
    'Strategy',
    'Other',
];
const GAME_STATUSES = ['Wishlist', 'In bezit', 'Speelt nu', 'Uitgespeeld'];

function escape_html(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function request_string(array $input, string $key): string
{
    $value = $input[$key] ?? '';

    return is_string($value) || is_numeric($value) ? trim((string) $value) : '';
}

function csrf_token(): string
{
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function valid_csrf_token(mixed $token): bool
{
    return is_string($token)
        && isset($_SESSION['csrf_token'])
        && hash_equals($_SESSION['csrf_token'], $token);
}

function set_flash_message(string $message): void
{
    $_SESSION['flash_message'] = $message;
}

function take_flash_message(): ?string
{
    if (!isset($_SESSION['flash_message'])) {
        return null;
    }

    $message = (string) $_SESSION['flash_message'];
    unset($_SESSION['flash_message']);

    return $message;
}

function game_status_counts(PDO $pdo): array
{
    $counts = array_fill_keys(GAME_STATUSES, 0);
    $statement = $pdo->query('SELECT status, COUNT(*) AS game_count FROM games GROUP BY status');

    foreach ($statement->fetchAll() as $row) {
        $counts[$row['status']] = (int) $row['game_count'];
    }

    return $counts;
}

function find_game(PDO $pdo, int $id): ?array
{
    $statement = $pdo->prepare('SELECT * FROM games WHERE id = :id');
    $statement->execute(['id' => $id]);
    $game = $statement->fetch();

    return $game === false ? null : $game;
}

function game_id_from_request(): ?int
{
    $value = $_GET['id'] ?? null;
    if (!is_string($value) && !is_int($value)) {
        return null;
    }

    $id = filter_var($value, FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 1],
    ]);

    return $id === false ? null : $id;
}

function validate_game_input(array $input): array
{
    $values = [
        'name' => request_string($input, 'name'),
        'image_url' => request_string($input, 'image_url'),
        'platform' => request_string($input, 'platform'),
        'genre' => request_string($input, 'genre'),
        'release_year' => request_string($input, 'release_year'),
        'status' => request_string($input, 'status'),
        'rating' => request_string($input, 'rating'),
    ];
    $errors = [];

    if ($values['name'] === '' || mb_strlen($values['name']) > 150) {
        $errors[] = 'Vul een naam van maximaal 150 tekens in.';
    }

    if (
        $values['image_url'] === ''
        || mb_strlen($values['image_url']) > 2048
        || filter_var($values['image_url'], FILTER_VALIDATE_URL) === false
        || !in_array(strtolower((string) parse_url($values['image_url'], PHP_URL_SCHEME)), ['http', 'https'], true)
    ) {
        $errors[] = 'Vul een geldige afbeeldings-URL in die met http:// of https:// begint.';
    }

    if (!in_array($values['platform'], GAME_PLATFORMS, true)) {
        $errors[] = 'Kies een geldig platform.';
    }

    if (!in_array($values['genre'], GAME_GENRES, true)) {
        $errors[] = 'Kies een geldig genre.';
    }

    $year = filter_var($values['release_year'], FILTER_VALIDATE_INT);
    if ($year === false || $year < 1950 || $year > (int) date('Y') + 5) {
        $errors[] = 'Vul een geldig releasejaar in.';
    }

    if (!in_array($values['status'], GAME_STATUSES, true)) {
        $errors[] = 'Kies een geldige status.';
    }

    $rating = filter_var($values['rating'], FILTER_VALIDATE_INT);
    if ($rating === false || $rating < 1 || $rating > 10) {
        $errors[] = 'De beoordeling moet een heel cijfer van 1 t/m 10 zijn.';
    }

    return [$values, $errors];
}

function game_name_year_exists(PDO $pdo, string $name, int $year, ?int $exceptId = null): bool
{
    $sql = 'SELECT id FROM games WHERE name = :name AND release_year = :release_year';
    $parameters = ['name' => $name, 'release_year' => $year];

    if ($exceptId !== null) {
        $sql .= ' AND id <> :id';
        $parameters['id'] = $exceptId;
    }

    $statement = $pdo->prepare($sql);
    $statement->execute($parameters);

    return $statement->fetch() !== false;
}

function is_duplicate_key_error(PDOException $error): bool
{
    return isset($error->errorInfo[1]) && (int) $error->errorInfo[1] === 1062;
}
