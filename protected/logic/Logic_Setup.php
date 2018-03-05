<?php
/**
*
* digunakan untuk memproses setup aplikasi
*
*/
prado::using ('Application.logic.Logic_Global');
class Logic_Setup extends Logic_Global {    
    /**
     * setting application
     */
    private $settings;
    /**
     *
     * file parameters xpath
     */
    private $parameters;
	public function __construct ($db) {
		parent::__construct ($db);	        
        $this->loadSetting();        
        $this->parameters=$this->Application->getParameters ();	
	}	
    /**
     * digunakan untuk meload setting
     */
    public function loadSetting ($flush=false) {     
        if ($flush) {
            $this->settings=$this->populateSetting ();
            $this->settings['loaded']=true;
            if ($this->Application->Cache) {                
                $this->Application->Cache->set('settings',$this->settings);
            }else {
                $_SESSION['settings']=$this->settings;                
            }
        }elseif ($this->Application->Cache) {
            $this->settings=$this->Application->Cache->get('settings');
            if (!$this->settings['loaded']) $this->loadSetting (true);
        }else {
            $this->settings=$_SESSION['settings'];
            if (!$this->settings['loaded']) $this->loadSetting (true);
        }        
    }
    /**
     * digunakan untuk populate setting
     */
    private function populateSetting () {
        $str = 'SELECT setting_id,`key`,`value` FROM setting';
        $this->db->setFieldTable(array('setting_id','key','value'));
        $r=$this->db->getRecord($str);
        $result=array();
        while (list($k,$v)=each($r)) {
            $result[$v['key']]=array('setting_id'=>$v['setting_id'],'key'=>$v['key'],'value'=>$v['value']);
        }
        return $result;
    }
    /**
     * digunakan untuk mendapat nilai setting
     * @param type $mode
     * @return type
     */
    public function getSettingValue($keys,$mode='value') {  
        $value=$this->settings[$keys][$mode];
        if ($value=='') {            
            $this->loadSetting (true);
            $value=$this->settings[$keys][$mode];
        }        
        return $value; 
    } 
    /**
     * digunakan untuk mendapatkan mode belanja
     * @param $ta tahun anggaran
     */
    public function getModeBelanja($ta) {
        $str = "SELECT mode FROM mode_belanja WHERE ta=$ta";
        $this->db->setFieldTable(array('mode'));
        $r=$this->db->getRecord($str);
        if (isset($r[1])) {
            return $r[1]['mode'];
        }else{
            $this->db->insertRecord("REPLACE INTO mode_belanja SET ta=$ta,mode='APBDM',date_modified=NOW()");
            return 'APBDM';
        }
    }
    /**
     * digunakan untuk mendapatkan alamat aplikasi
     * 
     */
    public function getAddress () {       
		$ip=explode('.',$_SERVER['REMOTE_ADDR']);		        
		$ipaddress=$ip[0];	       	
		if ($ipaddress == '127' || $ipaddress == '::1') {
			$url=$this->parameters['address_lokal'];
		}elseif ($ipaddress == '192' || $ip=='10'||$ip=='172'){
			$url=$this->parameters['address_lan'];
		}else {
			$url=$this->parameters['address_internet'];
		}				
		return $url;
    }    
    /**
     * digunakan untuk memperoleh ukuran maksimal file
     */
    public function getMaxFileSize () {
        $size=(int)ini_get('upload_max_filesize');        
        $filesize=$size*1048576;
        return $filesize;
    }
    /**
     * digunakan untuk memperoleh ukuran file
     */
    public function getFileSize ($filename) {
        if (file_exists($filename)) {
            return filesize($filename);
        }else{
            return false;
        }
    }
    /**
     * digunakan untuk mengatur format ukuran file
     * @param type $bytes
     * @return string
     */
    function formatSizeUnits($bytes)    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }
    /**
     * digunakan untuk membersihkan nama file dari string non alphanumerik
     * @param type $string
     */
    public function cleanFileNameString ($filename) {
        $data=explode ('.',$filename);           
        $extensi=$data[count($data)-1];        
        $replacefile=preg_replace('/\W+/', '_', $filename);
        $files= str_replace($extensi, '', $replacefile);
        return "$files.$extensi";
        
    }
    /**
     * digunakan untuk menghapus file atau direktori
     * @param type $arg
     */
    public function totalDelete($arg) {
        if (file_exists($arg)) {
            @chmod($arg,0755);
            if (is_dir($arg)) {
                $handle = opendir($arg);
                while($aux = readdir($handle)) {
                    if ($aux != "." && $aux != "..") $this->totalDelete($arg."/".$aux);
                }
                @closedir($handle);
                rmdir($arg);
            } else unlink($arg);
        }
    }
    /**
     * digunakan untuk membuat direktori baru
     * @param type $dirname
     */
    public function createNewDir ($base,$dirname) {
        $dirname = BASEPATH . $base.$dirname;
        if (!is_dir($dirname)) {           
            mkdir($dirname,0755);
            chmod($dirname,0755);
        }
    }
    /**
     * mengembalikan nilai durasi output cache
     */
    public function getDurationOutputCache () {
        return 86400;
    }        
    /**
     * easy image resize function
     * @param  $file - file name to resize
     * @param  $string - The image data, as a string
     * @param  $width - new image width
     * @param  $height - new image height
     * @param  $proportional - keep image proportional, default is no
     * @param  $output - name of the new file (include path if needed)
     * @param  $delete_original - if true the original image will be deleted
     * @param  $use_linux_commands - if set to true will use "rm" to delete the image, if false will use PHP unlink
     * @param  $quality - enter 1-100 (100 is best quality) default is 100
     * @return boolean|resource
    */ 
    public function resizeImage($file,$string= null,$width= 0, $height= 0, $proportional= false, $output= 'file', $delete_original= true, $use_linux_commands = false,$quality = 100) {
        if ( $height <= 0 && $width <= 0 ) return false;
        if ( $file === null && $string === null ) return false;
        # Setting defaults and meta
        $info= $file !== null ? getimagesize($file) : getimagesizefromstring($string);
        $image= '';
        $final_width= 0;
        $final_height= 0;
        list($width_old, $height_old) = $info;
        $cropHeight = $cropWidth = 0;
        # Calculating proportionality
        if ($proportional) {
            if($width  == 0)  
                $factor = $height/$height_old;            
            elseif  ($height == 0)  
                $factor = $width/$width_old;
            else
                $factor = min( $width / $width_old, $height / $height_old );
            $final_width  = round( $width_old * $factor );
            $final_height = round( $height_old * $factor );
        }else {
            $final_width = ( $width <= 0 ) ? $width_old : $width;
            $final_height = ( $height <= 0 ) ? $height_old : $height;
            $widthX = $width_old / $width;
            $heightX = $height_old / $height;
            $x = min($widthX, $heightX);
            $cropWidth = ($width_old - $width * $x) / 2;
            $cropHeight = ($height_old - $height * $x) / 2;
        }
        # Loading image to memory according to type
        switch ( $info[2] ) {
            case 
                IMAGETYPE_JPEG:  $file !== null ? $image = imagecreatefromjpeg($file) : $image = imagecreatefromstring($string);  
            break;
            case IMAGETYPE_GIF:   
                $file !== null ? $image = imagecreatefromgif($file)  : $image = imagecreatefromstring($string);  
            break;
            case IMAGETYPE_PNG:   
                $file !== null ? $image = imagecreatefrompng($file)  : $image = imagecreatefromstring($string);  
            break;
            default: return false;
        }
        
        # This is the resizing/resampling/transparency-preserving magic
        $image_resized = imagecreatetruecolor( $final_width, $final_height );
        if ( ($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG) ) {
            $transparency = imagecolortransparent($image);
            $palletsize = imagecolorstotal($image);
            
            if ($transparency >= 0 && $transparency < $palletsize) {
                $transparent_color  = imagecolorsforindex($image, $transparency);
                $transparency       = imagecolorallocate($image_resized, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
                imagefill($image_resized, 0, 0, $transparency);
                imagecolortransparent($image_resized, $transparency);
            }elseif ($info[2] == IMAGETYPE_PNG) {
                imagealphablending($image_resized, false);
                $color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);
                imagefill($image_resized, 0, 0, $color);
                imagesavealpha($image_resized, true);
            }
        }
        imagecopyresampled($image_resized, $image, 0, 0, $cropWidth, $cropHeight, $final_width, $final_height, $width_old - 2 * $cropWidth, $height_old - 2 * $cropHeight);
        
        # Taking care of original, if needed
        if ( $delete_original ) {
            if ( $use_linux_commands ) 
                exec('rm '.$file);
            else 
                @unlink($file);            
        }
        # Preparing a method of providing result
        switch ( strtolower($output) ) {
            case 'browser':
                $mime = image_type_to_mime_type($info[2]);
                header("Content-type: $mime");
                $output = NULL;
            break;
            case 'file':
                $output = $file;
            break;
            case 'stream' :
                ob_start();
                imagejpeg($image_resized); 
                $thumbjpg = ob_get_clean();
                return "data:image/jpeg;base64,".base64_encode($thumbjpg);
            break;
            case 'return':
                return $image_resized;
            break;
            default:
                break;
        }
        
        # Writing image according to type to the output destination and image quality
        switch ( $info[2] ) {
            case IMAGETYPE_GIF:   
                imagegif($image_resized, $output);    
            break;
            case IMAGETYPE_JPEG:  
                imagejpeg($image_resized, $output, $quality);   
            break;
            case IMAGETYPE_PNG:
                $quality = 9 - (int)((0.9*$quality)/10.0);
                imagepng($image_resized, $output, $quality);
            break;
            default: 
                return false;
        }
        return true;
    }   
    /**
     * digunakan untuk mendapatkan tipe file output report
     */
    public function getOutputFileType() {
        $tipefile=array('pdf'=>'PDF','excel2007'=>'Excel 2007','summarypdf'=>'Summary PDF','summaryexcel'=>'Summary Excel');
        return $tipefile;
    }
    /**
     * digunakan untuk mendapatkan tipe output compress
     */
    public function getOutputCompressType() {
        $tipecompress=array('none'=>' ','zip'=>'ZIP');
        return $tipecompress;
    }    
    /**
     * digunakan untuk membuat zip compression file
     * @param type $files
     * @param type $destination
     * @param type $overwrite
     * @return boolean
     */
    public function createZIP($files = array(),$destination = '',$overwrite = true) {
        //if the zip file already exists and overwrite is false, return false
        if(file_exists($destination) && !$overwrite) { return false; }
        //vars
        $valid_files = array();
        //if files were passed in...
        if(is_array($files)) {
            //cycle through each file
            foreach($files as $nama_file=>$lokasi_file) {
                //make sure the file exists
                if(file_exists($lokasi_file)) {
                    $valid_files[$nama_file] = $lokasi_file;
                }
            }
        }
        //if we have good files...
        if(count($valid_files)) {
            //create the archive
            $zip = new ZipArchive();
            if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
                return false;
            }
            //add the files
            foreach($valid_files as $nama_file=>$lokasi_file){
                $zip->addFile($lokasi_file,$nama_file);
            }
            //debug
            //echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;

            //close the zip -- done!
            $zip->close();

            //check to make sure the file exists
            return file_exists($destination);
        }
        else
        {
            return false;
        }
    }
    /**
     * digunakan untuk mendapatkan daftar nama themes
     */
    public function getListThemes () {
        $folder = 'themes/';
        $weeds = array('.', '..');
        $directories = array_diff(scandir($folder), $weeds);
        $themefolders=array();
        foreach($directories as $value) {
            if ($value != 'default') { 
                if(is_dir($folder.$value)){
                   $themefolders[$value]=strtoupper($value);
                }
            }
        } 
        return $themefolders;
    }
    /**
     * Format NIP
     * @param type $nip integer
     */
    public function nipFormat ($nip) {        
        $formatnip=$nip;        
        if (isset($nip[17])) {             
            $tgllahir=  substr($nip, 0, 8);
            $tmtcpns=  substr($nip, 8, 6);
            $jk=  substr($nip, 14, 1);
            $nourut=substr($nip, 15, 3);
            $formatnip = "$tgllahir $tmtcpns $jk $nourut";
        }       
        return $formatnip;
    }
    /**
     * digunakan untuk menginputkan log untuk dieksekusi oleh cron
     */
    public function insertNewCronLog ($process,$activity) {
        $str = "INSERT INTO log_cron SET idlog=NULL,aktivitas='$activity',process='$process',status=0,date_added=NOW(),date_modified=NOW()";
        $this->db->insertRecord($str);
    }
}