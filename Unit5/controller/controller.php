<?php
include_once("model/model.php");
include_once("view/view.php");

class Controller {
	public $model=null;
	public $view = null;
	
	function __construct() {  
		$connectionDetails = parse_ini_file("db-connection.ini");
		$this->model = new Model($connectionDetails['host'].":".$connectionDetails['port'], $connectionDetails['dbname'], $connectionDetails['user'], $connectionDetails['password']); #put your DB details in this line !
        
        $this->model->connect();
        $this->view = new View($this->model);
    } 
	
	function invoke() {
			//display the menu page
			$this->view->display();

   }

}

?>
