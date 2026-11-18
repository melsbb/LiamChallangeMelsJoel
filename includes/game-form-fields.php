<div class="form-field">
    <label for="name">Naam</label>
    <input id="name" name="name" type="text" maxlength="150" value="<?= escape_html($values['name']) ?>" required>
</div>
<div class="form-field">
    <label for="image_url">Afbeelding-URL</label>
    <input id="image_url" name="image_url" type="url" maxlength="2048" placeholder="https://voorbeeld.nl/cover.jpg" value="<?= escape_html($values['image_url']) ?>" required>
</div>
<div class="form-row">
    <div class="form-field">
        <label for="platform">Platform</label>
        <select id="platform" name="platform" required>
            <option value="">Kies een platform</option>
            <?php foreach (GAME_PLATFORMS as $platform): ?>
                <option value="<?= escape_html($platform) ?>"<?= $values['platform'] === $platform ? ' selected' : '' ?>><?= escape_html($platform) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-field">
        <label for="genre">Genre</label>
        <select id="genre" name="genre" required>
            <option value="">Kies een genre</option>
            <?php foreach (GAME_GENRES as $genre): ?>
                <option value="<?= escape_html($genre) ?>"<?= $values['genre'] === $genre ? ' selected' : '' ?>><?= escape_html($genre) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<div class="form-row">
    <div class="form-field">
        <label for="release_year">Releasejaar</label>
        <input id="release_year" name="release_year" type="number" min="1950" max="<?= (int) date('Y') + 5 ?>" value="<?= escape_html($values['release_year']) ?>" required>
    </div>
    <div class="form-field">
        <label for="status">Status</label>
        <select id="status" name="status" required>
            <option value="">Kies een status</option>
            <?php foreach (GAME_STATUSES as $status): ?>
                <option value="<?= escape_html($status) ?>"<?= $values['status'] === $status ? ' selected' : '' ?>><?= escape_html($status) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<div class="form-field">
    <label for="rating">Beoordeling (1-10)</label>
    <input id="rating" name="rating" type="number" min="1" max="10" step="1" value="<?= escape_html($values['rating']) ?>" required>
</div>
