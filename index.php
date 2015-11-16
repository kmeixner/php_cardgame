<?php 
/***************************************************************************
 * Kevin Meixner is the copyright holder of all code below, with the       *
 * exception of the JQuery and JQuery Mobile JavaScript libraries and      *
 * JQuery Mobile CSS. Do not re-use without permission.                    *
 *                                                                         *
 * JQuery and JQuery Mobile are under the The MIT License,                 *
 * See https://jquery.org/license/for details...                          *
 ***************************************************************************/ 
require_once('cardgame.inc.php');
session_start(); // Note: session_start() must appear before HTML tag
?>  
<!DOCTYPE html>
<html lang="en-us">
<head>
  <!-- 
  KM NOTE: This markup including the generated markup has been confirmed to 
  be valid HTML5 by testing with http://validator.w3.org/
  -->
  <meta charset="windows-1252">
  <title>Match Game</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">  
  
  <!-- KM Note: An external CSS style sheet is used as per best practices -->  
  <link rel="stylesheet" href="css/cardgame.css" type="text/css" />
  
  <!-- 
  KM NOTE: JQuery Mobile stuff is included just to quickly put a nice skin on 
           the page. The game is designed to work without JQuery Mobile and 
		   even with JavaScript turned off for maximum browser compatibility!
		   
  KM NOTE: Copied JQuery Mobile files from http://code.jquery.com instead 
           of linking to them to avoid extra time to fetch from 3rd-party 
		   server and also will allow our application access to the files 
		   even if the http://code.jquery.com server ever goes down.
  -->  
  <link rel="stylesheet" href="jquery/mobile/1.3.0/jquery.mobile-1.3.0.min.css" />
  <script src="jquery/jquery-1.9.1.min.js"></script>
  <script src="jquery/mobile/1.3.0/jquery.mobile-1.3.0.min.js"></script>  
  
</head>
<body>

    <div data-role="page">

	  <div data-role="header">
		<h1>PHP Card Match Game</h1>
	  </div><!-- /header -->

	  <div data-role="content">
	  
<?php  

  // PART I: Handle Sessions and setup the Gameboard accordingly:

  if(!isset($_SESSION['gameboard'])){
    $gameboard = new Gameboard();  
    $_SESSION['gameboard'] = $gameboard;
  }
  else {

	if ($_REQUEST['action'] == 'new') {
      unset($_SESSION['gameboard']);	
      $gameboard = new Gameboard();  
      $_SESSION['gameboard'] = $gameboard;	  
	}  
    else {
	
      $gameboard = $_SESSION['gameboard'];
	  
	  if ($_REQUEST['action'] == 'update'){
        $gameboard->updateCardsDisplayed();
	  }
	  else if ($_REQUEST['c'] !== NULL){
	    $gameboard->handleTurnOver($_REQUEST['c']);
	  }
	  
	}

  }
  
  // PART II: Displays the Gameboard (shows cards):
  
  $gameboard->displayBoard();
  
?>  
	  
	  </div><!-- /content -->

	  <div data-role="footer">
		<h4>&copy;2013</h4>
	  </div><!-- /footer -->

	</div><!-- /page -->
   
</body>
</html>  
  