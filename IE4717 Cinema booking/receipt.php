<?php
    include "dbconnect.php";

    $email = $_POST['enter_email'];
    $query = "select * from booking";
    $result = $dbcnx->query($query);
    $name=array();
    $screening_id=array();
    $booking_id=array();
    while($row = $result->fetch_assoc()){
        if($email==$row['email']){
            array_push($name,$row['name']);
            array_push($booking_id,$row['booking_id']);
            array_push($screening_id,$row['screening_id']); //for movie title and date_time
        }
    }
    if(empty($booking_id)){
        echo '<script type="text/javascript">alert("No email found!");history.go(-1);</script>';
    }
    else{
    $movie_id=array();
    $date_time=array();
    foreach($screening_id as $int){
        $query_screenings = "select * from screenings";
        $result_screenings = $dbcnx->query($query_screenings);
        while($row_screenings = $result_screenings->fetch_assoc()){
            if($int==$row_screenings['screening_id']){
                array_push($movie_id,$row_screenings['movie_id']);
                array_push($date_time,$row_screenings['screen_start']);
            }
        }
    }
    $movie_title=array();
    foreach($movie_id as $int){
        $query_movies = "select * from movies";
        $result_movies = $dbcnx->query($query_movies);
        while($row_movies = $result_movies->fetch_assoc()){
            if($int==$row_movies['movie_id']){
                array_push($movie_title,$row_movies['title']);
            }
        }
    }
    $seat_for=[];
    $seat=[];
    foreach($booking_id as $int){
        $query_seats_booked = "select * from seats_booked";
        $result_seats_booked = $dbcnx->query($query_seats_booked);
        while($row_seats_booked = $result_seats_booked->fetch_assoc()){
            if($int==$row_seats_booked['booking_id']){
                array_push($seat,$row_seats_booked['seat_id']);
                array_push($seat_for,$int);
            }
        }
    }
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<script type="text/javascript">
    window.onload = function(event) {
        reset_selectEdit=document.getElementById('select_booking_id');
        reset_selectEdit.selectedIndex = -1;
    }
    const name= <?php echo json_encode($name);?>; 
    var booking_id= <?php echo json_encode($booking_id);?>; 
    const date_time= <?php echo json_encode($date_time);?>; 
    const movie_title= <?php echo json_encode($movie_title);?>; 
    var seat_for= <?php echo json_encode($seat_for);?>; 
    var seat= <?php echo json_encode($seat);?>; 
    function update_details(value){
        let index = booking_id.indexOf(value);
        document.getElementById("name_td").innerHTML = name[index];
        document.getElementById("title_td").innerHTML = movie_title[index];
        document.getElementById("date_time_td").innerHTML = date_time[index];
        var seat_for_id= []; 
        for(let i=0;i<seat_for.length;i++){
            if(value==seat_for[i]){
                seat_for_id.push(seat[i]);
            }
        }
        document.getElementById("seat_td").innerHTML = seat_for_id;
    }
</script>
  <head>
    <title>EL Cinema</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="style.css" />
    <style>
      .container{
        display:flex;
        justify-content:center;
        align-items:center;
        flex-direction:column ;
        font-size:40px;
        height:80vh;
      }
      p{
        display: flex;
        justify-content: center;
      }
      form{
        display: flex;
        justify-content: center;
      }
      table{
        margin:auto;
        display: flex;
        justify-content: center;
        margin-top:40px;
        margin-bottom:40px;
        background-color:#EAEAEA;
        border-collapse: collapse;
        border-radius: 10px;
        border-style: hidden; /* hide standard table (collapsed) border */
        box-shadow: 0 0 0 1px #666; /* this draws the table border  */ 
      }
      select{
        padding: 5px;
        width:100%;
        display:flex;
        text-align:center;
        font-size:30px;
      }
      input{
        height: 30px;
        display:flex;
        text-align:center;
      }
      tr{
        border-bottom: 1px solid white;
      }
      tr:last-child {
        border-bottom: none;
      } 
      td{
        padding:5px;
        overflow:auto;
        text-align:right;
      }
      td:nth-child(2) {
        border-left:1px solid white;
        text-align:center;
      }
      th{
        border-top-left-radius:10px;
        border-top-right-radius:10px;
        background-color:black;
        color: white;
        font-size:60px;
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
        <table>
        <tr>
            <td><b>Entered email:</td>
            <td><?php echo $email; ?></td>
        </tr>
        <tr>
            <td><b>Booking ID:</td>
            <td>
                <select name="select_booking_id" id="select_booking_id" onchange="update_details(this.value)">
                <?php
                    $query = "select * from booking";
                    $result = $dbcnx->query($query);
                    while($row = $result->fetch_assoc()){
                        if($email==$row['email']){?>
                        <option value="<?php echo $row['booking_id']; ?>">
                            <?php echo $row['booking_id']; ?>
                        </option>
                    <?php }
                    }
                ?>
            </td>
        </tr>
        </table>
        <table>
        <tr>
            <th colspan="2"><b>Details</td>
        </tr>
        <tr>
            <td><b>Name:</td>
            <td id="name_td">-</td>
        </tr>
        <tr>
        
            <td><b>Movie title:</td>
            <td id="title_td">-</td>
        </tr>
        <tr>
            <td><b>Movie date & time:</td>
            <td id="date_time_td">-</td>
        </tr>
        <tr>
            <td><b>Seat no:</td>
            <td id="seat_td">-</td>
        </tr>
        </table>
    </div>
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
  </body>
</html>
