<?php
include "dbconnect.php";
$query = "select * from movies";

$result = $dbcnx->query($query);
$x=0;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>EL Cinema</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="style.css" />
  </head>
  <style>
    table{
        margin:auto;
        padding-top:50px;
        padding-bottom:50px;
    }
    td {
        padding:5px 70px 40px 70px;
        text-align:center;
        font-size:1.1rem;
    }
    .movie-title{
      text-decoration: none;
      color: black;
    }
    img{
      border-radius:5%;
    }

  </style>
  <body>
    <nav>
      <ul>
        <li><a href="index.html">Home</a></li>
        <li><a href="movies.php">Movies</a></li>
        <li><a href="booking.php">Booking</a></li>
      </ul>
    </nav>
    <?php
        echo "<table><tr>";
        $num_result = $result->num_rows;
        if($num_result > 0){
          while($row = mysqli_fetch_assoc($result)){
            $x++;
            echo '<div class="movie-border">';
            echo '<td><a href="movieInfo.php?role='.$row['title'].'" class="movie-title""><img src="data::/png;base64,'.base64_encode($row['movie_pic']).'" width="200" height="300"/><br><strong>'.$row['title'].'</a></strong><br>Duration: '.$row['duration_min'].' mins</td></div>';
            if ($x % 4 == 0){
                echo'</tr><tr>';
            }
        }
        echo "</tr></table>";
        }
        else{
          echo "<h1>No movies available<h1>";
        }


    ?>
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
</html>
