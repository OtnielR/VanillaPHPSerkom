<?php

/** @var mysqli_result|null $foods */

?>

<div class="table-container">
    <?php if (isset($foods) && $foods->num_rows > 0) : ?>
        <table>
            <thead>
                <tr>
                    <td>No</td>
                    <td>Name</td>
                    <td>Category</td>
                    <td>Price</td>
                    <td>Description</td>
                    <td>Image</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody>
                <?php
                $index = 1;

                while ($row = $foods->fetch_assoc()):
                ?>
                    <tr>
                        <td>
                            <?= $index++ ?>
                        </td>
                        <td>
                            <b>
                                <?= $row["name"] ?>
                            </b>
                        </td>

                        <td>
                            <?= strtoupper(substr($row["category"], 0, 1)) . substr($row["category"], 1) ?>
                        </td>
                        <td>
                            <p>
                                <?= "Rp. " . $row["price"] ?>
                            </p>
                        </td>

                        <td>
                            <?= $row["description"] ?>
                        </td>
                        <td class="img">
                            <img src="<?= __BASEURL__ . $row['image'] ?>" alt="">
                        </td>
                        <td>
                            <div class="table-action">
                                <a class="table-action-delete"
                                    href="<?= __BASEURL__ . '/view/dashboard/food-delete.php?food_id=' . $row['id'] ?>">Delete
                                </a>
                                <a class="table-action-update"
                                    href="<?= __BASEURL__ . '/view/dashboard/food-form.php?food_id=' . $row['id'] ?>&method=update">Update
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>

            </tbody>
        </table>
    <?php else: ?>
        <div>
            <p>No Foods Found</p>
        </div>

    <?php endif ?>
</div>
