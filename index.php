<?php
    require "controller/todo_controller.php";

    if (isset($_GET["action"])) {
        $route = $_GET["action"];

        switch ($route) {
            case "afficher":
                show_todos();
                break;

            case "login":
                sign_in();
                break;

            case "ajouter":
                new_todo();
                break;

            case "update":
                update();
                break;

            case "logout":
                deconnection();
                break;

            case "authentification":
                authentification();
                break;

            case "supprimer":
                supprimer();
                break;

            case "401":
                unauthorized();
                break;

            case "403":
                forbidden();
                break;

            default:
                not_found();
        }
    } else {
        sign_in();
    }