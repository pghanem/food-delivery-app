<?php
  ini_set('session.save_path', '../' . '/');
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type = "text/css" href="style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="index.php">Fuudie</a>
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              id="navbarDropdown"
              role="button"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              Pages
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="customerPage.php">Customer Page</a>
              <a class="dropdown-item" href="restaurantPage.php">Restaurant Page</a>
              <a class="dropdown-item" href="driverPage.php">Driver Page</a>
              <a class="dropdown-item" href="foodList.php">Food List</a>
              <a class="dropdown-item" href="restaurants.php">Restaurant</a>
            </div>
        </li>
    </ul>

      <?php
        if (isset($_SESSION['ID'])) {
          // a user is logged in. Hide the log in options, show logout.
          echo '<form class="form-inline my-2 my-lg-0" action="includes/logout.inc.php"           method="POST">
          <button class="btn btn-outline-light my-2 my-sm-0 mx-1" type="submit" name="logout-submit">
            Logout
          </button>
          </form>';
        } else {
          // user is not currently logged in. Show log in options, hide logout.
          echo '<form class="form-inline my-2 my-lg-0" action ="includes/login.inc.php" method="POST">
          <input
            class="form-control mr-sm-2"
            type="text"
            placeholder="Email Address"
            aria-label="Search"
            name="uid"
          />
          <input
            class="form-control mr-sm-2"
            type="password"
            placeholder="Password"
            aria-label="Search"
            name="pwd"
          />
          <select class="custom-select my-1 mr-sm-2" id="mealTypeSelector" name="user-type">
              <option selected>Choose...</option>
              <option value="Customer">Customer</option>
              <option value="Delivery Driver">Delivery Driver</option>
              <option value="Restaurant Manager">Restaurant Manager</option>
          </select>

          <button class="btn btn-outline-light my-2 my-sm-0 mx-1" type="submit" name="login-submit">
            Login
          </button>
        </form>
        <form class="form-inline my-2 my-lg-0" action="includes/signup.inc.php" method="POST">
            <button class="btn btn-outline-light my-2 my-sm-0 mx-1" type="submit" name="signup-submit">
              Signup
            </button>
        </form>';
        }
      ?>

    </div>
  </nav>
</body>