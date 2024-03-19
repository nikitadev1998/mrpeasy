<?php

use WebApp\Models\LoginForm;

/* @var $username string */
/* @var $errorMessage string */
?>
<!-- The Modal -->

<div id="myModal" class="modal">

    <!-- Modal content -->

    <div class="modal-content">

        <?php if (!empty($errorMessage)): ?>
            <span class="close">&times;</span> Error: <?= $errorMessage ?>
        <?php endif; ?>

        <form method="post">

            <label for="username"><?= LoginForm::attributeLabels()['username'] ?></label>

            <input type="text" id="username" name="username" value="<?= $username ?? '' ?>" required>

            <label for="password"><?= LoginForm::attributeLabels()['password'] ?></label>

            <input type="password" id="password" name="password" value="" required>

            <input  type="submit" value="Login">

        </form>

    </div>

</div>