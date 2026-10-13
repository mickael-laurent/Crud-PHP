<?php
declare(strict_types=1);

function page_header(string $title): void
{
    ?>
    <!doctype html>
    <html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= e($title) ?> — Mon carnet de contacts</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
    <header class="site-header">
        <div class="header-inner">
            <a class="brand" href="index.php">Mon carnet de contacts</a>
            <?php if (function_exists('is_logged_in') && is_logged_in()): ?>
                <nav aria-label="Navigation principale">
                    <a href="index.php">Contacts</a>
                    <a href="add.php">Ajouter</a>
                    <form class="nav-form" action="logout.php" method="post">
                        <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                        <button class="nav-link" type="submit">Déconnexion</button>
                    </form>
                </nav>
            <?php endif; ?>
        </div>
    </header>
    <main class="container">
    <?php
}

function page_footer(): void
{
    ?>
    </main>
    <footer class="site-footer">CRUD PHP — version pédagogique sans framework CSS</footer>
    </body>
    </html>
    <?php
}
