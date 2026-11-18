CREATE DATABASE IF NOT EXISTS gamespark
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE gamespark;

CREATE TABLE IF NOT EXISTS games (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(150) NOT NULL,
    image_url VARCHAR(2048) NOT NULL,
    platform VARCHAR(50) NOT NULL,
    genre VARCHAR(50) NOT NULL,
    release_year SMALLINT UNSIGNED NOT NULL,
    status ENUM('Wishlist', 'In bezit', 'Speelt nu', 'Uitgespeeld') NOT NULL,
    rating TINYINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY unique_game_name_year (name, release_year),
    KEY games_platform_idx (platform),
    KEY games_genre_idx (genre),
    KEY games_status_idx (status),
    KEY games_rating_idx (rating),
    CONSTRAINT games_rating_range CHECK (rating BETWEEN 1 AND 10)
) ENGINE=InnoDB;

INSERT IGNORE INTO games (name, image_url, platform, genre, release_year, status, rating) VALUES
    ('Minecraft', 'https://store-images.s-microsoft.com/image/apps.60323.14294656681058683.4d17bdd8-7026-429a-846f-cf7836bc9e56.a69e6905-8926-4a48-b243-14a039b97aae?mode=scale&q=90&h=1080&w=1920&format=jpg', 'PC', 'Sandbox', 2011, 'Uitgespeeld', 9),
    ('GTA V', 'https://thumb.wikimedia.org/wikipedia/en/thumb/a/a5/Grand_Theft_Auto_V.png/250px-Grand_Theft_Auto_V.png', 'PlayStation', 'Action', 2013, 'In bezit', 8),
    ('Fortnite', 'https://gmedia.playstation.com/is/image/SIEPDC/fortnite-keyart-01-en-30nov23?$facebook$', 'PC', 'Battle Royale', 2017, 'Speelt nu', 7),
    ('Red Dead Redemption 2', 'https://thumb.wikimedia.org/wikipedia/en/thumb/4/44/Red_Dead_Redemption_II.jpg/250px-Red_Dead_Redemption_II.jpg', 'PlayStation', 'Action-Adventure', 2018, 'Wishlist', 10),
    ('Call of Duty: Modern Warfare III', 'https://thumb.wikimedia.org/wikipedia/en/thumb/f/f6/MWIII_Cover_Art.png/250px-MWIII_Cover_Art.png', 'Xbox', 'Shooter', 2023, 'In bezit', 8),
    ('Assassin''s Creed IV: Black Flag', 'https://thumb.wikimedia.org/wikipedia/en/thumb/2/28/Assassin%27s_Creed_IV_-_Black_Flag_cover.jpg/250px-Assassin%27s_Creed_IV_-_Black_Flag_cover.jpg', 'PC', 'Action-Adventure', 2013, 'Uitgespeeld', 9);
