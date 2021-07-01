<?php

//fetch the deposit amount and get the new balance;
if (isset($_POST["deposit"])) {

    $deposit = $_POST["amount"];
# You could REFERENCE the withdraw.php to write this part; 
# firstly you need to check and ensure that the user has enter a valid value for deposit, 
# then call the model's deposit method which will update balance 
# then you should display the new balance 
# you shoudl report some suitable error messages 
if (preg_match ('/^[0-9]+$/',trim($deposit))){ 
    //update balance of user id
    $balance = $this->model->deposit($_POST["id"], $deposit);

    //Display the new balance
    if ($balance != null) {
        echo "<b><h3>Your New balance is: &pound; $balance</h3></b>";
    } else echo "<p>Sorry, transaction failure.</p>";
} else { //validation fail
           echo "<p>Sorry, Please enter a valid, positive integer.</p>";
}

} 
//display the form	
?>
<h1>Deposit</h1>
<form method="post" action="">
<div>	Please enter the account ID
        <input type="text" name="id"/> </br><br>
		Please enter the amount to deposit
		<input type="text" name="amount"/>
        <input type="submit" name="deposit" value="deposit">
</div>
</form>
	