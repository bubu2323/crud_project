<?php
include('../partials/db.php');
include('../utils/validation.php');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$title = 'registration form';

$link_css = "'../css/form.css'";
$error = false;
$psw_length_error = false;
$data_exist = false;



if ($_SERVER["REQUEST_METHOD"] == "POST") {



  $email = test_input(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
  $username = test_input($_POST['username']);
  $psw = test_input($_POST['password']);
  $repeat_psw = test_input($_POST['repeat_password']);

  if (!empty($email) && !empty($username) && !empty($psw) && !empty($repeat_psw)) {

    if (strlen($psw) < 5 || strlen($repeat_psw) < 5) $psw_length_error = true;
    else if ($psw == $repeat_psw) {
      echo 'parametri rispettati.';
      //verify if insert data exist in db
      $query = $pdo->prepare('SELECT username,email FROM registered_users WHERE username = :username OR email = :email');
      $query->bindValue(':username', $username);
      $query->bindValue(':email', $email);
      $query->execute();

      $users = $query->fetchAll(PDO::FETCH_ASSOC);

      if (empty($users)) {
        //crypy password and insert into database
        $crypt_psw = password_hash($psw, PASSWORD_DEFAULT);


        $statement = $pdo->prepare("INSERT INTO registered_users(id,username,password,email,registration_data) VALUES(NULL,:username,:password,:email,NULL)");
        $statement->bindValue(':username', $username);
        $statement->bindValue(':password', $crypt_psw);
        $statement->bindValue(':email', $email);
        $statement->execute();
        echo 'dati inseriti.';
        header("location:../show.php");

      } else $data_exist = true;
    }
  } else $error = true;
}

?>

<!DOCTYPE html>
<html lang="en">
<?php include("../partials/head.php") ?>

<body>
  <main>
    <div class="container text-center">
      <?php if ($error) : ?>
        <?php echo "<div class='alert alert-danger' role='alert'>
        <strong>Insert data</strong>
      </div>" ?>
      <?php endif ?>

      <?php if ($psw_length_error) : ?>
        <?php echo "<div class='alert alert-danger' role='alert'>
        <strong>5 is the min length for the password</strong>
      </div>" ?>
      <?php endif ?>


      <?php if ($data_exist) : ?>
        <?php echo "<div class='alert alert-danger' role='alert'>
        <strong>username or email already exist</strong>
      </div>" ?>
      <?php endif ?>





      <div class="form">

        <h2 class="title">Registration form</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" )>>

          <div class=" input-container ic2">
            <input id="email" class="input" type="email" placeholder=" " name="email" required />
            <div class="cut"></div>
            <label for="email" class="placeholder">email</label>
          </div>

          <div class="input-container ic1">
            <input id="username" class="input" type="text" placeholder=" " name="username" required />
            <div class="cut"></div>
            <label for="username" class="placeholder">username</label>
          </div>

          <div class="input-container ic2">
            <input id="password" class="input" type="password" placeholder=" " name="password" required>
            <div class="cut"></div>
            <label for="password" class="placeholder">password</label>
          </div>

          <div class="input-container ic2">
            <input id="repeat_password" class="input" type="password" placeholder=" " name="repeat_password" required>
            <div class="cut"></div>
            <label for="repeat_password" class="placeholder">repeat password</label>
          </div>

          <div class="">
            <input type="submit" class="submit" value="register user">
          </div>

        </form>
      </div>
    </div>
  </main>
  <?php include("../partials/js-bs.html") ?>
</body>

</html>