<?php 

    class kiralar extends Controller {

        function __construct () {

            parent:: libsInclude(array("View", "Form", "Bilgi", "Pagination", "DosyaCikti", "Session"));

            @Session::init();

            @$this->ModelYukle("kira");

            if(!Session::get("adminAd") || !Session::get("adminId")): 

                $this->giris();

                exit();

            endif;

        }

        function giris () {

            if(Session::get("adminAd") && Session::get("adminId")): 

                $this->Bilgi->direktYonlen("/kiralar/kiraListele");

            else:

                $this->View->goster("sayfalar/index");

            endif;
            
        }

        function kiraListele($mevcutsayfa=false) {

            $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
            $this->Pagination->paginationOlustur($this->model->sayfalama("kiralar"), $mevcutsayfa, $adet[0][0]);

            $this->View->goster("sayfalar/kiralar/kiralistele", array(
                "kiralar" => $this->model->listele("kiralar", " LIMIT ".($this->Pagination->limit>=0 ? $this->Pagination->limit : 0).", ".$this->Pagination->gosterilecekadet),
                "toplamsayfa" => $this->Pagination->toplamsayfa,
                "toplamveri" => $this->model->sayfalama("kiralar"),
                "araclar" => $this->model->gelismisArama("id, plaka", "arabalar"),
                "firmalar" => $this->model->gelismisArama("cus_id, firma_ismi", "firmalar"),
                "sorgu" => ""
            ));

        }

        function kiraBaslat() {

            $this->View->goster("sayfalar/kiralar/kirabaslat", array(
                "araclar" => $this->model->gelismisArama("id, plaka", "arabalar", " where durum='boşta'"),
                'firmalar' => $this->model->gelismisArama("cus_id, firma_ismi", "firmalar")
            ));

        }

        function kiraBaslatSon ($mevcutsayfa=false) {

            if($_POST):

                $arac_id = $this->Form->selectBoxGet("arac_id");

                $firma_id = $this->Form->selectBoxGet("firma_id");

                $sozbas = $this->Form->get("sozbas")->bosmu();

                $sozbit = $this->Form->get("sozbit")->bosmu();

                $sozbaskm = $this->Form->get("sozbaskm")->bosmu();

                $ucret = $this->Form->get("ucret")->bosmu();

                $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
                $this->Pagination->paginationOlustur($this->model->sayfalama("kiralar"), $mevcutsayfa, $adet[0][0]);

                if (!empty($this->Form->error)) :
                    
                    $this->View->goster("sayfalar/kiralar/kiralistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/kiralar/kiraListele", "BAŞARISIZ", "BOŞ ALAN BIRAKILAMAZ", "warning"),
                        "kiralar" => $this->model->listele("kiralar", " LIMIT ".($this->Pagination->limit>=0 ? $this->Pagination->limit : 0).", ".$this->Pagination->gosterilecekadet),
                        "toplamsayfa" => $this->Pagination->toplamsayfa,
                        "toplamveri" => $this->model->sayfalama("kiralar"),
                        "araclar" => $this->model->gelismisArama("id, plaka", "arabalar"),
                        "firmalar" => $this->model->gelismisArama("cus_id, firma_ismi", "firmalar")
                    ));

                else:

                    $sonuc = $this->model->ekle("kiralar", array("arac_id", "firma_id", "sozbas", "sozbit", "sozbaskm", "ucret"), array($arac_id, $firma_id, $sozbas, $sozbit, $sozbaskm, $ucret));

                    if($sonuc):

                        $sonuc2 = $this->model->basitGuncelle("arabalar", "durum='Kirada'", "id=".$arac_id);

                        $this->View->goster("sayfalar/kiralar/kiralistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/kiralar/kiraListele", "BAŞARILI", "EKLEME BAŞARILI", "success"),
                            "kiralar" => $this->model->listele("kiralar", " LIMIT ".($this->Pagination->limit>=0 ? $this->Pagination->limit : 0).", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("kiralar"),
                            "araclar" => $this->model->gelismisArama("id, plaka", "arabalar"),
                            "firmalar" => $this->model->gelismisArama("cus_id, firma_ismi", "firmalar")
                        ));

                    else:

                        $this->View->goster("sayfalar/kiralar/kiralistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/kiralar/kiraListele", "BAŞARISIZ", "EKLEME SIRASINDA HATA OLUŞTU", "warning"),
                            "kiralar" => $this->model->listele("kiralar", " LIMIT ".($this->Pagination->limit>=0 ? $this->Pagination->limit : 0).", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("kiralar"),
                            "araclar" => $this->model->gelismisArama("id, plaka", "arabalar"),
                            "firmalar" => $this->model->gelismisArama("cus_id, firma_ismi", "firmalar")
                        ));

                    endif;

                endif;
                
            else:

                $this->Bilgi->direktYonlen("/kiralar/kiraListele");
                
            endif;

        }

        function kiraGuncelle($id) {

            $kiralar = $this->model->listele("kiralar", "where id=".$id);

            $this->View->goster("sayfalar/kiralar/kiraguncelle", array(
                'kira' => $kiralar,
                "araclar" => $this->model->gelismisArama("id, plaka", "arabalar", " where durum='boşta' || id=".$kiralar[0]["arac_id"]),
                'firmalar' => $this->model->gelismisArama("cus_id, firma_ismi", "firmalar")
            ));

        }
        
        function kiraGuncelleSon ($mevcutsayfa=false) {

            if($_POST):

                $id = $this->Form->get("id")->bosmu();

                $arac_id = $this->Form->selectBoxGet("arac_id");

                $firma_id = $this->Form->selectBoxGet("firma_id");

                $sozbas = $this->Form->get("sozbas")->bosmu();

                $sozbit = $this->Form->get("sozbit")->bosmu();

                $sozbaskm = $this->Form->get("sozbaskm")->bosmu();

                $ucret = $this->Form->get("ucret")->bosmu();

                $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
                $this->Pagination->paginationOlustur($this->model->sayfalama("kiralar"), $mevcutsayfa, $adet[0][0]);

                if (!empty($this->Form->error)) :
                
                    $this->View->goster("sayfalar/kiralar/kiralistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/kiralar/kiraListele", "BAŞARISIZ", "BOŞ ALAN BIRAKILAMAZ", "warning"),
                        "kiralar" => $this->model->listele("kiralar", " LIMIT ".($this->Pagination->limit>=0 ? $this->Pagination->limit : 0).", ".$this->Pagination->gosterilecekadet),
                        "toplamsayfa" => $this->Pagination->toplamsayfa,
                        "toplamveri" => $this->model->sayfalama("kiralar"),
                        "araclar" => $this->model->gelismisArama("id, plaka", "arabalar"),
                        "firmalar" => $this->model->gelismisArama("cus_id, firma_ismi", "firmalar")
                    ));

                else:

                    $eskiarac = $this->model->gelismisArama("arac_id", "kiralar", "where id=".$id);

                    $sonuc = $this->model->guncelle("kiralar", array("arac_id", "firma_id", "sozbas", "sozbit", "sozbaskm", "ucret"), array($arac_id, $firma_id, $sozbas, $sozbit, $sozbaskm, $ucret), "id=".$id);

                    if($sonuc):

                        if($eskiarac[0][0] != $arac_id) :

                            $sonuc2 = $this->model->basitGuncelle("arabalar", "durum='Boşta'", "id=".$eskiarac[0][0]);

                            $sonuc3 = $this->model->basitGuncelle("arabalar", "durum='Kirada'", "id=".$arac_id);

                        endif;
                        
                        $this->View->goster("sayfalar/kiralar/kiralistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/kiralar/kiraListele", "BAŞARILI", "GÜNCELLEME BAŞARILI", "success"),
                            "kiralar" => $this->model->listele("kiralar", " LIMIT ".($this->Pagination->limit>=0 ? $this->Pagination->limit : 0).", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("kiralar"),
                            "araclar" => $this->model->gelismisArama("id, plaka", "arabalar"),
                            "firmalar" => $this->model->gelismisArama("cus_id, firma_ismi", "firmalar")
                        ));

                    else:

                        $this->View->goster("sayfalar/kiralar/kiralistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/kiralar/kiraListele", "BAŞARISIZ", "GÜNCELLEME SIRASINDA HATA OLUŞTU", "warning"),
                            "kiralar" => $this->model->listele("kiralar", " LIMIT ".($this->Pagination->limit>=0 ? $this->Pagination->limit : 0).", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("kiralar"),
                            "araclar" => $this->model->gelismisArama("id, plaka", "arabalar"),
                            "firmalar" => $this->model->gelismisArama("cus_id, firma_ismi", "firmalar")
                        ));

                    endif;
                
                endif;
                
            else:

                $this->Bilgi->direktYonlen("/kiralar/kiraListele");
                
            endif;

        }

        function kiraSil ($id, $mevcutsayfa=false) {

            $arac_id = $this->model->gelismisArama("arac_id", "kiralar", "where id=".$id);

            $sonuc = $this->model->sil("kiralar", "id=".$id);

            $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);

            $this->Pagination->paginationOlustur($this->model->sayfalama("kiralar"), $mevcutsayfa, $adet[0][0]);

            if ($sonuc):

                $sonuc2 = $this->model->basitGuncelle("arabalar", "durum='Boşta'", "id=".$arac_id[0][0]);
            
                $this->View->goster("sayfalar/kiralar/kiralistele", array(
                    "bilgi" => $this->Bilgi->sweetAlert(URL."/kiralar/kiraListele", "BAŞARILI", "SİLME İŞLEMİ BAŞARILI", "success"),
                    "kiralar" => $this->model->listele("kiralar", " LIMIT ".($this->Pagination->limit>=0 ? $this->Pagination->limit : 0).", ".$this->Pagination->gosterilecekadet),
                    "toplamsayfa" => $this->Pagination->toplamsayfa,
                    "toplamveri" => $this->model->sayfalama("kiralar"),
                    "araclar" => $this->model->gelismisArama("id, plaka", "arabalar"),
                    "firmalar" => $this->model->gelismisArama("cus_id, firma_ismi", "firmalar")
                ));

            else:

                $this->View->goster("sayfalar/kiralar/kiralistele", array(
                    "bilgi" => $this->Bilgi->sweetAlert(URL."/kiralar/kiraListele", "BAŞARISIZ", "SİLME SIRASINDA HATA OLUŞTU", "warning"),
                    "kiralar" => $this->model->listele("kiralar", " LIMIT ".($this->Pagination->limit>=0 ? $this->Pagination->limit : 0).", ".$this->Pagination->gosterilecekadet),
                    "toplamsayfa" => $this->Pagination->toplamsayfa,
                    "toplamveri" => $this->model->sayfalama("kiralar"),
                    "araclar" => $this->model->gelismisArama("id, plaka", "arabalar"),
                    "firmalar" => $this->model->gelismisArama("cus_id, firma_ismi", "firmalar")
                ));

            endif;

        }

        function aracTeslim($id) {

            $ids = $this->model->gelismisArama("arac_id, firma_id", "kiralar", "where id=".$id);

            $plaka = $this->model->gelismisArama("plaka", "arabalar", "where id=".$ids[0]["arac_id"]);

            $firmaisim = $this->model->gelismisArama("firma_ismi", "firmalar", "where cus_id=".$ids[0]["firma_id"]);

            $this->View->goster("sayfalar/kiralar/aracteslim", array(
                "info" => $this->model->gelismisArama("id, ucret", "kiralar", "where id=".$id),
                "info2" => [$ids[0]["arac_id"], $plaka[0][0], $ids[0]["firma_id"], $firmaisim[0][0]]
            ));

        }

        function aracTeslimSon ($mevcutsayfa=false) {

            if($_POST):

                $id = $this->Form->get("id")->bosmu();

                $arac_id = $this->Form->selectBoxGet("arac_id");

                $firma_id = $this->Form->selectBoxGet("firma_id");

                $testar = $this->Form->get("testar")->bosmu();

                $teskm = $this->Form->get("teskm")->bosmu();

                $ucret = $this->Form->get("ucret")->bosmu();

                $tesnot = $this->Form->get("tesnot")->bosmu();

                $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
                $this->Pagination->paginationOlustur($this->model->sayfalama("kiralar"), $mevcutsayfa, $adet[0][0]);

                if (!empty($this->Form->error)) :
                    
                    $this->View->goster("sayfalar/kiralar/kiralistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/kiralar/kiraListele", "BAŞARISIZ", "BOŞ ALAN BIRAKILAMAZ", "warning"),
                        "kiralar" => $this->model->listele("kiralar", " LIMIT ".($this->Pagination->limit>=0 ? $this->Pagination->limit : 0).", ".$this->Pagination->gosterilecekadet),
                        "toplamsayfa" => $this->Pagination->toplamsayfa,
                        "toplamveri" => $this->model->sayfalama("kiralar"),
                        "araclar" => $this->model->gelismisArama("id, plaka", "arabalar"),
                        "firmalar" => $this->model->gelismisArama("cus_id, firma_ismi", "firmalar")
                    ));

                else:

                    $sonuc1 = $this->model->ekle("raporlar", array("arac_id", "firma_id", "testar", "teskm", "ucret", "tesnot"), array($arac_id, $firma_id, $testar, $teskm, $ucret, $tesnot));
                    
                    if($sonuc1):

                        $sonuc2 = $this->model->sil("kiralar", "id=".$id);

                        if($sonuc2):

                            $sonuc3 = $this->model->basitGuncelle("arabalar", "durum='Boşta'", "id=".$arac_id);

                            $veriAl = $this->model->gelismisArama("kilometre", "arabalar", "where id=".$arac_id);

                            $a = $veriAl[0][0] + $teskm;

                            $sonuc3 = $this->model->guncelle("arabalar", array("kilometre"), array($a), "id=".$arac_id);

                            $this->View->goster("sayfalar/kiralar/kiralistele", array(
                                "bilgi" => $this->Bilgi->sweetAlert(URL."/kiralar/kiraListele", "BAŞARILI", "ARAÇ TESLİM İŞLEMİ BAŞARILI", "success"),
                                "kiralar" => $this->model->listele("kiralar", " LIMIT ".($this->Pagination->limit>=0 ? $this->Pagination->limit : 0).", ".$this->Pagination->gosterilecekadet),
                                "toplamsayfa" => $this->Pagination->toplamsayfa,
                                "toplamveri" => $this->model->sayfalama("kiralar"),
                                "araclar" => $this->model->gelismisArama("id, plaka", "arabalar"),
                                "firmalar" => $this->model->gelismisArama("cus_id, firma_ismi", "firmalar")
                            ));

                        else:

                            $this->View->goster("sayfalar/kiralar/kiralistele", array(
                                "bilgi" => $this->Bilgi->sweetAlert(URL."/kiralar/kiraListele", "BAŞARISIZ", "ARAÇ TESLİM İŞLEMİ SIRASINDA HATA OLUŞTU", "warning"),
                                "kiralar" => $this->model->listele("kiralar", " LIMIT ".($this->Pagination->limit>=0 ? $this->Pagination->limit : 0).", ".$this->Pagination->gosterilecekadet),
                                "toplamsayfa" => $this->Pagination->toplamsayfa,
                                "toplamveri" => $this->model->sayfalama("kiralar"),
                                "araclar" => $this->model->gelismisArama("id, plaka", "arabalar"),
                                "firmalar" => $this->model->gelismisArama("cus_id, firma_ismi", "firmalar")
                            ));

                        endif;

                    else:

                        $this->View->goster("sayfalar/kiralar/kiralistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/kiralar/kiraListele", "BAŞARISIZ", "ARAÇ TESLİM İŞLEMİ SIRASINDA HATA OLUŞTU", "warning"),
                            "kiralar" => $this->model->listele("kiralar", " LIMIT ".($this->Pagination->limit>=0 ? $this->Pagination->limit : 0).", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("kiralar"),
                            "araclar" => $this->model->gelismisArama("id, plaka", "arabalar"),
                            "firmalar" => $this->model->gelismisArama("cus_id, firma_ismi", "firmalar")
                        ));
                        
                    endif;
                
                endif;
                
            else:

                $this->Bilgi->direktYonlen("/kiralar/kiraListele");
                
            endif;

        }

        function kiraArama ($tercih=false, $kelime=false, $mevcutsayfa=false) {

            if($_POST || isset($kelime)):

                $tercihKontrol = "";

                $tarih1 = "";

                $tarih2 = "";

                $ara = "";

                $searchVal = "";

                $link = "";

                if($_POST):

                    $aramatercih = $this->Form->get("aramatercih")->bosmu();

                    if($aramatercih=="sozbas"||$aramatercih=="sozbit") {
                        
                        $tercihKontrol = "date";

                        $tarih1 = $this->Form->get("tarih1")->bosmu();

                        $tarih2 = $this->Form->get("tarih2")->bosmu();

                    } else {

                        $tercihKontrol = "normal";

                        $ara = $this->Form->get("ara")->bosmu();

                    }

                    $kosul = !empty($this->Form->error);

                else:

                    $ara = $kelime;

                    $kosul = empty($kelime);

                    $aramatercih = $tercih; 

                endif;
            
                if($kosul):

                    $this->View->goster("sayfalar/kiralar/kiralistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/kiralar/kiraListele", "BAŞARISIZ", "ARAMA KISMI BOŞ BIRAKILAMAZ", "warning"),
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

                    $columnNames = ["arac_id", "firma", "sozbas", "sozbit", "sozbaskm", "ucret"];

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

                    $bilgicek = $this->model->arama("kiralar", $sorgu);

                    if(isset($bilgicek[0]["id"])):

                        $this->Pagination->paginationOlustur($this->model->sayfalama("kiralar", $sorgu), $mevcutsayfa, $adet[0][0]);

                        $this->View->goster("sayfalar/kiralar/kiralistele", array(
                            "kiralar" => $this->model->listele("kiralar", $sorgu." LIMIT ".($this->Pagination->limit>=0 ? $this->Pagination->limit : 0).", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("kiralar", $sorgu),
                            "kiraarama" => $link,
                            "aramatercih" => $aramatercih,
                            "sorgu" => $sorgu
                        ));

                    else:
                        
                        $this->View->goster("sayfalar/kiralar/kiralistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/kiralar/kiraListele", "BAŞARISIZ", "HİÇ BİR BİLGİ İLE UYUŞMADI", "warning"),
                        ));

                    endif;

                endif;

            else:

                $this->bilgi->direktYonlen("/kiralar/kiraListele");
                
            endif;
            
        }

        function KiraSirala($kriter=false, $tercih=false, $mevcutsayfa=false) {

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

                    $this->View->goster("sayfalar/kiralar/kiralistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/kiralar/kiraListele", "BAŞARISIZ", "ARAMA KISMI BOŞ BIRAKILAMAZ", "warning"),
                    ));

                else:

                    $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);

                    $this->Pagination->paginationOlustur($this->model->sayfalama("kiralar"), $mevcutsayfa, $adet[0][0]);

                    if($siralamaTercih=="a-z"):

                        $this->View->goster("sayfalar/kiralar/kiralistele", array(
                            "kiralar" => $this->model->listele("kiralar", " ORDER BY ".$siralamaKriteri." ASC LIMIT ".($this->Pagination->limit>=0 ? $this->Pagination->limit : 0).", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("kiralar"),
                            "siralamakriteri" => $siralamaKriteri,
                            "siralamatercih" => $siralamaTercih,
                            "sorgu" => " ORDER BY ".$siralamaKriteri." ASC"
                        ));

                    else:

                        $this->View->goster("sayfalar/kiralar/kiralistele", array(
                            "kiralar" => $this->model->listele("kiralar", " ORDER BY ".$siralamaKriteri." DESC LIMIT ".($this->Pagination->limit>=0 ? $this->Pagination->limit : 0).", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("kiralar"),
                            "siralamakriteri" => $siralamaKriteri,
                            "siralamatercih" => $siralamaTercih,
                            "sorgu" => " ORDER BY ".$siralamaKriteri." DESC"
                        ));

                    endif;

                endif;
                
            else:

                $this->Bilgi->direktYonlen("/kiralar/kiraListele");

            endif;

        }

        function kiralarExcelAl ($sorgu=false) {

            $degerler = $this->model->listele("kiralar", Session::get("excelkirasorgu"));

            $icerikler = [];

            foreach ($degerler as $key => $deger) :

                $icerikler[] = array($deger["arac_id"], $deger["firma"], $deger["sozbas"], $deger["sozbit"], $deger["sozbaskm"], $deger["ucret"]);
            
            endforeach;

            $this->DosyaCikti->excelAl("Kiralar", array("Araç", "Firma", "Sözleşme Başlangıç Tarihi", "Sözleşme Bitiş Tarihi", "Sözleşme Başlangıç Kilometresi", "Aylık Ücret"), $icerikler);

            Session::unset("excelkirasorgu");

        }

    }

?>

<!-- 7.4 -->