<?php

class Card {

  private $strBackOfCardImage = 'img/backofcard.jpg';
  private $strFrontOfCard;
  private $strState = 'displayback'; // displayback|displayfront|hidden
  private $iId = 0;
  private $strNameTag;
  
  function __construct($iId, $strNameTag, $strImgUrl) {
  
    if ($iId === NULL){
	  echo 'ERROR: Card constructor requires $iId parameter.';
	  die();
	}
	
    $this->iId = $iId;

    if ($strNameTag === NULL){
	  echo 'ERROR: Card constructor requires $strNameTag parameter.';
	  die();
	}
	
    $this->strNameTag = $strNameTag;		
	
	if ($strImgUrl == NULL){
	  echo 'ERROR: Card constructor requires $strImgUrl parameter.';
	  die();	
	}
	
    $this->strFrontOfCard = $strImgUrl;	
	
  }  
  
  public function getId(){
    return $this->iId;
  }
  
  public function getNameTag(){
    return $this->strNameTag;
  }  
  
  public function getCardHTML($blnShowLink=TRUE){
  
    switch ($this->strState){
	
	  case 'displayback':
	  
	    $strMarkup = '<img src="'.$this->strBackOfCardImage.'" alt="Card Back" />';
	    
		if ($blnShowLink)
		  $strMarkup = '<a href="?c='.$this->iId.'">'.$strMarkup.'</a>';
		
	    return $strMarkup;	  
	    break;
		
	  case 'displayfront':
	    return '<img src="'.$this->strFrontOfCard.'" alt="'.$this->strNameTag.'" />';
	    break;		
		
	  case 'hidden':
	    return '&nbsp;';
	    break;		
	
	}
	
  }  
  
  public function flipCard(){
  
    switch ($this->strState){
	
	  case 'displayback':
	    $this->strState = 'displayfront';	  
	    break;
		
	  case 'displayfront':
	    $this->strState = 'displayback';	  
	    break;		
		
      default:
	    // do nothing card is invisible
	
	}    
  
  }
  
  public function hideCard(){
    $this->strState = 'hidden';
  }

}

?>