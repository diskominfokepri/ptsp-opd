<?php
class Home extends MainPage {
    public function OnPreInit ($param) {	
		parent::onPreInit ($param);	
        $theme=$_SESSION['theme'];
		$this->MasterClass="Application.layouts.$theme.LoginTemplate";	
        $this->Theme=$theme;
	}
    public function onLoad ($param) {		
		parent::onLoad($param);
    }
    public function checkUsernameAndPassword($sender,$param) {
        $username=$param->Value;
        if ($username != '') {
            try {
                $auth = $this->Application->getModule ('auth');
                $password=addslashes(trim($this->txtPassword->Text));
                if (!$auth->login ($username,$password)){			                    
                    throw new Exception ('Username atau password salah!.Silahkan ulangi kembali');						
                }
            } catch (Exception $ex) {
                $message=$ex->getMessage();
                $sender->ErrorMessage=$message;					
                $param->IsValid=false;		
            }
        }
    }   
    public function doLogin ($sender,$param) {
        if ($this->IsValid) {   
            $pengguna=$this->getLogic('Users');            
            $this->redirect('Home',true);
        }
    }
    public function doLogout ($sender,$param) {
        $this->Application->getModule('auth')->logout();
        $this->Response->reload();
    }
}