<?php
$title = 'create user';
include("./partials/db.php");
$link_css = "'css/form.css'";

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$name = "";
$surname = "";
$adress = "";
$citta = "";
$type_id = "";

$error = false;
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  $query = $pdo->query("SELECT * FROM type");
  $privileges = $query->fetchAll();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = htmlspecialchars($_POST['name']);
  $surname = htmlspecialchars($_POST['surname']);
  $adress = htmlspecialchars($_POST['adress']);
  $city = htmlspecialchars($_POST['city']);
  $type_id = htmlspecialchars($_POST['type_id'], 0);

  if (!empty($name) && !empty($surname) && !empty($adress) && !empty($city) && !empty($type_id)) {
    $statement = $pdo->prepare("INSERT INTO users (name, surname, adress, city, type_id) VALUES (:name, :surname, :adress, :city, :type_id)");
    $statement->bindValue(':name', $name);
    $statement->bindValue(':surname', $surname);
    $statement->bindValue(':adress', $adress);
    $statement->bindValue(':city', $city);
    $statement->bindValue(':type_id', $type_id);
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
    <main>
      <div class="container text-center">
        <?php if ($error) : ?>
          <div class="alert alert-danger alert-width" role="alert">
            <p>Insert all the imputs</p>
          </div>
        <?php endif ?>
        <div class="form">

          <h2 class="title">Insert new user</h2>
          <form method="POST">

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
              <label for="address" class="placeholder">address</>
            </div>

            <div class="input-container ic2">
              <input id="city" class="input" type="text" placeholder=" " name="city" required />
              <div class="cut cut-short"></div>
              <label for="city" class="placeholder">citta</>
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

            <div class="">
              <input type="submit" class="submit" value="Insert">
            </div>
          </form>
        </div>
      </div>
    </main>
    <?php include("partials/js-bs.html") ?>
  </body>



</html>
<!-- Realizzare un sito in grado di permettere la registrazione di un utente, questo deve poter inserire: 1 tipo di utente, 2: nome, 3: cognome, 4: indirizzo, 5:citta’
Creare una tabella user con le colonne richieste
Creare una tabella type che rappresenti il tipo di utente, che deve avere name, privilege, created at
Utente, 1
Editor, 2
Admin, 3 -->