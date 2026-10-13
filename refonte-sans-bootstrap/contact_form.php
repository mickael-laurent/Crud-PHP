<?php
declare(strict_types=1);

/** Partial de formulaire : attend $data et $errors. */
$countries = ['France', 'Royaume-Uni', 'Pays-Bas'];
$jobs = ['dev' => 'Développeur', 'integrateur' => 'Intégrateur', 'reseau' => 'Réseau'];
?>
<input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
<div class="field">
    <label for="name">Nom *</label>
    <input id="name" name="name" maxlength="120" required value="<?= e($data['name'] ?? '') ?>">
    <?php if (isset($errors['name'])): ?><p class="error"><?= e($errors['name']) ?></p><?php endif; ?>
</div>
<div class="field">
    <label for="firstname">Prénom *</label>
    <input id="firstname" name="firstname" maxlength="120" required value="<?= e($data['firstname'] ?? '') ?>">
    <?php if (isset($errors['firstname'])): ?><p class="error"><?= e($errors['firstname']) ?></p><?php endif; ?>
</div>
<div class="field">
    <label for="age">Âge *</label>
    <input id="age" type="number" name="age" min="0" max="120" required value="<?= e($data['age'] ?? '') ?>">
    <?php if (isset($errors['age'])): ?><p class="error"><?= e($errors['age']) ?></p><?php endif; ?>
</div>
<div class="field">
    <label for="tel">Téléphone *</label>
    <input id="tel" type="tel" name="tel" maxlength="30" required value="<?= e($data['tel'] ?? '') ?>">
    <?php if (isset($errors['tel'])): ?><p class="error"><?= e($errors['tel']) ?></p><?php endif; ?>
</div>
<div class="field">
    <label for="email">Adresse e-mail *</label>
    <input id="email" type="email" name="email" maxlength="254" required value="<?= e($data['email'] ?? '') ?>">
    <?php if (isset($errors['email'])): ?><p class="error"><?= e($errors['email']) ?></p><?php endif; ?>
</div>
<div class="field">
    <label for="pays">Pays *</label>
    <select id="pays" name="pays" required>
        <option value="">— Choisir —</option>
        <?php foreach ($countries as $country): ?>
            <option value="<?= e($country) ?>" <?= ($data['pays'] ?? '') === $country ? 'selected' : '' ?>><?= e($country) ?></option>
        <?php endforeach; ?>
    </select>
    <?php if (isset($errors['pays'])): ?><p class="error"><?= e($errors['pays']) ?></p><?php endif; ?>
</div>
<fieldset class="field">
    <legend><strong>Métier *</strong></legend>
    <div class="choice-list">
        <?php foreach ($jobs as $value => $label): ?>
            <label class="choice"><input type="radio" name="metier" value="<?= e($value) ?>" <?= ($data['metier'] ?? '') === $value ? 'checked' : '' ?> required> <?= e($label) ?></label>
        <?php endforeach; ?>
    </div>
    <?php if (isset($errors['metier'])): ?><p class="error"><?= e($errors['metier']) ?></p><?php endif; ?>
</fieldset>
<div class="field">
    <label for="url">Site web (facultatif)</label>
    <input id="url" type="url" name="url" maxlength="2048" placeholder="https://exemple.fr" value="<?= e($data['url'] ?? '') ?>">
    <?php if (isset($errors['url'])): ?><p class="error"><?= e($errors['url']) ?></p><?php endif; ?>
</div>
<div class="field">
    <label for="comment">Commentaire *</label>
    <textarea id="comment" name="comment" maxlength="5000" required><?= e($data['comment'] ?? '') ?></textarea>
    <?php if (isset($errors['comment'])): ?><p class="error"><?= e($errors['comment']) ?></p><?php endif; ?>
</div>
