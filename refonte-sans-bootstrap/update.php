<?php
declare(strict_types=1);

// Compatibilite pour les anciens liens : la modification est geree par edit.php.
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
if (!$id) {
    header('Location: index.php');
    exit;
}
header('Location: edit.php?id=' . $id);
exit;
