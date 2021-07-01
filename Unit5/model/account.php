<?php
# An Account object corresponds to the columns in table savings

class Account {
  # declare two private fields: id and balance here
  private $id;
  private $balance;
  
  # constructor with two arguments: id and balance
  public function __construct($iden, $bal)
  {
    $this->id = $iden;
    $this->balance = $bal;
  } 
  
  # magic getter method: __get() 
  public function __get($prop)
  {
    return $this->$prop;
  }

}
?>
