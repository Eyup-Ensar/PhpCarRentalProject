<?php 

    class servisler extends Controller {

        function __construct () {

            parent:: libsInclude(array("View", "Form", "Bilgi", "Pagination", "DosyaCikti", "Session", "DosyaIslemleri"));

            @Session::init();

            @$this->ModelYukle("servis");

            if(!Session::get("adminAd") || !Session::get("adminId")): 
 
                $this->giris();

                exit();

            endif;

        }

        function giris () {

            if(Session::get("adminAd") && Session::get("adminId")): 

                $this->Bilgi->direktYonlen("/servisler/servisListele");

            else:

                $this->View->goster("sayfalar/index");

            endif;
            
        }

        function servisListele($mevcutsayfa=false) {  

            $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
            $this->Pagination->paginationOlustur($this->model->sayfalama("servisler"), $mevcutsayfa, $adet[0][0]);
            
            $this->View->goster("sayfalar/servisler/servislistele", array(
                "servisler" => $this->model->listele("servisler", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                "toplamsayfa" => $this->Pagination->toplamsayfa,
                "toplamveri" => $this->model->sayfalama("servisler"),
                "araclar" => $this->model->gelismisArama("id, plaka", "arabalar"),
                "sorgu" => ""
            ));

        }

        function servisEkle() {

            $this->View->goster("sayfalar/servisler/servisekle", array(
                "araclar" => $this->model->gelismisArama("plaka", "arabalar")
            ));
            
        }

        function servisEkleSon ($mevcutsayfa=false) {

            if($_POST):

                $arac_id = $this->Form->get("arac_id")->bosmu();

                $servis_bayi_adi = $this->Form->get("servis_bayi_adi")->bosmu();

                $yapilan_islem = $this->Form->get("yapilan_islem")->bosmu();

                $islem_nedeni = $this->Form->get("islem_nedeni")->bosmu();

                $servis_giris_tarihi = $this->Form->get("servis_giris_tarihi")->bosmu();

                $servis_cikis_tarihi = $this->Form->get("servis_cikis_tarihi")->bosmu();

                $servis_giris_km = $this->Form->get("servis_giris_km")->bosmu();

                $servis_tutari = $this->Form->get("servis_tutari")->bosmu();

                $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
                $this->Pagination->paginationOlustur($this->model->sayfalama("servisler"), $mevcutsayfa, $adet[0][0]);

                if (!empty($this->Form->error)) :
                    
                    $this->View->goster("sayfalar/servisler/servislistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/servisler/servisListele", "BAŞARISIZ", "BOŞ ALAN BIRAKILAMAZ", "warning"),
                        "servisler" => $this->model->listele("servisler", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                        "toplamsayfa" => $this->Pagination->toplamsayfa,
                        "toplamveri" => $this->model->sayfalama("servisler")
                    ));
                    
                else:

                    $sonuc = $this->model->ekle("servisler", array("arac_id", "servis_bayi_adi", "yapilan_islem", "islem_nedeni", "servis_giris_tarihi", "servis_cikis_tarihi", "servis_giris_km", "servis_tutari"), array($arac_id, $servis_bayi_adi, $yapilan_islem, $islem_nedeni, $servis_giris_tarihi, $servis_cikis_tarihi, $servis_giris_km, $servis_tutari));

                    if($sonuc):
                        
                        $this->View->goster("sayfalar/servisler/servislistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/servisler/servisListele", "BAŞARILI", "EKLEME BAŞARILI", "success"),
                            "servisler" => $this->model->listele("servisler", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("servisler")
                        ));

                    else:

                        $this->View->goster("sayfalar/servisler/servislistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/servisler/servisListele", "BAŞARISIZ", "EKLEME SIRASINDA HATA OLUŞTU", "warning"),
                            "servisler" => $this->model->listele("servisler", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("servisler")
                        ));

                    endif;
                
                endif;
                
            else:

                $this->Bilgi->direktYonlen("/servisler/servisListele");
                
            endif;

        }

        function servisGuncelle($id) {

            $this->View->goster("sayfalar/servisler/servisguncelle", array(
                'servis' => $this->model->listele("servisler", "where id=".$id),
                "araclar" => $this->model->gelismisArama("plaka", "arabalar")
            ));

        }
        
        function servisGuncelleSon ($mevcutsayfa=false) {

            if($_POST):

                $id = $this->Form->get("id")->bosmu();

                $arac_id = $this->Form->get("arac_id")->bosmu();

                $servis_bayi_adi = $this->Form->get("servis_bayi_adi")->bosmu();

                $yapilan_islem = $this->Form->get("yapilan_islem")->bosmu();

                $islem_nedeni = $this->Form->get("islem_nedeni")->bosmu();

                $servis_giris_tarihi = $this->Form->get("servis_giris_tarihi")->bosmu();

                $servis_cikis_tarihi = $this->Form->get("servis_cikis_tarihi")->bosmu();

                $servis_giris_km = $this->Form->get("servis_giris_km")->bosmu();

                $servis_tutari = $this->Form->get("servis_tutari")->bosmu();

                $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
                $this->Pagination->paginationOlustur($this->model->sayfalama("servisler"), $mevcutsayfa, $adet[0][0]);

                if (!empty($this->Form->error)) :
                
                    $this->View->goster("sayfalar/servisler/servislistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/servisler/servisListele", "BAŞARISIZ", "BOŞ ALAN BIRAKILAMAZ", "warning"),
                        "servisler" => $this->model->listele("servisler", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                        "toplamsayfa" => $this->Pagination->toplamsayfa,
                        "toplamveri" => $this->model->sayfalama("servisler")
                    ));

                else:

                    $sonuc = $this->model->guncelle("servisler", array("arac_id", "servis_bayi_adi", "yapilan_islem", "islem_nedeni", "servis_giris_tarihi", "servis_cikis_tarihi", "servis_giris_km", "servis_tutari"), array($arac_id, $servis_bayi_adi, $yapilan_islem, $islem_nedeni, $servis_giris_tarihi, $servis_cikis_tarihi, $servis_giris_km, $servis_tutari), "id=".$id);

                    if($sonuc):

                        $this->View->goster("sayfalar/servisler/servislistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/servisler/servisListele", "BAŞARILI", "GÜNCELLEME BAŞARILI", "success"),
                            "servisler" => $this->model->listele("servisler", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("servisler")
                        ));

                    else:

                        $this->View->goster("sayfalar/servisler/servislistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/servisler/servisListele", "BAŞARISIZ", "GÜNCELLEME SIRASINDA HATA OLUŞTU", "warning"),
                            "servisler" => $this->model->listele("servisler", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("servisler")
                        ));

                    endif;
                
                endif;
                
            else:

                $this->Bilgi->direktYonlen("/servisler/servisListele");
                
            endif;

        }

        function servisSil ($id, $mevcutsayfa=false) {

            $sonuc = $this->model->sil("servisler", "id=".$id);

            $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
            $this->Pagination->paginationOlustur($this->model->sayfalama("servisler"), $mevcutsayfa, $adet[0][0]);

            if ($sonuc):
            
                $this->View->goster("sayfalar/servisler/servislistele", array(
                    "bilgi" => $this->Bilgi->sweetAlert(URL."/servisler/servisListele", "BAŞARILI", "SİLME İŞLEMİ BAŞARILI", "success"),
                    "servisler" => $this->model->listele("servisler", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                    "toplamsayfa" => $this->Pagination->toplamsayfa,
                    "toplamveri" => $this->model->sayfalama("servisler")
                ));
            
            else:

                $this->View->goster("sayfalar/servisler/servislistele", array(
                    "bilgi" => $this->Bilgi->sweetAlert(URL."/servisler/servisListele", "BAŞARISIZ", "SİLME SIRASINDA HATA OLUŞTU", "warning"),
                    "servisler" => $this->model->listele("servisler", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                    "toplamsayfa" => $this->Pagination->toplamsayfa,
                    "toplamveri" => $this->model->sayfalama("servisler")
                ));

            endif;

        }

        function servisArama ($tercih=false, $kelime=false, $mevcutsayfa=false) {

            if($_POST || isset($kelime)):

                $tercihKontrol = "";

                $tarih1 = "";

                $tarih2 = "";

                $ara = "";

                $searchVal = "";

                $link = "";

                if($_POST):

                    $aramatercih = $this->Form->get("aramatercih")->bosmu();

                    if($aramatercih=="servis_giris_tarihi"||$aramatercih=="servis_cikis_tarihi") {
                        
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

                    $this->View->goster("sayfalar/servisler/servislistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/servisler/servisListele", "BAŞARISIZ", "ARAMA KISMI BOŞ BIRAKILAMAZ", "warning"),
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

                    $columnNames = ["arac_id", "servis_bayi_adi", "yapilan_islem", "islem_nedeni", "servis_giris_tarihi", "servis_cikis_tarihi", "servis_giris_km", "servis_tutari"];

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

                    $bilgicek = $this->model->arama("servisler", $sorgu);

                    if(isset($bilgicek[0]["id"])):

                        $this->Pagination->paginationOlustur($this->model->sayfalama("servisler", $sorgu), $mevcutsayfa, $adet[0][0]);

                        $this->View->goster("sayfalar/servisler/servislistele", array(
                            "servisler" => $this->model->listele("servisler", $sorgu." LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("servisler", $sorgu),
                            "servisarama" => $link,
                            "aramatercih" => $aramatercih,
                            "sorgu" => $sorgu
                        ));

                    else:
                        
                        $this->View->goster("sayfalar/servisler/servislistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/servisler/servisListele", "BAŞARISIZ", "HİÇ BİR BİLGİ İLE UYUŞMADI", "warning"),
                        ));

                    endif;

                endif;

            else:

                $this->bilgi->direktYonlen("/servisler/servisListele");
                
            endif;
            
        }

        function servisSirala($kriter=false, $tercih=false, $mevcutsayfa=false) {

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

                    $this->View->goster("sayfalar/servisler/servislistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/servisler/servisListele", "BAŞARISIZ", "ARAMA KISMI BOŞ BIRAKILAMAZ", "warning"),
                    ));

                else:

                    $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);

                    $this->Pagination->paginationOlustur($this->model->sayfalama("servisler"), $mevcutsayfa, $adet[0][0]);

                    if($siralamaTercih=="a-z"):

                        $this->View->goster("sayfalar/servisler/servislistele", array(
                            "servisler" => $this->model->listele("servisler", " ORDER BY ".$siralamaKriteri." ASC LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("servisler"),
                            "siralamakriteri" => $siralamaKriteri,
                            "siralamatercih" => $siralamaTercih,
                            "sorgu" => " ORDER BY ".$siralamaKriteri." ASC"
                        ));

                    else:

                        $this->View->goster("sayfalar/servisler/servislistele", array(
                            "servisler" => $this->model->listele("servisler", " ORDER BY ".$siralamaKriteri." DESC LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("servisler"),
                            "siralamakriteri" => $siralamaKriteri,
                            "siralamatercih" => $siralamaTercih,
                            "sorgu" => " ORDER BY ".$siralamaKriteri." DESC"
                        ));

                    endif;

                endif;
                
            else:

                $this->Bilgi->direktYonlen("/servisler/servisListele");

            endif;

        }

        function servislerExcelAl ($sorgu=false) {

            $degerler = $this->model->listele("servisler", Session::get("excelservissorgu"));

            $icerikler = [];

            foreach ($degerler as $key => $deger) :

                $icerikler[] = array($deger["arac_id"], $deger["servis_bayi_adi"], $deger["yapilan_islem"], $deger["islem_nedeni"], $deger["servis_giris_tarihi"], $deger["servis_cikis_tarihi"], $deger["servis_giris_km"], $deger["servis_tutari"]);

            endforeach;

            $this->DosyaCikti->excelAl("Servisler", array("Araç", "servis_bayi_adi", "Yapılan İşlem", "İşlem Nedeni", "Servis Giriş Tarihi", "Servis Çıkış Tarihi", "Servis Giriş KM", "Servis Tutarı"), $icerikler);

            Session::unset("excelservissorgu");
            
        }
        
        function topluServisEkle ($son = false, $mevcutsayfa=false) {

            if($son):

                $sorgum = $this->DosyaIslemleri->jsonVerileriAyikla("dosya");

                $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
                $this->Pagination->paginationOlustur($this->model->sayfalama("servisler"), $mevcutsayfa, $adet[0][0]);

                if(!empty($this->DosyaIslemleri->error)) :
                    
                    $this->View->goster("sayfalar/servisler/servislistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/servisler/servisListele", "BAŞARISIZ", "JSON DOSYASI AÇILAMADI", "warning"),
                        "servisler" => $this->model->listele("servisler", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                        "toplamsayfa" => $this->Pagination->toplamsayfa,
                        "toplamveri" => $this->model->sayfalama("servisler")
                    ));

                else:

                    $sonuc = $this->model->topluEkle(
                        "servisler",
                        array("arac_id", "servis_bayi_adi", "yapilan_islem", "islem_nedeni", "servis_giris_tarihi", "servis_cikis_tarihi", "servis_giris_km", "servis_tutari"),
                        $sorgum
                    );

                    if($sonuc):

                        $this->View->goster("sayfalar/servisler/servislistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/servisler/servisListele", "BAŞARISIZ", "EKLEME BAŞARILI", "success"),
                            "servisler" => $this->model->listele("servisler", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("servisler")
                        ));

                    else:

                        $this->View->goster("sayfalar/servisler/servislistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/servisler/servisListele", "BAŞARISIZ", "EKLEME İŞLEMİNDE HATA OLUŞTU", "warning"),
                            "servisler" => $this->model->listele("servisler", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("servisler")
                        ));

                    endif;

                endif;

            else:

                $this->View->goster("sayfalar/topluservisislemleri",
                    [ "topluFirmaEkleme" => true ]
                );

            endif;

        }

    }

?>