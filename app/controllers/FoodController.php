<?php

require_once(__DIR__ . "/../core/database.php");
require_once(__DIR__ . "/../models/Food.php");
require_once(__DIR__ . "/../models/Order.php");
require_once(__DIR__ . "/../models/OrderDetail.php");
require_once(__DIR__ . "/../core/config.php");
require_once(__DIR__ . "/../core/Controller.php");
require_once(__DIR__ . "/../core/Auth.php");
require_once(__DIR__ . "/../utils/FileUtils.php");
require_once(__DIR__ . "/../utils/ComponentUtils.php");

class FoodController extends Controller
{
    private Database $db;
    private Food $foodModel;
    private Order $orderModel;
    private OrderDetail $orderDetailModel;

    public function __construct()
    {
        $this->db = new Database();
        $this->foodModel = new Food($this->db);
        $this->orderModel = new Order($this->db);
        $this->orderDetailModel = new OrderDetail($this->db);
    }

    public function index(): void
    {

        $foods = null;
        $foodOrders = null;
        $category = null;

        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            if (!isset($_SESSION["cart"])) {
                $_SESSION["cart"] = [];
            }

            if (!isset($_GET["action"]) && !isset($_GET["food_id"])) {
                $error = "Request Failed";
            } else if ($_GET["action"] === "add") {
                $foodId = $_GET["food_id"];

                if (isset($_SESSION["cart"][$foodId])) {
                    $_SESSION["cart"][$foodId]["quantity"]++;
                } else {
                    $_SESSION["cart"][$foodId]["quantity"] = 1;
                    $_SESSION["cart"][$foodId]["name"] = $_GET["food_name"];
                    $_SESSION["cart"][$foodId]["price"] = $_GET["food_price"];
                    $_SESSION["cart"][$foodId]["image_url"] = $_GET["food_image_url"];
                }

                header("Location: " . __BASEURL__);
            } else if ($_GET["action"] == "decrease") {
                $foodId = $_GET["food_id"];

                if (isset($_SESSION["cart"][$foodId])) {
                    if ($_SESSION["cart"][$foodId]["quantity"] <= 1) {
                        unset($_SESSION["cart"][$foodId]);
                    } else {
                        $_SESSION["cart"][$foodId]["quantity"]--;
                    }
                }

                header("Location: " . __BASEURL__);
            } else if ($_GET["action"] == "remove") {

                $foodId = $_GET["food_id"];

                unset($_SESSION["cart"][$foodId]);

                header("Location: " . __BASEURL__);
            }
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_SESSION["cart"])) {
                $name = trim($_POST["name"]);
                $tableNumber = trim($_POST["table_number"]);
                $totalPrice = trim($_POST["total_price"]);

                $orderId = $this->orderModel->create($name, $tableNumber, $totalPrice);

                if ($orderId) {
                    foreach ($_SESSION["cart"] as $key => $value) {
                        $this->orderDetailModel->create($orderId, $key, $value["quantity"], $value["quantity"] * $value["price"]);
                    }
                }
            }
            unset($_SESSION["cart"]);
        }

        if (isset($_GET["category"])) {
            $category = $_GET["category"];
            $foods = $this->foodModel->getFoodsByCategory($category);
        } else {
            $foods = $this->foodModel->getAllFoods();
        }

        if (isset($_SESSION["cart"]) && $_SESSION["cart"]) {
            $foodOrders = $_SESSION["cart"];
        }

        $this->view("components/header", ["title" => "Foods", "subtitle" => "This are all foods that available in our restaurant"]);
        $this->view("components/filter/filter-by-category", ["title" => "Filter Foods by Category", "categories" => ["makanan", "minuman", "cemilan"], "currentCategory" => $category]);

        ComponentUtils::grid("dashboard-card-grid", function () use ($foods) {
            while ($food = $foods->fetch_assoc()) {
                $quantity = 0;

                if (isset($_SESSION["cart"][$food["id"]])) {
                    $quantity = $_SESSION["cart"][$food["id"]]["quantity"];
                }

                $this->view("components/card/food-card", ["title" => $food["name"], "price" => $food["price"], "description" => $food["description"], "imageUrl" => __BASEURL__ . $food["image"], "category" => $food["category"], "id" => $food["id"], "quantity" => $quantity]);
            }
        });

        if (!is_null($foodOrders)) {
            $this->view("components/order-form", ["foodOrders" => $foodOrders]);
        }
    }

    public function create(): void
    {

        Auth::requireAuth();
        $error = "";
        $method = isset($_GET["method"]) ? $_GET["method"] : "";
        $food_id = isset($_GET["food_id"]) ? $_GET["food_id"] : "";
        $food = null;

        if ($food_id) {
            $food = $this->foodModel->getFoodById($food_id);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST["name"];
            $category = $_POST["category"];
            $price = $_POST["price"];
            $description = $_POST["description"];
            $image = null;

            $imageResponse = FileUtils::storeImage("image");

            if ($imageResponse["status"]) {
                $image = $imageResponse["path"];
            }

            if ($method == "update") {
                $status = $this->foodModel->update($name, $category, $price, $description, $image, $food_id);
            } else {
                $status = $this->foodModel->create($name, $category, $price, $description, $image);
            }


            if ($status) {
                header("Location: " . __BASEURL__ . "/view/dashboard/food-list.php");
            } else {
                $error = "Insert Form Failed";
            }
        }

        $this->view("components/food-form", ["title" => "Food Form", "error" => $error, "method" => $method, "food_id" => $food_id, "food" => $food]);
    }

    public function foodList(): void
    {
        Auth::requireAuth();
        $foods = $this->foodModel->getAllFoods();

        $this->view("components/header", ["title" => "Food List", "subtitle" => "This was all food that available in our restaurant"]);
        $this->view("components/food-table", ["foods" => $foods]);
    }

    public function delete(): void
    {
        Auth::requireAuth();

        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            if (isset($_GET["food_id"])) {
                $this->foodModel->delete($_GET["food_id"]);
            }

            header("Location: " . __BASEURL__ . "/view/dashboard/food-list.php");
        }
    }
}
