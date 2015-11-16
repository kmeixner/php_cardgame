<?php
/* 
KM NOTE: Used same formatting style for comments and code as the policy 
at my current Job at Sarolta Technologies.
*/

/**
 * @file
 * @author  Kevin Meixner <kmit@rogers.com>
 * @version 1.0
 *
 * @section LICENSE
 *
 * This program is copyright 2013 by Kevin Meixner. Do not re-use without
 * permission.
 *
 * @section DESCRIPTION
 *
 * The Gameboard class represents an area on a table or board where a player
 * has the cards laid out in front of them.
 *
 * The Gameboard class manages all of the gameplay rules of the game.
 * 
 */
class Gameboard {

  /** 
  @param string $strCardMarkupStart: start markup of HTML container for card
  */
  private $strCardMarkupStart = '<div class="card">';
  
  /** 
  @param string $strCardMarkupEnd: end markup of HTML container for card 
  */ 
  private $strCardMarkupEnd = '</div>';  
  
  /** 
  @param string $strRowMarkupStart: start markup of HTML container for card 
                                    rows
  */  
  private $strRowMarkupStart = '<div class="row">';
  
  /** 
  @param string $strCardMarkupEnd: end markup of HTML container for card rows
  */   
  private $strRowMarkupEnd = '</div>'; 

  /** 
  @param array[Cards] $arrCards: an array of the Card objects
  */     
  private $arrCards = array();
  
  /** 
  @param Card $objFirstCard: the first card turned over in a turn
  */   
  private $objFirstCard;
  
  /** 
  @param Card $objFirstCard: the second card turned over in a turn
  */     
  private $objSecondCard; 
  
  /** 
  @param boolean $blnMatch: whether or not a match has been found
  */  
  private $blnMatch = FALSE;  
  
  /** 
  @param integer $iMatches: how many matches have been found so far
  */    
  private $iMatches = 0;
  
  /** The Gameboard{} Constructor */
  function __construct() {
    
	for ($i=1; $i<13; $i++){
	
	  // Note: There are 24 cards, but they are twelve pairs of two
	  
	  $objCard1 = new Card($i, 'card'.$i, 'img/card'.$i.'.png');
	  $objCard2 = new Card(($i+12), 'card'.$i, 'img/card'.$i.'.png');
	  
	  array_push($this->arrCards, $objCard1);
	  array_push($this->arrCards, $objCard2);

	  shuffle($this->arrCards);
	  
	}
	
  }

  /**
   * This will display all of the cards in their current state.
   */
  public function displayBoard() {
  
	if ($this->objSecondCard == NULL){
	  $blnShowCardLink = TRUE;
	}
	else {
	  $blnShowCardLink = FALSE;	  
	}  
  
    for ($i=0; $i<sizeof($this->arrCards); $i++){
	
	  $iModulus = $i % 6;
	  
	  if ($iModulus == 0){
	  
	    if ($i != 0)
		  echo $this->strRowMarkupEnd."\n";
		  
		echo $this->strRowMarkupStart."\n";
	  
	  }
	  
	  echo $this->strCardMarkupStart;
	  echo $this->arrCards[$i]->getCardHTML($blnShowCardLink);
	  echo $this->strCardMarkupEnd."\n";	  
	}
	
	echo $this->strRowMarkupEnd;
	
  }
  
  /**
   * This will respond to an event where the player turns a card over.
   *
   * @param integer $iId: the id of the card the player turned over
   */  
  public function handleTurnOver($iId){
  
    for ($i=0; $i<sizeof($this->arrCards); $i++){
	  
	  if ($this->arrCards[$i]->getId() == $iId){
	    $this->arrCards[$i]->flipCard();
		$objCurrCard = $this->arrCards[$i];
		break;
	  }
	  
	}
	
	if ($this->objFirstCard != NULL){
	
	  $this->objSecondCard = $objCurrCard;	
	
	  if ($this->objFirstCard->getNameTag() == $objCurrCard->getNameTag()){
	  
		$this->blnMatch = TRUE;	  
		$this->iMatches++;
		
		if ($this->iMatches < 12){
		  echo '<script>setTimeout("location.href = \'?action=update\';", 1500);</script>';
		  // No Script will allow game to work without JavaScript:
		  echo '<noscript> Click <a href="?action=update">here</a> to Continue...</a></noscript>';
		  		}
		else {
		  echo 'Congradulations you matched all of the cards!';
          echo ' Click <a href="?action=new">here</a> to play again...</a>';			  
		}
		
	  }
	  else {
	  
		$this->blnMatch = FALSE;			  
		echo '<script>setTimeout("location.href = \'?action=update\';", 1500);</script>';	
		// No Script will allow game to work without JavaScript:		
	    echo '<noscript> Click <a href="?action=update">here</a> to Continue...</a></noscript>';		  		
	  }
	  
	}
	else {
	  $this->objFirstCard = $objCurrCard;
	  $this->blnMatch = FALSE;	  
	}
  
  }
  
  /**
   * This function is meant to be called after the user has turned two 
   * cards over. It will hide both of the cards in the event of a match 
   * or turn them over to show their back side in the event of a mismatch.
   */
  public function updateCardsDisplayed(){
  
	if ($this->blnMatch){
	  $this->objFirstCard->hideCard();
	  $this->objSecondCard->hideCard();	  
	}
	else {
	  $this->objFirstCard->flipCard();
	  $this->objSecondCard->flipCard();	  	
	}
	
	$this->objFirstCard = NULL;
	$this->objSecondCard = NULL;
	
	$this->blnMatch = FALSE;
  }
  
}

?>