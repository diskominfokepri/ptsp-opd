<?php

class MainPage extends TPage {   
	/**
	* id process
	*/
	public $idProcess;	
	/**
	* Object Variable "Database"
	*
	*/
	public $DB;		
	/**
	* Object Variable "Setup"
	*
	*/
	public $setup;		
	/**
	* Object Variable "Tanggal"	
	*/
	public $TGL;	
    /**
	* Object Variable "DMaster"	
	*/
	public $DMaster;
    /**
	* Object Variable "Report"	
	*/
	public $report;
    /**
	* Object Variable "User"	
	*/
	public $Pengguna;    
    /**
     * show page dashboard page
     * @var boolean 
     */
    public $showDashboard = false;
    /**
     * show page profiles page
     * @var boolean 
     */
    public $showProfiles = false;    
	public function OnPreInit ($param) {	
		parent::onPreInit ($param);
		//instantiasi database		
		$this->DB = $this->Application->getModule ('db')->getLink();		
        //instantiasi fungsi setup
        $this->setup = $this->getLogic('Setup');                 
        //instantiasi user
		$this->Pengguna = $this->getLogic('Users');    
        //setting templates dan theme yang aktif        
        if (!isset($_SESSION['theme'])) {
            $_SESSION['theme']='default';
        }
        $theme=$_SESSION['theme'];
        $this->Theme=$theme;
        $this->MasterClass="Application.layouts.$theme.MainTemplate";
	}
	public function onLoad ($param) {		
		parent::onLoad($param);						            
		//instantiasi fungsi tanggal
		$this->TGL = $this->getLogic ('Penanggalan');       
	}
	/**
	* mendapatkan lo object
	* @return obj	
	*/
	public function getLogic ($_class=null) {
		if ($_class === null)
			return $this->Application->getModule ('logic');
		else 
			return $this->Application->getModule ('logic')->getInstanceOfClass($_class);	
	}
	/**
	* id proses tambah, delete, update,show
	*/
	protected function setIdProcess ($sender,$param) {		
		$this->idProcess=$sender->getId();
	}
	
	/**
	* add panel
	* @return boolean
	*/
	public function getAddProcess ($disabletoolbars=true) {
		if ($this->idProcess == 'add') {			
			if ($disabletoolbars)$this->disableToolbars();
			return true;
		}else {
			return false;
		}
	}
	
	/**
	* edit panel
	* @return boolean
	*/
	public function getEditProcess ($disabletoolbars=true) {
		if ($this->idProcess == 'edit') {			
			if ($disabletoolbars)$this->disableToolbars();
			return true;
		}else {
			return false;
		}

	}
	
	/**
	* view panel
	* @return boolean
	*/
	public function getViewProcess ($disabletoolbars=true) {
		if ($this->idProcess == 'view') {
			if ($disabletoolbars)$this->disableToolbars();			
			return true;
		}else {
			return false;
		}

	}
	
	/**
	* default panel
	* @return boolean
	*/
	public function getDefaultProcess () {
		if ($this->idProcess == 'add' || $this->idProcess == 'edit'|| $this->idProcess == 'view') {
			return false;
		}else {
			return true;
		}
	}	
	/**
	* digunakan untuk mendapatkan sebuah data key dari repeater
	* @return data key
	*/
	protected function getDataKeyField($sender,$repeater) {
		$item=$sender->getNamingContainer();
		return $repeater->DataKeys[$item->getItemIndex()];
	}    
    /**
	* Redirect
	*/
	public function redirect ($page,$automaticpage=false,$param=array()) {
		$this->Response->Redirect($this->constructUrl($page,$automaticpage,$param));	
	}	  
    /**
     * digunakan untuk membuat url
     */
    public function constructUrl($page,$automaticpage=false,$param=array()) {              
        $url=$page;
        if ($automaticpage) {
            $this->Pengguna = $this->getLogic('Users');
            $tipeuser=$this->Pengguna->getTipeUser(); 
            $theme=$_SESSION['theme'];
            $url="$tipeuser.$theme.$url";
        }        
        return $this->Service->constructUrL($url,$param);
    }
    /**
     * digunakan untuk mendapatkan informasi paging
     */
    public function getInfoPaging ($repeater) {
        $str='';
        if ($repeater->Items->Count() > 0) {
            $jumlah_baris=$repeater->VirtualItemCount;
            $currentPage=$repeater->CurrentPageIndex;
            $offset=$currentPage*$repeater->PageSize;
            $awal=$offset+1;        
            $akhir=$repeater->Items->Count()+$offset;
            $str="Menampilkan $awal hingga $akhir dari $jumlah_baris";        
        }
        return $str;
    }
    /**
     * digunakan untuk merubah outputreport
     * @param type $sender
     * @param type $param
     */
    public function changeOutputReport ($sender,$param) {
        if ($this->IsValid) {
            $_SESSION['outputreport']=$this->tbCmbOutputReport->Text;
        }
    }
    /**
     * digunakan untuk mengganti tipe kompresi output
     * @param type $sender
     * @param type $param
     */
    public function changeOutputCompress ($sender,$param) {
        if ($this->IsValid) {
            $_SESSION['outputcompress']=$this->tbCmbOutputCompress->Text;
        }
    }
    /**
     * digunakan untuk membuat berbagai macam object
     */
    public function createObj ($nama_object) {
        switch (strtolower($nama_object)) {
            case 'dmaster' :
                $this->DMaster = $this->getLogic('DMaster');
            break;
        
        }
    }    
}