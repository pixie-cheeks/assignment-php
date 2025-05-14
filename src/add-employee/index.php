<?php include '../config.php'; ?>
<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a new employee</title>
    <script>
    const BASE_URL = "<?php echo BASE_URL ?>";
    </script>

    <script defer type="module"
      src="<?php echo BASE_URL ?>/add-employee/add-employee.js"></script>
    <link rel="stylesheet"
      href="<?php echo BASE_URL ?>/global/bootstrap.min.css">
    <script defer src="<?php echo BASE_URL ?>/global/bootstrap.bundle.min.js">
    </script>

    <style>
    .form-required::after {
      content: " *";
      color: red;
    }
    </style>
  </head>

  <body>
    <dialog class="js-dialog">
      <div class="container text-center">
        <p class="js-dialog-text">Hello my name is Charmander.</p>
        <button class="js-dialog-button btn btn-primary">Okay</button>
      </div>
    </dialog>

    <div style="max-width: 800px;" class="container p-4">
      <form name="emp-form" class="js-form form">
        <div class="border rounded p-4 mb-4">
          <div class="mb-3 row">
            <label for="emp-id" class="form-required col-form-label col-4">
              Emp ID
            </label>
            <div class="col-sm-8">
              <input type="tel" pattern="[0-9]+" id="emp-id" name="emp-id"
                class="js-emp-id form-control" required>
            </div>
          </div>

          <div class="mb-3 row">
            <label for="first-name" class="col-form-label form-required col-4">
              First Name
            </label>
            <div class="col-sm-8">
              <input type="text" id="first-name" name="first-name"
                class="form-control" required>
            </div>
          </div>

          <div class="mb-3 row">
            <label for="middle-name" class="col-form-label col-4">
              Middle Name
            </label>
            <div class="col-sm-8">
              <input type="text" id="middle-name" name="middle-name"
                class="form-control">
            </div>
          </div>

          <div class="mb-3 row">
            <label for="last-name" class="col-form-label col-4 form-required">
              Last Name
            </label>
            <div class="col-sm-8">
              <input type="text" id="last-name" name="last-name"
                class="form-control" required>
            </div>
          </div>
          <div class="mb-3 row">
            <label for="joining-date" class="col-form-label col-4">
              Joining Date
            </label>
            <div class="col-sm-8">
              <input type="date" id="joining-date" name="joining-date"
                class="form-control">
            </div>
          </div>

          <div class="mb-3 row">
            <label for="position-id"
              class="col-form-label form-required col-4">Position</label>
            <div class="col-sm-8">
              <select name="position-id" id="position-id" class="form-select"
                required>
                <option value="" disabled hidden selected>
                  Select an option
                </option>
                <?php
                    require_once __DIR__ . '/../server/database-manager.php';
                    $db = new Database();
                    /**
                     * @var array{id: int, title: string} $positionObj
                     */
                    foreach ($db->getPositions() as $positionObj) {
                        ['id' => $id, 'title' => $title] = $positionObj;
                        echo "<option value=\"{$id}\">{$title}</option>";
                    }
                ?>
              </select>
            </div>
          </div>

          <div class="mb-3 row">
            <label for="address" class="col-form-label col-4">Address</label>
            <div class="col-sm-8">
              <textarea name="address" id="address"
                class="form-control"></textarea>
            </div>
          </div>

          <div class="mb-3 row">
            <label for="is-active"
              class="form-check-label col-4">Active?</label>
            <div class="col">
              <div
                class="form-switch form-check d-flex justify-content-sm-center">
                <input type="checkbox" name="is-active" id="is-active"
                  class="form-check-input">
              </div>
            </div>
          </div>
        </div>
        <div class="d-flex justify-content-between gap-5">
          <button type="button"
            class="btn btn-outline-danger js-cancel-button col">Cancel</button>
          <button type="submit" class="btn btn-success col">Add</button>
        </div>
      </form>
    </div>
  </body>

</html>