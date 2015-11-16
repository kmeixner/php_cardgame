<?php

class Gameboard {

  private $iNumTries=0;
  
  private $strCardMarkupStart = '<div class="card">';
  private $strCardMarkupEnd = '</div>';  
  
  private $strRowMarkupStart = '<div class="row">';
  private $strRowMarkupEnd = '</div>'; 
  
  private $arrCards = array();
  private $objFirstCard;
  private $objSecondCard; 
  private $blnMatch = FALSE;  
  private $iTries;
  private $iMatches = 0;
  
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
//		  echo 'You found a match!';
		  echo '<script>setTimeout("location.href = \'?action=update\';", 1500);</script>';
		  echo '<noscript> Click <a href="?action=update">here</a> to Continue...</a></noscript>';
		}
		else {
		  echo 'Congradulations you matched all of the cards!';
          echo ' Click <a href="?action=new">here</a> to play again...</a>';			  
		}
		
	  }
	  else {
		$this->blnMatch = FALSE;			  
//		echo 'Sorry, no match!';
		echo '<script>setTimeout("location.href = \'?action=update\';", 1500);</script>';	
	    echo '<noscript> Click <a href="?action=update">here</a> to Continue...</a></noscript>';		  		
	  }
	  
	}
	else {
	  $this->objFirstCard = $objCurrCard;
	  $this->blnMatch = FALSE;	  
	}
  
  }
  
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