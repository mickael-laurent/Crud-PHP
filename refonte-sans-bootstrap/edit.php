<?php
declare(strict_types=1);

require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/layout.php';
require_login();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
$contact = $id ? find_contact($id) : null;

if (!$contact) {
    http_response_code(404);
    page_header('Contact introuvable');
    echo '<section class="panel"><h1>Contact introuvable</h1><p>Ce contact n’existe pas ou son identifiant est invalide.</p><a class="button" href="index.php">Retour aux contacts</a></section>';
    page_footer();
    exit;
}

$data = contact_input($contact);
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $data = contact_input($_POST);
    $errors = validate_contact($data);

    if (!$errors) {
        $statement = db()->prepare(
            'UPDATE contacts
             SET name = :name, firstname = :firstname, age = :age, tel = :tel,
                 email = :email, pays = :pays, comment = :comment, metier = :metier, url = :url
             WHERE id = :id'
        );
        $statement->execute([
            'name' => $data['name'],
            'firstname' => $data['firstname'],
            'age' => (int) $data['age'],
            'tel' => $data['tel'],
            'email' => $data['email'],
            'pays' => $data['pays'],
            'comment' => $data['comment'],
            'metier' => $data['metier'],
            'url' => $data['url'] === '' ? null : $data['url'],
            'id' => $id,
        ]);
        redirect('show.php?id=' . $id . '&saved=1');
    }
}

page_header('Modifier un contact');
?>
<section class="panel">
    <h1>Modifier un contact</h1>
    <p class="muted">Les champs marqués d’un astérisque sont obligatoires.</p>
    <form method="post" action="edit.php?id=<?= (int) $id ?>">
        <?php require __DIR__ . '/contact_form.php'; ?>
        <div class="actions">
            <button class="button" type="submit">Enregistrer les modifications</button>
            <a class="button secondary" href="show.php?id=<?= (int) $id ?>">Annuler</a>
        </div>
    </form>
</section>
<?php page_footer(); ?>
