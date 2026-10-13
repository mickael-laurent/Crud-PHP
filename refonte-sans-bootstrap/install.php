<?php
declare(strict_types=1);

require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/layout.php';

$count = (int) db()->query('SELECT COUNT(*) FROM users')->fetchColumn();
if ($count > 0) {
    redirect('login.php');
}

$errors = [];
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $username = trim(is_string($_POST['username'] ?? null) ? $_POST['username'] : '');
    $password = is_string($_POST['password'] ?? null) ? $_POST['password'] : '';
    $confirm = is_string($_POST['password_confirm'] ?? null) ? $_POST['password_confirm'] : '';

    if (!preg_match('/^[a-zA-Z0-9_.-]{3,80}$/', $username)) {
        $errors[] = 'Le nom de compte doit contenir 3 à 80 caractères (lettres, chiffres, ., _ ou -).';
    }
    if (strlen($password) < 12) {
        $errors[] = 'Le mot de passe doit contenir au moins 12 caractères.';
    }
    if ($password !== $confirm) {
        $errors[] = 'Les deux mots de passe ne correspondent pas.';
    }

    if (!$errors) {
        try {
            $statement = db()->prepare('INSERT INTO users (username, password_hash) VALUES (:username, :hash)');
            $statement->execute(['username' => $username, 'hash' => password_hash($password, PASSWORD_DEFAULT)]);
            redirect('login.php?created=1');
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
            $errors[] = 'Impossible de créer le compte. Vérifie que l’installation n’a pas déjà été effectuée.';
        }
    }
}

page_header('Créer le premier compte');
?>
<section class="panel" style="max-width:560px;margin:auto">
    <h1>Installation</h1>
    <p class="muted">Crée le premier compte administrateur local. Cet écran se désactive dès qu’un compte existe.</p>
    <?php foreach ($errors as $error): ?><p class="error"><?= e($error) ?></p><?php endforeach; ?>
    <form method="post">
        <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
        <div class="field">
            <label for="username">Nom de compte</label>
            <input id="username" name="username" autocomplete="username" required maxlength="80" value="<?= e($username) ?>">
        </div>
        <div class="field">
            <label for="password">Mot de passe (12 caractères minimum)</label>
            <input id="password" type="password" name="password" autocomplete="new-password" required minlength="12">
        </div>
        <div class="field">
            <label for="password_confirm">Confirmer le mot de passe</label>
            <input id="password_confirm" type="password" name="password_confirm" autocomplete="new-password" required minlength="12">
        </div>
        <button class="button" type="submit">Créer le compte</button>
    </form>
</section>
<?php page_footer(); ?>
