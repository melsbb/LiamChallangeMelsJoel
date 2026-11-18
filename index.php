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
                <span class="nav-count">70</span>
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