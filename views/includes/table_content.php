<?php

    require "../../controller/update.php";

    session_start();
    foreach(user_todos() as $todo):
?>
    <tr>
        <td><?= $todo["todo"] ?></td>
        <td>
            <a href="index.php?action=supprimer&id=<?= $todo["id"] ?>" class="btn btn-danger">Delete</a>
            <button data-action = "update" data-todo-id="<?= $todo['id'] ?>" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Update</button>
        </td>
    </tr>

<?php
    endforeach;
?>
