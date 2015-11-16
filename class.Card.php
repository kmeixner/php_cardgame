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
 * The Card class represents a playing card.
 * 
 */
class Card {

  /** 
  @param string $strBackOfCardImage: Relative URL of the back of the card 
  */
  private $strBackOfCardImage = 'img/backofcard.jpg';
  
  /** 
  @param string $strFrontOfCard: Relative URL of the front of the card 
  */
  private $strFrontOfCard;
  
  /** 
  @param string $strState: Display state: displayback 
                          (default)|displayfront|hidden 
  */
  private $strState = 'displayback';
  
  /** @param integer $iId: unique integer id for this card */
  private $iId = 0;
  
  /** @param string $strNameTag: a name tag for this card, only two cards can have the same name */
  private $strNameTag;
  
  /**   
   * This is the constructor for the Card{} class.
   *
   * @param integer $iId: a unique integer id associated with the card
   *
   * @param string $strTagName: a tag name for the card that will show up 
   *                            as an alt tag if the front of the card image 
   *                            fails to load (eg: on a browser for the 
   *                            vision-impaired, etc.). 
   *
   * @param string $strImgUrl: a relative URL path to the image for the 
   *                           front of the card
   */
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
  
  /**
   * Returns the id associated with this card.
   *
   * @returns integer: the integer id
   */
  public function getId(){
    return $this->iId;
  }

   /**
   * Returns the name tag associated with this card. Note: This is used for
   * the alt tag in the image markup.
   *
   * @returns string: the name tag
   */
  public function getNameTag(){
    return $this->strNameTag;
  }  
  
  /*
   * Gets the HTML markup for this card's image.
   *
   * @param boolean $blnShowLink: (optional)(Default: TRUE) If TRUE then 
   *                               add a hypertext link around the image 
   *                               that points to the current page but 
   *                               passes the id of this card ($this->id) 
   *                               as an HTTP parameter called 'c'.
   *
   * @returns string: the HTML markup.
   */
  public function getCardHTML($blnShowLink=TRUE){
  
    switch ($this->strState){
	
	  case 'displayback': // show back of card
	  
	    $strMarkup = '<img src="'.$this->strBackOfCardImage.'" alt="Card Back" />';
	    
		if ($blnShowLink)
		  $strMarkup = '<a href="?c='.$this->iId.'">'.$strMarkup.'</a>';
		
	    return $strMarkup;	  
	    break;
		
	  case 'displayfront': // show front of card
	  
	    return '<img src="'.$this->strFrontOfCard.'" alt="'.$this->strNameTag.'" />';
	    break;		
		
	  case 'hidden': // hide card
	    return '&nbsp;';
	    break;		
	
	}
	
  }  
  
  /*
   * This will flip this card over.
   *
   * If the card had the back facing then the front will now be displayed, 
   * if the front was visible then the back will now be displayed.
   *
   * Does nothing for an invisible card.
   */
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
  
  /**
   * Sets this card to invisible, used after a match is found.
   */
  public function hideCard(){
    $this->strState = 'hidden';
  }

}

?>