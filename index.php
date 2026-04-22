<?php
require_once "config/Database.php";
require_once "classes/Note.php";

$database = new Database();
$db = $database->connect();

$note = new Note($db);

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
            <li class="list-group-item d-flex justify-content-between">
                <div>
                    <strong><?php echo htmlspecialchars($row['title']); ?></strong><br>
                    <?php echo htmlspecialchars($row['content']); ?><br>
                    <small><?php echo $row['created_at']; ?></small>
                </div>
                <div>
                    <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger">Delete</a>
                </div>
            </li>
        <?php endwhile; ?>
    </ul>

</div>

</body>
</html>