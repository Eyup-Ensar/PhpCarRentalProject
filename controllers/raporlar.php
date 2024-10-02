<?php 

    class raporlar extends Controller {

        function __construct () {

            parent:: libsInclude(array("View", "Form", "Bilgi", "Pagination", "DosyaCikti", "Session"));

            @Session::init();

            @$this->ModelYukle("rapor");

            if(!Session::get("adminAd") || !Session::get("adminId")): 
 
                $this->giris();

                exit();

            endif;

        }

        function giris () {

            if(Session::get("adminAd") && Session::get("adminId")): 

                $this->Bilgi->direktYonlen("/raporlar/raporListele");

            else:

                $this->View->goster("sayfalar/index");

            endif;
            
        }

        function raporListele($mevcutsayfa=false) {

            $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
            $this->Pagination->paginationOlustur($this->model->sayfalama("raporlar"), $mevcutsayfa, $adet[0][0]);
            
            $this->View->goster("sayfalar/raporlar/raporlistele", array(
                "raporlar" => $this->model->listele("raporlar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                "toplamsayfa" => $this->Pagination->toplamsayfa,
                "toplamveri" => $this->model->sayfalama("raporlar"),
                "araclar" => $this->model->gelismisArama("id, plaka", "arabalar"),
                "firmalar" => $this->model->gelismisArama("cus_id, firma_ismi", "firmalar"),
                "sorgu" => ""
            ));

        }

        // function raporEkle() {

        //     $this->View->goster("sayfalar/raporlar/raporekle");

        // }

        // function raporEkleSon () {

        //     if($_POST):

        //         $arac_id = $this->Form->get("arac_id")->bosmu();

        //         $rapor = $this->Form->get("rapor")->bosmu();

        //         $testar = $this->Form->get("testar")->bosmu();

        //         $teskm = $this->Form->get("teskm")->bosmu();

        //         $tesnot = $this->Form->get("tesnot")->bosmu();

        //         if (!empty($this->Form->error)) :
                    
        //             $this->View->goster(
        //                 "sayfalar/raporlar/raporlistele", 
        //                 array(
        //                     "bilgi" => $this->Bilgi->sweetAlert(URL."/raporlar/raporListele", "BAŞARISIZ", "BOŞ ALAN BIRAKILAMAZ", "warning"),
        //                     'raporlar' => $this->model->listele("raporlar")
        //                 )); 

        //         else:

        //             $sonuc = $this->model->ekle("raporlar", array("arac_id", "rapor", "testar", "teskm", "tesnot"), array($arac_id, $rapor, $testar, $teskm, $tesnot));

        //             if($sonuc):
                        
        //                 $this->View->goster("sayfalar/raporlar/raporlistele",
        //                 array(
        //                     "bilgi" => $this->Bilgi->sweetAlert(URL."/raporlar/raporListele", "BAŞARILI", "EKLEME BAŞARILI", "success"),
        //                     'raporlar' => $this->model->listele("raporlar")
        //                 ));

        //             else:

        //                 $this->View->goster("sayfalar/raporlar/raporlistele", 
        //                 array(
        //                     "bilgi" => $this->Bilgi->sweetAlert(URL."/raporlar/raporListele", "BAŞARISIZ", "EKLEME SIRASINDA HATA OLUŞTU", "warning"),
        //                     'raporlar' => $this->model->listele("raporlar")
        //                 )); 

        //             endif;
                
        //         endif;
                
        //     else:

        //         $this->Bilgi->direktYonlen("/raporlar/raporListele");
                
        //     endif;

        // }

        function raporGuncelle($id) {

            $this->View->goster("sayfalar/raporlar/raporguncelle", array(
                'rapor' => $this->model->listele("raporlar", "where id=".$id),
            ));

        }
        
        function raporGuncelleSon ($mevcutsayfa=false) {

            if($_POST):

                $id = $this->Form->get("id")->bosmu();

                $arac_id = $this->Form->get("arac_id")->bosmu();

                $firma = $this->Form->get("firma")->bosmu();

                $testar = $this->Form->get("testar")->bosmu();

                $teskm = $this->Form->get("teskm")->bosmu();

                $ucret = $this->Form->get("ucret")->bosmu();

                $tesnot = $this->Form->get("tesnot")->bosmu();

                $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
                $this->Pagination->paginationOlustur($this->model->sayfalama("raporlar"), $mevcutsayfa, $adet[0][0]);

                if (!empty($this->Form->error)) :
                
                    $this->View->goster("sayfalar/raporlar/raporlistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/raporlar/raporListele", "BAŞARISIZ", "BOŞ ALAN BIRAKILAMAZ", "warning"),
                        "raporlar" => $this->model->listele("raporlar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                        "toplamsayfa" => $this->Pagination->toplamsayfa,
                        "toplamveri" => $this->model->sayfalama("raporlar")
                    ));

                else:

                    $sonuc = $this->model->guncelle("raporlar", array("arac_id", "firma", "testar", "teskm", "ucret", "tesnot"), array($arac_id, $firma, $testar, $teskm, $ucret, $tesnot), "id=".$id);

                    if($sonuc):
                        
                        $this->View->goster("sayfalar/raporlar/raporlistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/raporlar/raporListele", "BAŞARILI", "GÜNCELLEME BAŞARILI", "success"),
                            "raporlar" => $this->model->listele("raporlar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("raporlar")
                        ));

                    else:

                        $this->View->goster("sayfalar/raporlar/raporlistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/raporlar/raporListele", "BAŞARISIZ", "GÜNCELLEME SIRASINDA HATA OLUŞTU", "warning"),
                            "raporlar" => $this->model->listele("raporlar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("raporlar")
                        ));

                    endif;
                
                endif;
                
            else:

                $this->Bilgi->direktYonlen("/raporlar/raporListele");
                
            endif;

        }

        function raporSil ($id, $mevcutsayfa=false) {

            $sonuc = $this->model->sil("raporlar", "id=".$id);

            $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
            $this->Pagination->paginationOlustur($this->model->sayfalama("raporlar"), $mevcutsayfa, $adet[0][0]); 

            if ($sonuc):
            
                $this->View->goster("sayfalar/raporlar/raporlistele", array(
                    "bilgi" => $this->Bilgi->sweetAlert(URL."/raporlar/raporListele", "BAŞARILI", "SİLME İŞLEMİ BAŞARILI", "success"),
                    "raporlar" => $this->model->listele("raporlar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                    "toplamsayfa" => $this->Pagination->toplamsayfa,
                    "toplamveri" => $this->model->sayfalama("raporlar")
                ));

            
            else:

                $this->View->goster("sayfalar/raporlar/raporlistele", array(
                    "bilgi" => $this->Bilgi->sweetAlert(URL."/raporlar/raporListele", "BAŞARISIZ", "SİLME SIRASINDA HATA OLUŞTU", "warning"),
                    "raporlar" => $this->model->listele("raporlar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                    "toplamsayfa" => $this->Pagination->toplamsayfa,
                    "toplamveri" => $this->model->sayfalama("raporlar")
                ));

            endif;

        }

        function raporArama ($tercih=false, $kelime=false, $mevcutsayfa=false) {

            if($_POST || isset($kelime)):

                $tercihKontrol = "";

                $tarih1 = "";

                $tarih2 = "";

                $ara = "";

                $searchVal = "";

                $link = "";

                if($_POST):

                    $aramatercih = $this->Form->get("aramatercih")->bosmu();

                    if($aramatercih=="testar") {
                        
                        $tercihKontrol = "date";

                        $tarih1 = $this->Form->get("tarih1")->bosmu();

                        $tarih2 = $this->Form->get("tarih2")->bosmu();

                    } else {

                        $tercihKontrol = "normal";

                        $ara = $this->Form->get("ara")->bosmu();

                    }

                    $kosul = !empty($this->Form->error);

                else:

                    $tercihKontrol = "";

                    $kosul = empty($kelime);

                    $aramatercih = $tercih; 

                endif;
            
                if($kosul):

                    $this->View->goster("sayfalar/raporlar/raporlistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/raporlar/raporListele", "BAŞARISIZ", "ARAMA KISMI BOŞ BIRAKILAMAZ", "warning"),
                    ));

                else:

                    if($tercihKontrol=="normal"):

                        $searchVal = $ara;

                        $link = $ara;

                    elseif($tercihKontrol=="date"):

                        $searchVal = "'".$tarih1. "'"." AND "."'".$tarih2."'";

                        $link = $tarih1."_".$tarih2;

                    else :

                        $dateOrNormal = explode("-", $kelime);

                        $parca = explode("_" ,$kelime);

                        $searchVal = count($dateOrNormal)>=4 ? "'".$parca[0]."'"." AND "."'".$parca[1]."'" : $kelime;

                        $link = $kelime;

                    endif;

                    $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);

                    $sorgu = "";

                    $columnNames = ["arac_id", "firma", "testar", "teskm", "ucret", "tesnot"];

                    foreach ($columnNames as $key => $value) :
                        switch ($aramatercih): 
                            case $value:
                                switch ($tercihKontrol) :
                                    case 'normal':
                                        $sorgu = "where ".$value." like '%".$searchVal."%'";
                                        break;
                                    case 'date':
                                        $sorgu = "where ".$value." BETWEEN ".$searchVal;
                                        break;
                                    default:
                                        $sorgu = count($dateOrNormal)>=4 ? "where ".$value." BETWEEN ".$searchVal :  "where ".$value." like '%".$searchVal."%'";
                                        break;
                                endswitch;
                                break;
                        endswitch;
                    endforeach;

                    $bilgicek = $this->model->arama("raporlar", $sorgu);

                    if(isset($bilgicek[0]["id"])):

                        $this->Pagination->paginationOlustur($this->model->sayfalama("raporlar", $sorgu), $mevcutsayfa, $adet[0][0]);

                        $this->View->goster("sayfalar/raporlar/raporlistele", array(
                            "raporlar" => $this->model->listele("raporlar", $sorgu." LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("raporlar", $sorgu),
                            "raporarama" => $link,
                            "aramatercih" => $aramatercih,
                            "sorgu" => $sorgu
                        ));

                    else:
                        
                        $this->View->goster("sayfalar/raporlar/raporlistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/raporlar/raporListele", "BAŞARISIZ", "HİÇ BİR BİLGİ İLE UYUŞMADI", "warning"),
                        ));

                    endif;

                endif;

            else:

                $this->bilgi->direktYonlen("/raporlar/raporListele");
                
            endif;
            
        }

        function raporSirala($kriter=false, $tercih=false, $mevcutsayfa=false) {

            if($_POST || isset($kriter)) :

                if($_POST):

                    $siralamaTercih = $this->Form->get("siralamatercih")->bosmu();

                    $siralamaKriteri = $this->Form->get("siralamakriteri")->bosmu();

                    $kosul = !empty($this->Form->error);

                else:

                    $siralamaTercih = $tercih;

                    $siralamaKriteri = $kriter;

                    $kosul = empty($kriter);

                endif;
            
                if($kosul):

                    $this->View->goster("sayfalar/raporlar/raporlistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/raporlar/raporListele", "BAŞARISIZ", "ARAMA KISMI BOŞ BIRAKILAMAZ", "warning"),
                    ));

                else:

                    $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);

                    $this->Pagination->paginationOlustur($this->model->sayfalama("raporlar"), $mevcutsayfa, $adet[0][0]);

                    if($siralamaTercih=="a-z"):

                        $this->View->goster("sayfalar/raporlar/raporlistele", array(
                            "raporlar" => $this->model->listele("raporlar", " ORDER BY ".$siralamaKriteri." ASC LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("raporlar"),
                            "siralamakriteri" => $siralamaKriteri,
                            "siralamatercih" => $siralamaTercih,
                            "sorgu" => " ORDER BY ".$siralamaKriteri." ASC"
                        ));

                    else:

                        $this->View->goster("sayfalar/raporlar/raporlistele", array(
                            "raporlar" => $this->model->listele("raporlar", " ORDER BY ".$siralamaKriteri." DESC LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("raporlar"),
                            "siralamakriteri" => $siralamaKriteri,
                            "siralamatercih" => $siralamaTercih,
                            "sorgu" => " ORDER BY ".$siralamaKriteri." DESC"
                        ));

                    endif;

                endif;
                
            else:

                $this->Bilgi->direktYonlen("/raporlar/raporListele");

            endif;

        }

        function raporlarExcelAl ($sorgu=false) {

            $degerler = $this->model->listele("raporlar", Session::get("excelraporsorgu"));

            $icerikler = [];

            foreach ($degerler as $key => $deger) :

                $icerikler[] = array($deger["arac_id"], $deger["firma"], $deger["testar"], $deger["teskm"], $deger["tesnot"]);
            
            endforeach;

            $this->DosyaCikti->excelAl("Raporlar", array("Araç", "Firma", "Teslim Tarihi", "Teslim KM", "Teslim Not"), $icerikler);

            Session::unset("excelraporsorgu");
            
        }
        
    }

?>