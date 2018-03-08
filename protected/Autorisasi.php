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
			$str = "SELECT user.user_id AS userid,user.username, user.password, opd.id_opd, opd.nama_opd FROM user INNER JOIN opd ON user.id_opd = opd.id_opd WHERE username='$username'";
			$this->db->setFieldTable (array('userid','username','password', 'id_opd', 'nama_opd'));					
        	$r = $this->db->getRecord($str); 
        	$datauser = $r[1];
			$datauser ['page']= 'opd';

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
		// $str = "SELECT username, password FROM `user` WHERE username='$username' AND role='OPD' ";
		$str = "SELECT user.username, user.password, role.nama_role FROM user INNER JOIN role ON user.id_role = role.id_role WHERE username='$username' AND role.nama_role='OPD'";
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