<?php
  if (session_status() == PHP_SESSION_NONE)
  {
    session_start();
  }
  require_once('config/connection.php');
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
                          <h1 class="h3 mb-0 text-gray-800">Karta pracowników</h1>
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
                                              $search = $_POST['search'];
                                              // echo $search;

                                              if (!isset($_SESSION['loginStatus']))
                                              {
                                                echo 'Zaloguj się';
                                              }
                                              else
                                              {
                                                $query = "SELECT * FROM customer WHERE first_name LIKE '%".$search."%'";
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
                                                  </tr>
                                                  </thead>';
                                                  while ($row = $result->fetch_assoc())
                                                  {
                                                    echo '<tbody>
                                                    <td>'.$row['first_name'].'</td>
                                                    </tbody>';
                                                  }
                                                  echo  '</table>';
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
