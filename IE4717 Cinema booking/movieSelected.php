<?php
include "dbconnect.php";
session_start();
$movie = $_SESSION['movie'];
if(!isset($_GET['seats'])){
    echo "Select a seat";
}
else{
    $_SESSION['seats'] = $_GET['seats'];
    $seats = $_SESSION['seats'];

}
$query = 'select * from movies '
."where title='$movie' ";
$result = $dbcnx->query($query);
$row=mysqli_fetch_assoc($result);
$screening_query = "select * from screenings where movie_id=".$row['movie_id']."";
$screening_result = $dbcnx->query($screening_query);
$screening_row = mysqli_fetch_assoc($screening_result);
$date = date("d-m-Y", strtotime(substr($_SESSION['timing'],0,10)));
$time = substr($_SESSION['timing'],11);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>EL Cinema</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="style.css" />
    <style>
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
        .container{
            display:flex;
            width:100%;
            align-items:top;
            justify-content:center;
            /* background-color:white; */
            height:61vh;
        
        }
        input[type=text]{
            width:250px;
        }
        input[type=email]{
            width:250px;
        }
        input[type=submit]{
          padding:5px;
          width:100%;
          margin-top:15px;
          border-radius:30px;
          background-color:#222831;
          color:#ffffff;
          font-size:1.05rem;
        }
        input[type=submit]:hover{
          background-color:#B2B2B2;
          color:#222831;
        }
        table{
            margin:auto;
        }
        td{
            text-align:right;
            margin:auto;
            /* border:1px solid black; */
            padding:5px;
        }
        .error {
            border:2px solid red;
        }
        img{
            width:2.5rem;
            height:1.5rem;
            margin:3px;
        }
        .cc-logo{
            display:flex;
            flex-direction:row;
            justify-content:center;
        }
        .visa{
            display:none;
        }
        .master{
            display:none;
        }
        .seat-header{
            text-align:center;
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
            <li class="circle">2.Payment Selection</ulil>
            <li>3.Confirmation</li>
        </ol></h1>
    </div>
    <div class="container">

    <form action="processPayment.php" method="post" onsubmit="return confirmation()">
    <table>
        <tr>
            <td colspan="2" class="seat-header"><h4>You have selected seat <span style="color:#DD5353"><?php foreach ($seats as $seat){ 
        echo "S".$seat." ";
    }?></span></h4></td>
        </tr>
        <tr>
            <td><label for="name">Name:</label></td>
            <td><input type="text" name="name" id="name" placeholder="No Numbers or Special Characters"><br>
            </td>
        </tr>
        <tr>
            <td><label for="email" >Email:</label></td>
            <td><input type="email" name="email" id="email" placeholder="example@gmail.com.sg"><br></td>
        </tr>
            <td><label for="cc">Credit Card:</label></td>
            <td><input type="text" name="cc" id="cc"><br></td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="cc-logo">
                <img src="img/mastercard.png" alt="Mastercard" class="master">
                <img src="img/visa.jpg" alt="Visa" class="visa"><br>
                </div>
            </td>
        </tr>
        <tr>
        <td colspan="2"><input type="submit"></td>
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
            const name = document.getElementById('name')
            const cc = document.getElementById('cc');
            const email = document.getElementById('email');

            name.addEventListener('input',function(e){
                name_check = e.target.value;
                if (!name_check.match(/^[A-Za-z\s]+$/)) {
                    document.getElementById("name").className = 'error';
                }
                else{
                    document.getElementById("name").className = '';
                }
            })
            cc.addEventListener('input', function(e){
                cc_check = e.target.value;
                if(cc_check.match(/^(5[1-5][0-9]{14}|2(22[1-9][0-9]{12}|2[3-9][0-9]{13}|[3-6][0-9]{14}|7[0-1][0-9]{13}|720[0-9]{12}))$/)){
                    document.getElementsByClassName("master")[0].style.display = 'block';
                    document.getElementById("cc").className = '';
                }
                else if(cc_check.match(/^4[0-9]{12}(?:[0-9]{3})?$/)){
                    document.getElementsByClassName("visa")[0].style.display = 'block';
                    document.getElementById("cc").className = '';
                }
                else{
                    document.getElementsByClassName("master")[0].style.display = 'none';
                    document.getElementsByClassName("visa")[0].style.display = 'none';
                    document.getElementById("cc").className = 'error';
                }
            })
            email.addEventListener('input',function(e){
                email_check = e.target.value;
                if (!email_check.match(/^[\w.-]+@[\w]+(\.[A-Za-z]{2,3}){1,3}\.[A-Za-z]{2,3}$/)) {
                    document.getElementById("email").className = 'error';
                }
                else{
                    document.getElementById('email').className = '';
                }

            })
            function confirmation(){
                const name = document.getElementById('name').value;
                const cc = document.getElementById('cc').value;
                const email = document.getElementById('email').value;
                if (!name.match(/^[A-Za-z\s]+$/)) {
                    alert('Name is wrong format, Please do not include any special characters or numbers')
                    return false;
                }
                if (!email.match(/^[\w.-]+@[\w]+(\.[A-Za-z]{2,3}){1,3}\.[A-Za-z]{2,3}$/)){
                    alert('Email is wrong format. Make sure its test@example.com.sg');
                    return false;
                }
                else {
                    if((cc.match(/^(5[1-5][0-9]{14}|2(22[1-9][0-9]{12}|2[3-9][0-9]{13}|[3-6][0-9]{14}|7[0-1][0-9]{13}|720[0-9]{12}))$/)) || (cc.match(/^4[0-9]{12}(?:[0-9]{3})?$/))){
                        alert('Thank you for booking');
                        return true;
                        }
                    else
                    {
                        alert('Wrong cc info');
                        return false;
                    }
                };
            }
                
    </script>
</html>

