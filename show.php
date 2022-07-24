<?php

$title = 'CRUD user';
$link_css = "'css/form.css'";
include("./partials/db.php");

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $statement = $pdo->prepare('SELECT users.*, type.name_privilege FROM users LEFT JOIN type ON users.type_id = type.id;');
    $statement->execute();
    $users = $statement->fetchAll(PDO::FETCH_ASSOC);
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

    <main>
        <div class="container">
            <div class="table-responsive">
                <table class="table mt-5 text-dark table-striped align-middle">
                    <thead class="blue text-light">
                        <tr>
                            <th class="px-5" scope="col">Name</th>
                            <th scope="col">Surname</th>
                            <th scope="col">Adress</th>
                            <th scope="col">City</th>
                            <th scope="col">Type privilege</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>


                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        foreach ($users as $user) : ?>
                            <tr>
                                <td class="px-5" scope="row"><?php echo $user['name'] ?></td>
                                <td scope="row"><?php echo $user['surname'] ?></td>
                                <td scope="row"><?php echo $user['adress'] ?></td>
                                <td scope="row"><?php echo $user['city'] ?></td>
                                <td scope="row"><?php echo $user['name_privilege'] ?></td>
                                <td>
                                    <a href="edit_user.php?id=<?php echo $user['id'] ?>" class="btn btn-outline-primary btn-sm"><span>edit</span></a>
                                </td>
                                <td>
                                    <form action="delete.php" method="POST" class="form-delete">
                                        <input type="hidden" name="id" value="<?php echo $user['id'] ?>"> <button type="submit" class="btn btn-outline-danger btn-sm">delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <?php include("partials/js-bs.html") ?>

</body>

</html>