<?php
class Autorisasi extends TModule implements IUserManager {	
    /**
	* Obj DB
	*/
	private $db;
    public function __construct () {
		$this->db = $this->Application->getModule('db')->getLink();						
	}
	/**
	* @return string name for a guest user	
	*/		
	public function getGuestName () {
		return 'Guest';
	}
	/**
	* returns a user instance given the username
	* @param string username, null if it is a guest
	* @return TUser the user instance, null if the specified username is not the user database
	*
	*/
	public function getUser ($username=null) {				
		if ($username === null) {
			$user = new TUser ($this);
			$user->setIsGuest(true);
			return $user;
		}else {			
			$user = new TUser ($this);	
            $datauser=array('page'=>'opd');
            $user->setIsGuest (false);
			$user->setRoles($datauser['page']);						
			$user->setName ($datauser);									
			return $user;		
		}
	}
	
	/**
	* validate if the username and password is correct
	* @param string username
	* @param string password
	* @return boolean true if validation is sucessful, false otherwise
	*
	*/
	public function validateUser ($username,$password) {		
		$str = "SELECT username, password FROM `user` WHERE username='$username' AND role='OPD' ";
        $this->db->setFieldTable (array('username','password'));							
        $r = $this->db->getRecord($str); 
		$passwd= md5($password);	
		$bool=false;
		if (isset($r[1])) {
			$bool=$r[1]['password']==$passwd;	
		}       
		return $bool;
	}	
	/**
	* Dua method dibawah ini tidak dipakai. Tetapi harus tetap Ada.
	*
	*/			
	public function saveUserToCookie($cookie) { }
	
	public function getUserFromCookie($cookie) { }
}