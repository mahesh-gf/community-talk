<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="Chanakya.ico">


    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>commuNITy-Talks</title>
  </head>
  <body>
  <?php include 'Partial/_header.php';?>
  <?php include 'Partial/_dbconnect.php';?>

<?php  
    $id = $_GET['queryid'];
    $sql ="SELECT * FROM `queries` WHERE query_id = $id"; 
$result = mysqli_query($conn,$sql);
while($row = mysqli_fetch_assoc($result)){
    $title = $row['query_title'];
    $desc = $row['query_desc'];
    $commentby = $row['query_user_id'];

    $sql3 = "SELECT username FROM `users` WHERE sno='$commentby'";
  $result3 = mysqli_query($conn,$sql3);
  $row3 = mysqli_fetch_assoc($result3);
  $posted_by = $row3["username"]; 

}


?>



<?php
    $showAlert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    if($method == 'POST'){

        $comment =htmlspecialchars($_POST['comment']);
        $comment = str_replace("'","&#039;",$comment);
        $sno = $_POST['sno'];
        if($comment!=null){
        $sql = "INSERT INTO `comments` (`comment_content`,`thread_id`,`comment_by`,`comment_time`) 
        VALUES ('$comment','$id','$sno',current_timestamp());";
        $result = mysqli_query($conn,$sql);
        $showAlert = true;
        if($showAlert)
        {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>SUCCESS!</strong> Your Comment has been added.
          </div>';

        }
      }else{
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>OOPS!</strong> Your comment cannot be empty!
        
      </div>' ;
      }


    }
    
?>






  <div class="container my-4" style="background-color:#e1e1e1">
        <div class="jumbotron">
            <br>
            <h1 class="display-4"><?php echo $title; ?></h1>
            <p class="lead"> <?php echo $desc ?> </p>
            <hr class="my-4">
            <p>Posted By : <b> <?php echo $posted_by;?> </b> </p>
            <p>NOTE : <BR>Spam / Advertising / Self-promote in the forums is not allowed.<br> Do not post “offensive” posts, links or images.<br> </p>
           
            
            <br>
        </div>
    </div>




    <?php

if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']==true){
echo'
<div class="container">

<h1 class="text-center"> Post a Talk</h1>


<form action="'.$_SERVER['REQUEST_URI'].'" method="POST">
 <div class="form-group mx-3">
   <label for="exampleInputPassword1"> Share your view on this..! </label>
   <textarea style="width:90%" rows="3" class="form-control" id="comment" name="comment"></textarea>
   <input type="hidden" name="sno" value="'.$_SESSION["sno"].'">
 
   </div>

 <button type="submit" class="btn btn-success mx-4 my-2">E-Talk</button>
</form>

</div>
 ';
}
else{
    echo'<div class="container">
    <h1 class="text-center">Post a Talk</h1>
    <p class="lead">
    You need to login to share your view on this.
    </p>
    
     </div>';
}
 
 ?>


    






    <h2 class="text-center py-2"> E-TALKS! </h2>
  <!-- Media object -->

 
<?php
  $id2 = $_GET['queryid'];
  $sql ="SELECT * FROM `comments` WHERE thread_id = $id2"; 
$result = mysqli_query($conn,$sql);
while($row = mysqli_fetch_assoc($result)){
  $id = $row['comment_id'];
  $content = $row['comment_content'];
  $date = $row['comment_time'];
  $query_user_id = $row['comment_by'];
  $sql2 = "SELECT username FROM `users` WHERE sno='$query_user_id'";
  $result2 = mysqli_query($conn,$sql2);
  $row2 = mysqli_fetch_assoc($result2);
  $name = $row2['username']; 
  echo  '<div class="container mt-3">
  <div class="d-flex border p-3">
  
    <!-- Image -->
    <img
      src="images/user.jpg"
      alt="'.$name.'"
      class="me-3 rounded-circle"
      style="width: 60px; height: 60px;"
    />
    <!-- Body -->
    <div>
    <h5 class="font-weight-bold">
    <a href="" style="text-decoration:none;" class="text-dark">
        '.$name.' <small> Posted on  '.$date.' </small></a></h5>
  
      <h6 class="font-weight-normal">
         ' .$content. '
      </h6>';
      if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']==true){
        if($_SESSION['sno']==$query_user_id){

     echo'<button id="'.$id.'" class="delete btn btn-sm btn-primary">
     <a href="delete.php?deleteid='.$id.'" style="color:white;text-decoration:none;">Delete</a></button>';
      }
    }
    echo'</div>
  </div></div>';
}

?> 





<!-- Media object -->
<!-- 
<div class="container mt-3">
<div class="d-flex border p-3" style="justify-content:center;">

   Image
  <img
    src="https://mdbcdn.b-cdn.net/img/new/avatars/2.webp"
    alt="John Doe"
    class="me-3 rounded-circle"
    style="width: 60px; height: 60px;"
  />
  < Body 
  <div>
    <h4>
      Love doe
      <small>Posted on February 19, 2021</small>
    </h4>

    <p>
        <h6>Question 1</h6>
      Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
      incididunt ut labore et dolore magna aliqua.
    </p>
  </div>
</div></div> -->
<?php include 'Partial/_footer.php';?>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
  </body>
</html>