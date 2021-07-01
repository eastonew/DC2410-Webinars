<?php

include_once("model/account.php");

class Model {

    private $server;
    private $dbname;
    private $username;
    private $password;
    private $pdo;
	# define the constructor which has four arguments for $server, $dbname, $username, $password. 
	# The $pdo field should be assigned as null  
	public function __construct($serv, $dbN, $userN, $pass)
	{
	  $this->server = $serv;
	  $this->dbname = $dbN;
	  $this->username = $userN;
	  $this->password = $pass;
	  $this->pdo = NULL;
	} 
	
	
	
	
    #Define a Connect() function to create the $pdo as a PDO object based on the four fields $server, $dbname, $username, $password. 
	#Using the try/catch structure to handle the database connection error
	public function connect()
	{
		try {
			$this->pdo = new PDO("mysql:dbname=$this->dbname;host=$this->server", $this->username, $this->password); 
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch(PDOException $ex) {
			echo("Failed to connect to the database.<br>");
			echo($ex->getMessage());
			exit;
		}
	}

  

    #method to get an account by id, returns an account object
	#it querys database and create an object account if the id exists in database; 
	#return null otherwise
    public function getAccountById($id) {
		$account = NULL;
		try
		{
			$rows = $this->pdo->query("SELECT id, balance FROM savings WHERE Id = $id");
			if($rows->rowCount() > 0) {
				$row = $rows->fetch();
				#get the first row
				$account = new Account($row["id"], $row["balance"]);
			}
		}
		catch(PDOException $ex) {
			echo("Failed to obtain account from database.<br>");
			echo($ex->getMessage());
			exit;
		}
		return $account;
	}

	#method to withdraw money from account
	#returns the new balance after withdraw amount from account; return null if failure
	#it update balance of user id in the database
	#should check whether amount is less than or equal to current balance
    public function withdraw($id, $amount) {
		$newBalance = NULL;
		#First get the account details from the database
		$account = $this->getAccountById($id);
		if($account != NULL)
		{
			##check for greater or equal to  - ensure we dont allow overdrawn accounts
			if($account->balance >= $amount)
			{
				$tempBalance = $account->balance - $amount;
				#Update balance in DB
				if ($this->pdo->exec("UPDATE savings SET balance = $tempBalance WHERE id = $id") === 1) {
					$newBalance = $tempBalance;
				}
			}
		}
		return $newBalance;
    }
	
	
	#method to deposit amount to account id
	#returns the new balance after depositing amount to account; return null if failure
	#it update balance of user id in the database
    public function deposit($id, $amount) {
		$newBalance = NULL;
		#First get the account details from the database
		$account = $this->getAccountById($id);
		if($account != NULL)
		{
			$tempBalance = $account->balance + $amount;
			#Update balance in DB
			if ($this->pdo->exec("UPDATE savings SET balance = $tempBalance WHERE id = $id") === 1) {
				$newBalance = $tempBalance;
			}
		}
		return $newBalance;
	}
}
?>