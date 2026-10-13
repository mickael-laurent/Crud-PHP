<?php
declare(strict_types=1);

require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/layout.php';
require_login();

$data = contact_input([]);
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $data = contact_input($_POST);
    $errors = validate_contact($data);

    if (!$errors) {
        $statement = db()->prepare(
            'INSERT INTO contacts (name, firstname, age, tel, email, pays, comment, metier, url)
             VALUES (:name, :firstname, :age, :tel, :email, :pays, :comment, :metier, :url)'
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
        ]);
        redirect('index.php?saved=1');
    }
}

page_header('Ajouter un contact');
?>
<section class="panel">
    <h1>Ajouter un contact</h1>
    <p class="muted">Les champs marqués d’un astérisque sont obligatoires.</p>
    <form method="post">
        <?php require __DIR__ . '/contact_form.php'; ?>
        <div class="actions">
            <button class="button" type="submit">Enregistrer</button>
            <a class="button secondary" href="index.php">Annuler</a>
        </div>
    </form>
</section>
<?php page_footer(); ?>
