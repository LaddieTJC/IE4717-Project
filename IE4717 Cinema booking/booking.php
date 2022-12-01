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
      }
      select{
        padding: 5px;
        width:100%;
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
      input[type=email]{
        height: 40px;
        display:flex;
        text-align:center;
        font-size:30px;
      }
      input[type=submit]{
          padding:5px;
          width:100%;
          margin-top:5px;
          border-radius:30px;
          background-color:#222831;
          color:#ffffff;
          font-size:1.5rem;
          text-align:center;
        }
      input[type=submit]:hover{
          background-color:#B2B2B2;
          color:#222831;
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
        <form name="form_email" id="form_email" action="receipt.php" method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <td><b>Enter email:</b></td>
                    <td><input type="email" name="enter_email" id="enter_email" size="50"></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="Check" value="Check"/></td>
                </tr>
            </table>
        </form>
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
