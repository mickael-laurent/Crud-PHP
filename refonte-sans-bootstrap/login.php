<?php
declare(strict_types=1);

require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/layout.php';

if (is_logged_in()) {
    redirect('index.php');
}

$hasUsers = (int) db()->query('SELECT COUNT(*) FROM users')->fetchColumn() > 0;
$errors = [];
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $username = trim(is_string($_POST['username'] ?? null) ? $_POST['username'] : '');
    $password = is_string($_POST['password'] ?? null) ? $_POST['password'] : '';

    if ($username === '' || $password === '') {
        $errors[] = 'Saisis ton nom de compte et ton mot de passe.';
    } else {
        $statement = db()->prepare('SELECT id, username, password_hash FROM users WHERE username = :username');
        $statement->execute(['username' => $username]);
        $user = $statement->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = (int) $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            redirect('index.php');
        }

        $errors[] = 'Nom de compte ou mot de passe incorrect.';
    }
}

page_header('Connexion');
?>
<section class="panel" style="max-width:520px;margin:auto">
    <h1>Connexion</h1>
    <?php if (isset($_GET['created'])): ?><p class="alert success">Compte créé. Tu peux maintenant te connecter.</p><?php endif; ?>
    <?php if (!$hasUsers): ?>
        <p>Aucun compte n’existe encore. <a href="install.php">Créer le premier compte</a>.</p>
    <?php else: ?>
        <?php foreach ($errors as $error): ?><p class="error"><?= e($error) ?></p><?php endforeach; ?>
        <form method="post">
            <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
            <div class="field">
                <label for="username">Nom de compte</label>
                <input id="username" name="username" autocomplete="username" required value="<?= e($username) ?>">
            </div>
            <div class="field">
                <label for="password">Mot de passe</label>
                <input id="password" type="password" name="password" autocomplete="current-password" required>
            </div>
            <button class="button" type="submit">Se connecter</button>
        </form>
    <?php endif; ?>
</section>
<?php page_footer(); ?>
