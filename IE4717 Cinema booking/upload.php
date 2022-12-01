<?php
    include "dbconnect.php";

    if(isset($_POST['submit'])){
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false){
            $image = $_FILES['image']['tmp_name'];
            $imgContent = addslashes(file_get_contents($image));

            // Get data from html
            $movie_id =NULL;
            $title=$_POST['title'];
            $director=$_POST['director'];
            $cast=$_POST['cast'];
            $description=$_POST['description'];
            $duration_min=$_POST['duration_min'];
            $query = "select * from movies";
            $result = $dbcnx->query($query);
            $movie_found = 0;
            while($row = $result->fetch_assoc()){
                if($row['title']==$title){
                    $movie_found=1;
                }
            }
            if($movie_found==1){
                echo '<script type="text/javascript">alert("Movie name already exists!");history.go(-1);</script>';
            }
            else{//Insert details into database
                $insert = $dbcnx->query("INSERT into movies VALUES ('".$movie_id."','".$title."','".$director."','".$cast."','".$description."','".$duration_min."','".$imgContent."')");

                //Auto go back to previous page and prompt alert
                echo '<script type="text/javascript">alert("upload complete!");history.go(-1);</script>';
            }}
        else{
            echo '<script type="text/javascript">alert("upload error!");history.go(-1);</script>';
        }
        
    }
    else if(isset($_POST['confirmDelete'])){
        $query = "select * from booking";
        $result = $dbcnx->query($query);
        $booking_screen=array();
        while($row = $result->fetch_assoc()){
            array_push($booking_screen,$row['screening_id']);
        }
        $screenings=array();
        foreach($booking_screen as $int){
            $query = "select * from screenings";
            $result = $dbcnx->query($query);
            while($row = $result->fetch_assoc()){
                if($int == $row['screening_id']){
                    array_push($screenings,$row['movie_id']);
                }
            }
        }

        $deleteTitle=$_POST['deleteTitle'];
        $query = "select * from movies";
        $result = $dbcnx->query($query);
        while($row = $result->fetch_assoc()){
            if($row['title']==$deleteTitle){
                $movie_id=$row['movie_id'];
            }
        }
        if(in_array($movie_id,$screenings)){
            echo '<script type="text/javascript">alert("Movie is Booked! Unable to delete!");history.go(-1);</script>';
        }
        else{
            $delete = "DELETE FROM movies WHERE title='$deleteTitle'";
            $dbcnx->query($delete);
            $delete_screenings = "DELETE FROM screenings WHERE movie_id='$movie_id'";
            $dbcnx->query($delete_screenings);
            echo '<script type="text/javascript">alert("Delete complete!");history.go(-1);</script>';
        }
    }
    else if(isset($_POST['AddButton'])){
        $select_movie=$_POST['select_movie'];
        $start_date=$_POST['start-date'];
        $selectTime=$_POST['selectTime'];
        $screening_id=NULL;
        $screen_start=$start_date." ".$selectTime;

        $query = "select * from movies";
        $result = $dbcnx->query($query);
        while($row = $result->fetch_assoc()){
            if($row['title']==$select_movie){
                $movie_id=$row['movie_id'];
            }
        }
        $insert = $dbcnx->query("INSERT into screenings VALUES ('".$screening_id."','".$movie_id."','".$screen_start."')");

        echo '<script type="text/javascript">alert("Time Added!");history.go(-1);</script>';

    }
?>