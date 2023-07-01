<?php
    $title = $full_name;

    ob_start();
?>

    <!-- TODO: This Should Be More Dynamic -->
    <div id="alert" class="alert alert-success d-none">Todo Has Been Updated Successfully!!!</div>

    <form action="index.php?action=ajouter" method="post" class="pb-4">
        <label for="todo" class="form-label">New Todo</label>
        <div class="input-group">
            <input type="text" class="form-control" name="todo">
            <input type="submit" value="Create Todo" class="btn btn-primary">
        </div>
    </form>

    <table class="table table-bordered table-hover table-striped">
        <thead>
            <th>TODO</th>
            <th class="w-25">Action</th>
        </thead>
        <?php
            foreach($user_todos as $todo):
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
    </table>

    <!-- Modal For Updating Todos -->

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Update Todo</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="index.php?action=update" method="post" id="form_update">
                <input type="hidden" name="todo_id" id="todo_form_id">
                <textarea class="form-control" name="todo" id="" cols="60" rows="5"></textarea>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <input type="submit" id="submit_update" class="btn btn-primary" value="Update">
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <script src="scripts/update_todo.js"></script>
<?php
    $content = ob_get_contents();
    ob_get_clean();

    require "views/master.php";
?>