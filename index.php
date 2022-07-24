<?php
include('partials/db.php');
$link_css = "'css/form.css'";
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$title = 'login';
$error = false;
$incorrect_psw = false;
$not_registred = false;



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $psw = htmlspecialchars($_POST['psw']);

    if (!empty($username) && !empty($psw)) {
        $query = $pdo->prepare('SELECT * FROM registered_users WHERE username = :username');

        $query->bindValue(':username', $username);
        $query->execute();

        //find corrispondence insert user - db
        $users = $query->fetchAll(PDO::FETCH_ASSOC);

        //verify if user exist and password matches
        if (!empty($users)) {
            if (password_verify($psw, $users[0]['password'])) header("location:show.php");
            else $incorrect_psw = true;
        } else $not_registred = true;
    } else $error = true;
}





?>
<!DOCTYPE html>
<html lang="en">

<?php include('partials/head.php') ?>

<body>
    <div class="container text-center">


        <?php if ($error) echo "<div class='alert alert-danger' role='alert'>
            <strong>insert all the fields</strong>
        </div>"
        ?>
        <?php if ($not_registred) echo "<div class='alert alert-danger' role='alert'>
            <strong>User not registered</strong>
        </div>"
        ?>
        <?php if ($incorrect_psw) echo "<div class='alert alert-danger' role='alert'>
            <strong>Incorrect password. Try again</strong>
        </div>"
        ?>

        <div class="form">
        <h1 class="title">Login</h1>

            <form method="post" class="">
                <div class="input-container ic2">
                    <input class="input" type="text" name="username" id="username" placeholder=" ">
                    <div class="cut"></div>
                    <label for="username" class="placeholder">Username</label>
                </div>

                <div class="input-container ic2">
                    <input type="password" class="input" name="psw" id="psw" placeholder=" ">
                    <div class="cut"></div>
                    <label for="psw" class="placeholder">Password</label>
                </div>
                <button type="submit" class="submit mb-4 mt-5">submit</button>
                <div><a name="create-user" id="create-user" class="text-danger text-decoration-none" href="registration.php" role="button">Not registered? Click here</a></div>

            </form>
        </div>
    </div>
</body>

</html>