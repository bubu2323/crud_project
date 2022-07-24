<?php
$title = 'create new privilege user';
$link_css = "'css/form.css'";

include("./partials/db.php");

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$name = "";
$privilege = "";

$error = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $privilege = $_POST['privilege'];

    if (!empty($name) && !empty($privilege)) {

        $statement = $pdo->prepare("INSERT INTO type (name_privilege, privilege) VALUES (:name, :privilege)");
        $statement->bindValue(':name', $name);
        $statement->bindValue(':privilege', $privilege);
        $statement->execute();
        header("location:show.php");
    } else $error = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include("./partials/head.php");
?>

<body>
    <header class="blue">
        <?php include("./partials/nav.php") ?>
    </header>

    <body>
        <div class="container">
        <?php if ($error) : ?>
            <div class="alert alert-danger alert-width" role="alert">
                <p>Insert all the imputs</p>
            </div>
            <?php endif ?>
            <div class="form">

                <form method="POST" enctype="multipart/form-data">
                    <h2 class="title">Create privilege</h2>

                    <div class="input-container ic2">

                        <input type="text" name="name" id="name" class="input" placeholder=" " required>
                        <div class="cut"></div><label for="nome" class="placeholder">privilege name</label>
                    </div>
                    <div class="input-container ic2">

                        <input type="number" name="privilege" id="privilege" class="input" placeholder="privilege level " min="1" required> <label for="surname"></label>
                    </div>

                    <button type="text" class="submit">submit</button>
                </form>
            </div>
        </div>
        <?php include("partials/js-bs.html"); ?>

    </body>

</html>