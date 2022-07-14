<?php
  if (session_status() == PHP_SESSION_NONE)
  {
    session_start();
  }
  require_once('config/connection.php');
  // unset($_SESSION['films']);
  // unset($_SESSION['customer']);
  // unset($_SESSION['rental']);
  // unset($_SESSION['employee']);
?>

<html lang="pl">
  <body id="page-top">

      <!-- Page Wrapper -->
      <div id="wrapper">

          <!-- Sidebar -->
          <?php include('addons/sidebar.php'); ?>
          <!-- End of Sidebar -->

          <!-- Content Wrapper -->
          <div id="content-wrapper" class="d-flex flex-column">

              <!-- Main Content -->
              <div id="content">

                  <!-- Topbar -->
                  <?php include('addons/topbar.php');  ?>
                  <!-- End of Topbar -->

                  <!-- Begin Page Content -->
                  <div class="container-fluid">

                      <!-- Page Heading -->
                      <div class="d-sm-flex align-items-center justify-content-between mb-4">
                          <h1 class="h3 mb-0 text-gray-800">Wyszukiwarka</h1>
                      </div>

                      <div class="row">

                          <!-- Loops area -->
                          <div class="col-xl-12 col-lg-12">
                              <div class="card shadow mb-4">
                                  <!-- Card Body -->
                                  <div class="card-body">
                                      <div class="row">
                                          <div class = "col-md-12">
                                            <?php
                                              // $_SESSION['search'] = $_GET['search'];
                                              $search = trim($_GET['search']);

                                              echo '<h2 class="h5 mb-0 text-gray-700">Wyniki dla frazy: "'.$search.'"</h2><br>';

                                              if (!isset($_SESSION['loginStatus']))
                                              {
                                                echo 'Zaloguj się';
                                              }
                                              else
                                              {

                                                if (isset($_GET['films']))
                                                {
                                                  // if (isset($_GET['order']))
                                                  // {
                                                  //   $order = $_GET['order'];
                                                  // }
                                                  // else {
                                                  //   $order = 'film_id';
                                                  // }

                                                  // if (isset($_GET['sort']))
                                                  // {
                                                  //   $sort = $_GET['sort'];
                                                  // }
                                                  // else {
                                                  //   $sort = 'ASC';
                                                  // }
                                                    $parametrs = array();

                                                  if (isset($_GET['films']))
                                                  {
                                                    // $search = trim($_GET['search']);
                                                    $query = "SELECT
                                                    film_id,
                                                    title,
                                                    release_year,
                                                    name,
                                                    length,
                                                    rental_rate
                                                    FROM
                                                    film AS F
                                                    JOIN language AS L ON F.language_id = L.language_id
                                                    WHERE title LIKE ?";
                                                    $parametrs[] = "'%$search%'";
                                                    $_SESSION['search'] = $search;
                                                  }
                                                  else {
                                                    if (isset($_GET['search']) && strlen($_GET['search']) > 0) {
                                                      $search = $_SESSION['search'];
                                                      $query = "SELECT
                                                      film_id,
                                                      title,
                                                      release_year,
                                                      name,
                                                      lenght,
                                                      rental_rate
                                                      FROM
                                                      film AS F
                                                      JOIN language AS L ON F.language_id = L.language_id
                                                      WHERE title LIKE ?";
                                                      $parametrs[] = "'%$search%'";
                                                    }
                                                  }

                                                  if (isset($_GET['sort']) && strlen($_GET['sort']) > 0)
                                                  {
                                                    $sort = addslashes(trim($_GET['sort']));
                                                    $query = "SELECT
                                                    film_id,
                                                    title,
                                                    release_year,
                                                    name,
                                                    length,
                                                    rental_rate
                                                    FROM
                                                    film AS F
                                                    JOIN language AS L ON F.language_id = L.language_id
                                                    ORDER BY $sort";
                                                  }

                                                  $result = $connection->prepare($query);
                                                  $result->execute($parametrs);

                                                  if ($result->num_rows() == 0)
                                                  {
                                                    echo 'Brak danych';
                                                  }
                                                  else
                                                  {
                                                    // $sort == "DESC" ? $sort = "ASC" : $sort = "DESC";

                                                    echo  "<table class='table'>
                                                    <thead class='table-dark'>
                                                    <tr>
                                                    <th><a href='?sort=film_id' class='text-light' name='sortFilmId'>ID</a></th>
                                                    <th><a href='?sort=title' class='text-light' name='sortTitle'>Tytuł</a></th>
                                                    <th><a href='?sort=release_year' class='text-light' name='sortReleaseYear'>Data produkcji</a></th>
                                                    <th><a href='?sort=name' class='text-light' name='sortName'>Jęyk</a></th>
                                                    <th><a href='?sort=length' class='text-light' name='sortLength'>Czas</a></th>
                                                    <th><a href='?sort=rantal_rate' class='text-light' name='sortRentalRate'>Cena</a></th>
                                                    </tr>
                                                    </thead>";

                                                    while ($row = $result->fetch())
                                                    {
                                                      $filmId = $row['film_id'];
                                                      $title = $row['title'];
                                                      $releaseYear = $row['release_year'];
                                                      $name = $row['name'];
                                                      $length = $row['length'];
                                                      $rentalRate = $row['rental_rate'];

                                                      echo '<tbody>
<<<<<<< HEAD
                                                      <td>'.$row['film_id'].'</td>
                                                      <td>'.$row['title'].'</td>
                                                      <td>'.$row['release_year'].'</td>
                                                      <td>'.$row['name'].'</td>
                                                      <td>'.$row['length'].'</td>
                                                      <td>'.$row['rental_rate'].'</td>
=======
                                                      <td>'.$filmId.'</td>
                                                      <td>'.$title.'</td>
                                                      <td>'.$releaseYear.'</td>
                                                      <td>'.$name.'</td>
                                                      <td>'.$length.'</td>
                                                      <td>'.$rentalRate.'</td>
>>>>>>> 3f711eb0c7bb4140c0bc48fa37e57a6043073af2
                                                      </tbody>';
                                                    }
                                                    echo  '</table>';
                                                  }
                                                }
                                                elseif (isset($_GET['customer']))
                                                {
                                                  $query = "SELECT * FROM customer WHERE first_name LIKE '%$search%' OR last_name LIKE '%$search%' OR email LIKE '%$search%'";
                                                  $result = $connection->query($query);
                                                  if (mysqli_num_rows($result) == 0)
                                                  {
                                                    echo 'Brak danych';
                                                  }
                                                  else
                                                  {
                                                    echo  '<table class="table">
                                                    <thead class="table-dark">
                                                    <tr>
                                                    <th>Wyniki wyszuliwań</th>
                                                    <th></th>
                                                    <th></th>
                                                    </tr>
                                                    </thead>';
                                                    while ($row = $result->fetch_assoc())
                                                    {
                                                      echo '<tbody>
                                                      <td>'.$row['first_name'].'</td>
                                                      <td>'.$row['last_name'].'</td>
                                                      <td>'.$row['email'].'</td>
                                                      </tbody>';
                                                    }
                                                      echo  '</table>';
                                                    }
                                                  }
                                                  elseif (isset($_GET['rental']))
                                                  {
                                                    $query = "SELECT
                                                    rental_date,
                                                    return_date,
                                                    inventory_id,
                                                    first_name,
                                                    last_name
                                                    FROM
                                                    rental AS F
                                                    JOIN customer AS L ON F.customer_id = L.customer_id
                                                    WHERE first_name LIKE '%$search%' OR last_name LIKE '%$search%'
                                                    ORDER BY rental_date DESC
                                                    LIMIT 10";
                                                    $result = $connection->query($query);
                                                    if (mysqli_num_rows($result) == 0)
                                                    {
                                                      echo 'Brak danych';
                                                    }
                                                    else
                                                    {
                                                      echo
                                                      '<table class="table">
                                                      <thead class="table-dark">
                                                      <tr>
                                                      <th>Data wypożyczenia</th>
                                                      <th>Imię</th>
                                                      <th>Nazwisko</th>
                                                      <th>Data zwrotu</th>
                                                      </tr>
                                                      </thead>';
                                                      while ($row = $result->fetch_assoc())
                                                      {
                                                        echo
                                                        '<tbody>
                                                        <td>'.$row['rental_date'].'</td>
                                                        <td>'.$row['first_name'].'</td>
                                                        <td>'.$row['last_name'].'</td>
                                                        <td>'.$row['return_date'].'</td>
                                                        </tbody>';
                                                      }
                                                        echo  '</table>';
                                                      }
                                                    }
                                                  elseif (isset($_GET['employee']))
                                                  {
                                                    $query = "SELECT * FROM employee
                                                    WHERE firstNameUser LIKE '%$search%' OR lastNameUser LIKE '%$search%' OR emailUser LIKE '%$search%'";
                                                    $result = $connection->query($query);
                                                    if (mysqli_num_rows($result) == 0)
                                                    {
                                                      echo 'Brak danych';
                                                    }
                                                    else
                                                    {
                                                      echo  '<table class="table">
                                                      <thead class="table-dark">
                                                      <tr>
                                                      <th>Imię</th>
                                                      <th>Nazwisko</th>
                                                      <th>Adres e-mail</th>
                                                      </tr>
                                                      </thead>';
                                                      while ($row = $result->fetch_assoc())
                                                      {
                                                        echo '<tbody>
                                                        <td>'.$row['firstNameUser'].'</td>
                                                        <td>'.$row['lastNameUser'].'</td>
                                                        <td>'.$row['emailUser'].'</td>
                                                        </tbody>';
                                                      }
                                                        echo  '</table>';
                                                      }
                                                    }
                                                  }
                                            ?>
                                          </div>
                                        </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <!-- /.container-fluid -->

              </div>
              <!-- End of Main Content -->

              <!-- Footer -->
              <?php include('addons/footer.php'); ?>
              <!-- End of Footer -->

          </div>
          <!-- End of Content Wrapper -->

      </div>
      <!-- End of Page Wrapper -->

      <!-- Scroll to Top Button-->
      <?php include('addons/scroll.php'); ?>

      <!-- Logout Modal-->
      <?php include('addons/logoutmodal.php'); ?>

      <!-- Bootstrap core JavaScript-->
      <?php include('addons/js.php'); ?>

  </body>
</html>
