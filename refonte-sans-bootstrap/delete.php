<?php
declare(strict_types=1);

require_once __DIR__ . '/helpers.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    exit('Méthode non autorisée.');
}

verify_csrf();

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
if (!$id || !find_contact($id)) {
    http_response_code(404);
    exit('Contact introuvable.');
}

$statement = db()->prepare('DELETE FROM contacts WHERE id = :id');
$statement->execute(['id' => $id]);

redirect('index.php?deleted=1');
