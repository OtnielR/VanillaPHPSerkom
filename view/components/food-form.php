<?php
// @var string $title
// @var string $error
// @var string $method
// @var string $food_id
// @var array $food
?>

<form action="?method=<?= isset($method) ? $method : '' ?>&food_id=<?= isset($food_id) ? $food_id : '' ?>" method="post"
    enctype="multipart/form-data">
    <?php if (isset($title)): ?>
        <div class="form-title">
            <h3>
                <?= $title ?>
            </h3>
        </div>

    <?php endif ?>

    <div>
        <label for="name">Name: </label>
        <br>
        <input type="text" name="name" required value="<?= $food ? $food['name'] : '' ?>">
    </div>
    <div>
        <label for="category">Category: </label>
        <br>
        <select type="text" name="category" required>
            <?php if ($food): ?>
                <option value="makanan" <?= $food["category"] == "makanan" ? 'selected' : '' ?>>Makanan</option>
                <option value="minuman" <?= $food["category"] == "minuman" ? 'selected' : '' ?>>Minuman</option>
                <option value="cemilan" <?= $food["category"] == "cemilan" ? 'selected' : '' ?>>Cemilan</option>
            <?php else: ?>
                <option value="makanan">Makanan</option>
                <option value="minuman">Minuman</option>
                <option value="cemilan">Cemilan</option>

            <?php endif; ?>
        </select>
    </div>
    <div>
        <label for="price">Price: </label>
        <br>
        <input type="number" name="price" required value="<?= $food ? $food['price'] : '' ?>">
    </div>
    <div>
        <label for="description">Description: </label>
        <br>
        <textarea rows="4" name="description" required>
            <?= $food ? htmlspecialchars($food['description']) : '' ?>
        </textarea>
    </div>
    <div>
        <label for="image">Image: </label>
        <br>
        <input type="file" name="image" accept="image/*" required>
    </div>

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
