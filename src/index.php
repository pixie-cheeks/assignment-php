<?php include __DIR__ . '/config.php'; ?>
<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet"
      href="<?php echo BASE_URL ?>global/bootstrap.min.css">
    <script>
    const BASE_URL = "<?php echo BASE_URL ?>";
    </script>
    <script defer src="<?php echo BASE_URL ?>global/bootstrap.bundle.min.js">
    </script>
    <script defer type="module" src="<?php echo BASE_URL ?>site.js"></script>
  </head>

  <body>
    <div class="container p-4 d-flex flex-column gap-3">
      <button class="js-add-button btn btn-success align-self-end">Add</button>
      <table class="table">
        <thead>
          <tr>
            <th>Emp Id</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Position</th>
            <th>Active</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody class="js-tbody">
        </tbody>
      </table>
    </div>
  </body>

</html>