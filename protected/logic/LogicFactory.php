<?php

class LogicFactory extends TModule {	
	/**
	*
	* objek db
	*/
	private $db;	
	public function init ($config) {
		$this->db = $this->Application->getModule ('db')->getLink();	
	}				
	/**
	* digunakna untuk membuat objek dari sebuah kelas
	*
	*/
	public function getInstanceOfClass ($className) {		
		switch ($className) {
			case 'Users' :
				prado::using ('Application.logic.Logic_Users');
				return new Logic_Users ($this->db);
			break;		
            case 'Setup' :
				prado::using ('Application.logic.Logic_Setup');
				return new Logic_Setup ($this->db);
			break;
            case 'Penanggalan' :
				prado::using ('Application.logic.Logic_Penanggalan');
				return new Logic_Penanggalan ($this->db);
			break;  
            case 'DMaster' :
				prado::using ('Application.logic.Logic_DMaster');
				return new Logic_DMaster ($this->db);
			break; 
			default :
				throw new Exception ("Logic_Factory.php :: $className tidak di ketahui");
		}
	}
}