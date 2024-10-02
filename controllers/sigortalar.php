<?php 

    class sigortalar extends Controller {

        function __construct () {

            parent:: libsInclude(array("View", "Form", "Bilgi", "Pagination", "DosyaCikti", "Session", "DosyaIslemleri"));

            @Session::init();

            @$this->ModelYukle("sigorta");

            if(!Session::get("adminAd") || !Session::get("adminId")): 
 
                $this->giris();

                exit();

            endif;

        }

        function giris () {

            if(Session::get("adminAd") && Session::get("adminId")): 

                $this->Bilgi->direktYonlen("/sigortalar/sigortaListele");

            else:

                $this->View->goster("sayfalar/index");

            endif;
            
        }

        function sigortaListele($mevcutsayfa=false) {  

            $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
            $this->Pagination->paginationOlustur($this->model->sayfalama("sigortalar"), $mevcutsayfa, $adet[0][0]);
            
            $this->View->goster("sayfalar/sigortalar/sigortalistele", array(
                "sigortalar" => $this->model->listele("sigortalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                "toplamsayfa" => $this->Pagination->toplamsayfa,
                "toplamveri" => $this->model->sayfalama("sigortalar"),
                "araclar" => $this->model->gelismisArama("id, plaka", "arabalar"),
                "sorgu" => ""
            ));

        }

        function sigortaEkle() {

            $this->View->goster("sayfalar/sigortalar/sigortaekle", array(
                "araclar" => $this->model->gelismisArama("plaka", "arabalar")
            ));
            
        }

        function sigortaEkleSon ($mevcutsayfa=false) {

            if($_POST):

                $arac_id = $this->Form->get("arac_id")->bosmu();

                $sigorta_turu = $this->Form->get("sigorta_turu")->bosmu();

                $baslangic_tarihi = $this->Form->get("baslangic_tarihi")->bosmu();

                $bitis_tarihi = $this->Form->get("bitis_tarihi")->bosmu();

                $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
                $this->Pagination->paginationOlustur($this->model->sayfalama("sigortalar"), $mevcutsayfa, $adet[0][0]);

                if (!empty($this->Form->error)) :
                    
                    $this->View->goster("sayfalar/sigortalar/sigortalistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/sigortalar/sigortaListele", "BAŞARISIZ", "BOŞ ALAN BIRAKILAMAZ", "warning"),
                        "sigortalar" => $this->model->listele("sigortalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                        "toplamsayfa" => $this->Pagination->toplamsayfa,
                        "toplamveri" => $this->model->sayfalama("sigortalar")
                    ));
                    
                else:

                    $sonuc = $this->model->ekle("sigortalar", array("arac_id", "sigorta_turu", "baslangic_tarihi", "bitis_tarihi"), array($arac_id, $sigorta_turu, $baslangic_tarihi, $bitis_tarihi));

                    if($sonuc):
                        
                        $this->View->goster("sayfalar/sigortalar/sigortalistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/sigortalar/sigortaListele", "BAŞARILI", "EKLEME BAŞARILI", "success"),
                            "sigortalar" => $this->model->listele("sigortalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("sigortalar")
                        ));

                    else:

                        $this->View->goster("sayfalar/sigortalar/sigortalistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/sigortalar/sigortaListele", "BAŞARISIZ", "EKLEME SIRASINDA HATA OLUŞTU", "warning"),
                            "sigortalar" => $this->model->listele("sigortalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("sigortalar")
                        ));

                    endif;
                
                endif;
                
            else:

                $this->Bilgi->direktYonlen("/sigortalar/sigortaListele");
                
            endif;

        }

        function sigortaGuncelle($id) {

            $this->View->goster("sayfalar/sigortalar/sigortaguncelle", array(
                'sigorta' => $this->model->listele("sigortalar", "where id=".$id),
                "araclar" => $this->model->gelismisArama("plaka", "arabalar")
            ));

        }
        
        function sigortaGuncelleSon ($mevcutsayfa=false) {

            if($_POST):

                $id = $this->Form->get("id")->bosmu();

                $arac_id = $this->Form->get("arac_id")->bosmu();

                $sigorta_turu = $this->Form->get("sigorta_turu")->bosmu();

                $baslangic_tarihi = $this->Form->get("baslangic_tarihi")->bosmu();

                $bitis_tarihi = $this->Form->get("bitis_tarihi")->bosmu();

                $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
                $this->Pagination->paginationOlustur($this->model->sayfalama("sigortalar"), $mevcutsayfa, $adet[0][0]);

                if (!empty($this->Form->error)) :
                
                    $this->View->goster("sayfalar/sigortalar/sigortalistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/sigortalar/sigortaListele", "BAŞARISIZ", "BOŞ ALAN BIRAKILAMAZ", "warning"),
                        "sigortalar" => $this->model->listele("sigortalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                        "toplamsayfa" => $this->Pagination->toplamsayfa,
                        "toplamveri" => $this->model->sayfalama("sigortalar")
                    ));

                else:

                    $sonuc = $this->model->guncelle("sigortalar", array("arac_id", "sigorta_turu", "baslangic_tarihi", "bitis_tarihi"), array($arac_id, $sigorta_turu, $baslangic_tarihi, $bitis_tarihi), "id=".$id);

                    if($sonuc):

                        $this->View->goster("sayfalar/sigortalar/sigortalistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/sigortalar/sigortaListele", "BAŞARILI", "GÜNCELLEME BAŞARILI", "success"),
                            "sigortalar" => $this->model->listele("sigortalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("sigortalar")
                        ));

                    else:

                        $this->View->goster("sayfalar/sigortalar/sigortalistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/sigortalar/sigortaListele", "BAŞARISIZ", "GÜNCELLEME SIRASINDA HATA OLUŞTU", "warning"),
                            "sigortalar" => $this->model->listele("sigortalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("sigortalar")
                        ));

                    endif;
                
                endif;
                
            else:

                $this->Bilgi->direktYonlen("/sigortalar/sigortaListele");
                
            endif;

        }

        function sigortaSil ($id, $mevcutsayfa=false) {

            $sonuc = $this->model->sil("sigortalar", "id=".$id);

            $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
            $this->Pagination->paginationOlustur($this->model->sayfalama("sigortalar"), $mevcutsayfa, $adet[0][0]);

            if ($sonuc):
            
                $this->View->goster("sayfalar/sigortalar/sigortalistele", array(
                    "bilgi" => $this->Bilgi->sweetAlert(URL."/sigortalar/sigortaListele", "BAŞARILI", "SİLME İŞLEMİ BAŞARILI", "success"),
                    "sigortalar" => $this->model->listele("sigortalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                    "toplamsayfa" => $this->Pagination->toplamsayfa,
                    "toplamveri" => $this->model->sayfalama("sigortalar")
                ));
            
            else:

                $this->View->goster("sayfalar/sigortalar/sigortalistele", array(
                    "bilgi" => $this->Bilgi->sweetAlert(URL."/sigortalar/sigortaListele", "BAŞARISIZ", "SİLME SIRASINDA HATA OLUŞTU", "warning"),
                    "sigortalar" => $this->model->listele("sigortalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                    "toplamsayfa" => $this->Pagination->toplamsayfa,
                    "toplamveri" => $this->model->sayfalama("sigortalar")
                ));

            endif;

        }

        function sigortaArama ($tercih=false, $kelime=false, $mevcutsayfa=false) {

            if($_POST || isset($kelime)):

                $tercihKontrol = "";

                $tarih1 = "";

                $tarih2 = "";

                $ara = "";

                $searchVal = "";

                $link = "";

                if($_POST):

                    $aramatercih = $this->Form->get("aramatercih")->bosmu();

                    if($aramatercih=="baslangic_tarihi"||$aramatercih=="bitis_tarihi") {
                        
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

                    $this->View->goster("sayfalar/sigortalar/sigortalistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/sigortalar/sigortaListele", "BAŞARISIZ", "ARAMA KISMI BOŞ BIRAKILAMAZ", "warning"),
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

                    $columnNames = ["arac_id", "sigorta_turu", "baslangic_tarihi", "bitis_tarihi"];

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

                    $bilgicek = $this->model->arama("sigortalar", $sorgu);

                    if(isset($bilgicek[0]["id"])):

                        $this->Pagination->paginationOlustur($this->model->sayfalama("sigortalar", $sorgu), $mevcutsayfa, $adet[0][0]);

                        $this->View->goster("sayfalar/sigortalar/sigortalistele", array(
                            "sigortalar" => $this->model->listele("sigortalar", $sorgu." LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("sigortalar", $sorgu),
                            "sigortaarama" => $link,
                            "aramatercih" => $aramatercih,
                            "sorgu" => $sorgu
                        ));

                    else:
                        
                        $this->View->goster("sayfalar/sigortalar/sigortalistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/sigortalar/sigortaListele", "BAŞARISIZ", "HİÇ BİR BİLGİ İLE UYUŞMADI", "warning"),
                        ));

                    endif;

                endif;

            else:

                $this->bilgi->direktYonlen("/sigortalar/sigortaListele");
                
            endif;
            
        }

        function sigortaSirala($kriter=false, $tercih=false, $mevcutsayfa=false) {

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

                    $this->View->goster("sayfalar/sigortalar/sigortalistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/sigortalar/sigortaListele", "BAŞARISIZ", "ARAMA KISMI BOŞ BIRAKILAMAZ", "warning"),
                    ));

                else:

                    $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);

                    $this->Pagination->paginationOlustur($this->model->sayfalama("sigortalar"), $mevcutsayfa, $adet[0][0]);

                    if($siralamaTercih=="a-z"):

                        $this->View->goster("sayfalar/sigortalar/sigortalistele", array(
                            "sigortalar" => $this->model->listele("sigortalar", " ORDER BY ".$siralamaKriteri." ASC LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("sigortalar"),
                            "siralamakriteri" => $siralamaKriteri,
                            "siralamatercih" => $siralamaTercih,
                            "sorgu" => " ORDER BY ".$siralamaKriteri." ASC"
                        ));

                    elseif($siralamaTercih=="z-a"):

                        $this->View->goster("sayfalar/sigortalar/sigortalistele", array(
                            "sigortalar" => $this->model->listele("sigortalar", " ORDER BY ".$siralamaKriteri." DESC LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("sigortalar"),
                            "siralamakriteri" => $siralamaKriteri,
                            "siralamatercih" => $siralamaTercih,
                            "sorgu" => " ORDER BY ".$siralamaKriteri." DESC"
                        ));

                    elseif($siralamaTercih==="trafik_sigortasi") :

                        $this->View->goster("sayfalar/sigortalar/sigortalistele", array(
                            "sigortalar" => $this->model->listele("sigortalar", " ORDER BY ".$siralamaKriteri." DESC LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("sigortalar"),
                            "siralamakriteri" => $siralamaKriteri,
                            "siralamatercih" => $siralamaTercih,
                            "sorgu" => " ORDER BY ".$siralamaKriteri." DESC"
                        ));

                    elseif($siralamaTercih==="kasko_sigortasi") :

                        $this->View->goster("sayfalar/sigortalar/sigortalistele", array(
                            "sigortalar" => $this->model->listele("sigortalar", " ORDER BY ".$siralamaKriteri." ASC LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("sigortalar"),
                            "siralamakriteri" => $siralamaKriteri,
                            "siralamatercih" => $siralamaTercih,
                            "sorgu" => " ORDER BY ".$siralamaKriteri." DESC"
                        ));

                    endif;

                endif;
                
            else:

                $this->Bilgi->direktYonlen("/sigortalar/sigortaListele");

            endif;

        }

        function sigortalarExcelAl ($sorgu=false) {

            $degerler = $this->model->listele("sigortalar", Session::get("excelsigortasorgu"));

            $icerikler = [];

            foreach ($degerler as $key => $deger) :

                $icerikler[] = array($deger["arac_id"], $deger["sigorta_turu"], $deger["baslangic_tarihi"], $deger["bitis_tarihi"]);
            
            endforeach;

            $this->DosyaCikti->excelAl("Trafik Sigortaları", array("Araç", "Sigorta Türü", "Başlangıç Tarihi", "Bitiş Tarihi"), $icerikler);
            
            Session::unset("excelsigortasorgu");
            
        }
        
        function topluSigortaEkle ($son = false, $mevcutsayfa=false) {

            if($son):

                $sorgum = $this->DosyaIslemleri->jsonVerileriAyikla("dosya");

                $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
                $this->Pagination->paginationOlustur($this->model->sayfalama("sigortalar"), $mevcutsayfa, $adet[0][0]);

                if(!empty($this->DosyaIslemleri->error)) :
                    
                    $this->View->goster("sayfalar/sigortalar/sigortalistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/sigortalar/sigortaListele", "BAŞARISIZ", "JSON DOSYASI AÇILAMADI", "warning"),
                        "sigortalar" => $this->model->listele("sigortalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                        "toplamsayfa" => $this->Pagination->toplamsayfa,
                        "toplamveri" => $this->model->sayfalama("sigortalar")
                    ));

                else:

                    $sonuc = $this->model->topluEkle(
                        "sigortalar",
                        array("arac_id", "sigorta_turu", "baslangic_tarihi", "bitis_tarihi"),
                        $sorgum
                    );

                    if($sonuc):

                        $this->View->goster("sayfalar/sigortalar/sigortalistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/sigortalar/sigortaListele", "BAŞARISIZ", "EKLEME BAŞARILI", "success"),
                            "sigortalar" => $this->model->listele("sigortalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("sigortalar")
                        ));

                    else:

                        $this->View->goster("sayfalar/sigortalar/sigortalistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/sigortalar/sigortaListele", "BAŞARISIZ", "EKLEME İŞLEMİNDE HATA OLUŞTU", "warning"),
                            "sigortalar" => $this->model->listele("sigortalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("sigortalar")
                        ));

                    endif;

                endif;

            else:

                $this->View->goster("sayfalar/toplusigortaislemleri",
                    [ "topluFirmaEkleme" => true ]
                );

            endif;

        }

    }

?>