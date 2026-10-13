<?php

class Controller
{
    protected function view(string $viewPath, array $data): void
    {
        extract($data);

        require_once(__BASEPATH__ . "/view/partials/header.php");
        require_once(__BASEPATH__ . "/view/partials/navbar.php");

        $file = __BASEPATH__ . "/view/" . $viewPath . ".php";

        if (file_exists($file)) {
            require($file);
        } else {
            die("View [$viewPath] not found at $file");
        }
    }

    function __destruct()
    {
        require_once(__BASEPATH__ . "/view/partials/footer.php");
    }
}
