<?php

require_once(__DIR__ . "/../core/database.php");
require_once(__DIR__ . "/../models/User.php");
require_once(__DIR__ . "/../models/Food.php");
require_once(__DIR__ . "/../models/Order.php");
require_once(__DIR__ . "/../core/config.php");
require_once(__DIR__ . "/../core/Controller.php");
require_once(__DIR__ . "/../core/Auth.php");
require_once(__DIR__ . "/../utils/ComponentUtils.php");

class DashboardController extends Controller
{
    public Database $db;
    public User $userModel;
    public Food $foodModel;
    public Order $orderModel;

    public function __construct()
    {
        $this->db = new Database();
        $this->userModel = new User($this->db);
        $this->foodModel = new Food($this->db);
        $this->orderModel = new Order($this->db);
    }

    public function index(): void
    {
        Auth::requireAuth();

        $users = $this->userModel->getAllUsers();
        $usersCount = $users->num_rows;

        $foods = $this->foodModel->getAllFoods();
        $foodsCount = $foods->num_rows;

        $pendingOrders = $this->orderModel->getAllPendingOrders();
        $pendingOrdersCount = $pendingOrders->num_rows;

        $ongoingOrders = $this->orderModel->getAllOngoingOrders();
        $ongoingOrdersCount = $ongoingOrders->num_rows;

        $completeOrders = $this->orderModel->getAllCompleteOrders();
        $completeOrdersCount = $completeOrders->num_rows;

        $this->view("components/header", ["title" => "Dashboard", "subtitle" => "This was the dasboard that only admin can access"]);

        ComponentUtils::grid("dashboard-card-grid", function () use ($usersCount, $foodsCount) {

            $this->view("components/card/dashboard-card", ["title" => "Users", "subtitle" => "This was the total user that available", "content" => $usersCount]);

            $this->view("components/card/dashboard-card", ["title" => "Foods", "subtitle" => "This was the total food that available", "content" => $foodsCount]);
        });

        $this->view("components/header", ["title" => "Orders", "subtitle" => "This was all the orders that available right now"]);

        ComponentUtils::grid("dashboard-card-grid", function () use ($completeOrdersCount, $ongoingOrdersCount, $pendingOrdersCount) {

            $this->view("components/card/dashboard-card", ["title" => "Pending", "subtitle" => "This was the total og pending order", "content" => $pendingOrdersCount]);

            $this->view("components/card/dashboard-card", ["title" => "Ongoing", "subtitle" => "This was the total of ongoing order", "content" => $ongoingOrdersCount]);

            $this->view("components/card/dashboard-card", ["title" => "Complete", "subtitle" => "This was the total of complete order", "content" => $completeOrdersCount]);
        });
    }

    public function userList(): void
    {
        Auth::requireAuth();

        $users = $this->userModel->getAllUsers();

        $this->view("components/header", ["title" => "Users", "subtitle" => "This was all the user that registered in our website"]);
        $this->view("components/user-table", ["users" => $users]);
    }
}
