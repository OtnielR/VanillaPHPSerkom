<?php

// @var $title string
// @var $categories array
// @var $currentCategory string

?>

<div class="filter">
    <p class="filter-title">
        <?= $title ?>
    </p>
    <div class="filter-nav">

        <div class="<?= !$currentCategory ? 'active' : '' ?>">
            <a href="?">
                All
            </a>
        </div>
        <?php foreach ($categories as $category) : ?>
            <div class="<?= $category == $currentCategory ? 'active' : '' ?>">
                <a href="<?= '?category=' . $category ?>">
                    <?= strtoupper(substr($category, 0, 1)) . substr($category, 1) ?>
                </a>
            </div>

        <?php endforeach; ?>

    </div>

</div>
