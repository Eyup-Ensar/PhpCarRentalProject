<?php 

    class suruculer extends Controller {

        function __construct () {

            parent:: libsInclude(array("View", "Form", "Bilgi", "Pagination", "DosyaCikti", "Session", "DosyaIslemleri"));

            @Session::init();

            @$this->ModelYukle("surucu");

            if(!Session::get("adminAd") || !Session::get("adminId")): 
 
                $this->giris();

                exit();

            endif;

        }

        function giris () {

            if(Session::get("adminAd") && Session::get("adminId")): 

                $this->Bilgi->direktYonlen("/suruculer/surucuListele");

            else:

                $this->View->goster("sayfalar/index");

            endif;
            
        }

    //   [  "ad", "soyad", "telefon", "mail_adresi", "belge_turu", "belge_numarasi", "belge_skt"]

        function surucuListele($mevcutsayfa=false) {  

            $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
            $this->Pagination->paginationOlustur($this->model->sayfalama("suruculer"), $mevcutsayfa, $adet[0][0]);
            
            $this->View->goster("sayfalar/suruculer/suruculistele", array(
                "suruculer" => $this->model->listele("suruculer", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                "toplamsayfa" => $this->Pagination->toplamsayfa,
                "toplamveri" => $this->model->sayfalama("suruculer"),
                "sorgu" => ""
            ));

        }

        function surucuEkle() {

            $this->View->goster("sayfalar/suruculer/surucuekle", array(
                "araclar" => $this->model->gelismisArama("plaka", "arabalar")
            ));
            
        }

        function surucuEkleSon ($mevcutsayfa=false) {

            if($_POST):

                $ad = $this->Form->get("ad")->bosmu();

                $soyad = $this->Form->get("soyad")->bosmu();

                $telefon = $this->Form->get("telefon")->bosmu();

                $mail_adresi = $this->Form->get("mail_adresi")->bosmu();

                $belge_turu = $this->Form->get("belge_turu")->bosmu();

                $belge_numarasi = $this->Form->get("belge_numarasi")->bosmu();

                $belge_skt = $this->Form->get("belge_skt")->bosmu();

                $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
                $this->Pagination->paginationOlustur($this->model->sayfalama("suruculer"), $mevcutsayfa, $adet[0][0]);

                if (!empty($this->Form->error)) :
                    
                    $this->View->goster("sayfalar/suruculer/suruculistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/suruculer/surucuListele", "BAŞARISIZ", "BOŞ ALAN BIRAKILAMAZ", "warning"),
                        "suruculer" => $this->model->listele("suruculer", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                        "toplamsayfa" => $this->Pagination->toplamsayfa,
                        "toplamveri" => $this->model->sayfalama("suruculer")
                    ));
                    
                else:

                    $sonuc = $this->model->ekle("suruculer", array("ad", "soyad", "telefon", "mail_adresi", "belge_turu", "belge_numarasi", "belge_skt"), array($ad, $soyad, $telefon, $mail_adresi, $belge_turu, $belge_numarasi, $belge_skt));

                    if($sonuc):
                        
                        $this->View->goster("sayfalar/suruculer/suruculistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/suruculer/surucuListele", "BAŞARILI", "EKLEME BAŞARILI", "success"),
                            "suruculer" => $this->model->listele("suruculer", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("suruculer")
                        ));

                    else:

                        $this->View->goster("sayfalar/suruculer/suruculistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/suruculer/surucuListele", "BAŞARISIZ", "EKLEME SIRASINDA HATA OLUŞTU", "warning"),
                            "suruculer" => $this->model->listele("suruculer", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("suruculer")
                        ));

                    endif;
                
                endif;
                
            else:

                $this->Bilgi->direktYonlen("/suruculer/surucuListele");
                
            endif;

        }

        function surucuGuncelle($id) {

            $this->View->goster("sayfalar/suruculer/surucuguncelle", array(
                'surucu' => $this->model->listele("suruculer", "where id=".$id),
                "araclar" => $this->model->gelismisArama("plaka", "suruculer")
            ));

        }
        
        function surucuGuncelleSon ($mevcutsayfa=false) {

            if($_POST):

                $id = $this->Form->get("id")->bosmu();

                $ad = $this->Form->get("ad")->bosmu();

                $soyad = $this->Form->get("soyad")->bosmu();

                $telefon = $this->Form->get("telefon")->bosmu();

                $mail_adresi = $this->Form->get("mail_adresi")->bosmu();

                $belge_turu = $this->Form->get("belge_turu")->bosmu();

                $belge_numarasi = $this->Form->get("belge_numarasi")->bosmu();

                $belge_skt = $this->Form->get("belge_skt")->bosmu();

                $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
                $this->Pagination->paginationOlustur($this->model->sayfalama("suruculer"), $mevcutsayfa, $adet[0][0]);

                if (!empty($this->Form->error)) :
                
                    $this->View->goster("sayfalar/suruculer/suruculistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/suruculer/surucuListele", "BAŞARISIZ", "BOŞ ALAN BIRAKILAMAZ", "warning"),
                        "suruculer" => $this->model->listele("suruculer", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                        "toplamsayfa" => $this->Pagination->toplamsayfa,
                        "toplamveri" => $this->model->sayfalama("suruculer")
                    ));

                else:

                    $sonuc = $this->model->guncelle("suruculer",  array("ad", "soyad", "telefon", "mail_adresi", "belge_turu", "belge_numarasi", "belge_skt"), array($ad, $soyad, $telefon, $mail_adresi, $belge_turu, $belge_numarasi, $belge_skt), "id=".$id);

                    if($sonuc):

                        $this->View->goster("sayfalar/suruculer/suruculistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/suruculer/surucuListele", "BAŞARILI", "GÜNCELLEME BAŞARILI", "success"),
                            "suruculer" => $this->model->listele("suruculer", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("suruculer")
                        ));

                    else:

                        $this->View->goster("sayfalar/suruculer/suruculistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/suruculer/surucuListele", "BAŞARISIZ", "GÜNCELLEME SIRASINDA HATA OLUŞTU", "warning"),
                            "suruculer" => $this->model->listele("suruculer", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("suruculer")
                        ));

                    endif;
                
                endif;
                
            else:

                $this->Bilgi->direktYonlen("/suruculer/surucuListele");
                
            endif;

        }

        function surucuSil ($id, $mevcutsayfa=false) {

            $sonuc = $this->model->sil("suruculer", "id=".$id);

            $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
            $this->Pagination->paginationOlustur($this->model->sayfalama("suruculer"), $mevcutsayfa, $adet[0][0]);

            if ($sonuc):
            
                $this->View->goster("sayfalar/suruculer/suruculistele", array(
                    "bilgi" => $this->Bilgi->sweetAlert(URL."/suruculer/surucuListele", "BAŞARILI", "SİLME İŞLEMİ BAŞARILI", "success"),
                    "suruculer" => $this->model->listele("suruculer", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                    "toplamsayfa" => $this->Pagination->toplamsayfa,
                    "toplamveri" => $this->model->sayfalama("suruculer")
                ));
            
            else:

                $this->View->goster("sayfalar/suruculer/suruculistele", array(
                    "bilgi" => $this->Bilgi->sweetAlert(URL."/suruculer/surucuListele", "BAŞARISIZ", "SİLME SIRASINDA HATA OLUŞTU", "warning"),
                    "suruculer" => $this->model->listele("suruculer", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                    "toplamsayfa" => $this->Pagination->toplamsayfa,
                    "toplamveri" => $this->model->sayfalama("suruculer")
                ));

            endif;

        }

        function surucuArama ($tercih=false, $kelime=false, $mevcutsayfa=false) {

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

                    $this->View->goster("sayfalar/suruculer/suruculistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/suruculer/surucuListele", "BAŞARISIZ", "ARAMA KISMI BOŞ BIRAKILAMAZ", "warning"),
                    ));

                else:

                    $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);

                    $sorgu = "";

                    $columnNames = ["ad", "soyad", "telefon", "mail_adresi", "belge_turu", "belge_numarasi", "belge_skt"];

                    foreach ($columnNames as $key => $value) :
                        switch ($aramatercih): 
                            case $value:
                                    $sorgu = "where ".$value." like '%".$ara."%'";
                                break;
                            endswitch;
                    endforeach;

                    $bilgicek = $this->model->arama("suruculer", $sorgu);

                    if(isset($bilgicek[0]["id"])):

                        $this->Pagination->paginationOlustur($this->model->sayfalama("suruculer", $sorgu), $mevcutsayfa, $adet[0][0]);

                        $this->View->goster("sayfalar/suruculer/suruculistele", array(
                            "suruculer" => $this->model->listele("suruculer", $sorgu." LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("suruculer", $sorgu),
                            "surucuarama" => $ara,
                            "aramatercih" => $aramatercih,
                            "sorgu" => $sorgu
                        ));

                    else:
                        
                        $this->View->goster("sayfalar/suruculer/suruculistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/suruculer/surucuListele", "BAŞARISIZ", "HİÇ BİR BİLGİ İLE UYUŞMADI", "warning"),
                        ));

                    endif;

                endif;

            else:

                $this->bilgi->direktYonlen("/suruculer/surucuListele");
                
            endif;
            
        }

        function surucuSirala($kriter=false, $tercih=false, $mevcutsayfa=false) {

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

                    $this->View->goster("sayfalar/suruculer/suruculistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/suruculer/surucuListele", "BAŞARISIZ", "ARAMA KISMI BOŞ BIRAKILAMAZ", "warning"),
                    ));

                else:

                    $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);

                    $this->Pagination->paginationOlustur($this->model->sayfalama("suruculer"), $mevcutsayfa, $adet[0][0]);

                    if($siralamaTercih=="a-z"):

                        $this->View->goster("sayfalar/suruculer/suruculistele", array(
                            "suruculer" => $this->model->listele("suruculer", " ORDER BY ".$siralamaKriteri." ASC LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("suruculer"),
                            "siralamakriteri" => $siralamaKriteri,
                            "siralamatercih" => $siralamaTercih,
                            "sorgu" => " ORDER BY ".$siralamaKriteri." ASC"
                        ));

                    else:

                        $this->View->goster("sayfalar/suruculer/suruculistele", array(
                            "suruculer" => $this->model->listele("suruculer", " ORDER BY ".$siralamaKriteri." DESC LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("suruculer"),
                            "siralamakriteri" => $siralamaKriteri,
                            "siralamatercih" => $siralamaTercih,
                            "sorgu" => " ORDER BY ".$siralamaKriteri." DESC"
                        ));

                    endif;

                endif;
                
            else:

                $this->Bilgi->direktYonlen("/suruculer/surucuListele");

            endif;

        }

        function suruculerExcelAl ($sorgu=false) {

            $degerler = $this->model->listele("suruculer", Session::get("excelsurucusorgu"));

            $icerikler = [];

            foreach ($degerler as $key => $deger) :

                $icerikler[] = array($deger["ad"], $deger["soyad"], $deger["telefon"], $deger["mail_adresi"], $deger["belge_turu"], $deger["belge_numarasi"], $deger["belge_skt"]);

            endforeach;

            $this->DosyaCikti->excelAl("Trafik Cezaları", array("Ad", "Soyad", "Telefon", "Mail Adresi", "Belge Türü", "Belge Numarası", "Belge STK"), $icerikler);

            Session::unset("excelsurucusorgu");
            
        }
        
        function topluCezaEkle ($son = false, $mevcutsayfa=false) {

            if($son):

                $sorgum = $this->DosyaIslemleri->jsonVerileriAyikla("dosya");

                $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
                $this->Pagination->paginationOlustur($this->model->sayfalama("suruculer"), $mevcutsayfa, $adet[0][0]);

                if(!empty($this->DosyaIslemleri->error)) :
                    
                    $this->View->goster("sayfalar/suruculer/suruculistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/suruculer/surucuListele", "BAŞARISIZ", "JSON DOSYASI AÇILAMADI", "warning"),
                        "suruculer" => $this->model->listele("suruculer", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                        "toplamsayfa" => $this->Pagination->toplamsayfa,
                        "toplamveri" => $this->model->sayfalama("suruculer")
                    ));

                else:

                    $sonuc = $this->model->topluEkle(
                        "suruculer",
                        array("ad", "soyad", "telefon", "mail_adresi", "belge_turu", "belge_numarasi", "belge_skt"),
                        $sorgum
                    );

                    if($sonuc):

                        $this->View->goster("sayfalar/suruculer/suruculistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/suruculer/surucuListele", "BAŞARISIZ", "EKLEME BAŞARILI", "success"),
                            "suruculer" => $this->model->listele("suruculer", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("suruculer")
                        ));

                    else:

                        $this->View->goster("sayfalar/suruculer/suruculistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/suruculer/surucuListele", "BAŞARISIZ", "EKLEME İŞLEMİNDE HATA OLUŞTU", "warning"),
                            "suruculer" => $this->model->listele("suruculer", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("suruculer")
                        ));

                    endif;

                endif;

            else:

                $this->View->goster("sayfalar/toplusurucuislemleri",
                    [ "topluFirmaEkleme" => true ]
                );

            endif;

        }

    }

?>