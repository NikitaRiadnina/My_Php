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

    $isAlreadyRegistered = false;
    $fileUsers = "users.csv";

    if (file_exists($fileUsers)) {
        $sUsers = file_get_contents($fileUsers);
        $aJsonsUsers = explode("\n", $sUsers);

        foreach ($aJsonsUsers as $jsonUser) {
            $aUser = json_decode($jsonUser, true);
            if (!$aUser) break;

            foreach ($aUser as $email => $password) {
                if (($email == $_POST["email"]) && ($password == $_POST["password"])) {
                    $isAlreadyRegistered = true;

                    $inf = "Error ";
                    $inf .= "<a href='/login.php'>Страница входа</a>";
                }
            }
        }
    }

    if (!$isAlreadyRegistered) {
        $aNewUser = [$_POST["email"] => $_POST["password"]];
        file_put_contents("users.csv", json_encode($aNewUser) . "\n", FILE_APPEND);

        header("Location: /login.php");
        die;
    }

} elseif (!empty($_POST)) {
    $inf = "Fill out the registration form!";
}

// TODO 4: RENDER: 1) view (html) 2) data (from php)

?>


    <!DOCTYPE html>
    <html>

<?php require_once 'sectionHead.php' ?>

    <body>

    <div class="container">

        <?php require_once 'sectionNavbar.php' ?>

        <br>

        <div class="card card-primary">
            <div class="card-header bg-success text-light">
                Register form
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
                        <input type="submit" class="btn btn-primary" name="formRegister"/>
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
    </html><?php
