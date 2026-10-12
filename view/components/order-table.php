<?php

/** @var array $orders */
/** @var mysqli_result|null $category */

?>

<div class="table-container">
    <?php if (isset($orders) && count($orders) > 0) : ?>
        <table>
            <thead>
                <tr>
                    <td>No</td>
                    <td>Customer Name</td>
                    <td>Table Number</td>
                    <td>Total Price</td>
                    <td>Order Details</td>
                    <td>Status</td>
                </tr>
            </thead>
            <tbody>
                <?php
                $index = 1;

                foreach ($orders as $order):
                ?>
                    <tr>
                        <td>
                            <?= $index++ ?>
                        </td>
                        <td>
                            <b>
                                <?= $order["customer_name"] ?>
                            </b>
                        </td>
                        <td>
                            <?= $order["table_number"] ?>
                        </td>
                        <td>
                            Rp.
                            <?= $order["total_price"] ?>
                        </td>
                        <td>
                            <?php $orderDetails = $order["orderDetails"]; ?>
                            <?php if ($order["orderDetails"] && $orderDetails->num_rows > 0) : ?>
                                <?php while ($details = $orderDetails->fetch_assoc()): ?>
                                    <p>-
                                        <?= $details["name"] . " x "  . $details["quantity"] ?>
                                    </p>

                                <?php endwhile; ?>

                            <?php else: ?>
                                <p>No Order Details</p>
                            <?php endif; ?>
                        </td>
                        <td>
                            <form action="?category=<?= $category ?>" method="post">
                                <input type="hidden" name="id" value="<?= $order['id'] ?>">
                                <select name="status" id="status" onchange="this.form.submit()">
                                    <option value="pending" <?= $order["status"] == "pending" ? "selected" : null ?>>Pending
                                    </option>
                                    <option value="diproses" <?= $order["status"] == "diproses" ? "selected" : null ?>>Diproses
                                    </option>
                                    <option value="selesai" <?= $order["status"] == "selesai" ? "selected" : null ?>>Selesai
                                    </option>
                                </select>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    <?php else: ?>
        <div>
            <p>No Orders Found</p>
        </div>

    <?php endif ?>
</div>
