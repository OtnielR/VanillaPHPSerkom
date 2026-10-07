<?php

require_once(__DIR__ . "/../core/database.php");
require_once(__DIR__ . "/../models/User.php");
require_once(__DIR__ . "/../core/config.php");
require_once(__DIR__ . "/../core/Controller.php");
require_once(__DIR__ . "/../core/Auth.php");

class UserController extends Controller
{

    public Database $db;
    public User $model;

    public function __construct()
    {
        $this->db = new Database();
        $this->model = new User($this->db);
    }

    public function login(): void
    {
        Auth::requireGuest();

        $error = null;

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $email = trim($_POST["email"]);
            $password = trim($_POST["password"]);

            if (empty($email) || empty($password)) {
                $error = "Input not valid";
            } else {
                $user = $this->model->findUserByEmail($email);

                if (password_verify($password, $user["password"])) {
                    Auth::login($user);
                    header("Location: " . __BASEURL__ . "/view/dashboard/home.php");
                    exit;
                } else {
                    $error = "Email or Password Wrong";
                }
            }
        }

        $this->view("components/user-form", ["title" => "Login", "type" => "login", "error" => $error]);
    }

    public function register(): void
    {

        $error = null;

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            [
                'username' => $username,
                'email'    => $email,
                'password' => $password,
                'role'     => $role
            ] = $_POST;

            if (!$username || !$email || !$password || !$role) {
                $error = "Input not valid";
            }

            $this->model->create($username, $email, $password, $role);

            header("Location: " . __BASEURL__ . "/view/dashboard/home.php");
        }

        $this->view("components/user-form", ["title" => "User Form", "type" => "register", "error" => $error]);
    }

    public function delete(): void
    {
        Auth::requireAuth();

        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            if (isset($_GET["user_id"])) {
                $this->model->delete($_GET["user_id"]);
            }

            header("Location: " . __BASEURL__ . "/view/dashboard/user-list.php");
        }
    }

    public function logout(): void
    {
        Auth::logout();
        header("Location: " . __BASEURL__);
        exit;
    }
}
