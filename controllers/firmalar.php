<?php 

    class firmalar extends Controller {

        function __construct () {

            parent:: libsInclude(array("View", "Form", "Bilgi", "Pagination", "DosyaCikti", "Session", "DosyaIslemleri"));

            @Session::init();

            @$this->ModelYukle("firma");

            if(!Session::get("adminAd") || !Session::get("adminId")): 
 
                $this->giris();

                exit();

            endif;

        }

        function giris () {

            if(Session::get("adminAd") && Session::get("adminId")): 

                $this->Bilgi->direktYonlen("/firmalar/firmaListele");

            else:

                $this->View->goster("sayfalar/index");

            endif;
            
        }

        function firmaListele($mevcutsayfa=false) {

            $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
            $this->Pagination->paginationOlustur($this->model->sayfalama("firmalar"), $mevcutsayfa, $adet[0][0]);
            
            $this->View->goster("sayfalar/firmalar/firmalistele", array(
                "firmalar" => $this->model->listele("firmalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                "toplamsayfa" => $this->Pagination->toplamsayfa,
                "toplamveri" => $this->model->sayfalama("firmalar"),
                "araclar" => $this->model->gelismisArama("id, plaka", "arabalar"),
                "sorgu" => ""
            ));

        }

        function firmaEkle() {

            $this->View->goster("sayfalar/firmalar/firmaekle");

        }

        function firmaEkleSon ($mevcutsayfa=false) {

            if($_POST):

                $firma_ismi = $this->Form->get("firma_ismi")->bosmu();

                $vergi_dairesi = $this->Form->get("vergi_dairesi")->bosmu();

                $vergi_numarasi = $this->Form->get("vergi_numarasi")->bosmu();

                $yasak = $this->Form->get("yasak")->bosmu();

                $borc = $this->Form->get("borc")->bosmu();

                $firma_durum = $this->Form->get("firma_durum")->bosmu();

                $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
                $this->Pagination->paginationOlustur($this->model->sayfalama("firmalar"), $mevcutsayfa, $adet[0][0]);

                if (!empty($this->Form->error)) :
                    
                    $this->View->goster("sayfalar/firmalar/firmalistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/firmalar/firmaListele", "BAŞARISIZ", "BOŞ ALAN BIRAKILAMAZ", "warning"),
                        "firmalar" => $this->model->listele("firmalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                        "toplamsayfa" => $this->Pagination->toplamsayfa,
                        "toplamveri" => $this->model->sayfalama("firmalar")
                    ));
                    
                else:

                    $sonuc = $this->model->ekle("firmalar", array("firma_ismi", "vergi_dairesi", "vergi_numarasi", "yasak", "firma_durum", "borc"), array($firma_ismi, $vergi_dairesi, $vergi_numarasi, $yasak, $firma_durum, $borc));

                    if($sonuc):
                        
                        $this->View->goster("sayfalar/firmalar/firmalistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/firmalar/firmaListele", "BAŞARILI", "EKLEME BAŞARILI", "success"),
                            "firmalar" => $this->model->listele("firmalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("firmalar")
                        ));

                    else:

                        $this->View->goster("sayfalar/firmalar/firmalistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/firmalar/firmaListele", "BAŞARISIZ", "EKLEME SIRASINDA HATA OLUŞTU", "warning"),
                            "firmalar" => $this->model->listele("firmalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("firmalar")
                        ));

                    endif;
                
                endif;
                
            else:

                $this->Bilgi->direktYonlen("/firmalar/firmaListele");
                
            endif;

        }

        function firmaGuncelle($id) {

            $this->View->goster("sayfalar/firmalar/firmaguncelle", array(
                'firma' => $this->model->listele("firmalar", "where cus_id=".$id),
            ));

        }
        
        function firmaGuncelleSon ($mevcutsayfa=false) {

            if($_POST):

                $id = $this->Form->get("id")->bosmu();

                $firma_ismi = $this->Form->get("firma_ismi")->bosmu();

                $vergi_dairesi = $this->Form->get("vergi_dairesi")->bosmu();

                $vergi_numarasi = $this->Form->get("vergi_numarasi")->bosmu();

                $yasak = $this->Form->get("yasak")->bosmu();

                $borc = $this->Form->get("borc")->bosmu();

                $firma_durum = $this->Form->get("firma_durum")->bosmu();

                $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
                $this->Pagination->paginationOlustur($this->model->sayfalama("firmalar"), $mevcutsayfa, $adet[0][0]);

                if (!empty($this->Form->error)) :
                
                    $this->View->goster("sayfalar/firmalar/firmalistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/firmalar/firmaListele", "BAŞARISIZ", "BOŞ ALAN BIRAKILAMAZ", "warning"),
                        "firmalar" => $this->model->listele("firmalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                        "toplamsayfa" => $this->Pagination->toplamsayfa,
                        "toplamveri" => $this->model->sayfalama("firmalar")
                    ));

                else:

                    $sonuc = $this->model->guncelle("firmalar", array("firma_ismi", "vergi_dairesi", "vergi_numarasi", "yasak", "firma_durum", "borc"), array($firma_ismi, $vergi_dairesi, $vergi_numarasi, $yasak, $firma_durum, $borc), "cus_id=".$id);

                    if($sonuc):
                        
                        $this->View->goster("sayfalar/firmalar/firmalistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/firmalar/firmaListele", "BAŞARILI", "GÜNCELLEME BAŞARILI", "success"),
                            "firmalar" => $this->model->listele("firmalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("firmalar")
                        ));

                    else:

                        $this->View->goster("sayfalar/firmalar/firmalistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/firmalar/firmaListele", "BAŞARISIZ", "GÜNCELLEME SIRASINDA HATA OLUŞTU", "warning"),
                            "firmalar" => $this->model->listele("firmalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("firmalar")
                        ));

                    endif;
                
                endif;
                
            else:

                $this->Bilgi->direktYonlen("/firmalar/firmaListele");
                
            endif;

        }

        function firmaSil ($id, $mevcutsayfa=false) {

            $sonuc = $this->model->sil("firmalar", "cus_id=".$id);

            $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
            $this->Pagination->paginationOlustur($this->model->sayfalama("firmalar"), $mevcutsayfa, $adet[0][0]);

            if ($sonuc):
            
                $this->View->goster("sayfalar/firmalar/firmalistele", array(
                    "bilgi" => $this->Bilgi->sweetAlert(URL."/firmalar/firmaListele", "BAŞARILI", "SİLME İŞLEMİ BAŞARILI", "success"),
                    "firmalar" => $this->model->listele("firmalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                    "toplamsayfa" => $this->Pagination->toplamsayfa,
                    "toplamveri" => $this->model->sayfalama("firmalar")
                ));
            
            else:

                $this->View->goster("sayfalar/firmalar/firmalistele", array(
                    "bilgi" => $this->Bilgi->sweetAlert(URL."/firmalar/firmaListele", "BAŞARISIZ", "SİLME SIRASINDA HATA OLUŞTU", "warning"),
                    "firmalar" => $this->model->listele("firmalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                    "toplamsayfa" => $this->Pagination->toplamsayfa,
                    "toplamveri" => $this->model->sayfalama("firmalar")
                ));

            endif;

        }

        function firmaArama ($tercih=false, $kelime=false, $mevcutsayfa=false) {

            if($_POST || isset($kelime)):

                if($_POST):

                    $ara = $this->Form->get("ara")->bosmu();

                    $aramatercih = $this->Form->get("aramatercih")->bosmu();

                    $kosul = !empty($this->Form->error);

                else:

                    $ara = $kelime;

                    $kosul = empty($kelime);

                    $aramatercih = $tercih; 

                endif;
            
                if($kosul):

                    $this->View->goster("sayfalar/firmalar/firmalistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/firmalar/firmaListele", "BAŞARISIZ", "ARAMA KISMI BOŞ BIRAKILAMAZ", "warning"),
                    ));

                else:

                    $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);

                    $sorgu = "";

                    switch ($aramatercih) {
                        case 'firma_ismi':
                            $sorgu = "where firma_ismi like '%".$ara."%'";
                            break;
                        case 'vergi_dairesi':
                            $sorgu = "where vergi_dairesi like '%".$ara."%'";
                            break;
                        case 'vergi_numarasi':
                            $sorgu = "where vergi_numarasi like '%".$ara."%'";
                            break; 
                        case 'yasak':
                            $sorgu = "where yasak like '%".$ara."%'";
                            break;
                        case 'firma_durum':
                            $sorgu = "where firma_durum like '%".$ara."%'";
                            break;
                        case 'borc':
                            $sorgu = "where borc like '%".$ara."%'";
                            break; 
                        default:
                            break;
                    }

                    $bilgicek = $this->model->arama("firmalar", $sorgu);

                    if(isset($bilgicek[0]["cus_id"])):

                        $this->Pagination->paginationOlustur($this->model->sayfalama("firmalar", $sorgu), $mevcutsayfa, $adet[0][0]);

                        $this->View->goster("sayfalar/firmalar/firmalistele", array(
                            "firmalar" => $this->model->listele("firmalar", $sorgu." LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("firmalar", $sorgu),
                            "firmaarama" => $ara,
                            "aramatercih" => $aramatercih,
                            "sorgu" => $sorgu
                        ));

                    else:
                        
                        $this->View->goster("sayfalar/firmalar/firmalistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/firmalar/firmaListele", "BAŞARISIZ", "HİÇ BİR BİLGİ İLE UYUŞMADI", "warning"),
                        ));

                    endif;

                endif;

            else:

                $this->bilgi->direktYonlen("/firmalar/firmaListele");
                
            endif;
            
        }

        function firmaSirala($kriter=false, $tercih=false, $mevcutsayfa=false) {

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

                    $this->View->goster("sayfalar/firmalar/firmalistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/firmalar/firmaListele", "BAŞARISIZ", "ARAMA KISMI BOŞ BIRAKILAMAZ", "warning"),
                    ));

                else:

                    $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);

                    $this->Pagination->paginationOlustur($this->model->sayfalama("firmalar"), $mevcutsayfa, $adet[0][0]);

                    if($siralamaTercih=="a-z"):

                        $this->View->goster("sayfalar/firmalar/firmalistele", array(
                            "firmalar" => $this->model->listele("firmalar", " ORDER BY ".$siralamaKriteri." ASC LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("firmalar"),
                            "siralamakriteri" => $siralamaKriteri,
                            "siralamatercih" => $siralamaTercih,
                            "sorgu" => " ORDER BY ".$siralamaKriteri." ASC"
                        ));

                    else:

                        $this->View->goster("sayfalar/firmalar/firmalistele", array(
                            "firmalar" => $this->model->listele("firmalar", " ORDER BY ".$siralamaKriteri." DESC LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("firmalar"),
                            "siralamakriteri" => $siralamaKriteri,
                            "siralamatercih" => $siralamaTercih,
                            "sorgu" => " ORDER BY ".$siralamaKriteri." DESC"
                        ));

                    endif;

                endif;
                
            else:

                $this->Bilgi->direktYonlen("/firmalar/firmaListele");

            endif;

        }

        function firmalarExcelAl ($sorgu=false) {

            $degerler = $this->model->listele("firmalar", Session::get("excelfirmasorgu"));

            $icerikler = [];

            foreach ($degerler as $key => $deger) :

                $icerikler[] = array($deger["firma_ismi"], $deger["vergi_dairesi"], $deger["vergi_numarasi"], $deger["yasak"], $deger["borc"], $deger["firma_durum"]);
            
            endforeach;

            $this->DosyaCikti->excelAl("Müşteriler", array("Firma İsmi", "Vergi Dairesi", "Vergi Numarası", "Yasak", "Borç", "firma_durum"), $icerikler);

            Session::unset("excelfirmasorgu");
            
        }
        
        function topluFirmaEkle ($son = false, $mevcutsayfa=false) {

            if($son):

                $sorgum = $this->DosyaIslemleri->jsonVerileriAyikla("dosya");

                $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
                $this->Pagination->paginationOlustur($this->model->sayfalama("firmalar"), $mevcutsayfa, $adet[0][0]);

                if(!empty($this->DosyaIslemleri->error)) :
                    
                    $this->View->goster("sayfalar/firmalar/firmalistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/firmalar/firmaListele", "BAŞARISIZ", "JSON DOSYASI AÇILAMADI", "warning"),
                        "firmalar" => $this->model->firmaListele("firmalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                        "toplamsayfa" => $this->Pagination->toplamsayfa,
                        "toplamveri" => $this->model->sayfalama("firmalar")
                    ));

                else:

                    $sonuc = $this->model->topluEkle(
                        "firmalar",
                        array("firma_ismi", "vergi_dairesi", "vergi_numarasi", "yasak", "firma_durum", "borc"),
                        $sorgum
                    );

                    if($sonuc):

                        $this->View->goster("sayfalar/firmalar/firmalistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/firmalar/firmaListele", "BAŞARISIZ", "EKLEME BAŞARILI", "success"),
                            "firmalar" => $this->model->listele("firmalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("firmalar")
                        ));

                    else:

                        $this->View->goster("sayfalar/firmalar/firmalistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/firmalar/firmaListele", "BAŞARISIZ", "EKLEME İŞLEMİNDE HATA OLUŞTU", "warning"),
                            "firmalar" => $this->model->listele("firmalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("firmalar")
                        ));

                    endif;

                endif;

            else:

                $this->View->goster("sayfalar/firmalar/toplufirmaislemleri",
                    [ "topluFirmaEkleme" => true ]
                );

            endif;

        }

    }

?>