<?php
$title = 'edit user';
include("./partials/db.php");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$error = false;
$link_css = "'css/form.css'";


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $query = $pdo->query("SELECT id,name,surname,adress FROM users");
    $data = $query->fetchAll(PDO::FETCH_ASSOC);

    $query = $pdo->query("SELECT * FROM type");
    $privileges = $query->fetchAll();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $surname = htmlspecialchars($_POST['surname']);
    $adress = htmlspecialchars($_POST['adress']);
    $city = htmlspecialchars($_POST['city']);
    $type_id = (int) htmlspecialchars($_POST['type_id']); //privilegio  id

    $id = $_POST['edit_user'];
    if (!empty($name) && !empty($surname) && !empty($adress) && !empty($city) && !empty($type_id)) {
        $query = $pdo->prepare("UPDATE users SET name = :name, surname = :surname, adress = :adress,city = :city, type_id = :type_id WHERE id = :id");
        $query->bindValue(':name', $name);
        $query->bindValue(':surname', $surname);
        $query->bindValue(':adress', $adress);
        $query->bindValue(':city', $city);
        $query->bindValue(':type_id', $type_id);
        $query->bindValue(':id', $id);
        $query->execute();
        header("location:show.php");
    }else $error = true;
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
    <div class="container text-center">
        <?php if ($error) : ?>
            <div class="alert alert-danger alert-width" role="alert">
                <p>Insert all the imputs</p>
            </div>
        <?php endif ?>
        <div class="form">
            <form method="POST">
                <div class="title">Edit user</div>

                <div class="input-container ic2">
                    <select name="edit_user" id="edit_user" required>
                        <option value="">select an user</option>
                        <?php foreach ($data as $user) : ?>
                            <?php echo "<option value ='{$user["id"]}'>{$user['name']}</option>" ?>
                        <?php endforeach; ?>
                    </select>
                    <label for="edit_user"></label>

                </div>

                <div class="input-container ic1">
                    <input id="name" class="input" type="text" placeholder=" " name="name" required />
                    <div class="cut"></div>
                    <label for="name" class="placeholder">name</label>
                </div>

                <div class="input-container ic2">
                    <input id="surname" class="input" type="text" placeholder=" " name="surname" required />
                    <div class="cut"></div>
                    <label for="surname" class="placeholder">Surname</label>
                </div>

                <div class="input-container ic2">
                    <input id="address" class="input" type="text" placeholder=" " name="adress" required />
                    <div class="cut cut-short"></div>
                    <label for="address" class="placeholder">address</label>
                </div>

                <div class="input-container ic2">
                    <input id="city" class="input" type="text" placeholder=" " name="city" required />
                    <div class="cut cut-short"></div>
                    <label for="city" class="placeholder">citta</label>
                </div>

                <div class="input-container ic2">
                    <select name="type_id" required>
                        <option value="">select privilege</option>
                        <?php foreach ($privileges as $privilege) : ?>
                            <option value="<?php echo $privilege[0]; ?>">
                                <?php echo $privilege[1]; ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                    <label for="city"></label>
                </div>
                <button type="submit" class="submit">submit</button>
        </div>
        </form>
        <?php include("partials/js-bs.html") ?>

</body>

</html>