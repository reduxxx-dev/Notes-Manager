<?php
require_once "config/Database.php";
require_once "classes/Note.php";

$database = new Database();
$db = $database->connect();

$note = new Note($db);

// UPDATE
if (isset($_POST['update_id'])) {
    $id = $_POST['update_id'];
    $content = $_POST['updated_note'];

    $note->update($id, $content);

    header("Location: index.php");
    exit();
}

// CREATE
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = $_POST['note'];

    if (!empty($content)) {
        $note->create($content);
    }

    header("Location: index.php");
    exit();
}

// DELETE
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $note->delete($id);

    header("Location: index.php");
    exit();
}

// READ
$notes = $note->getAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Notes Manager</title>
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body>

<div class="container" style="margin-top: 50px; max-width: 600px;">

    <h1 class="mb-4">Notes Manager</h1>

    <!-- FORM -->
    <form method="POST">
        <div class="form-group mb-3">
            <textarea name="note" class="form-control" placeholder="Enter your note"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Add Note</button>
    </form>

    <hr>

    <h2 class="mt-4">Notes</h2>

    <!-- NOTES LIST -->
    <ul class="list-group mt-3">
        <?php while ($row = $notes->fetch(PDO::FETCH_ASSOC)) : ?>
            <li class="list-group-item">

    <form method="POST" class="d-flex justify-content-between">

        <div style="width: 70%;">
            <textarea name="updated_note" class="form-control"><?php echo htmlspecialchars($row['content']); ?></textarea>
            <input type="hidden" name="update_id" value="<?php echo $row['id']; ?>">
        </div>

        <div>
            <button type="submit" class="btn btn-sm btn-warning">Update</button>
            <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger">Delete</a>
        </div>

    </form>

</li>
        <?php endwhile; ?>
    </ul>

</div>

</body>
</html>