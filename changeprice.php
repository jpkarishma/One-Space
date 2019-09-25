<?php
  session_start();
  if (isset($_SESSION['fname']) == true && $_SESSION['is_admin'] == 1) 
  {
    $user = '<a href ="logout.php" class = "w3-bar-item w3-button w3-padding-large">Log Out</a>';
  }
  else
  {
    header("location: home.php");
  }

  require_once "config.php";

  $game_id = $game_name = $game_price = "";
  $game_id_err = $game_name_err = $game_price_err = "";
     
    // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){
     
        // Validate username
        if(empty(trim($_POST["game_name"]))){
            $game_name_err = "Please enter a game name.";
        } 
        if(empty(trim($_POST["game_id"])))
        {
            $game_id_err = "Please enter a game id.";
        }
        else
        {
            // Prepare a select statement
            $sql = "SELECT game_name FROM games WHERE game_name = ? && game_ID = ?";
            
            if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "ss", $param_game_name, $param_game_id);
                
                // Set parameters
                $param_game_id = trim($_POST["game_id"]);
                $param_game_name = trim($_POST["game_name"]);
                
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    /* store result */
                    mysqli_stmt_store_result($stmt);
                    
                    if(mysqli_stmt_num_rows($stmt) == 1)
                    {
                        $game_name = trim($_POST["game_name"]);
                    } 
                    else
                    {
                        $game_name_err = "Doesnt exists.";
                    }
                } 
                else
                {
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
             
            // Close statement
            mysqli_stmt_close($stmt);
        }
        
        
        // Check input errors before inserting in database
        if(empty($game_name_err) && empty($game_id_err) && empty($game_price_err))
        {
            
            // Prepare an insert statement
            $sql = "UPDATE games SET price=? WHERE (game_ID = ? && game_name = ?)";
             
            if($stmt = mysqli_prepare($link, $sql))
            {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, 'sss', $game_price, $game_id, $game_name);
                // Set parameters
                $game_price = trim($_POST["game_price"]);
                $game_name = trim($_POST["game_name"]);
                $game_id = trim($_POST["game_id"]);               
                // Attempt to execute the prepared statement
                if(!mysqli_stmt_execute($stmt))
                {
                    // Redirect to home page
                    echo "You didn't change the price!";
                }
                else
                {
                    echo "Changed Price of game!";
                }
            }
             
            // Close statement
            mysqli_stmt_close($stmt);
        }
        
        // Close connection
        mysqli_close($link);
    }
  
  ?>
<!DOCTYPE html>
<html>
<title>game shop</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.w3-sidebar a {font-family: "Roboto", sans-serif}
body,h1,h2,h3,h4,h5,h6,.w3-wide {font-family: "Montserrat", sans-serif;}
</style>
<body class="w3-content" style="max-width:1200px">


<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-bar-block w3-white w3-collapse" style="z-index:3;width:250px" id="mySidebar">
  <div class="w3-container w3-display-container w3-padding-16">
    <i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button "></i>
    <h3 class="w3-wide"><font size="3">Admin Page</font></h3>
	 
  </div>
  <div class="w3-padding-64 w3-large w3-text-grey" style="font-weight:bold">
    <p class="w3-bar-item">Shop By Category</p>
    <a href="action.php" class="w3-bar-item w3-button">Action</a>
    <a href="fighting.php" class="w3-bar-item w3-button">Fighting</a>
    <a href="role-playing.php" class="w3-bar-item w3-button">Role-playing</a>
    <a href="shooter.php" class="w3-bar-item w3-button">Shooter</a>
    <a href="simulation.php" class="w3-bar-item w3-button">Simulation</a>
    <a href="sports.php" class="w3-bar-item w3-button">Sports</a>
  </div>
</nav>

<!-- Top menu on small screens -->
<header class="w3-bar w3-top w3-hide-large w3-black w3-xlarge">
<div class="w3-top">
<!-- Navbar on small screens -->
  <div id="navDemo" class="w3-bar-block w3-white w3-hide w3-hide-large w3-hide-medium w3-large">
  <?php echo $user ?>
   
 <!--    <a href="#" class="w3-bar-item w3-button w3-padding-large">Link 4</a>   -->
  </div>
</div>
  <div class="w3-bar-item w3-padding-24 w3-wide">One Space</div>
  <a href="javascript:void(0)" class="w3-bar-item w3-button w3-padding-24 w3-right" onclick="w3_open()"><i class="fa fa-bars"></i></a>
</header>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:250px">

  <!-- Push down content on small screens -->
  <div class="w3-hide-large" style="margin-top:83px"></div>
  
  <!-- Top header -->
  <header class="w3-container w3-xlarge">

  <div class="w3-bar w3-black w3-card w3-left-align w3-large">
    <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large w3-red" href="javascript:void(0);" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
    <a href="home.php" class="w3-bar-item w3-button w3-padding-large w3-hover-white">Home</a>
    <?php echo $user ?>
    
   <!-- <a href="#" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">Link 4</a> -->
  </div>
    <h3 class="w3-wide"><p class="w3-center"><b>One Space</b></h3></p>
    
    <header class="w3-container w3-large w3-center">
        <p><font size="5"><b>Edit Database</b></font></p>
      
        <div class="w3-bar w3-black w3-card w3-left-align w3-large">
          <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large w3-red" href="javascript:void(0);" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
          <a href="newgame.php" class="w3-bar-item w3-button w3-padding-large w3-hover-white ">Add New Game</a>
        <a href="changeprice.php" class="w3-bar-item w3-button w3-padding-large w3-hover-white ">Change Price</a>
        <a href="changeqty.php" class="w3-bar-item w3-button w3-padding-large w3-hover-white ">Change Stock Qty</a>
          <a href="deletegame.php" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">Delete Game</a>
          <a href="searchAdmin.php" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">Search</a> 
        </div>
          
         <p> </p>
      
        </header>
   
  </header>

  <!-- Image header -->


  <div class="w3-container w3-center" id="jeans">
    <p><b><font size="6">Change Game Price</font></b></p>

  </div>

  
 <!-- insert item -->
 
 <div class="w3-row-padding  w3-container">
  <div class="w3-content">
    <div class="w3-center">
	 
	
	<center>
      <div>
		</div>
		<form form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post"> 
		<table border = "0" width = "300" height = "150">
		<tr> <td>Game ID</td>
        <td><input type="text" name="game_id" value="<?php echo $game_id; ?>">
        <?php echo $game_id_err; ?> </td> </tr>
		
		<tr> <td>Game Name </td>
        <td><input type="text" name="game_name" value="<?php echo $game_name; ?>"> 
        <?php echo $game_name_err; ?> </td> </tr>
		
		<tr> <td>New Price </td>
        <td><input type="text" name="game_price" value="<?php echo $game_price; ?>"> 
        <?php echo $game_price_err; ?></td> </tr>
		
		</table>
		
		<input class="w3-button w3-black w3-margin-top" type = "submit" value = "Change Price">
        <input type="reset" class="w3-button w3-black w3-margin-top" value="Reset">
		<p> </p>
		</form>
	
	</center> 
	
	</div>
  </div>
 </div>
  
  <!-- Footer -->
  <footer class="w3-container w3-black  w3-center w3-opacity">  
  <div class="w3-xlarge w3-padding-32">
  	
         <h3 class="w3-margin w3-xlarge">Contact:</h3>
        <p><i class="fa fa-fw fa-phone"><font size="4"></i> 1234567890</p>
        <p><i class="fa fa-fw fa-envelope"><font size="4"></i> onespace@mail.com</p>
	<h3 class="w3-margin w3-xlarge">Follow us on:</h3>
    <i class="fa fa-facebook-official fa-2x w3-hover-opacity"></i>
    <i class="fa fa-instagram fa-2x w3-hover-opacity"></i>
    <i class="fa fa-snapchat fa-2x w3-hover-opacity"></i>
 <!--   <i class="fa fa-pinterest-p w3-hover-opacity"></i>
    <i class="fa fa-twitter w3-hover-opacity"></i>
    <i class="fa fa-linkedin w3-hover-opacity"></i>   -->
 </div>
</footer>
	
  <div class="w3-black w3-center w3-padding-24">Powered by w3.css</a>
  <p>Created by Davin, Krishna and Karishma</p></div>

  <!-- End page content -->
</div>


<script>
// Accordion 
function myAccFunc() {
  var x = document.getElementById("demoAcc");
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
  } else {
    x.className = x.className.replace(" w3-show", "");
  }
}

// Click on the "Jeans" link on page load to open the accordion for demo purposes
document.getElementById("myBtn").click();


// Open and close sidebar
function w3_open() {
  document.getElementById("mySidebar").style.display = "block";
  document.getElementById("myOverlay").style.display = "block";
}
 
function w3_close() {
  document.getElementById("mySidebar").style.display = "none";
  document.getElementById("myOverlay").style.display = "none";
}
</script>

</body>
</html>