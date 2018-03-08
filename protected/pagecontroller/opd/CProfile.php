<?php 
prado::using('Application.MainPageOPD');

class CProfile extends MainPageOPD
{
	public function OnLoad($param)
	{
		parent::OnLoad($param);	
		$this->txtUsername->Text = $this->Pengguna->getDataUser('username');
		$this->txtOPD->Text = $this->Pengguna->getDataUser('nama_opd');
		// $this->txtOldPassword->Text = $this->Pengguna->getDataUser('password');
		// $this->txtNewPassword->Text = $this->Pengguna->getDataUser('password');

		// print_r($this->Pengguna->getDataUser());
	}	
	public function checkOldPassword($sender,$param) {
        $old_password=$param->Value;
        if ($old_password != '') {
            try {
            	$userid = $this->Pengguna->getDataUser('userid');
                $sql="SELECT password FROM user WHERE user_id=$userid";
				$this->DB->setFieldTable(array('password'));
				$r=$this->DB->getRecord($sql);

				if (md5($old_password) != $r[1]['password']) {
					throw new Exception ("Password lama anda salah");
				}
            } catch (Exception $ex) {
                $message=$ex->getMessage();
                $sender->ErrorMessage=$message;					
                $param->IsValid=false;		
            }
        }
    }   
	public function saveData($sender, $parameter)
	{
		if($this->IsValid) {
			$userid = $this->Pengguna->getDataUser('userid');
			$password= addslashes($this->txtNewPassword->Text);
			$password=md5($password);
			$sql="UPDATE user SET password='$password' WHERE user_id=$userid";
			$this->DB->updateRecord($sql);

			$this->redirect("Profile",true);
        }
	}
	
}	