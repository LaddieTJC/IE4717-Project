<?php include "dbconnect.php";
session_start();

$query_title_movies ="SELECT title FROM movies";
$result = $dbcnx->query($query_title_movies);
if($result->num_rows> 0){
  $options= mysqli_fetch_all($result, MYSQLI_ASSOC);
}
$query_all_movies ="SELECT * FROM movies";
$result_all_movies = $dbcnx->query($query_all_movies);
$movies=array();
$movies_id=array();
while($row_movies = $result_all_movies->fetch_assoc()){
  array_push($movies,$row_movies['title']);
  array_push($movies_id,$row_movies['movie_id']);
}
$dates=array();
$times=array();
$screenings_movies_id=array();
$query_all_screenings = "select * from screenings";
$result_all_screenings = $dbcnx->query($query_all_screenings);
while($row_screenings = $result_all_screenings->fetch_assoc()){
  array_push($screenings_movies_id,$row_screenings['movie_id']);
  $temp_dates = explode(" ",$row_screenings['screen_start'])[0];
  array_push($dates,$temp_dates);
  $temp_times = explode(" ",$row_screenings['screen_start'])[1];
  array_push($times,$temp_times);
}
?>
<!DOCTYPE html>
<html lang="en">
<script type="text/javascript">
  window.onload = function(event) {
    var tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate()+1);
    tomorrow=tomorrow.toISOString().split('T')[0];
    document.getElementsByName("start-date")[0].setAttribute('min', tomorrow);
    setForm(0);
    reset_selectEdit=document.getElementById('selectEdit');
    reset_selectEdit.selectedIndex = 0;
    reset_select_movie=document.getElementById('select_movie');
    reset_select_movie.selectedIndex = -1;
    };
  function setForm(value) {
      if(value == 'form_delete'){
        document.getElementById('form_delete').style='display:block;';
        document.getElementById('form_add').style='display:none;';
        document.getElementById('form_timing').style='display:none;';
              }
      else if(value == 'form_add'){
          document.getElementById('form_add').style = 'display:block;';
          document.getElementById('form_delete').style = 'display:none;';
          document.getElementById('form_timing').style='display:none;';
      }
      else if(value == 'form_timing'){
          document.getElementById('form_add').style = 'display:none;';
          document.getElementById('form_delete').style = 'display:none;';
          document.getElementById('form_timing').style='display:block;';
      }
      else{
          document.getElementById('form_add').style = 'display:none;';
          document.getElementById('form_delete').style = 'display:none;';
          document.getElementById('form_timing').style='display:none;';
      }
  }
  
</script>
  <head>
    <title>EL Cinema</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="style.css" />
    <style>
      body{
        min-width:1300px;
      }
      .container{
        margin:auto;
        width:50%;
        font-size:40px;
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
      textarea{
        resize: none;
        font-size:20px;
        display:flex;
      }
      select{
        padding: 5px;
        width:100%;
      }
      input[type=number]{
        width:95%;
      }
      input[type=date]{
        width:95%;
        font-size:30px;
      }
      input[type=submit]{
          padding:5px;
          height:40px;
          width:100%;
          margin-top:15px;
          border-radius:30px;
          background-color:#222831;
          color:#ffffff;
          font-size:1.5rem;
        }
        input[type=submit]:hover{
          background-color:#B2B2B2;
          color:#222831;
        }
      .delete_div{
        display:flex;
        justify-content:center;
        align-items:center;
        flex-direction:column ;
        min-width: 250px;
        padding:5px;
        margin-bottom: 50px;
      }
      label{
        padding:5px;
        margin-bottom:20px;
      }
    </style>
  </head>
  <body>
    <nav>
      <ul>
        <li><a href="editMovie.php">Edit Movie</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
    <div class="container">
      <?php
      echo "<p>you are logging in as ".$_SESSION['valid_user']."</p>"?>
      <form>
        <table>
      <tr>
        <td>
          <b>Select edit: <b></td>
        <td>
          <select name="selectEdit" id="selectEdit" onchange="setForm(this.value)">
            <option value=" " selected>choose here</option>
            <option value="form_add">Add</option>
            <option value="form_delete">Delete</option>
            <option value="form_timing">Add timing</option>
          </select></td></tr></table>
      </form>

      <form name="form_add" id="form_add" action="upload.php" method="post" enctype="multipart/form-data">
        <table>
          <tr>
            <td>
              <b>Title</b>
            </td>
            <td>
              <textarea id="title" name="title" cols="30" required></textarea>
            </td></tr>
          <tr>
            <td>
              <b>Director</b>
            </td>
            <td>
              <textarea id="director" name="director" cols="30" required></textarea>
            </td></tr>
          <tr>
            <td>
              <b>Cast</b>
            </td>
            <td>
              <textarea id="cast" name="cast" cols="30 required"></textarea>
            </td></tr>
          <tr>
            <td>
              <b>Description</b>
            </td>
            <td>
            <textarea id="description" name="description" rows="3" cols="30" required></textarea>
            </td></tr>
          <tr>
            <td>
              <b>Duration_min</b>
            </td>
            <td>
              <input type="number" id="duration_min" name="duration_min" min="0" oninput="this.value = Math.abs(this.value)" required>
            </td></tr>
          
          <tr>
            <td>
              <b>Movie_pic</b>
            </td>
            <td>
              <input type="file" name="image" required/>
            </td></tr>
            <tr><td colspan="2"><input type="submit" name="submit" value="UPLOAD"/></td></tr>
        </table>
      </form>

      <form name="form_delete" id="form_delete" method="post" action="upload.php">
        <div class="delete_div">
          <label><b>Select movie to delete:</b><br></label>
        <select name="deleteTitle" id="deleteTitle">
          <?php foreach ($options as $option) {?>
          <option><?php echo $option['title']; ?> </option>
          <?php }?>
        </select>
        <input type="submit" name="confirmDelete" value="Delete"/>
        </div>
        
      </form>

      <form name="form_timing" id="form_timing" method="post" action="upload.php">
        <table>
          <tr>
            <td>
              <b>Select movie:</b>
            </td>
            <td>
              <select name="select_movie" id="select_movie" onchange="time_load()">
              <?php foreach ($options as $option) {?>
              <option value="<?php echo $option['title']; ?>"><?php echo $option['title']; ?> </option>
              <?php }?>
              </select></td></tr>
          <tr>
            <td>
              <b>Date</b>
            </td>
            <td>
              <input id="start-date" type="date" name="start-date" onchange="time_load()"/>
            </td></tr>
          <tr>
            <td>
              <b>Time</b>
            </td>
            <td>
              <select name="selectTime" id="selectTime">
            </td></tr>
          <tr><td colspan="2"><input type="submit" name="AddButton" value="Add"/></td></tr>
          </table>
        </form>
    </div>
  </body>
  <footer>
      <ul class="list">
      </ul>
      <p class="copyright">EL Cinema &copy; 2022</p>
  </footer>

</html>
<script type="text/javascript">
  function time_load(){
    var screenings_movies_id=<?php echo json_encode($screenings_movies_id);?>;
    var movies=<?php echo json_encode($movies);?>; 
    var movies_id=<?php echo json_encode($movies_id);?>; 
    var dates= <?php echo json_encode($dates);?>; 
    var times= <?php echo json_encode($times);?>; 
    var new_dates=[];
    var new_times=[];
    let field = document.getElementById('start-date').value;
    let selected_movie = document.getElementById('select_movie').value;
    var index = movies.indexOf(selected_movie);
    var daySelect = document.getElementById("selectTime");
    var length = daySelect.options.length;
    for (i = length-1; i >= 0; i--) {
      daySelect.options[i] = null;
    }
    if(screenings_movies_id.includes(movies_id[index])){
      for(let i=0;i<screenings_movies_id.length;i++){
        if(screenings_movies_id[i]==movies_id[index]){
          new_dates.push(dates[i]);
          new_times.push(times[i]);
        }
      }
    }
    const temp_times=[];
    for(let i=0;i<new_dates.length;i++){
      if(field==new_dates[i]){
        temp_times.push(new_times[i]);
      }
    }
    console.log(temp_times);
    if(!temp_times.includes("09:00:00")){
      daySelect.options[daySelect.options.length] = new Option('09:00:00', '09:00:00');
    }
    if(!temp_times.includes("13:00:00")){
      daySelect.options[daySelect.options.length] = new Option('13:00:00', '13:00:00');
    }
    if(!temp_times.includes("18:00:00")){
      daySelect.options[daySelect.options.length] = new Option('18:00:00', '18:00:00');
    }
  }
</script>
