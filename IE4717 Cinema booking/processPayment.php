<?php
include "dbconnect.php";
session_start();
$name = $_POST['name'];
$email = $_POST['email'];
$cc = $_POST['cc'];
$screen_id= $_SESSION['screening_id'];
$booking_query = "insert into booking (screening_id,name,email,cc) values('".$screen_id."','".$name."','".$email."','".$cc."')";
$result = $dbcnx->query($booking_query);
$id = $dbcnx->insert_id;
foreach ($_SESSION['seats'] as $seat) {
    $seats_booked_query = "insert into seats_booked (seat_id,booking_id,screening_id) values ('".$seat."','".$id."','".$screen_id."')";
    $seats_booked_result = $dbcnx->query($seats_booked_query);
}
$date = date("d-m-Y", strtotime(substr($_SESSION['timing'],0,10)));
$time = substr($_SESSION['timing'],11);
$to='f32ee@localhost';
$subject = 'EL cinema: movie ticket purchase';
$message = 'Thanks for purchasing at EL cinema.'. "\r\n" .
            'Booking_id: '.$id."\r\n" .
            'Movie: '.$_SESSION['movie']."\r\n" .
            'name: '.$name."\r\n" .
            'email: '.$email."\r\n" .
            'Screening Time and Date: '.$date.' '.$time. "\r\n" .
            'Seat: ';
            foreach($_SESSION["seats"] as $seat){
                $message.='S'.$seat.' ';
            }
        
$headers = 'From: f32ee@localhost' . "\r\n" .
'Reply-To: f32ee@localhost' . "\r\n" .
'X-Mailer: PHP/' . phpversion();
mail($to, $subject, $message, $headers,'-ff32ee@localhost');
echo ("mail sent to : ".$to);
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
            justify-content:center;
            align-items:center;
            flex-direction:column;
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
        .circle{
            border: 2px solid #DD5353;
            border-radius:50%;
        }
        .booking{
            margin:25px;
            /* border:1px solid #EAEAEA; */
            background-color:#eaeaea;
        }
        .booking th{
            background-color:#222831;
            color:white;
            border-bottom: 1px solid #EAEAEA;
            padding:15px;
            
            
        }
        .booking td{
            text-align:center;
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid black;
        }
        p{
            margin:0;
            padding:5px;
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
            <li>1.Seat Selection</li>
            <li>2.Payment Selection</ulil>
            <li class="circle">3.Confirmation</li>
        </ol></h1>
    </div>
    <div class="container">
        <p>Thank you for booking with us. Here is your booking details:<br></p>
        <table class="booking">

            <thead>
                <tr>
                    <th colspan="2">Booking Summary</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Booking ID:</td>
                    <td><?php echo $id?></td>
                </tr>
                <tr>
                    <td>Movie:</td>
                    <td><?php echo $_SESSION['movie']?></td>
                </tr>
                <tr>
                    <td>Name:</td>
                    <td><?php echo $name?></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><?php echo $email?></td>
                </tr>
                <tr>
                    <td>Screening Time and Date:</td>
                    <td><?php echo $date; echo $time;?></td>
                </tr>
                <tr>
                    <td>Seats:</td>
                    <td><?php foreach ($_SESSION['seats'] as $seat){ echo "S".$seat." ";}?></td>
                </tr>
                <tr>
                    <td>Amount:</td>
                    <td>$40</td>
                </tr>
                <tr>
                    <td colspan="2">Your booking details will be sent to your email.</td>
                </tr>
            </tbody>
        </table>
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
</html>

<?php
unset($_SESSION['movie']);
unset($_SESSION['seats']);
unset($_SESSION['screening_id']);
unset($_SESSION['timing']);
session_destroy();
exit();
?>