<?php
// @var string $title
// @var string $type
// @var string $error
?>

<form action="" method="post">
    <?php if (isset($title)): ?>
        <div class="form-title">
            <h3>
                <?= $title ?>
            </h3>
        </div>

    <?php endif ?>
    <?php if (isset($type) && $type === "register"): ?>
        <div>
            <label for="username">Username: </label>
            <br>
            <input type="text" name="username" required>
        </div>

    <?php endif ?>
    <div>
        <label for="email">Email: </label>
        <br>
        <input type="email" name="email" required>
    </div>
    <div>
        <label for="password">Password: </label>
        <br>
        <input type="password" name="password" required>
    </div>

    <?php if (isset($type) && $type === "register"): ?>
        <div>
            <label for="role">Role: </label>
            <br>
            <select type="text" name="role" required>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>
        </div>

    <?php endif ?>
    <div>
        <button type="submit">Submit</button>
    </div>
    <?php if (isset($error)): ?>
        <div class="error-message">
            <p>
                <?= $error ?>
            </p>
        </div>
    <?php endif ?>
</form>
