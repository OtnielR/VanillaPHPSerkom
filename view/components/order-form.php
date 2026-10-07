<?php
// @var $foodOrders array

$totalPrice = 0;

?>

<form class="order-form" action="" method="post">

    <div class="order">

        <h3 class="order-title">Orders</h3>
        <div class="order-input">
            <label for="name">Name:</label>
            <input type="text" name="name" required />
        </div>
        <div class="order-input">
            <label for="table_number">Table Number:</label>
            <input type="text" name="table_number" required />
        </div>

        <?php foreach ($foodOrders as $id => $food): ?>
            <?php $totalPrice += $food["quantity"] * $food["price"] ?>
            <div class="order-card">
                <div class="order-card-detail">
                    <div class="order-card-image">
                        <img src="<?= $food['image_url'] ?>" alt="<?= $food['name'] ?>">
                    </div>
                    <div>
                        <h3>
                            <?= $food["name"] ?>
                        </h3>
                        <span>
                            Rp.
                            <?= $food["price"] ?> x <b>
                                <?= $food["quantity"] ?>
                            </b>
                        </span>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
        <div class="order-result">
            <p>Total:</p>
            <span><b>
                    Rp.
                    <?= $totalPrice ?>
                </b></span>
        </div>
    </div>
    <div class="hidden-input">
        <input type="hidden" name="total_price" value="<?= $totalPrice ?>">
    </div>

    <button type="submit">Confirm Order</button>
</form>
