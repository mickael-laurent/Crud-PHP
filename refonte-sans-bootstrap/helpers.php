<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';

function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function redirect(string $location): never
{
    header('Location: ' . $location);
    exit;
}

function is_logged_in(): bool
{
    return isset($_SESSION['user_id']) && is_int($_SESSION['user_id']);
}

function require_login(): void
{
    if (!is_logged_in()) {
        redirect('login.php');
    }
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function verify_csrf(): void
{
    $sent = $_POST['csrf_token'] ?? '';
    $known = $_SESSION['csrf_token'] ?? '';

    if (!is_string($sent) || !is_string($known) || $known === '' || !hash_equals($known, $sent)) {
        http_response_code(403);
        exit('Formulaire expiré ou invalide. Recharge la page et réessaie.');
    }
}

function find_contact(int $id): ?array
{
    $statement = db()->prepare('SELECT * FROM contacts WHERE id = :id');
    $statement->execute(['id' => $id]);
    $contact = $statement->fetch();

    return $contact ?: null;
}

function contact_input(array $source): array
{
    $fields = ['name', 'firstname', 'age', 'tel', 'email', 'pays', 'comment', 'metier', 'url'];
    $data = [];

    foreach ($fields as $field) {
        $value = $source[$field] ?? '';
        $data[$field] = is_string($value) ? trim($value) : '';
    }

    return $data;
}

function validate_contact(array $data): array
{
    $errors = [];

    if ($data['name'] === '' || mb_strlen($data['name']) > 120) {
        $errors['name'] = 'Le nom est obligatoire (120 caractères maximum).';
    }
    if ($data['firstname'] === '' || mb_strlen($data['firstname']) > 120) {
        $errors['firstname'] = 'Le prénom est obligatoire (120 caractères maximum).';
    }
    if ($data['age'] === '' || filter_var($data['age'], FILTER_VALIDATE_INT) === false
        || (int) $data['age'] < 0 || (int) $data['age'] > 120) {
        $errors['age'] = 'Indique un âge entier entre 0 et 120.';
    }
    if ($data['tel'] === '' || mb_strlen($data['tel']) > 30) {
        $errors['tel'] = 'Le téléphone est obligatoire (30 caractères maximum).';
    }
    if ($data['email'] === '' || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)
        || mb_strlen($data['email']) > 254) {
        $errors['email'] = 'Indique une adresse e-mail valide.';
    }
    if (!in_array($data['pays'], ['France', 'Royaume-Uni', 'Pays-Bas'], true)) {
        $errors['pays'] = 'Choisis un pays dans la liste.';
    }
    if ($data['comment'] === '' || mb_strlen($data['comment']) > 5000) {
        $errors['comment'] = 'Le commentaire est obligatoire (5 000 caractères maximum).';
    }
    if (!in_array($data['metier'], ['dev', 'integrateur', 'reseau'], true)) {
        $errors['metier'] = 'Choisis un métier.';
    }
    if ($data['url'] !== '' && (!filter_var($data['url'], FILTER_VALIDATE_URL)
        || !in_array(strtolower((string) parse_url($data['url'], PHP_URL_SCHEME)), ['http', 'https'], true)
        || mb_strlen($data['url']) > 2048)) {
        $errors['url'] = 'Le site doit être une URL HTTP ou HTTPS valide.';
    }

    return $errors;
}
