<?php

$scriptName = explode('/', $_SERVER['SCRIPT_NAME'])[array_key_last(explode('/', $_SERVER['SCRIPT_NAME']))];


$isOnIndex =  $scriptName == "index.php";
$isOnDashboardIndex =  $scriptName == "home.php";
$isOnUserList = $scriptName == "user-list.php";
$isOnOrderList = $scriptName == "order-list.php";
$isOnUserForm = $scriptName == "user-form.php";
$isOnFoodList = $scriptName == "food-list.php";
$isOnFoodForm = $scriptName == "food-form.php";


?>
<nav class="">
    <?php if (empty($_SESSION["is_logged_in"])): ?>
        <div>
            <a href="<?= __BASEURL__ ?>">Pemesanan Makanan</a>
        </div>
        <div class="nav-user">
            <a href="<?= __BASEURL__ ?>/view/login.php">Login</a>
        </div>
    <?php endif ?>

    <?php if (isset($_SESSION["is_logged_in"])) : ?>
        <div class="nav-logout">
            <a href="<?= __BASEURL__ ?>/view/logout.php">Logout</a>
        </div>

        <div class="nav-page">
            <a href="<?= __BASEURL__ ?>/index.php" class="<?= $isOnIndex ? 'active' : '' ?>">
                Home
            </a>
            <a href="<?= __BASEURL__ ?>/view/dashboard/home.php" class="<?= $isOnDashboardIndex ? 'active' : '' ?>">
                Dashboard
            </a>
            <a href="<?= __BASEURL__ ?>/view/dashboard/user-list.php" class="<?= $isOnUserList ? 'active' : '' ?>">
                User List
            </a>
            <a href="<?= __BASEURL__ ?>/view/dashboard/user-form.php" class="<?= $isOnUserForm ? 'active' : '' ?>">
                User Form
            </a>
            <a href="<?= __BASEURL__ ?>/view/dashboard/food-list.php" class="<?= $isOnFoodList ? 'active' : '' ?>">
                Food List
            </a>
            <a href="<?= __BASEURL__ ?>/view/dashboard/food-form.php" class="<?= $isOnFoodForm ? 'active' : '' ?>">
                Food Form
            </a>
            <a href="<?= __BASEURL__ ?>/view/dashboard/order-list.php" class="<?= $isOnOrderList ? 'active' : '' ?>">
                Order List
            </a>
        </div>
        <div>

            <div class="nav-profile">
                <div class="nav-profile-icon">
                    <?= strtoupper($_SESSION["user_username"][0]) ?>
                </div>
                <div>
                    <p>
                        <?= $_SESSION["user_username"] ?>
                    </p>
                    <i>
                        <?= $_SESSION["user_email"] ?>
                    </i>
                </div>

            </div>
        </div>
    <?php endif ?>
</nav>

<main>
