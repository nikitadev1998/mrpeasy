<?php

use WebApp\Models\LoginForm;


/* @var $username string */
/* @var $errorMessage string */
/* @var $password string */
?>

<div class="wrapper">

    <?php if (!empty($errorMessage)): ?>
        Error: <?= $errorMessage ?>
    <?php endif; ?>

    <form method="post" class="login">
        <p class="title">Log in</p>
        <input class="field" type="text" id="username" name="username"
               placeholder="<?= LoginForm::attributeLabels()['username'] ?>" autofocus required/>
        <i class="bi-person-fill"></i>
        <input class="field" type="password" id="password" name="password"
               placeholder="<?= LoginForm::attributeLabels()['password'] ?>" required/>
        <i class="bi-lock"></i>
        <input class="button" type="submit" value="Log in"/>
    </form>
    </p>
</div>

