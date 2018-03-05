<?php
/**
*
* digunakan untuk memproses tanggal
*
*/
prado::using ('Application.logic.Logic_Global');
class Logic_Penanggalan extends Logic_Global {
    /*
     * nama bulan dalam bahasa indonesia
     */
    private $Bulan = array('none'=>' ',1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April', 5=>'Mei',6=>'Juni', 7=>'Juli', 8=>'Agustus', 9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember');
   
    /**
     * digunakan untuk mendapatkan bulan
     */
    public function getBulan($idx=null) {
        if ($idx === null) {
            return $this->Bulan;
        }else{
            return $this->Bulan[$idx];
        }
    }
    /**
     * digunakan untuk memformat tanggal
     * @param type $format
     * @param type $date
     * @return type date
     */
    public function tanggal($format, $date=null) {
        if (is_object($date)){            
            $tgl=$date;
        }else {
            if ($date === null) {
                $tgl = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
            }else {
                $tgl = new DateTime($date, new DateTimeZone('Asia/Jakarta'));
            }
        }		
        $result = str_replace(array('Sunday', 'Monday', 'Tuesday','Wednesday', 'Thursday', 'Friday', 'Saturday'), array('Minggu', 'Senin', 'Selasa','Rabu', 'Kamis', 'Jumat', 'Sabtu'), $tgl->format ($format));
        return str_replace(array('January', 'February', 'March', 'April', 'May','June', 'July', 'August', 'September', 'October', 'November' , 'December'), array('Januari', 'Februari', 'Maret', 'April', 'Mei','Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'), $result);
	}   

   
}