<?php

require_once(__DIR__ . "/../core/Controller.php");
require_once(__DIR__ . "/../core/database.php");
require_once(__DIR__ . "/../models/Order.php");
require_once(__DIR__ . "/../models/OrderDetail.php");
require_once(__DIR__ . "/../core/Auth.php");

class OrderController extends Controller
{
    public Database $db;
    public Order $orderModel;
    public OrderDetail $orderDetailModel;

    public function __construct()
    {
        $this->db = new Database();
        $this->orderModel = new Order($this->db);
        $this->orderDetailModel = new OrderDetail($this->db);
    }

    public function index()
    {

        $orders = null;
        $category = null;
        $error = null;
        $completeOrders = [];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $orderId = $_POST["id"];
            $status = $_POST["status"];

            $status = $this->orderModel->update($orderId, $status);

            if (!$status) {
                $error = "Error: Cannot change order status";
            }
        }

        if (isset($_GET["category"])) {
            $category = $_GET["category"];
        }

        switch ($category) {
            case "pending":
                $orders = $this->orderModel->getAllPendingOrders();
                break;
            case "diproses":
                $orders = $this->orderModel->getAllOngoingOrders();
                break;
            case "selesai":
                $orders = $this->orderModel->getAllCompleteOrders();
                break;
            default:
                $orders = $this->orderModel->getAllOrders();
                break;
        }

        while ($order = $orders->fetch_assoc()) {
            $orderDetails = $this->orderDetailModel->getOrderDetailsByOrderId($order["id"]);

            if (!$orderDetails) {
                $orderDetails = null;
            }

            array_push($completeOrders, ["id" => $order["id"], "customer_name" => $order["customer_name"], "table_number" => $order["table_number"], "total_price" => $order["total_price"], "timestamps" => $order["timestamps"], "status" => $order["status"], "orderDetails" => $orderDetails]);
        }

        $this->view("components/header", ["title" => "Orders", "subtitle" => "This was all the orders that available right now sorted by the newest order"]);
        $this->view("components/filter/filter-by-category", ["title" => "Filter Orders by Status", "categories" => ["pending", "diproses", "selesai"], "currentCategory" => $category]);
        $this->view("components/order-table", ["orders" => $completeOrders, "category" => $category, "error" => $error]);
    }
}
