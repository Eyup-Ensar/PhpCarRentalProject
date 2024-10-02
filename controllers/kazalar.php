<?php 

    class kazalar extends Controller {

        function __construct () {

            parent:: libsInclude(array("View", "Form", "Bilgi", "Pagination", "DosyaCikti", "Session", "DosyaIslemleri", "Upload"));

            @Session::init();

            @$this->ModelYukle("kaza");

            if(!Session::get("adminAd") || !Session::get("adminId")): 
 
                $this->giris();

                exit();

            endif;

        }

        function giris () {

            if(Session::get("adminAd") && Session::get("adminId")): 

                $this->Bilgi->direktYonlen("/kazalar/kazaListele");

            else:

                $this->View->goster("sayfalar/index");

            endif;
            
        }

        function kazaListele($mevcutsayfa=false) {  

            $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
            $this->Pagination->paginationOlustur($this->model->sayfalama("kazalar"), $mevcutsayfa, $adet[0][0]);
            
            $this->View->goster("sayfalar/kazalar/kazalistele", array(
                "kazalar" => $this->model->listele("kazalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                "toplamsayfa" => $this->Pagination->toplamsayfa,
                "toplamveri" => $this->model->sayfalama("kazalar"),
                "araclar" => $this->model->gelismisArama("id, plaka", "arabalar"),
                "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
            ));

        }

        function kazaEkle() {

            $this->View->goster("sayfalar/kazalar/kazaekle", array(
                "araclar" => $this->model->gelismisArama("plaka", "arabalar"),
                "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
            ));
            
        }

        function kazaEkleSon ($mevcutsayfa=false) {

            if($_POST):

                $arac_id = $this->Form->get("arac_id")->bosmu();

                $surucu_id = $this->Form->get("surucu_id")->bosmu();

                $kaza_tarihi = $this->Form->get("kaza_tarihi")->bosmu();

                $servis_adi = $this->Form->get("servis_adi")->bosmu();

                $aciklama = $this->Form->get("aciklama")->bosmu();

                $this->Upload->dosyaEkle("kazafoto");

                $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
                $this->Pagination->paginationOlustur($this->model->sayfalama("kazalar"), $mevcutsayfa, $adet[0][0]);

                if (!empty($this->Form->error)) :
                    
                    $this->View->goster("sayfalar/kazalar/kazalistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/kazalar/kazaListele", "BAŞARISIZ", "BOŞ ALAN BIRAKILAMAZ", "warning"),
                        "kazalar" => $this->model->listele("kazalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                        "toplamsayfa" => $this->Pagination->toplamsayfa,
                        "toplamveri" => $this->model->sayfalama("kazalar"),
                        "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
                    ));
                    
                else:

                    if (!empty($this->Upload->error)) :

                        $this->View->goster("sayfalar/kazalar/kazalistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/kazalar/kazaListele", "BAŞARISIZ", "RESİM YÜKLEME SIRASINDA HATA OLUŞTU!", "warning"),
                            "kazalar" => $this->model->listele("kazalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("kazalar"),
                            "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
                        ));
    
                    else:   

                        $fotos = "";

                        $res = $this->Upload->yukle();

                        foreach ($res as $key => $value) :

                            $fotos .= $value.",";

                        endforeach;

                        $fotos = rtrim($fotos, ",");

                        $sonuc = $this->model->ekle("kazalar", array("arac_id", "resim", "surucu_id", "kaza_tarihi", "servis_adi", "aciklama"), array($arac_id, $fotos, $surucu_id, $kaza_tarihi, $servis_adi, $aciklama));

                        if($sonuc):

                            $this->View->goster("sayfalar/kazalar/kazalistele", array(
                                "bilgi" => $this->Bilgi->sweetAlert(URL."/kazalar/kazaListele", "BAŞARILI", "EKLEME BAŞARILI", "success"),
                                "kazalar" => $this->model->listele("kazalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                                "toplamsayfa" => $this->Pagination->toplamsayfa,
                                "toplamveri" => $this->model->sayfalama("kazalar"),
                                "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
                            ));

                        else:

                            $this->View->goster("sayfalar/kazalar/kazalistele", array(
                                "bilgi" => $this->Bilgi->sweetAlert(URL."/kazalar/kazaListele", "BAŞARISIZ", "EKLEME SIRASINDA HATA OLUŞTU", "warning"),
                                "kazalar" => $this->model->listele("kazalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                                "toplamsayfa" => $this->Pagination->toplamsayfa,
                                "toplamveri" => $this->model->sayfalama("kazalar"),
                                "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
                            ));

                        endif;

                    endif;
                    
                endif;
                
            else:

                $this->Bilgi->direktYonlen("/kazalar/kazaListele");
                
            endif;

        }

        function kazaGuncelle($id) {

            $this->View->goster("sayfalar/kazalar/kazaguncelle", array(
                'kaza' => $this->model->listele("kazalar", "where id=".$id),
                "araclar" => $this->model->gelismisArama("plaka", "arabalar"),
                "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
            ));

        }
        
        function kazaGuncelleSon ($mevcutsayfa=false) {

            if($_POST):

                $id = $this->Form->get("id")->bosmu();

                $arac_id = $this->Form->get("arac_id")->bosmu();

                $surucu_id = $this->Form->get("surucu_id")->bosmu();

                $kaza_tarihi = $this->Form->get("kaza_tarihi")->bosmu();

                $servis_adi = $this->Form->get("servis_adi")->bosmu();

                $aciklama = $this->Form->get("aciklama")->bosmu();
                
                $dosya_adlari = $this->Form->get("resimdosyaadlari")->bosmu();
                
                $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
                $this->Pagination->paginationOlustur($this->model->sayfalama("kazalar"), $mevcutsayfa, $adet[0][0]);

                if (!empty($this->Form->error)) :
                
                    $this->View->goster("sayfalar/kazalar/kazalistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/kazalar/kazaListele", "BAŞARISIZ", "BOŞ ALAN BIRAKILAMAZ", "warning"),
                        "kazalar" => $this->model->listele("kazalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                        "toplamsayfa" => $this->Pagination->toplamsayfa,
                        "toplamveri" => $this->model->sayfalama("kazalar"),
                        "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
                    ));

                else:

                    $resimadlari = $this->Upload->dosyaGuncelle("kazafoto", $dosya_adlari);

                    $resim = "";

                    foreach ($resimadlari as $value) :

                        $resim .= $value.",";

                    endforeach;

                    $resim = rtrim($resim, ",");

                    if (!empty($this->Upload->error)) :

                        $this->View->goster("sayfalar/kazalar/kazalistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/kazalar/kazaListele", "BAŞARISIZ", "RESİM YÜKLEME SIRASINDA HATA OLUŞTU!", "warning"),
                            "kazalar" => $this->model->listele("kazalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("kazalar"),
                            "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
                        ));
    
                    else:   

                        $sonuc = $this->model->guncelle("kazalar", array("arac_id", "resim", "surucu_id", "kaza_tarihi", "servis_adi", "aciklama"), array($arac_id, $resim, $surucu_id, $kaza_tarihi, $servis_adi, $aciklama), "id=".$id);

                        if($sonuc):

                            $this->View->goster("sayfalar/kazalar/kazalistele", array(
                                "bilgi" => $this->Bilgi->sweetAlert(URL."/kazalar/kazaListele", "BAŞARILI", "GÜNCELLEME BAŞARILI", "success"),
                                "kazalar" => $this->model->listele("kazalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                                "toplamsayfa" => $this->Pagination->toplamsayfa,
                                "toplamveri" => $this->model->sayfalama("kazalar"),
                                "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
                            ));

                        else:

                            $this->View->goster("sayfalar/kazalar/kazalistele", array(
                                "bilgi" => $this->Bilgi->sweetAlert(URL."/kazalar/kazaListele", "BAŞARISIZ", "GÜNCELLEME SIRASINDA HATA OLUŞTU", "warning"),
                                "kazalar" => $this->model->listele("kazalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                                "toplamsayfa" => $this->Pagination->toplamsayfa,
                                "toplamveri" => $this->model->sayfalama("kazalar"),
                                "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
                            ));

                        endif;

                    endif;
                
                endif;
                
            else:

                $this->Bilgi->direktYonlen("/kazalar/kazaListele");
                
            endif;

        }

        function kazaSil ($id, $mevcutsayfa=false) {
            
            $resimler = $this->model->gelismisArama("resim", "kazalar", "where id=".$id);

            $sonuc = $this->model->sil("kazalar", "id=".$id);

            $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
            $this->Pagination->paginationOlustur($this->model->sayfalama("kazalar"), $mevcutsayfa, $adet[0][0]);

            if ($sonuc):

                $this->Upload->dosyaSil($resimler[0][0]);
            
                $this->View->goster("sayfalar/kazalar/kazalistele", array(
                    "bilgi" => $this->Bilgi->sweetAlert(URL."/kazalar/kazaListele", "BAŞARILI", "SİLME İŞLEMİ BAŞARILI", "success"),
                    "kazalar" => $this->model->listele("kazalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                    "toplamsayfa" => $this->Pagination->toplamsayfa,
                    "toplamveri" => $this->model->sayfalama("kazalar"),
                    "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
                ));
            
            else:

                $this->View->goster("sayfalar/kazalar/kazalistele", array(
                    "bilgi" => $this->Bilgi->sweetAlert(URL."/kazalar/kazaListele", "BAŞARISIZ", "SİLME SIRASINDA HATA OLUŞTU", "warning"),
                    "kazalar" => $this->model->listele("kazalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                    "toplamsayfa" => $this->Pagination->toplamsayfa,
                    "toplamveri" => $this->model->sayfalama("kazalar"),
                    "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
                ));

            endif;

        }

        function kazaArama ($tercih=false, $kelime=false, $mevcutsayfa=false) {

            if($_POST || isset($kelime)):

                $tercihKontrol = "";

                $tarih1 = "";

                $tarih2 = "";

                $ara = "";

                $searchVal = "";

                $link = "";

                if($_POST):

                    $aramatercih = $this->Form->get("aramatercih")->bosmu();

                    if($aramatercih=="kaza_tarihi") {
                        
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

                    $this->View->goster("sayfalar/kazalar/kazalistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/kazalar/kazaListele", "BAŞARISIZ", "ARAMA KISMI BOŞ BIRAKILAMAZ", "warning"),
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

                    $columnNames = ["arac_id", "surucu_id", "kaza_tarihi", "servis_adi", "aciklama"];

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

                    $bilgicek = $this->model->arama("Kazalar", $sorgu);

                    if(isset($bilgicek[0]["id"])):

                        $this->Pagination->paginationOlustur($this->model->sayfalama("Kazalar", $sorgu), $mevcutsayfa, $adet[0][0]);

                        $this->View->goster("sayfalar/kazalar/kazalistele", array(
                            "kazalar" => $this->model->listele("Kazalar", $sorgu." LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("Kazalar", $sorgu),
                            "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer"),
                            "kazaarama" => $link,
                            "aramatercih" => $aramatercih,
                            "sorgu" => $sorgu
                        ));

                    else:
                        
                        $this->View->goster("sayfalar/kazalar/kazalistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/kazalar/kazaListele", "BAŞARISIZ", "HİÇ BİR BİLGİ İLE UYUŞMADI", "warning"),
                        ));

                    endif;

                endif;

            else:

                $this->bilgi->direktYonlen("/kazalar/kazaListele");
                
            endif;
            
        }

        function kazaSirala($kriter=false, $tercih=false, $mevcutsayfa=false) {

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

                    $this->View->goster("sayfalar/kazalar/kazalistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/kazalar/kazaListele", "BAŞARISIZ", "ARAMA KISMI BOŞ BIRAKILAMAZ", "warning"),
                    ));

                else:

                    $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);

                    $this->Pagination->paginationOlustur($this->model->sayfalama("kazalar"), $mevcutsayfa, $adet[0][0]);

                    if($siralamaTercih=="a-z"):

                        $this->View->goster("sayfalar/kazalar/kazalistele", array(
                            "kazalar" => $this->model->listele("kazalar", " ORDER BY ".$siralamaKriteri." ASC LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("kazalar"),
                            "siralamakriteri" => $siralamaKriteri,
                            "siralamatercih" => $siralamaTercih,
                            "sorgu" => " ORDER BY ".$siralamaKriteri." ASC",
                            "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
                        ));

                    else:

                        $this->View->goster("sayfalar/kazalar/kazalistele", array(
                            "kazalar" => $this->model->listele("kazalar", " ORDER BY ".$siralamaKriteri." DESC LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("kazalar"),
                            "siralamakriteri" => $siralamaKriteri,
                            "siralamatercih" => $siralamaTercih,
                            "sorgu" => " ORDER BY ".$siralamaKriteri." DESC",
                            "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
                        ));

                    endif;

                endif;
                
            else:

                $this->Bilgi->direktYonlen("/kazalar/kazaListele");

            endif;

        }

        function kazalarExcelAl ($sorgu=false) {

            $degerler = $this->model->listele("kazalar", Session::get("excelkazasorgu"));

            $icerikler = [];

            foreach ($degerler as $key => $deger) :
                
                $suruculer = $this->model->gelismisArama("ad, soyad", "suruculer", "where id = ".$deger["surucu_id"]);

                $icerikler[] = array($deger["arac_id"], isset($suruculer[0][0]) ? $suruculer[0][0]." ".$suruculer[0][1] : "Sürücü bulunamadı!", $deger["kaza_tarihi"], $deger["servis_adi"], $deger["aciklama"]);
            
            endforeach;

            $this->DosyaCikti->excelAl("Trafik kazaları", array("Araç", "Sürücü", "Kaza Tarihi", "Servis Adı", "Açıklama"), $icerikler);

            Session::unset("excelkazasorgu");
            
        }
        
        function topluKazalarEkle ($son = false, $mevcutsayfa=false) {

            if($son):

                $sorgum = $this->DosyaIslemleri->jsonVerileriAyikla("dosya");

                $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
                $this->Pagination->paginationOlustur($this->model->sayfalama("kazalar"), $mevcutsayfa, $adet[0][0]);

                if(!empty($this->DosyaIslemleri->error)) :
                    
                    $this->View->goster("sayfalar/kazalar/kazalistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/kazalar/kazaListele", "BAŞARISIZ", "JSON DOSYASI AÇILAMADI", "warning"),
                        "kazalar" => $this->model->listele("kazalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                        "toplamsayfa" => $this->Pagination->toplamsayfa,
                        "toplamveri" => $this->model->sayfalama("kazalar"),
                        "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
                    ));

                else:

                    $sonuc = $this->model->topluEkle(
                        "kazalar",
                        array("arac_id", "surucu_id", "kaza_tarihi", "teblig_tarihi", "son_odeme_tarihi", "aciklama", "durum", "kaza_tutari"),
                        $sorgum
                    );

                    if($sonuc):

                        $this->View->goster("sayfalar/kazalar/kazalistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/kazalar/kazaListele", "BAŞARISIZ", "EKLEME BAŞARILI", "success"),
                            "kazalar" => $this->model->listele("kazalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("kazalar"),
                            "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
                        ));

                    else:

                        $this->View->goster("sayfalar/kazalar/kazalistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/kazalar/kazaListele", "BAŞARISIZ", "EKLEME İŞLEMİNDE HATA OLUŞTU", "warning"),
                            "kazalar" => $this->model->listele("kazalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("kazalar"),
                        ));

                    endif;

                endif;

            else:

                $this->View->goster("sayfalar/kazalar/toplukazaislemleri",
                    [ "topluKazaEkleme" => true ]
                );

            endif;

        }

    }

?>