<?php

prado::using ('Application.logic.Logic_Global');
class Logic_Users extends Logic_Global {	
	/**
	* object Users
	*/
	private $U;	
	/**
	* Roles
	*/
	private $Roles;
	/**
	* Data User
	*/
	private $DataUser;
	public function __construct ($db) {
		parent::__construct ($db);	
		$this->U = $this->User;
		if (method_exists($this->U,'getRoles')) {
			$dataUser=$this->U->getName();	            
			if ($dataUser != 'Guest') {
				$this->Roles=$this->U->getRoles();			                
				$this->DataUser=$dataUser;									
            }		
		}				
	}
	/**
	* digunakan untuk membuat hash password
	* @return array
	*/
	public function createHashPassword($password,$salt='',$new=true) {
		if ($new) {
			$salt = substr(md5(uniqid(rand(), true)), 0, 6);	
			$password = hash('sha256', $salt . hash('sha256', $password));
			$data =array('salt'=>$salt,'password'=>$password);			
		}else {
			$data = hash('sha256', $salt . hash('sha256', $password));	
			$data =array('salt'=>$salt,'password'=>$password);		
		}
		return $data;
	}
    /**
	* digunakan untuk mendapatkan roles user
	*/		
	public function getRoles () {
		return $this->Roles[0];
	}    
	/**
	* digunakan untuk mendapatkan tipe user
	*/		
	public function getTipeUser () {          
		return $this->DataUser['page'];
	}		
	/**
	* digunakan untuk mendapatkan data user
	*
	* @return datauser
	*/
	public function getDataUser ($id='all') {						
		if ($id=='all')
			return $this->DataUser;
		else
			return $this->DataUser[$id];
	}	
	/**
	* untuk mendapatkan userid dari user
	*
	*/
	public function getUserid () {			
		return $this->DataUser['userid'];		
	}		
	/**
	* untuk mendapatkan username dari user	
	*/
	public function getUsername () {		
		return $this->DataUser['username'];
	}       
    /**
     * digunakan untuk inputkan aktivitas user ke tabel log
     * @param type $page
     * @param type $activity
     */
    public function insertNewActivity ($page,$activity) {
        $userid=$this->getUserid ();
        $username=$this->getUsername ();
        $str = "INSERT INTO log_aktivitas_user SET userid=$userid,username='$username',halaman='$page',aktivitas='$activity',date_activity=NOW()";
        $this->db->insertRecord($str);        
    } 
}