<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail du livre : <?= htmlspecialchars($livre->getTitre()) ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; }
        .container { max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px; }
        .field { margin-bottom: 15px; }
        .field label { font-weight: bold; display: block; margin-bottom: 5px; }
        .field .value { padding: 8px; background: #f9f9f9; border-radius: 3px; }
        .actions { margin-top: 20px; }
        .btn { display: inline-block; padding: 8px 12px; text-decoration: none; border-radius: 4px; }
        .btn-back { background: #6c757d; color: white; }
        .btn-edit { background: #007bff; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Détail du livre</h1>

        <div class="field">
            <label>Titre :</label>
            <div class="value"><?= htmlspecialchars($livre->getTitre()) ?></div>
        </div>

        <div class="field">
            <label>Auteur :</label>
            <div class="value"><?= htmlspecialchars($livre->getAuteur()) ?></div>
        </div>

        <?php if ($livre->getIsbn()): ?>
        <div class="field">
            <label>ISBN :</label>
            <div class="value"><?= htmlspecialchars($livre->getIsbn()) ?></div>
        </div>
        <?php endif; ?>

        <?php if ($livre->getDescription()): ?>
        <div class="field">
            <label>Description :</label>
            <div class="value"><?= nl2br(htmlspecialchars($livre->getDescription())) ?></div>
        </div>
        <?php endif; ?>

        <?php if ($livre->getDatePublication()): ?>
        <div class="field">
            <label>Date de publication :</label>
            <div class="value"><?= htmlspecialchars($livre->getDatePublication()->format('d/m/Y')) ?></div>
        </div>
        <?php endif; ?>

        <div class="field">
            <label>Identifiant (ID) :</label>
            <div class="value"><?= (int)$livre->getId() ?></div>
        </div>

        <div class="actions">
            <a href="/livres" class="btn btn-back">← Retour à la liste</a>
            <a href="/livres/edit/<?= $livre->getId() ?>" class="btn btn-edit">✏️ Modifier ce livre</a>
        </div>
    </div>
</body>
</html>