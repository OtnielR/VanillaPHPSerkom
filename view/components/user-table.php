<?php

/** @var mysqli_result|null $users */
?>

<div class="table-container">
    <?php if (isset($users) && $users->num_rows > 0) : ?>
        <table>
            <thead>
                <tr>
                    <td>No</td>
                    <td>Username</td>
                    <td>Email</td>
                    <td>Role</td>
                    <td>action</td>
                </tr>
            </thead>
            <tbody>
                <?php
                $index = 1;

                while ($row = $users->fetch_assoc()):
                ?>
                    <tr>
                        <td>
                            <?= $index++ ?>
                        </td>
                        <td>
                            <b>
                                <?= $row["username"] ?>
                            </b>
                        </td>
                        <td>
                            <?= $row["email"] ?>
                        </td>
                        <td>
                            <?= strtoupper(substr($row["role"], 0, 1)) . substr($row["role"], 1) ?>
                        </td>
                        <td class="table-action">
                            <a class="table-action-delete"
                                href="<?= __BASEURL__ . '/view/dashboard/food-delete.php?user_id=' . $row['id'] ?>">Delete</a>


                        </td>
                    </tr>
                <?php endwhile; ?>

            </tbody>
        </table>
    <?php else: ?>
        <div>
            <p>No Users Found</p>
        </div>

    <?php endif ?>
</div>
