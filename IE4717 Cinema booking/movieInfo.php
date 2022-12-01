<?php
include "dbconnect.php";
session_start();
$_SESSION['movie'] = $_GET['role'];
$movie = $_SESSION['movie'];
$query = 'select * from movies '
."where title='$movie' ";
date_default_timezone_set('Asia/Singapore');
$date_today = strtotime(date('d-m-Y h:i:s'));
$result = $dbcnx->query($query);
$row=mysqli_fetch_assoc($result);
$screening_query = "select * from screenings where movie_id=".$row['movie_id'];
$screening_result = $dbcnx->query($screening_query);
$counter = 0;
// $screening_row = mysqli_fetch_assoc($screening_result);
// $cinema_query = "select * from cinemas where cinema_id =".$screening_row['cinema_id'];
// $cinema_result = $dbcnx->query($cinema_query);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>EL Cinema</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="style.css" />
    <style>
        .container{
          display:flex;
          flex-direction:row;
          align-items:center;
          justify-content:center;
          height:76vh;
        }
        #movie{
            margin:auto;
            line-height:0;
        }
        #movie td{
          padding:20px;
        }
        h3{
          padding:0px;
          padding-bottom:2px;
          margin:0px;
        }
        img{
          border-radius:10%;
          padding: 15px;
          margin:10px;
        }
        input[type=submit]{
          padding:5px;
          width:100%;
          margin-top:10px;
          border-radius:30px;
          background-color:#222831;
          color:#ffffff;
          font-size:1.05rem;
        }
        input[type=submit]:hover{
          background-color:#B2B2B2;
          color:#222831;
        }
        #cslabel{
          color:red;
          text-align:center;
          display:none;
          font-size:1.5rem;
        }
        td select{
          padding:5px;
          margin:5px 0px 15px 0px;
          width:55%;
        }
        .heading{
          color:black;
        }
    </style>
  </head>
  <body>
    <nav>
      <ul>
        <li><a href="index.html">Home</a></li>
        <li><a href="movies.php">Movies</a></li>
        <li><a href="booking.php">Booking</a></li>
      </ul>
    </nav>
    <div class="container">
      <table id="image-table">
          <tr>
            <td><?php echo '<img src="data::/png;base64,'.base64_encode($row['movie_pic']).'" width="300" height="400"/>'?></td> 
          </tr>
        </table>
      <form action="seatselection.php" method="get">
        <table id="movie">
              <tr>
                <td colspan="2"></td>
              </tr>
                <tr>
                    <td><strong><h3>Title</h3></strong><?php echo'<p>'.$row['title'].'</p>'?></td>
                    <td><strong><h3>Director</h3></strong><?php  echo'<p>'.$row['director'].'</p>'?></td>
                </tr>
                <tr>
                    <td><strong><h3>Running Time</h3></strong><?php  echo '<p>'.$row['duration_min'].'</p>'?></td>
                    <td><strong><h3>Cast</h3></strong><?php  echo '<p>'.$row['cast'].'</p>'?></td>
                </tr>
                <tr>
                    <td colspan="2" class="summary"><strong><h3>Summary</h3></strong><?php  echo '<p>'.$row['description'].'</p>'?></td>
                </tr>
                <tr>
                  <td colspan="2">
                    <?php
                    echo 'Choose a timing: <select name="timing" id="timing">';
                    $num_result = $screening_result->num_rows;
                    
                    for ($i=0;$i<$num_result;$i++){
                      $screen_row = $screening_result->fetch_assoc();
                      if($date_today<=strtotime(date("d-m-Y H:i:s",strtotime($screen_row['screen_start']))))
                      {
                          echo '<option value="'.htmlspecialchars($screen_row['screen_start']).'">'.$screen_row['screen_start'].'</option>';  
                          $counter = $counter + 1;
                      }
                        }
                      ?>
                      <input type="Submit" value="Select" id="selectBtn">
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <p id="cslabel">Coming Soon</p></td>
                  </tr>
                </table>
        </form>
      </div>

  </body>
  <footer>
      <ul class="list">
        <li>
          <a href="index.html">Home</a>
        </li>
        <li>
          <a href="movies.php">Movies</a>
        </li>
        <li>
          <a href="login.html">Login</a>
        </li>
      </ul>
      <p class="copyright">EL Cinema &copy; 2022</p>
    </footer>
    <script>
      var num_result = <?php echo $num_result?>;
      var counter = <?php echo $counter?>;
      if (counter == 0){
        document.getElementById("cslabel").style.display="block";
        document.getElementById("timing").style.display="none";
        document.getElementById("selectBtn").style.display="none";
      }

      // if (num_result>0){
      //   document.getElementById("timing").style.display="block";
      // }
      // else{
      //   document.getElementById("cslabel").style.display="block";
      // }
    </script>
</html>
