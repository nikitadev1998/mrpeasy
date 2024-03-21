<?php

use WebApp\Database;

require '../vendor/autoload.php';

Database::init();
if (!isset($_SESSION)) {
    session_start();
}

?>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/error.css">
    <link rel="stylesheet" href="css/style.css?<?= time() ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
    <a href="/" class="">
        <img class="bi" width="200" height="32" aria-label="Bootstrap" src="mrpeasy-logo.svg"/>
    </a>
    <?php if (isset($_SESSION['username'])): ?>
        <div class="col-md-3 text-end" style="justify-content: end;display: flex; align-items: center">
            <b class="m-2"><?= $_SESSION['username'] ?></b>
            <a href="logout" type="button" class="btn btn-primary me-2">Exit</a>
        </div>
    <?php endif; ?>
</header>
</body>
<?php $router = require '../src/Routes/index.php'; ?>
<footer></footer>
