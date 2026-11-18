<?php
$navigation = [
    ['label' => 'All Games', 'status' => null, 'icon' => 'fa-solid fa-gamepad'],
    ['label' => 'Wishlist', 'status' => 'Wishlist', 'icon' => 'fa-regular fa-heart'],
    ['label' => 'In bezit', 'status' => 'In bezit', 'icon' => 'fa-solid fa-box-open'],
    ['label' => 'Speelt nu', 'status' => 'Speelt nu', 'icon' => 'fa-solid fa-play'],
    ['label' => 'Uitgespeeld', 'status' => 'Uitgespeeld', 'icon' => 'fa-solid fa-circle-check'],
];
$activeStatus = $activeStatus ?? null;
$createUrl = $createUrl ?? 'games/create.php';
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= escape_html($pageTitle) ?> | GameSpark</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="<?= escape_html($cssPath ?? 'css/style.css') ?>">
    <script src="<?= escape_html($jsPath ?? 'js/app.js') ?>" defer></script>
</head>
<body>
    <aside class="sidebar" aria-label="Gamefilters">
        <a class="brand" href="<?= escape_html($homeUrl) ?>">GameSpark</a>
        <nav class="sidebar-nav">
            <?php foreach ($navigation as $item): ?>
                <?php
                $isActive = $item['status'] === $activeStatus;
                $href = $homeUrl;
                if ($item['status'] !== null) {
                    $href .= '?' . http_build_query(['status' => $item['status']]);
                }
                $count = $item['status'] === null
                    ? array_sum($statusCounts)
                    : ($statusCounts[$item['status']] ?? 0);
                ?>
                <a class="nav-item<?= $isActive ? ' active' : '' ?>" href="<?= escape_html($href) ?>"<?= $isActive ? ' aria-current="page"' : '' ?>>
                    <span class="nav-icon" aria-hidden="true"><i class="<?= escape_html($item['icon']) ?>"></i></span>
                    <span class="nav-label"><?= escape_html($item['label']) ?></span>
                    <span class="nav-count"><?= (int) $count ?></span>
                </a>
            <?php endforeach; ?>
        </nav>
    </aside>
    <main class="main-content">
        <header class="page-header">
            <h1><?= escape_html($pageTitle) ?></h1>
            <a class="add-game-link" href="<?= escape_html($createUrl) ?>"><i class="fa-solid fa-plus" aria-hidden="true"></i> Game toevoegen</a>
        </header>
