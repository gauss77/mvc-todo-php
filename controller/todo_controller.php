<?php
    require "model/todo_model.php";

    // VIEWS
    function sign_in() {
        session_start();

        if (!(isset($_SESSION["logged"]) or isset($_SESSION["username"]))) {
            require "views/login.php";
        } else {
            header("location: index.php?action=login");
            exit();
        }
    }

    function show_todos() {
        $user_todos = user_todos();

        $username = get_user($_SESSION["username"]);

        $full_name = strtoupper($username["last_name"]) . " " . ucfirst($username["first_name"]);

        require "views/todos.php";
    }

    function user_todos() {
        session_start();
        if (isset($_SESSION["username"])) {
            $username = $_SESSION["username"];
            return get_todos($username);
        } else {
            header("location: index.php?action=401");
            exit();
        }
    }

    function new_todo() {
        session_start();
        if (isset($_POST["todo"])) {
            $todo = htmlspecialchars($_POST["todo"]);
            $todo = trim($_POST["todo"]);
            $todo = ucfirst($_POST["todo"]);
            if (!empty($todo)) {
                $username = $_SESSION["username"];
                ajouter_todo($todo, $username);
            }
        }

        header("location: index.php?action=afficher");
        exit();
    }

    function authentification() {
        if (isset($_POST["username"]) and isset($_POST["password"])) {
            $username = htmlspecialchars($_POST["username"]);
            $username = trim($_POST["username"]);
            $password = htmlspecialchars($_POST["password"]);

            if($username != "" and $password != "") {
                $user = get_user($username);

                if (!empty($user)) {
                    // Use Hashing Later
                    if ($user["username"] == $username and $user["password"] == $password) {
                        session_start();
                        $_SESSION["logged"] = "true";
                        $_SESSION["username"] = $username;

                        echo '{"stat": "success", "message": "You Are Logged"}';
                        
                        // Used to print out feedback alerts in the sign in page
                    } else echo '{"stat": "error", "message": "Wrong Email Or Passowrd!!!"}';
                } else echo '{"stat": "error", "message": "Username Does not Exists!!!"}';
            } else echo '{"stat": "error", "message": "Please Fill Out All The Fields!!!"}';
            
        } else {
            echo "Forbidden!!!";
            // Missing Up With URL
            // header("location: index.php?action=403");
            // exit();
        }

        // Used The Action Attribute To Redirect Instead
        // if ($success) {
        //     header("location: index.php?action=afficher");
        //     exit();
        // }

        // Success
        // header("location: index.php?action=afficher");
        // exit();
    }

    function update() {
        session_start();
        if (isset($_SESSION["logged"]) and isset($_SESSION["username"])) {
            if (isset($_POST["todo"]) and isset($_POST["todo_id"])) {
                $id = htmlspecialchars($_POST["todo_id"]);
                $id = trim($_POST["todo_id"]);
                $todo = htmlspecialchars($_POST["todo"]);
                $todo = trim($_POST["todo"]);

                if ($id && $todo) {
                    update_todo($id, $todo);
                    echo "GOOD";
                } else echo "Fields Required";

            } else echo "Not Allowed";
        } else {
            echo "Forbidden";
        }

    }

    function supprimer() {
        session_start();
        if (isset($_SESSION["logged"]) and isset($_SESSION["username"])) {
            if (isset($_GET["action"]) and isset($_GET["id"])) {
                $id = htmlspecialchars(trim($_GET["id"]));
                if ($_GET["action"] == "supprimer") {
                    drop_todo($id);
                }
            }
        } else {
            header("location: index.php?action=404");
            exit();
        }

        echo "Somehow Not Entering";
        header("location: index.php?action=afficher");
        exit();
    }

    function deconnection() {
        session_start();
        if (isset($_SESSION["logged"]) and isset($_SESSION["username"])) {
            session_unset();
            session_destroy();
        } else {
            header("location: index.php?action=403");
            exit();
        }

        header("location: index.php?action=login");
        exit();
    }


    // ! ERRORS PAGES VIEWS
    function forbidden() {
        require "views/errors/403.php";
    }

    function not_found() {
        require "views/errors/404.php";
    }
    
    function unauthorized() {
        require "views/errors/401.php";
    }
?>