<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title><?= $title ?? 'Bibliothèque' ?></title>
    <style>
        body{font-family:Arial;margin:2rem;}
        table{border-collapse:collapse;width:100%;}
        th,td{border:1px solid #ccc;padding:.5rem;}
        th{background:#f5f5f5;}
        a{text-decoration:none;color:#0b5ed7;}
    </style>
</head>
<body>
    <h1><a href="/livres">📚 Bibliothèque</a></h1>
    <?= $content ?>
</body>
</html>