<?php 

    class yakitlar extends Controller {

        function __construct () {

            parent:: libsInclude(array("View", "Form", "Bilgi", "Pagination", "DosyaCikti", "Session", "DosyaIslemleri"));

            @Session::init();

            @$this->ModelYukle("yakit");

            if(!Session::get("adminAd") || !Session::get("adminId")): 
 
                $this->giris();

                exit();

            endif;

        }

        function giris () {

            if(Session::get("adminAd") && Session::get("adminId")): 

                $this->Bilgi->direktYonlen("/yakitlar/yakitListele");

            else:

                $this->View->goster("sayfalar/index");

            endif;
            
        }

        function yakitListele($mevcutsayfa=false) {  

            $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
            $this->Pagination->paginationOlustur($this->model->sayfalama("yakitlar"), $mevcutsayfa, $adet[0][0]);
            
            $this->View->goster("sayfalar/yakitlar/yakitlistele", array(
                "yakitlar" => $this->model->listele("yakitlar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                "toplamsayfa" => $this->Pagination->toplamsayfa,
                "toplamveri" => $this->model->sayfalama("yakitlar"),
                "sorgu" => "",
                "araclar" => $this->model->gelismisArama("id, plaka", "arabalar"),
                "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
            ));

        }

        function yakitEkle() {

            $this->View->goster("sayfalar/yakitlar/yakitekle", array(
                "araclar" => $this->model->gelismisArama("plaka", "arabalar"),
                "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
            ));
            
        }

        function yakitEkleSon ($mevcutsayfa=false) {

            if($_POST):

                $arac_id = $this->Form->get("arac_id")->bosmu();

                $surucu_id = $this->Form->get("surucu_id")->bosmu();

                $istasyon = $this->Form->get("istasyon")->bosmu();

                $fatura_tarihi = $this->Form->get("fatura_tarihi")->bosmu();

                $yakit_alim_km = $this->Form->get("yakit_alim_km")->bosmu();

                $birim_fiyat = $this->Form->get("birim_fiyat")->bosmu();

                $miktar = $this->Form->get("miktar")->bosmu();

                $iskonto = $this->Form->get("iskonto")->bosmu();

                $toplam_tutar = $this->Form->get("toplam_tutar")->bosmu();

                $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
                $this->Pagination->paginationOlustur($this->model->sayfalama("yakitlar"), $mevcutsayfa, $adet[0][0]);

                if (!empty($this->Form->error)) :
                    
                    $this->View->goster("sayfalar/yakitlar/yakitlistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/yakitlar/yakitListele", "BAŞARISIZ", "BOŞ ALAN BIRAKILAMAZ", "warning"),
                        "yakitlar" => $this->model->listele("yakitlar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                        "toplamsayfa" => $this->Pagination->toplamsayfa,
                        "toplamveri" => $this->model->sayfalama("yakitlar"),
                        "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
                    ));
                    
                else:

                    $sonuc = $this->model->ekle("yakitlar", array("arac_id", "surucu_id", "istasyon", "fatura_tarihi", "yakit_alim_km", "birim_fiyat", "miktar", "iskonto", "toplam_tutar"), array($arac_id, $surucu_id, $istasyon, $fatura_tarihi, $yakit_alim_km, $birim_fiyat, $miktar, $iskonto, $toplam_tutar));

                    if($sonuc):
                        
                        $this->View->goster("sayfalar/yakitlar/yakitlistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/yakitlar/yakitListele", "BAŞARILI", "EKLEME BAŞARILI", "success"),
                            "yakitlar" => $this->model->listele("yakitlar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("yakitlar"),
                            "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
                        ));

                    else:

                        $this->View->goster("sayfalar/yakitlar/yakitlistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/yakitlar/yakitListele", "BAŞARISIZ", "EKLEME SIRASINDA HATA OLUŞTU", "warning"),
                            "yakitlar" => $this->model->listele("yakitlar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("yakitlar"),
                            "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
                        ));

                    endif;
                
                endif;
                
            else:

                $this->Bilgi->direktYonlen("/yakitlar/yakitListele");
                
            endif;

        }

        function yakitGuncelle($id) {

            $this->View->goster("sayfalar/yakitlar/yakitguncelle", array(
                'yakit' => $this->model->listele("yakitlar", "where id=".$id),
                "araclar" => $this->model->gelismisArama("plaka", "arabalar"),
                "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
            ));

        }
        
        function yakitGuncelleSon ($mevcutsayfa=false) {

            if($_POST):

                $id = $this->Form->get("id")->bosmu();

                $arac_id = $this->Form->get("arac_id")->bosmu();

                $surucu_id = $this->Form->get("surucu_id")->bosmu();

                $istasyon = $this->Form->get("istasyon")->bosmu();

                $fatura_tarihi = $this->Form->get("fatura_tarihi")->bosmu();

                $yakit_alim_km = $this->Form->get("yakit_alim_km")->bosmu();

                $birim_fiyat = $this->Form->get("birim_fiyat")->bosmu();

                $miktar = $this->Form->get("miktar")->bosmu();

                $iskonto = $this->Form->get("iskonto")->bosmu();

                $toplam_tutar = $this->Form->get("toplam_tutar")->bosmu();

                $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
                $this->Pagination->paginationOlustur($this->model->sayfalama("yakitlar"), $mevcutsayfa, $adet[0][0]);

                if (!empty($this->Form->error)) :
                
                    $this->View->goster("sayfalar/yakitlar/yakitlistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/yakitlar/yakitListele", "BAŞARISIZ", "BOŞ ALAN BIRAKILAMAZ", "warning"),
                        "yakitlar" => $this->model->listele("yakitlar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                        "toplamsayfa" => $this->Pagination->toplamsayfa,
                        "toplamveri" => $this->model->sayfalama("yakitlar"),
                        "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
                    ));

                else:

                    $sonuc = $this->model->guncelle("yakitlar", array("arac_id", "surucu_id", "istasyon", "fatura_tarihi", "yakit_alim_km", "birim_fiyat", "miktar", "iskonto", "toplam_tutar"), array($arac_id, $surucu_id, $istasyon, $fatura_tarihi, $yakit_alim_km, $birim_fiyat, $miktar, $iskonto, $toplam_tutar), "id=".$id);

                    if($sonuc):

                        $this->View->goster("sayfalar/yakitlar/yakitlistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/yakitlar/yakitListele", "BAŞARILI", "GÜNCELLEME BAŞARILI", "success"),
                            "yakitlar" => $this->model->listele("yakitlar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("yakitlar"),
                            "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
                        ));

                    else:

                        $this->View->goster("sayfalar/yakitlar/yakitlistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/yakitlar/yakitListele", "BAŞARISIZ", "GÜNCELLEME SIRASINDA HATA OLUŞTU", "warning"),
                            "yakitlar" => $this->model->listele("yakitlar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("yakitlar"),
                            "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
                        ));

                    endif;
                
                endif;
                
            else:

                $this->Bilgi->direktYonlen("/yakitlar/yakitListele");
                
            endif;

        }

        function yakitSil ($id, $mevcutsayfa=false) {

            $sonuc = $this->model->sil("yakitlar", "id=".$id);

            $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
            $this->Pagination->paginationOlustur($this->model->sayfalama("yakitlar"), $mevcutsayfa, $adet[0][0]);

            if ($sonuc):
            
                $this->View->goster("sayfalar/yakitlar/yakitlistele", array(
                    "bilgi" => $this->Bilgi->sweetAlert(URL."/yakitlar/yakitListele", "BAŞARILI", "SİLME İŞLEMİ BAŞARILI", "success"),
                    "yakitlar" => $this->model->listele("yakitlar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                    "toplamsayfa" => $this->Pagination->toplamsayfa,
                    "toplamveri" => $this->model->sayfalama("yakitlar"),
                "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
                ));
            
            else:

                $this->View->goster("sayfalar/yakitlar/yakitlistele", array(
                    "bilgi" => $this->Bilgi->sweetAlert(URL."/yakitlar/yakitListele", "BAŞARISIZ", "SİLME SIRASINDA HATA OLUŞTU", "warning"),
                    "yakitlar" => $this->model->listele("yakitlar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                    "toplamsayfa" => $this->Pagination->toplamsayfa,
                    "toplamveri" => $this->model->sayfalama("yakitlar"),
                "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
                ));

            endif;

        }

        function yakitArama ($tercih=false, $kelime=false, $mevcutsayfa=false) {

            if($_POST || isset($kelime)):

                $tercihKontrol = "";

                $tarih1 = "";

                $tarih2 = "";

                $ara = "";

                $searchVal = "";

                $link = "";

                if($_POST):

                    $aramatercih = $this->Form->get("aramatercih")->bosmu();

                    if($aramatercih=="fatura_tarihi") {
                        
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

                    $this->View->goster("sayfalar/yakitlar/yakitlistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/yakitlar/yakitListele", "BAŞARISIZ", "ARAMA KISMI BOŞ BIRAKILAMAZ", "warning"),
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

                    $columnNames = ["arac_id", "surucu_id", "istasyon", "fatura_tarihi", "yakit_alim_km", "birim_fiyat", "miktar", "iskonto", "toplam_tutar"];

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

                    $bilgicek = $this->model->arama("yakitlar", $sorgu);

                    if(isset($bilgicek[0]["id"])):

                        $this->Pagination->paginationOlustur($this->model->sayfalama("yakitlar", $sorgu), $mevcutsayfa, $adet[0][0]);

                        $this->View->goster("sayfalar/yakitlar/yakitlistele", array(
                            "yakitlar" => $this->model->listele("yakitlar", $sorgu." LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("yakitlar", $sorgu),
                            "yakitarama" => $link,
                            "aramatercih" => $aramatercih,
                            "sorgu" => $sorgu,
                            "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
                        ));

                    else:
                        
                        $this->View->goster("sayfalar/yakitlar/yakitlistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/yakitlar/yakitListele", "BAŞARISIZ", "HİÇ BİR BİLGİ İLE UYUŞMADI", "warning"),
                        ));

                    endif;

                endif;

            else:

                $this->bilgi->direktYonlen("/yakitlar/yakitListele");
                
            endif;
            
        }

        function yakitSirala($kriter=false, $tercih=false, $mevcutsayfa=false) {

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

                    $this->View->goster("sayfalar/yakitlar/yakitlistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/yakitlar/yakitListele", "BAŞARISIZ", "ARAMA KISMI BOŞ BIRAKILAMAZ", "warning"),
                    ));

                else:

                    $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);

                    $this->Pagination->paginationOlustur($this->model->sayfalama("yakitlar"), $mevcutsayfa, $adet[0][0]);

                    if($siralamaTercih=="a-z"):

                        $this->View->goster("sayfalar/yakitlar/yakitlistele", array(
                            "yakitlar" => $this->model->listele("yakitlar", " ORDER BY ".$siralamaKriteri." ASC LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("yakitlar"),
                            "siralamakriteri" => $siralamaKriteri,
                            "siralamatercih" => $siralamaTercih,
                            "sorgu" => " ORDER BY ".$siralamaKriteri." ASC",
                            "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
                        ));

                    else:

                        $this->View->goster("sayfalar/yakitlar/yakitlistele", array(
                            "yakitlar" => $this->model->listele("yakitlar", " ORDER BY ".$siralamaKriteri." DESC LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("yakitlar"),
                            "siralamakriteri" => $siralamaKriteri,
                            "siralamatercih" => $siralamaTercih,
                            "sorgu" => " ORDER BY ".$siralamaKriteri." DESC",
                            "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
                        ));

                    endif;

                endif;
                
            else:

                $this->Bilgi->direktYonlen("/yakitlar/yakitListele");

            endif;

        }

        function yakitlarExcelAl ($sorgu=false) {

            $degerler = $this->model->listele("yakitlar", Session::get("excelyakitsorgu"));

            $icerikler = [];

            foreach ($degerler as $key => $deger) :

                                
                $suruculer = $this->model->gelismisArama("ad, soyad", "suruculer", "where id = ".$deger["surucu_id"]);

                $icerikler[] = array($deger["arac_id"], isset($suruculer[0][0]) ? $suruculer[0][0]." ".$suruculer[0][1] : "Sürücü bulunamadı!", $deger["istasyon"], $deger["fatura_tarihi"], $deger["yakit_alim_km"], $deger["birim_fiyat"], $deger["miktar"], $deger["iskonto"], $deger["toplam_tutar"]);
            
            endforeach;

            $this->DosyaCikti->excelAl("Yakıt Kayıtları", array("Araç", "Sürücü", "İstason", "Fatura Tarihi", "Yakıt Alım KM", "Birim Fiyat", "Miktar", "İskonto", "Toplam Tutar"), $icerikler);

            Session::unset("excelyakitsorgu");
            
        }
        
        function topluYakitEkle ($son = false, $mevcutsayfa=false) {

            if($son):

                $sorgum = $this->DosyaIslemleri->jsonVerileriAyikla("dosya");

                $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
                $this->Pagination->paginationOlustur($this->model->sayfalama("yakitlar"), $mevcutsayfa, $adet[0][0]);

                if(!empty($this->DosyaIslemleri->error)) :
                    
                    $this->View->goster("sayfalar/yakitlar/yakitlistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/yakitlar/yakitListele", "BAŞARISIZ", "JSON DOSYASI AÇILAMADI", "warning"),
                        "yakitlar" => $this->model->listele("yakitlar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                        "toplamsayfa" => $this->Pagination->toplamsayfa,
                        "toplamveri" => $this->model->sayfalama("yakitlar"),
                        "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
                    ));

                else:

                    $sonuc = $this->model->topluEkle(
                        "yakitlar",
                        array("arac_id", "surucu_id", "istasyon", "fatura_tarihi", "yakit_alim_km", "birim_fiyat", "miktar", "iskonto", "toplam_tutar"),
                        $sorgum
                    );

                    if($sonuc):

                        $this->View->goster("sayfalar/yakitlar/yakitlistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/yakitlar/yakitListele", "BAŞARISIZ", "EKLEME BAŞARILI", "success"),
                            "yakitlar" => $this->model->listele("yakitlar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("yakitlar"),
                            "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
                            ));

                    else:

                        $this->View->goster("sayfalar/yakitlar/yakitlistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/yakitlar/yakitListele", "BAŞARISIZ", "EKLEME İŞLEMİNDE HATA OLUŞTU", "warning"),
                            "yakitlar" => $this->model->listele("yakitlar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("yakitlar"),
                            "suruculer" => $this->model->gelismisArama("id, ad, soyad", "suruculer")
                        ));

                    endif;

                endif;

            else:

                $this->View->goster("sayfalar/yakitlar/topluyakitislemleri",
                    [ "topluFirmaEkleme" => true ]
                );

            endif;

        }

    }

?>