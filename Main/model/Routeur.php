<?php 

class Routeur{

	private $request;
	
	public function __construct($request){
		$this->request = $request;
	}

	public function renderController(){
		
		$request =  $this->request;
		
		if(function_exists($request)){
			$request();
		}else{
			echo '404';
		}
	}

}