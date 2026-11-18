# GameSpark

GameSpark is a small PHP and MySQL game library. It supports adding, viewing, editing, and deleting games, plus filters for platform, genre, status, and rating.

## Local setup with Herd

1. Start the local MySQL service in Herd/DBngin.
2. Run `database.sql` once in your MySQL client. It creates the `gamespark` database and `games` table and adds example games.
3. By default, `database.php` connects to `127.0.0.1:3306` as the local `root` user with no password. For another local setup, configure `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` in the PHP environment.
4. Open the project through its Herd site.

The default database credentials are for local development only. Use a dedicated database user and a password outside a local development environment.

## Safety and validation

- Database reads and writes use PDO prepared statements.
- User-provided text and URLs are escaped before they are rendered in HTML.
- Create, edit, and delete forms use session-based CSRF tokens.
- Server-side validation enforces allowed platforms, genres, statuses, years, and ratings.
- The database has a unique constraint on game name and release year.
