<?php
session_start();

function Email($email) {return filter_var($email, FILTER_VALIDATE_EMAIL);}

function saveComment($name, $email, $comment) {
    $x = fopen("comments.csv", "a+");
    fputcsv($x, array($name, $email, $comment));
    fclose($x);
}

function render(){
    $comments = array_map("str_getcsv", file("comments.csv"));
    if (!empty($comments)) {
        foreach ($comments as $comment) {
            echo "<p><strong>Name:</strong> " . $comment[0] . "</p>";
            echo "<p><strong>Email:</strong> " . $comment[1] . "</p>";
            echo "<p><strong>Comment:</strong> " . $comment[2] . "</p>";
            echo "<hr>";
        }
    }
}

$errors = [];
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $comment = $_POST["comment"];

    if (empty($name)) {
        $errors[] = "Name is required";
    }

    if (empty($comment)) {
        $errors[] = "Comment is required";
    }

    if (!Email($email)) {
        $errors[] = "Invalid email address";
    }

    if (empty($errors)) {
        saveComment($name, $email, $comment);
    }
}

?>

<!DOCTYPE html>
<html>

<?php require_once "sectionHead.php" ?>

<body>

<div class="container">

    <?php require_once "sectionNavbar.php" ?>
    <br>

    <div class="card card-primary">
        <div class="card-header bg-primary text-light">
            GuestBook form
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-sm-6">

                    <form method="post">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="comment">Comment</label>
                            <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                        </div>
                        <div class="error">
                            <label for="error"><?php if (!empty($errors)) {
                                    foreach ($errors as $error) {
                                        echo '<p><strong>Error:</strong> ' . $error . '</p>';
                                    }
                                }?></label>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

                </div>
            </div>

        </div>
    </div>

    <br>

    <div class="card card-primary">
        <div class="card-header bg-body-secondary text-dark">
            Сomments
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <?php render();?>
                </div>
            </div>
        </div>
    </div>
</div>