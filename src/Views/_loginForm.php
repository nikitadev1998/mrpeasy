<?php

use WebApp\Models\LoginForm;

/* @var $username string */
/* @var $errorMessage string */
?>
<!-- The Modal -->

<div id="myModal" class="modal">

    <!-- Modal content -->

    <div class="modal-content">

        <span class="close">&times;</span>

        <?php if (!empty($errorMessage)): ?>
            Error: <?= $errorMessage ?>
        <?php endif; ?>

        <form>

            <label for="username"><?= LoginForm::attributeLabels()['username'] ?></label>

            <input type="text" id="username" name="username" value="<?= $username ?>" required>

            <label for="password"><?= LoginForm::attributeLabels()['password'] ?></label>

            <input type="password" id="password" name="password" value="" required>

            <input type="submit" value="Login">

        </form>

    </div>

</div>