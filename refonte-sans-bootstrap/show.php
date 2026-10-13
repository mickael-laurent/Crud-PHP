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

page_header('Détail du contact');
?>
<div class="page-heading">
    <div><h1><?= e($contact['firstname'] . ' ' . $contact['name']) ?></h1><p class="muted">Détail du contact</p></div>
    <a class="button" href="edit.php?id=<?= (int) $contact['id'] ?>">Modifier</a>
</div>
<section class="panel">
    <dl class="detail-grid">
        <div class="detail"><dt>Nom</dt><dd><?= e($contact['name']) ?></dd></div>
        <div class="detail"><dt>Prénom</dt><dd><?= e($contact['firstname']) ?></dd></div>
        <div class="detail"><dt>Âge</dt><dd><?= e($contact['age']) ?></dd></div>
        <div class="detail"><dt>Téléphone</dt><dd><?= e($contact['tel']) ?></dd></div>
        <div class="detail"><dt>E-mail</dt><dd><?= e($contact['email']) ?></dd></div>
        <div class="detail"><dt>Pays</dt><dd><?= e($contact['pays']) ?></dd></div>
        <div class="detail"><dt>Métier</dt><dd><?= e($contact['metier']) ?></dd></div>
        <div class="detail"><dt>Site web</dt><dd><?php if ($contact['url']): ?><a href="<?= e($contact['url']) ?>" target="_blank" rel="noopener noreferrer"><?= e($contact['url']) ?></a><?php else: ?>—<?php endif; ?></dd></div>
        <div class="detail" style="grid-column:1/-1"><dt>Commentaire</dt><dd><?= nl2br(e($contact['comment'])) ?></dd></div>
    </dl>
    <p><a class="button secondary" href="index.php">Retour à la liste</a></p>
</section>
<?php page_footer(); ?>
