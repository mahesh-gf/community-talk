
<?php
   session_start();
echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">commuNITy-Talks</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="home.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="http://ajs-nitmz-questionbank.epizy.com/HOME.html">NITMz-QB</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            ShortCut
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
          <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="https://www.nitmz.ac.in/">Official Website</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="https://nitmz.mastersofterp.in/">ERP Website</a></li>
            <li><hr class="dropdown-divider"></li>
          </ul>
        </li>
      </ul>
      ';
 
      
      if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']==true){

        echo'<div style="text-align:center;">
        <p class="text-light my-0 mx-2"> WELCOME '.($_SESSION['username']).' ! </p></div>
        <form class="d-flex" action="search.php" method="get">
        
        <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-success" type="submit">Search</button>
        </form>
      
        <button type="button" class="btn btn-outline-primary mx-2 my-2" onclick=window.location.href="logout.php">Log Out</button>
    
      </form>';


      }

        else{


            echo'
            <form class="d-flex"  action="search.php" method="get">
              <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-success" type="submit">Search</button>
            </form>
            <div class="mx-2 my-2">
            <button type="button" class="btn btn-outline-primary" onclick=window.location.href="login.php">Sign In</button>
            <button type="button" class="btn btn-outline-primary" onclick=window.location.href="signup.php">Sign Up</button>
            </div>' ;
        }
            
            echo'
          </div>
        </div>
      </nav>';
        
      


?>