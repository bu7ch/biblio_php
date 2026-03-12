<!-- src/View/livres/edit.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un livre</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; }
        .container { max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background: #fafafa; }
        h1 { margin-top: 0; color: #333; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input[type="text"], input[type="date"], textarea { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        textarea { height: 100px; }
        .btn { padding: 10px 16px; border: none; border-radius: 5px; cursor: pointer; }
        .btn-primary { background: #007bff; color: white; }
        .btn-secondary { background: #6c757d; color: white; text-decoration: none; display: inline-block; }
        .error { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin-bottom: 20px; }
        .error ul { margin: 0; padding-left: 20px; }
        .small-note { color: #666; font-size: 0.9em; }
    </style>
</head>
<body>
    <div class="container">
        <h1>✏️ Modifier le livre</h1>

        <?php if (!empty($errors)): ?>
        <div class="error">
            <strong>Erreur(s) :</strong>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <?php
        // Déterminer les valeurs à afficher :
        // - Si des données 'old' existent (après une soumission avec erreur), on les utilise.
        // - Sinon, on utilise les données du livre.
        $titreValue = htmlspecialchars($old['titre'] ?? $livre->getTitre() ?? '');
        $auteurValue = htmlspecialchars($old['auteur'] ?? $livre->getAuteur() ?? '');
        $isbnValue = htmlspecialchars($old['isbn'] ?? $livre->getIsbn() ?? '');
        $descriptionValue = htmlspecialchars($old['description'] ?? $livre->getDescription() ?? '');
        $dateValue = $old['date_publication'] ?? ($livre->getDatePublication() ? $livre->getDatePublication()->format('Y-m-d') : '');
        ?>

        <form action="/livres/<?= (int)$livre->getId() ?>/update" method="post">
            <div class="form-group">
                <label for="titre">Titre *</label>
                <input type="text" name="titre" id="titre" 
                       value="<?= $titreValue ?>" required>
            </div>

            <div class="form-group">
                <label for="auteur">Auteur *</label>
                <input type="text" name="auteur" id="auteur" 
                       value="<?= $auteurValue ?>" required>
            </div>

            <div class="form-group">
                <label for="isbn">ISBN</label>
                <input type="text" name="isbn" id="isbn" 
                       value="<?= $isbnValue ?>">
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description"><?= $descriptionValue ?></textarea>
            </div>

            <div class="form-group">
                <label for="date_publication">Date de publication</label>
                <input type="date" name="date_publication" id="date_publication" 
                       value="<?= $dateValue ?>">
                <div class="small-note">Format : AAAA-MM-JJ</div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                <a href="/livres" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</body>
</html>