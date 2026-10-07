<?php

// @var $id
// @var $title
// @var $price
// @var $description
// @var $imageUrl
// @var $category
// @var $quantity

?>

<div class="card">
    <div class="food-card-img">
        <img src="<?= $imageUrl ?>" alt="<?= $title ?>">

    </div>
    <div class="food-card-title">
        <h4>
            <?= $title ?>
        </h4>
        <span>
            <?= "Rp. " . $price ?>
        </span>
    </div>

    <div class="food-card-content">
        <p>
            <?= $description ?>
        </p>
    </div>


    <div class="food-card-action">
        <div class="">
            <form action="" method="GET" id="food-card-action">
                <input type="hidden" name="food_id" value="<?= $id ?>">
                <input type="hidden" name="action" value="decrease">
                <button type="submit">-</button>
            </form>
            <div class="food-card-quantity">
                <?= $quantity ?>
            </div>

            <form action="" method="GET" id="food-card-action">
                <input type="hidden" name="food_id" value="<?= $id ?>">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="food_name" value="<?= $title ?>">
                <input type="hidden" name="food_price" value="<?= $price ?>">
                <input type="hidden" name="food_image_url" value="<?= $imageUrl ?>">
                <button type="submit">+</button>
            </form>
        </div>
        <?php if ($quantity > 0) : ?>
            <div>
                <form action="" method="GET" id="food-card-action">
                    <input type="hidden" name="food_id" value="<?= $id ?>">
                    <input type="hidden" name="action" value="remove">
                    <button type="submit" style="background-color: red;">x</button>
                </form>
            </div>

        <?php endif; ?>
    </div>

</div>

</div>
