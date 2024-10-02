<?php 

    class cezalar extends Controller {

        function __construct () {

            parent:: libsInclude(array("View", "Form", "Bilgi", "Pagination", "DosyaCikti", "Session", "DosyaIslemleri"));

            @Session::init();

            @$this->ModelYukle("ceza");

            if(!Session::get("adminAd") || !Session::get("adminId")): 
 
                $this->giris();

                exit();

            endif;

        }

        function giris () {

            if(Session::get("adminAd") && Session::get("adminId")): 

                $this->Bilgi->direktYonlen("/cezalar/cezaListele");

            else:

                $this->View->goster("sayfalar/index");

            endif;
            
        }

        function cezaListele($mevcutsayfa=false) {  

            $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
            $this->Pagination->paginationOlustur($this->model->sayfalama("cezalar"), $mevcutsayfa, $adet[0][0]);
            
            $this->View->goster("sayfalar/cezalar/cezalistele", array(
                "cezalar" => $this->model->listele("cezalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                "toplamsayfa" => $this->Pagination->toplamsayfa,
                "toplamveri" => $this->model->sayfalama("cezalar"),
                "sorgu" => "",
                "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer"),
                "araclar" => $this->model->gelismisArama("id, plaka", "arabalar")
            
            ));

        }

        function cezaEkle() {

            $this->View->goster("sayfalar/cezalar/cezaekle", array(
                "araclar" => $this->model->gelismisArama("plaka", "arabalar"),
                "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
            ));
            
        }

        function cezaEkleSon ($mevcutsayfa=false) {

            if($_POST):

                $arac = $this->Form->get("arac_id")->bosmu();

                $surucu_id = $this->Form->get("surucu_id")->bosmu();

                $ceza_tarihi = $this->Form->get("ceza_tarihi")->bosmu();

                $teblig_tarihi = $this->Form->get("teblig_tarihi")->bosmu();

                $son_odeme_tarihi = $this->Form->get("son_odeme_tarihi")->bosmu();

                $ceza_aciklama = $this->Form->get("ceza_aciklama")->bosmu();

                $durum = $this->Form->get("durum")->bosmu();

                $ceza_tutari = $this->Form->get("ceza_tutari")->bosmu();

                $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
                $this->Pagination->paginationOlustur($this->model->sayfalama("cezalar"), $mevcutsayfa, $adet[0][0]);

                if (!empty($this->Form->error)) :
                    
                    $this->View->goster("sayfalar/cezalar/cezalistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/cezalar/cezaListele", "BAŞARISIZ", "BOŞ ALAN BIRAKILAMAZ", "warning"),
                        "cezalar" => $this->model->listele("cezalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                        "toplamsayfa" => $this->Pagination->toplamsayfa,
                        "toplamveri" => $this->model->sayfalama("cezalar"),
                        "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
                    ));
                    
                else:

                    $sonuc = $this->model->ekle("cezalar", array("arac_id", "surucu_id", "ceza_tarihi", "teblig_tarihi", "son_odeme_tarihi", "ceza_aciklama", "durum", "ceza_tutari"), array($arac, $surucu_id, $ceza_tarihi, $teblig_tarihi, $son_odeme_tarihi, $ceza_aciklama, $durum, $ceza_tutari));

                    if($sonuc):
                        
                        $this->View->goster("sayfalar/cezalar/cezalistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/cezalar/cezaListele", "BAŞARILI", "EKLEME BAŞARILI", "success"),
                            "cezalar" => $this->model->listele("cezalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("cezalar"),
                            "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
                        ));

                    else:

                        $this->View->goster("sayfalar/cezalar/cezalistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/cezalar/cezaListele", "BAŞARISIZ", "EKLEME SIRASINDA HATA OLUŞTU", "warning"),
                            "cezalar" => $this->model->listele("cezalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("cezalar"),
                            "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
                        ));

                    endif;
                
                endif;
                
            else:

                $this->Bilgi->direktYonlen("/cezalar/cezaListele");
                
            endif;

        }

        function cezaGuncelle($id) {

            $this->View->goster("sayfalar/cezalar/cezaguncelle", array(
                'ceza' => $this->model->listele("cezalar", "where id=".$id),
                "araclar" => $this->model->gelismisArama("plaka", "arabalar"),
                "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
            ));

        }
        
        function cezaGuncelleSon ($mevcutsayfa=false) {

            if($_POST):

                $id = $this->Form->get("id")->bosmu();

                $arac = $this->Form->get("arac_id")->bosmu();

                $surucu_id = $this->Form->get("surucu_id")->bosmu();

                $ceza_tarihi = $this->Form->get("ceza_tarihi")->bosmu();

                $teblig_tarihi = $this->Form->get("teblig_tarihi")->bosmu();

                $son_odeme_tarihi = $this->Form->get("son_odeme_tarihi")->bosmu();

                $ceza_aciklama = $this->Form->get("ceza_aciklama")->bosmu();

                $durum = $this->Form->get("durum")->bosmu();

                $ceza_tutari = $this->Form->get("ceza_tutari")->bosmu();

                $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
                $this->Pagination->paginationOlustur($this->model->sayfalama("cezalar"), $mevcutsayfa, $adet[0][0]);

                if (!empty($this->Form->error)) :
                
                    $this->View->goster("sayfalar/cezalar/cezalistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/cezalar/cezaListele", "BAŞARISIZ", "BOŞ ALAN BIRAKILAMAZ", "warning"),
                        "cezalar" => $this->model->listele("cezalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                        "toplamsayfa" => $this->Pagination->toplamsayfa,
                        "toplamveri" => $this->model->sayfalama("cezalar"),
                        "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
                    ));

                else:

                    $sonuc = $this->model->guncelle("cezalar", array("arac_id", "surucu_id", "ceza_tarihi", "teblig_tarihi", "son_odeme_tarihi", "ceza_aciklama", "durum", "ceza_tutari"), array($arac, $surucu_id, $ceza_tarihi, $teblig_tarihi, $son_odeme_tarihi, $ceza_aciklama, $durum, $ceza_tutari), "id=".$id);

                    if($sonuc):

                        $this->View->goster("sayfalar/cezalar/cezalistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/cezalar/cezaListele", "BAŞARILI", "GÜNCELLEME BAŞARILI", "success"),
                            "cezalar" => $this->model->listele("cezalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("cezalar"),
                            "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
                        ));

                    else:

                        $this->View->goster("sayfalar/cezalar/cezalistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/cezalar/cezaListele", "BAŞARISIZ", "GÜNCELLEME SIRASINDA HATA OLUŞTU", "warning"),
                            "cezalar" => $this->model->listele("cezalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("cezalar"),
                            "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
                        ));

                    endif;
                
                endif;
                
            else:

                $this->Bilgi->direktYonlen("/cezalar/cezaListele");
                
            endif;

        }

        function cezaSil ($id, $mevcutsayfa=false) {

            $sonuc = $this->model->sil("cezalar", "id=".$id);

            $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
            $this->Pagination->paginationOlustur($this->model->sayfalama("cezalar"), $mevcutsayfa, $adet[0][0]);

            if ($sonuc):
            
                $this->View->goster("sayfalar/cezalar/cezalistele", array(
                    "bilgi" => $this->Bilgi->sweetAlert(URL."/cezalar/cezaListele", "BAŞARILI", "SİLME İŞLEMİ BAŞARILI", "success"),
                    "cezalar" => $this->model->listele("cezalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                    "toplamsayfa" => $this->Pagination->toplamsayfa,
                    "toplamveri" => $this->model->sayfalama("cezalar"),
                    "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
                ));
            
            else:

                $this->View->goster("sayfalar/cezalar/cezalistele", array(
                    "bilgi" => $this->Bilgi->sweetAlert(URL."/cezalar/cezaListele", "BAŞARISIZ", "SİLME SIRASINDA HATA OLUŞTU", "warning"),
                    "cezalar" => $this->model->listele("cezalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                    "toplamsayfa" => $this->Pagination->toplamsayfa,
                    "toplamveri" => $this->model->sayfalama("cezalar"),
                    "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
                ));

            endif;

        }

        function cezaArama ($tercih=false, $kelime=false, $mevcutsayfa=false) {

            if($_POST || isset($kelime)):

                $tercihKontrol = "";

                $tarih1 = "";

                $tarih2 = "";

                $ara = "";

                $searchVal = "";

                $link = "";

                if($_POST):

                    $aramatercih = $this->Form->get("aramatercih")->bosmu();

                    if($aramatercih=="ceza_tarihi"||$aramatercih=="teblig_taihi"||$aramatercih=="son_odeme_tarihi") {
                        
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

                    $this->View->goster("sayfalar/cezalar/cezalistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/cezalar/cezaListele", "BAŞARISIZ", "ARAMA KISMI BOŞ BIRAKILAMAZ", "warning"),
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

                    $columnNames = ["arac_id", "surucu_id", "ceza_tarihi", "teblig_tarihi", "son_odeme_tarihi", "ceza_aciklama", "durum", "ceza_tutar"];

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

                    $bilgicek = $this->model->arama("cezalar", $sorgu);

                    if(isset($bilgicek[0]["id"])):

                        $this->Pagination->paginationOlustur($this->model->sayfalama("cezalar", $sorgu), $mevcutsayfa, $adet[0][0]);

                        $this->View->goster("sayfalar/cezalar/cezalistele", array(
                            "cezalar" => $this->model->listele("cezalar", $sorgu." LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("cezalar", $sorgu),
                            "cezaarama" => $link,
                            "aramatercih" => $aramatercih,
                            "sorgu" => $sorgu,
                            "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
                        ));

                    else:
                        
                        $this->View->goster("sayfalar/cezalar/cezalistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/cezalar/cezaListele", "BAŞARISIZ", "HİÇ BİR BİLGİ İLE UYUŞMADI", "warning"),
                        ));

                    endif;

                endif;

            else:

                $this->bilgi->direktYonlen("/cezalar/cezaListele");
                
            endif;
            
        }

        function cezaSirala($kriter=false, $tercih=false, $mevcutsayfa=false) {

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

                    $this->View->goster("sayfalar/cezalar/cezalistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/cezalar/cezaListele", "BAŞARISIZ", "ARAMA KISMI BOŞ BIRAKILAMAZ", "warning"),
                    ));

                else:

                    $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);

                    $this->Pagination->paginationOlustur($this->model->sayfalama("cezalar"), $mevcutsayfa, $adet[0][0]);

                    if($siralamaTercih=="a-z"):

                        $this->View->goster("sayfalar/cezalar/cezalistele", array(
                            "cezalar" => $this->model->listele("cezalar", " ORDER BY ".$siralamaKriteri." ASC LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("cezalar"),
                            "siralamakriteri" => $siralamaKriteri,
                            "siralamatercih" => $siralamaTercih,
                            "sorgu" => " ORDER BY ".$siralamaKriteri." ASC",
                            "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
                        ));

                    else:

                        $this->View->goster("sayfalar/cezalar/cezalistele", array(
                            "cezalar" => $this->model->listele("cezalar", " ORDER BY ".$siralamaKriteri." DESC LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("cezalar"),
                            "siralamakriteri" => $siralamaKriteri,
                            "siralamatercih" => $siralamaTercih,
                            "sorgu" => " ORDER BY ".$siralamaKriteri." DESC",
                            "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
                        ));

                    endif;

                endif;
                
            else:

                $this->Bilgi->direktYonlen("/cezalar/cezaListele");

            endif;

        }

        function cezalarExcelAl ($sorgu=false) {

            $degerler = $this->model->listele("cezalar", Session::get("excelcezasorgu"));

            $icerikler = [];

            foreach ($degerler as $key => $deger) :

                $suruculer = $this->model->gelismisArama("ad, soyad", "suruculer", "where id = ".$deger["surucu_id"]);

                $icerikler[] = array($deger["arac_id"], isset($suruculer[0][0]) ? $suruculer[0][0]." ".$suruculer[0][1] : "Sürücü bulunamadı!", $deger["ceza_tarihi"], $deger["teblig_tarihi"], $deger["son_odeme_tarihi"], $deger["ceza_aciklama"], $deger["durum"], $deger["ceza_tutari"]);
            
            endforeach;

            $this->DosyaCikti->excelAl("Trafik Cezaları", array("Araç", "Sürücüler", "Ceza Tarihi", "Tebliğ Tarihi", "Son Ödeme Tarihi", "Ceza Açıklama", "Ceza Durum", "Ceza Tutarı"), $icerikler);

            Session::unset("excelcezasorgu");
            
        }
        
        function topluCezaEkle ($son = false, $mevcutsayfa=false) {

            if($son):

                $sorgum = $this->DosyaIslemleri->jsonVerileriAyikla("dosya");

                $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
                $this->Pagination->paginationOlustur($this->model->sayfalama("cezalar"), $mevcutsayfa, $adet[0][0]);

                if(!empty($this->DosyaIslemleri->error)) :
                    
                    $this->View->goster("sayfalar/cezalar/cezalistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/cezalar/cezaListele", "BAŞARISIZ", "JSON DOSYASI AÇILAMADI", "warning"),
                        "cezalar" => $this->model->listele("cezalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                        "toplamsayfa" => $this->Pagination->toplamsayfa,
                        "toplamveri" => $this->model->sayfalama("cezalar"),
                        "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
                    ));

                else:

                    $sonuc = $this->model->topluEkle(
                        "cezalar",
                        array("arac_id", "suruculer", "ceza_tarihi", "teblig_tarihi", "son_odeme_tarihi", "ceza_aciklama", "durum", "ceza_tutari"),
                        $sorgum
                    );

                    if($sonuc):

                        $this->View->goster("sayfalar/cezalar/cezalistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/cezalar/cezaListele", "BAŞARISIZ", "EKLEME BAŞARILI", "success"),
                            "cezalar" => $this->model->listele("cezalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("cezalar"),
                            "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
                            ));

                    else:

                        $this->View->goster("sayfalar/cezalar/cezalistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/cezalar/cezaListele", "BAŞARISIZ", "EKLEME İŞLEMİNDE HATA OLUŞTU", "warning"),
                            "cezalar" => $this->model->listele("cezalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("cezalar"),
                            "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
                        ));

                    endif;

                endif;

            else:

                $this->View->goster("sayfalar/cezalar/toplucezaislemleri",
                    [ "topluFirmaEkleme" => true ]
                );

            endif;

        }

    }

?>