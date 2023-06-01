<?php
// TODO 1: PREPARING ENVIRONMENT: 1) session 2) functions
session_start();

// TODO 2: ROUTING
if (!empty($_SESSION["auth"])) {
    header("Location: /admin.php");
    die;
}

// TODO 3: CODE by REQUEST METHODS (ACTIONS) GET, POST, etc. (handle data from request): 1) validate 2) working with data source 3) transforming data

$inf = "";

if (!empty($_POST["email"]) && !empty($_POST["password"])) {

    // 3. Check that user has already existed
    $people = file_get_contents("users.csv");
    $JsonPeople = explode("\n", $people);

    $False = false;

    foreach ($JsonPeople as $jsonUser) {
        $a = json_decode($jsonUser, true);
        if (!$a) break;

        foreach ($a as $email => $password) {
            if (($email == $_POST["email"]) && ($password == $_POST["password"])) {
                $False = true;

                $_SESSION["auth"] = true;

                header("Location: admin.php");
                die;
            }
        }
    }

    if (!$False) {
        $inf = "Such a user does not exist. Go to the registration page";
        $inf .= "<a href='register.php'>Страница регистрации</a>";
    }

} elseif (!empty($_POST)) {
    $inf = "Fill out the authorization form!";
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
            Login form
        </div>
        <div class="card-body">
            <form method="post">
                <div class="form-group">
                    <label>Email</label>
                    <input class="form-control" type="email" name="email"/>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input class="form-control" type="password" name="password"/>
                </div>
                <br>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" name="form"/>
                </div>
            </form>

            <!-- TODO: render php data   -->
            <?php
            if ($inf) {
                echo "<hr/>";
                echo "<span style='color:red'>$inf</span>";
            }
            ?>

        </div>
    </div>
</div>


</body>
</html>
