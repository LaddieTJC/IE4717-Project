<?php
include "dbconnect.php";
session_start();
$movie = $_SESSION['movie'];
$query = 'select * from movies '
."where title='$movie' ";
$result = $dbcnx->query($query);
$row=mysqli_fetch_assoc($result);
$movie_id = $row['movie_id'];
$_SESSION['timing'] = $_GET['timing'];
$screen_time = $_SESSION['timing'];
$screening_query = 'select * from screenings '
."where movie_id='$movie_id' "
."and screen_start='$screen_time'";
$screening_result = $dbcnx->query($screening_query);
$screening_row = mysqli_fetch_assoc($screening_result);
$_SESSION['screening_id'] = $screening_row['screening_id'];
$date = date("d-m-Y", strtotime(substr($_SESSION['timing'],0,10)));
$time = substr($_SESSION['timing'],11);
$seat_query = "select * from seats_booked where screening_id =".$screening_row['screening_id'];
$seat_result = $dbcnx->query($seat_query);
$seat_num_result = $seat_result->num_rows;
if($seat_num_result > 0){
    $seats_booked = array();
    while($seat_row = mysqli_fetch_assoc($seat_result)){
        array_push($seats_booked,$seat_row['seat_id']);
    }
}


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>EL Cinema</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="style.css" />

    <style>
        #movie{
            margin:auto;
            font-size:1.2rem;
            line-height:0;
            margin-bottom:10px;
            cursor: none;
        }
        img{
          border-radius:10%;
          padding: 15px;
          margin: 0px 0px 0px 0px;
        }
        .container{
            display:flex;
            flex-direction:row;
        }
        .left-container{
            width:50%;
            /* background:red; */
            margin-left:3rem;
        }
        .right-container{
            display:inline-block;
            margin:0px 0px 30px 10px;
            padding: 0px 25px 40px 0px;
            border: 1px solid black;
            text-align:center;
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;
            /* background-color:white; */

        }
        .top-bar{
            text-align:center;
            margin-right:2.5rem;
        }
        .top-bar ol{
            width:100%;
            color: #222831;
        }
        .top-bar li{
            display: inline;   
            padding:15px;   
            margin:auto;
        }
        .step1{
            border: 2px solid #DD5353;
            border-radius:50%;
        }
        .seat{
            background-color:#444451;
            height:25px;
            width:25px;
            margin:5px;
        }
        .row{
            display:flex;
            margin:auto;
            align-items:center;
            justify-content: center;

        }
        .seat.selected{
            background-color:#6fea6f;
        }
        .seat.occupied{
            background-color:#ffffff;
        }
        .right-inner{
            padding:auto;
            margin-left:2.5rem;
        }
        .seat:not(.occupied):hover{
            cursor: pointer;
            transform:scale(1.1,1.1);
        }
        .showcase .seat:not(.occupied):hover{
            cursor:default;
            transform:scale(1);
        }
        .showcase{
            background-color:rgba(0,0,0,0);
            padding:5px 10px;
            margin-left:2.5rem;
            border-radius:5px;
            color:#777;
            display:flex;
            list-style-type:none;
            flex-direction: row;
        }
        .showcase li{
            display:flex;
            align-items:center;
            justify-content:center;
            margin:0 10px;
        }
        .showcase li small{
            margin-left:10px;
        }
        .screen{
            background-color: #fff;
            height: 70px;
            width: 50%;
            margin:auto;
            transform: rotateX(-55deg);
            box-shadow: 0 3px 10px rgba(255,255,255,0.75);
        }
        .top-info{
            margin-left:1.5rem;
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
    <div class="top-bar">
        <h1><ol>
            <li class="step1">1.Seat Selection</li>
            <li class="step2">2.Payment Selection</ulil>
            <li class="step3">3.Confirmation</li>
        </ol></h1>
    </div>
    <div class="container">
        <div class="left-container">
        <table id="movie">
            <thead>
              <tr>
                <th rowspan ="6" colspan="2"><?php echo '<img src="data::/png;base64,'.base64_encode($row['movie_pic']).'" width="300" height="400"/>'?></th>
              </tr>
                </thead>
        </table>
        </div>
        <div class="right-container">
        <h4 class="top-info">You have selected <span style="color:#DD5353"><?php echo $date; echo " ".$time;?></span> slot for <span style="color:#DD5353"><?php echo $row['title']?></span>. </h4>
            <ul class="showcase">
                
                <li>
                    <input type="checkbox" class="seat" checked style="pointer-events: none;">
                    <small>Selected</small>
                </li> 
                <li>
                    <input type="checkbox" class="seat" disabled>
                    <small>Occupied</small>
                </li> 
            </ul>
            <div class="right-inner">
                <form action="movieSelected.php" method="get" id="seat-selection" onsubmit="return checkCount()">
                    <div class="screen"></div>
                    <div class="row">
                        <input type="checkbox" name="seats[]" class="seat check" <?php if(isset($seats_booked)&&in_array(1,$seats_booked)) echo 'disabled style="transform:scale(1);cursor:default"';?> value="1">
                        <input type="checkbox" name="seats[]" class="seat check" <?php if(isset($seats_booked)&&in_array(2,$seats_booked)) echo 'disabled style="transform:scale(1);cursor:default"';?>  value="2">
                        <input type="checkbox" name="seats[]" class="seat check" <?php if(isset($seats_booked)&&in_array(3,$seats_booked)) echo 'disabled style="transform:scale(1);cursor:default"';?>  value="3">
                        <input type="checkbox" name="seats[]" class="seat check" <?php if(isset($seats_booked)&&in_array(4,$seats_booked)) echo 'disabled style="transform:scale(1);cursor:default"';?>  value="4">
                    </div>
                    <div class="row">
                        <input type="checkbox" name="seats[]" class="seat check"<?php if(isset($seats_booked)&&in_array(5,$seats_booked)) echo 'disabled style="transform:scale(1);cursor:default" ';?> value="5">
                        <input type="checkbox" name="seats[]" class="seat check" <?php if(isset($seats_booked)&&in_array(6,$seats_booked)) echo 'disabled style="transform:scale(1); cursor:default"';?>value="6">
                        <input type="checkbox" name="seats[]" class="seat check" <?php if(isset($seats_booked)&&in_array(7,$seats_booked)) echo 'disabled style="transform:scale(1); cursor:default"';?>value="7">
                        <input type="checkbox" name="seats[]" class="seat check" <?php if(isset($seats_booked)&&in_array(8,$seats_booked)) echo 'disabled style="transform:scale(1); cursor:default"';?>value="8">
                    </div>
                    <div class="row">
                        <input type="checkbox" name="seats[]" class="seat check"<?php if(isset($seats_booked)&&in_array(9,$seats_booked)) echo 'disabled style="transform:scale(1);cursor:default" ';?> value="9">
                        <input type="checkbox" name="seats[]" class="seat check" <?php if(isset($seats_booked)&&in_array(10,$seats_booked)) echo 'disabled style="transform:scale(1); cursor:default"';?>value="10">
                        <input type="checkbox" name="seats[]" class="seat check" <?php if(isset($seats_booked)&&in_array(11,$seats_booked)) echo 'disabled style="transform:scale(1); cursor:default"';?>value="11">
                        <input type="checkbox" name="seats[]" class="seat check" <?php if(isset($seats_booked)&&in_array(12,$seats_booked)) echo 'disabled style="transform:scale(1); cursor:default"';?>value="12">
                    </div>
                    <p class="text">
                        You have selected <span id="count"></span> seats for a price of <span id="total"></span>
                    </p>
                    <input type="submit">
                </form>


            </div>
        </div>

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
        function checkCount(){
            var form = document.getElementById('seat-selection');
            var checkedElms = form.querySelectorAll(':checked').length;
            if(checkedElms > 0)
            {
                return true;
            }
            else{
                alert('Please select at least 1 seat');
                return false;
            }
        }

    </script>
</html>
