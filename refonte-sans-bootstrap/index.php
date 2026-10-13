<?php
declare(strict_types=1);

require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/layout.php';
require_login();

$statement = db()->query('SELECT id, name, firstname, age, tel, email, pays, metier FROM contacts ORDER BY id DESC');
$contacts = $statement->fetchAll();

page_header('Contacts');
?>
<div class="page-heading">
    <div>
        <h1>Contacts</h1>
        <p class="muted"><?= count($contacts) ?> contact<?= count($contacts) > 1 ? 's' : '' ?> enregistré<?= count($contacts) > 1 ? 's' : '' ?>.</p>
    </div>
    <a class="button" href="add.php">+ Ajouter un contact</a>
</div>

<?php if (isset($_GET['saved'])): ?><p class="alert success">Le contact a été enregistré.</p><?php endif; ?>
<?php if (isset($_GET['deleted'])): ?><p class="alert success">Le contact a été supprimé.</p><?php endif; ?>

<?php if (!$contacts): ?>
    <section class="panel empty">
        <h2>Aucun contact pour le moment</h2>
        <p>Ajoute ton premier contact pour tester le CRUD.</p>
        <a class="button" href="add.php">Ajouter un contact</a>
    </section>
<?php else: ?>
    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>Nom</th><th>Prénom</th><th>Âge</th><th>Téléphone</th><th>E-mail</th><th>Pays</th><th>Métier</th><th>Actions</th></tr>
            </thead>
            <tbody>
            <?php foreach ($contacts as $contact): ?>
                <tr>
                    <td><?= e($contact['name']) ?></td>
                    <td><?= e($contact['firstname']) ?></td>
                    <td><?= e($contact['age']) ?></td>
                    <td><?= e($contact['tel']) ?></td>
                    <td><?= e($contact['email']) ?></td>
                    <td><?= e($contact['pays']) ?></td>
                    <td><?= e($contact['metier']) ?></td>
                    <td>
                        <div class="actions">
                            <a class="button secondary small" href="show.php?id=<?= (int) $contact['id'] ?>">Voir</a>
                            <a class="button small" href="edit.php?id=<?= (int) $contact['id'] ?>">Modifier</a>
                            <form method="post" action="delete.php" onsubmit="return confirm('Supprimer ce contact ?');">
                                <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                                <input type="hidden" name="id" value="<?= (int) $contact['id'] ?>">
                                <button class="button danger small" type="submit">Supprimer</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
<?php page_footer(); ?>
