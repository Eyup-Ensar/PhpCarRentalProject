<?php 

    class araclar extends Controller {

        function __construct () {

            parent:: libsInclude(array("View", "Form", "Bilgi", "Pagination", "DosyaCikti", "Session", "DosyaIslemleri", "Upload"));

            Session::init();

            @$this->ModelYukle("arac");

            if(!Session::get("adminAd") || !Session::get("adminId")): 

                $this->giris();

                exit();

            endif;

        }

        function giris () {

            if(Session::get("adminAd") && Session::get("adminId")): 

                $this->Bilgi->direktYonlen("/araclar/aracListele");

            else:

                $this->View->goster("sayfalar/index");

            endif;
            
        }

        function aracListele($mevcutsayfa=false) {

            $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
            $this->Pagination->paginationOlustur($this->model->sayfalama("arabalar"), $mevcutsayfa, $adet[0][0]);

            $this->View->goster("sayfalar/araclar/araclistele", array(
                "araclar" => $this->model->aracListele("arabalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                "aracdurum" => $this->model->gelismisArama("arac_id", "kiralar"),
                "sigortalar" => $this->model->gelismisArama("arac_id, sigorta_turu, baslangic_tarihi, bitis_tarihi", "sigortalar"),
                "toplamsayfa" => $this->Pagination->toplamsayfa,
                "toplamveri" => $this->model->sayfalama("arabalar"),
                "sorgu" => $this->model->aracListele("arabalar")
            ));

        }

        function aracEkle() {

            $this->View->goster("sayfalar/araclar/aracekle");

        }

        function aracEkleSon ($mevcutsayfa=false) {

            if($_POST):

                $marka = $this->Form->get("marka")->bosmu();

                $model = $this->Form->get("model")->bosmu();

                $plaka = $this->Form->get("plaka")->bosmu();

                $durum = "Boşta";

                $sayac = 0;

                $kilometre = $this->Form->get("kilometre")->bosmu();

                $yakit_tipi = $this->Form->get("yakit_tipi")->bosmu();

                $sanziman = $this->Form->get("sanziman")->bosmu();

                $yil = $this->Form->get("yil")->bosmu();

                $renk = $this->Form->get("renk")->bosmu();

                $bakim = $this->Form->get("bakim")->bosmu();

                $muayene_tarihi = $this->Form->get("muayene_tarihi")->bosmu();

                $sigorta_bas = $this->Form->get("sigorta_bas")->bosmu();

                $sigorta_bit = $this->Form->get("sigorta_bit")->bosmu();

                $kasko_bas = $this->Form->get("kasko_bas")->bosmu();

                $kasko_bit = $this->Form->get("kasko_bit")->bosmu();

                $km_tarihi = $this->Form->get("km_tarihi")->bosmu();

                $sase_no = $this->Form->get("sase_no")->bosmu();

                $kullanici = $this->Form->get("kullanici")->bosmu();

                $telefon = $this->Form->get("telefon")->bosmu();

                $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
                $this->Pagination->paginationOlustur($this->model->sayfalama("arabalar"), $mevcutsayfa, $adet[0][0]);
                $palakalar = $this->model->gelismisArama("plaka", "arabalar");

                if (!empty($this->Form->error)) :

                    $this->View->goster("sayfalar/araclar/araclistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/araclar/aracListele", "BAŞARISIZ", "BOŞ ALAN BIRAKILAMAZ", "warning"),
                        "araclar" => $this->model->aracListele("arabalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                        "sigortalar" => $this->model->gelismisArama("arac_id, sigorta_turu, baslangic_tarihi, bitis_tarihi", "sigortalar"),
                        "aracdurum" => $this->model->gelismisArama("arac_id", "kiralar"),
                        "toplamsayfa" => $this->Pagination->toplamsayfa,
                        "toplamveri" => $this->model->sayfalama("arabalar"),
                        "sorgu" => ""
                    ));

                else:

                    foreach ($palakalar as $value) :
                        if($plaka==$value[0]) :
                            $sayac++;
                        endif;
                    endforeach;

                    if($sayac>0) :

                        $this->View->goster("sayfalar/araclar/araclistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/araclar/aracListele", "BAŞARISIZ", "$plaka PLAKALI ARAÇ ZATEN VAR!", "warning"),
                            "araclar" => $this->model->aracListele("arabalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "sigortalar" => $this->model->gelismisArama("arac_id, sigorta_turu, baslangic_tarihi, bitis_tarihi", "sigortalar"),
                            "aracdurum" => $this->model->gelismisArama("arac_id", "kiralar"),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("arabalar"),
                            "sorgu" => ""
                        ));

                    else:

                        $sonuc1 = $this->model->ekle("arabalar", array("marka", "model", "plaka", "durum", "kilometre", "yakit_tipi", "sanziman", "yil", "renk", "bakim", "muayene_tarihi", "km_tarihi", "sase_no", "kullanici", "telefon"), array($marka, $model, $plaka, $durum, $kilometre, $yakit_tipi, $sanziman, $yil, $renk, $bakim, $muayene_tarihi, $km_tarihi, $sase_no, $kullanici, $telefon));
                        
                        $sonuc2 = $this->model->ekle("sigortalar", array("arac_id", "sigorta_turu", "baslangic_tarihi", "bitis_tarihi"), array($plaka, "Trafik Sigortası", $sigorta_bas, $sigorta_bit));
                        
                        $sonuc3 = $this->model->ekle("sigortalar", array("arac_id", "sigorta_turu", "baslangic_tarihi", "bitis_tarihi"), array($plaka, "Kasko Sigortası", $kasko_bas, $kasko_bit));

                        if($sonuc1 && $sonuc2 && $sonuc3):
                            
                            $this->View->goster("sayfalar/araclar/araclistele", array(
                                "bilgi" => $this->Bilgi->sweetAlert(URL."/araclar/aracListele", "BAŞARILI", "EKLEME BAŞARILI", "success"),
                                "araclar" => $this->model->aracListele("arabalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                                "sigortalar" => $this->model->gelismisArama("arac_id, sigorta_turu, baslangic_tarihi, bitis_tarihi", "sigortalar"),
                                "aracdurum" => $this->model->gelismisArama("arac_id", "kiralar"),
                                "toplamsayfa" => $this->Pagination->toplamsayfa,
                                "toplamveri" => $this->model->sayfalama("arabalar"),
                                "sorgu" => ""
                            ));

                        else:

                            $this->View->goster("sayfalar/araclar/araclistele", array(
                                "bilgi" => $this->Bilgi->sweetAlert(URL."/araclar/aracListele", "BAŞARISIZ", "EKLEME SIRASINDA HATA OLUŞTU", "warning"),
                                "araclar" => $this->model->aracListele("arabalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                                "sigortalar" => $this->model->gelismisArama("arac_id, sigorta_turu, baslangic_tarihi, bitis_tarihi", "sigortalar"),
                                "aracdurum" => $this->model->gelismisArama("arac_id", "kiralar"),
                                "toplamsayfa" => $this->Pagination->toplamsayfa,
                                "toplamveri" => $this->model->sayfalama("arabalar"),
                                "sorgu" => ""
                            ));

                        endif;

                    endif;

                endif;
                
            else:

                $this->Bilgi->direktYonlen("/araclar/aracListele");
                
            endif;

        }

        function aracGuncelle($id) {

            $plakaAl = $this->model->gelismisArama("plaka", "arabalar", "where id=".$id);

            $this->View->goster("sayfalar/araclar/aracguncelle", array(
                'arac_id' => $this->model->aracListele("arabalar", "where id=".$id),
                'sigorta' => $this->model->gelismisArama("sigorta_turu, baslangic_tarihi, bitis_tarihi", "sigortalar", "where arac_id='".$plakaAl[0][0]."'")
            ));

        }
        
        function aracGuncelleSon ($mevcutsayfa=false) {

            if($_POST):

                $id = $this->Form->get("id")->bosmu();

                $marka = $this->Form->get("marka")->bosmu();

                $model = $this->Form->get("model")->bosmu();

                $plaka = $this->Form->get("plaka")->bosmu();

                $kilometre = $this->Form->get("kilometre")->bosmu();

                $yakit_tipi = $this->Form->get("yakit_tipi")->bosmu();

                $sanziman = $this->Form->get("sanziman")->bosmu();

                $yil = $this->Form->get("yil")->bosmu();

                $renk = $this->Form->get("renk")->bosmu();

                $bakim = $this->Form->get("bakim")->bosmu();

                $muayene_tarihi = $this->Form->get("muayene_tarihi")->bosmu();

                $sigorta_bas = $this->Form->get("sigorta_bas")->bosmu();

                $sigorta_bit = $this->Form->get("sigorta_bit")->bosmu();

                $kasko_bas = $this->Form->get("kasko_bas")->bosmu();

                $kasko_bit = $this->Form->get("kasko_bit")->bosmu();

                $km_tarihi = $this->Form->get("km_tarihi")->bosmu();

                $sase_no = $this->Form->get("sase_no")->bosmu();

                $kullanici = $this->Form->get("kullanici")->bosmu();

                $telefon = $this->Form->get("telefon")->bosmu();

                $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
                $this->Pagination->paginationOlustur($this->model->sayfalama("arabalar"), $mevcutsayfa, $adet[0][0]);

                if (!empty($this->Form->error)) :

                    $this->View->goster("sayfalar/araclar/araclistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/araclar/aracListele", "BAŞARISIZ", "BOŞ ALAN BIRAKILAMAZ", "warning"),
                        "araclar" => $this->model->aracListele("arabalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                        "sigortalar" => $this->model->gelismisArama("arac_id, sigorta_turu, baslangic_tarihi, bitis_tarihi", "sigortalar"),
                        "aracdurum" => $this->model->gelismisArama("arac_id", "kiralar"),
                        "toplamsayfa" => $this->Pagination->toplamsayfa,
                        "toplamveri" => $this->model->sayfalama("arabalar")
                    ));
                    
                else:

                    $sutunlar = array("marka", "model", "plaka", "kilometre", "yakit_tipi", "sanziman", "yil", "renk", "bakim", "muayene_tarihi", "km_tarihi", "sase_no", "kullanici", "telefon");

                    $veriler = array($marka, $model, $plaka, $kilometre, $yakit_tipi, $sanziman, $yil, $renk, $bakim, $muayene_tarihi, $km_tarihi, $sase_no, $kullanici, $telefon);

                    $sonuc = $this->model->guncelle("arabalar", $sutunlar, $veriler, "id=".$id);

                    $idAl1 = $this->model->gelismisArama("id", "sigortalar", "where sigorta_turu='Trafik Sigortası' && arac_id='".$plaka."'");

                    $idAl2 = $this->model->gelismisArama("id", "sigortalar", "where sigorta_turu='Kasko Sigortası' && arac_id='".$plaka."'");

                    $sonuc2 = $this->model->guncelle("sigortalar", array("baslangic_tarihi", "bitis_tarihi"), array($sigorta_bas, $sigorta_bit), "id=".$idAl1[0][0]);
                    
                    $sonuc3 = $this->model->guncelle("sigortalar", array("baslangic_tarihi", "bitis_tarihi"), array($kasko_bas, $kasko_bit), "id=".$idAl2[0][0]);

                    if($sonuc || $sonuc2 || $sonuc3):

                        $this->View->goster("sayfalar/araclar/araclistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/araclar/aracListele", "BAŞARILI", "GÜNCELLEME BAŞARILI", "success"),
                            "araclar" => $this->model->aracListele("arabalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "sigortalar" => $this->model->gelismisArama("arac_id, sigorta_turu, baslangic_tarihi, bitis_tarihi", "sigortalar"),
                            "aracdurum" => $this->model->gelismisArama("arac_id", "kiralar"),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("arabalar")
                        ));
                        
                    else:

                        $this->View->goster("sayfalar/araclar/araclistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/araclar/aracListele", "BAŞARISIZ", "GÜNCELLEME SIRASINDA HATA OLUŞTU", "warning"),
                            "araclar" => $this->model->aracListele("arabalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "sigortalar" => $this->model->gelismisArama("arac_id, sigorta_turu, baslangic_tarihi, bitis_tarihi", "sigortalar"),
                            "aracdurum" => $this->model->gelismisArama("arac_id", "kiralar"),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("arabalar")
                        ));
                        
                    endif;
                    
                
                endif;
                
            else:

                $this->Bilgi->direktYonlen("/araclar/aracListele");
                
            endif;

        }

        function aracSil ($id, $mevcutsayfa=false) {

            $plaka = $this->model->gelismisArama("plaka", "arabalar", "where id=".$id);

            $sonuc = $this->model->sil("arabalar", "id=".$id);

            $sonuc1 = $this->model->sil("sigortalar", "arac_id='".$plaka[0][0]."'");

            print_r($plaka);

            $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
            $this->Pagination->paginationOlustur($this->model->sayfalama("arabalar"), $mevcutsayfa, $adet[0][0]);

            if ($sonuc || $sonuc1):
            
                $this->View->goster("sayfalar/araclar/araclistele", array(
                    "bilgi" => $this->Bilgi->sweetAlert(URL."/araclar/aracListele", "BAŞARILI", "SİLME İŞLEMİ BAŞARILI", "success"),
                    "araclar" => $this->model->aracListele("arabalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                    "sigortalar" => $this->model->gelismisArama("arac_id, sigorta_turu, baslangic_tarihi, bitis_tarihi", "sigortalar"),
                    "aracdurum" => $this->model->gelismisArama("arac_id", "kiralar"),
                    "toplamsayfa" => $this->Pagination->toplamsayfa,
                    "toplamveri" => $this->model->sayfalama("arabalar")
                ));

            else:

                $this->View->goster("sayfalar/araclar/araclistele", array(
                    "bilgi" => $this->Bilgi->sweetAlert(URL."/araclar/aracListele", "BAŞARISIZ", "SİLME SIRASINDA HATA OLUŞTU", "warning"),
                    "araclar" => $this->model->aracListele("arabalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                    "sigortalar" => $this->model->gelismisArama("arac_id, sigorta_turu, baslangic_tarihi, bitis_tarihi", "sigortalar"),
                    "aracdurum" => $this->model->gelismisArama("arac_id", "kiralar"),
                    "toplamsayfa" => $this->Pagination->toplamsayfa,
                    "toplamveri" => $this->model->sayfalama("arabalar")
                ));

            endif;

        }

        function aracArama ($tercih=false, $kelime=false, $mevcutsayfa=false) {

            if($_POST || isset($kelime)):

                $tercihKontrol = "";

                $tarih1 = "";

                $tarih2 = "";

                $ara = "";

                $searchVal = "";

                $link = "";

                if($_POST):

                    $aramatercih = $this->Form->get("aramatercih")->bosmu();

                    if($aramatercih=="muayene_tarihi"||$aramatercih=="sigorta_bas_tarihi"||$aramatercih=="sigorta_bit_tarihi"||$aramatercih=="kasko_bas_tarihi"||$aramatercih=="kasko_bit_tarihi"||$aramatercih=="km_tarihi") {
                        
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

                    $this->View->goster("sayfalar/araclar/araclistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/araclar/aracListele", "BAŞARISIZ", "ARAMA KISMI BOŞ BIRAKILAMAZ", "warning"),
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

                    $sorgu;

                    $sorgu2 = "";

                    $sigortakontrol = false;

                    $columnNames = ["plaka","marka", "model","yakit_tipi","sanziman","durum","kilometre","bakim","gelecek_bakim_km","yil","renk","muayene_tarihi",
                    "km_tarihi","sase_no","kullanici","telefon"];

                    switch ($aramatercih): 
                        case "sigorta_bas_tarihi":
                            $sigortakontrol=true;
                            $sorgu2 = "WHERE A.plaka = S.arac_id && sigorta_turu='Trafik Sigortası' && S.baslangic_tarihi BETWEEN ".$searchVal;
                            $this->Pagination->paginationOlustur($this->model->gelismisArama("COUNT(A.plaka) as toplam", "arabalar as A, sigortalar as S", $sorgu2)[0][0], $mevcutsayfa, $adet[0][0]);
                            $sorgu = $this->model->gelismisArama("A.*", "arabalar as A, sigortalar as S", $sorgu2." LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet);
                            break;
                        case "sigorta_bit_tarihi":
                            $sigortakontrol=true;
                            $sorgu2 = "WHERE A.plaka = S.arac_id && sigorta_turu='Trafik Sigortası' && S.bitis_tarihi BETWEEN ".$searchVal;
                            $this->Pagination->paginationOlustur($this->model->gelismisArama("COUNT(A.plaka) as toplam", "arabalar as A, sigortalar as S", $sorgu2)[0][0], $mevcutsayfa, $adet[0][0]);
                            $sorgu = $this->model->gelismisArama("A.*", "arabalar as A, sigortalar as S", $sorgu2." LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet);
                            break;
                        case "kasko_bas_tarihi":
                            $sigortakontrol=true;
                            $sorgu2 = "WHERE A.plaka = S.arac_id && sigorta_turu='Kasko Sigortası' && S.baslangic_tarihi BETWEEN ".$searchVal;
                            $this->Pagination->paginationOlustur($this->model->gelismisArama("COUNT(A.plaka) as toplam", "arabalar as A, sigortalar as S", $sorgu2)[0][0], $mevcutsayfa, $adet[0][0]);
                            $sorgu = $this->model->gelismisArama("A.*", "arabalar as A, sigortalar as S", $sorgu2." LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet);
                            break;
                        case "kasko_bit_tarihi":
                            $sigortakontrol=true;
                            $sorgu2 = "WHERE A.plaka = S.arac_id && sigorta_turu='Kasko Sigortası' && S.bitis_tarihi BETWEEN ".$searchVal;
                            $this->Pagination->paginationOlustur($this->model->gelismisArama("COUNT(A.plaka) as toplam", "arabalar as A, sigortalar as S", $sorgu2)[0][0], $mevcutsayfa, $adet[0][0]);
                            $sorgu = $this->model->gelismisArama("A.*", "arabalar as A, sigortalar as S", $sorgu2." LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet);
                            break;
                        default:
                            foreach ($columnNames as $key => $value) :
                                switch ($aramatercih): 
                                    case $value:
                                        switch ($tercihKontrol) :
                                            case 'normal':
                                                $sorgu2 = "where ".$value." like '%".$searchVal."%'";
                                                $this->Pagination->paginationOlustur($this->model->sayfalama("arabalar", $sorgu2), $mevcutsayfa, $adet[0][0]);
                                                $sorgu = $this->model->aracListele("arabalar", $sorgu2." LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet);
                                                break;
                                            case 'date':
                                                $sorgu2 = "where ".$value." BETWEEN ".$searchVal;
                                                $this->Pagination->paginationOlustur($this->model->sayfalama("arabalar", $sorgu2), $mevcutsayfa, $adet[0][0]);
                                                $sorgu = $this->model->aracListele("arabalar", $sorgu2. " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet);
                                                break;
                                            default:
                                                $sorgu2 = count($dateOrNormal)>=4 ? "where ".$value." BETWEEN ".$searchVal :  "where ".$value." like '%".$searchVal."%'";
                                                $this->Pagination->paginationOlustur($this->model->sayfalama("arabalar", $sorgu2), $mevcutsayfa, $adet[0][0]);
                                                $sorgu = $this->model->aracListele("arabalar", $sorgu2." LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet);
                                                break;
                                        endswitch;
                                        break;
                                endswitch;
                            endforeach;
                            break;
                    endswitch;
                    
                    if(isset($sorgu[0]["id"])):

                        $toplamveri2 = $sigortakontrol ? $this->model->gelismisArama("COUNT(A.plaka) as TOPLAM", "arabalar", $sorgu2) : $this->model->sayfalama("arabalar", $sorgu2);

                        $this->View->goster("sayfalar/araclar/araclistele", array(
                            "araclar" => $sorgu,
                            "sigortalar" => $this->model->gelismisArama("arac_id, sigorta_turu, baslangic_tarihi, bitis_tarihi", "sigortalar"),
                            "aracdurum" => $this->model->gelismisArama("arac_id", "kiralar"),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $toplamveri2,
                            "aracarama" => $link,
                            "aramatercih" => $aramatercih,
                            "sorgu" => $sigortakontrol ? $this->model->gelismisArama("A.*", "arabalar as A, sigortalar as S", $sorgu2) : $this->model->aracListele("arabalar", $sorgu2)
                        ));

                    else:
                        
                        $this->View->goster("sayfalar/araclar/araclistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/araclar/aracListele", "BAŞARISIZ", "HİÇ BİR BİLGİ İLE UYUŞMADI", "warning"),
                        ));

                    endif;

                endif;

            else:

                $this->bilgi->direktYonlen("/araclar/aracListele");
                
            endif;
            
        }

        function aracSirala($kriter=false, $tercih=false, $mevcutsayfa=false) {

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


                $yenidizi = [];

                $gelmeyenler = [];

                if($kosul):

                    $this->View->goster("sayfalar/araclar/araclistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/araclar/aracListele", "BAŞARISIZ", "ARAMA KISMI BOŞ BIRAKILAMAZ", "warning"),
                    ));

                else:

                    $sorgu = "";

                    $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);

                    $this->Pagination->paginationOlustur($this->model->sayfalama("arabalar"), $mevcutsayfa, $adet[0][0]);

                    $distinct = false;

                    if($siralamaTercih=="a-z") :

                        switch ($siralamaKriteri) :
                            case "sigorta_bas_tarihi":
                                $sorgu = "WHERE A.plaka = S.arac_id && S.sigorta_turu='Trafik Sigortası' ORDER BY S.baslangic_tarihi ASC";
                                break;
                            case "sigorta_bit_tarihi":
                                $sorgu = "WHERE A.plaka = S.arac_id && S.sigorta_turu='Trafik Sigortası' ORDER BY S.bitis_tarihi ASC";
                                break;
                            case "kasko_bas_tarihi":
                                $sorgu = "WHERE A.plaka = S.arac_id && S.sigorta_turu='Kasko Sigortası' ORDER BY S.baslangic_tarihi ASC";
                                break;
                            case "kasko_bit_tarihi":
                                $sorgu = "WHERE A.plaka = S.arac_id && S.sigorta_turu='Kasko Sigortası' ORDER BY S.bitis_tarihi ASC";
                                break;
                            default:
                                $distinct = true;
                                $sorgu = "ORDER BY A.".$siralamaKriteri." ASC";
                                break;
                        endswitch;

                    else:

                        switch ($siralamaKriteri) :
                            case "sigorta_bas_tarihi":
                                $sorgu = "WHERE A.plaka = S.arac_id && S.sigorta_turu='Trafik Sigortası' ORDER BY S.baslangic_tarihi DESC";
                                break;
                            case "sigorta_bit_tarihi":
                                $sorgu = "WHERE A.plaka = S.arac_id && S.sigorta_turu='Trafik Sigortası' ORDER BY S.bitis_tarihi DESC";
                                break;
                            case "kasko_bas_tarihi":
                                $sorgu = "WHERE A.plaka = S.arac_id && S.sigorta_turu='Kasko Sigortası' ORDER BY S.baslangic_tarihi DESC";
                                break;
                            case "kasko_bit_tarihi":
                                $sorgu = "WHERE A.plaka = S.arac_id && S.sigorta_turu='Kasko Sigortası' ORDER BY S.bitis_tarihi DESC";
                                break;
                            default:
                                $distinct = true;
                                $sorgu = "ORDER BY A.".$siralamaKriteri;
                                break;
                        endswitch;

                    endif;

                    $sorgu2 = $sorgu." LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet;

                    $this->View->goster("sayfalar/araclar/araclistele", array(
                        "araclar" => $this->model->gelismisArama($distinct ? "DISTINCT A.*" : "A.*", "arabalar as A, sigortalar as S", $sorgu2),
                        "aracdurum" => $this->model->gelismisArama("arac_id", "kiralar"),
                        "toplamsayfa" => $this->Pagination->toplamsayfa,
                        "toplamveri" => $this->model->sayfalama("arabalar"),
                        "siralamakriteri" => $siralamaKriteri,
                        "siralamatercih" => $siralamaTercih,
                        "sorgu" => $this->model->gelismisArama($distinct ? "DISTINCT A.*" : "A.*", "arabalar as A, sigortalar as S", $sorgu),
                        "sigortalar" => $this->model->gelismisArama("arac_id, sigorta_turu, baslangic_tarihi, bitis_tarihi", "sigortalar"),
                    ));

                endif;
                
            else:

                $this->Bilgi->direktYonlen("/araclar/aracListele");

            endif;

        }

        function araclarExcelAl ($sorgu=false) {

            $degerler = Session::get("excelaracsorgu");

            $degerler2 = Session::get("excelaracsigortasorgu");

            $icerikler = [];

            foreach ($degerler as $key => $deger) :

                $tsigortacontrol = $ksigortacontrol = 0;

                $icerikler[] = array($deger["marka"], $deger["model"], $deger["plaka"], $deger["durum"], $deger["kilometre"], $deger["yakit_tipi"], $deger["sanziman"], $deger["yil"], $deger["renk"], $deger["bakim"], date("d.m.Y", strtotime($deger["muayene_tarihi"])));
            
                foreach ($degerler2 as $val) :
                    if($deger["plaka"]==$val[0]) :
                        if($val[1]=="Trafik Sigortası") :
                            array_push($icerikler[$key], date("d.m.Y", strtotime($val[2])));
                            array_push($icerikler[$key], date("d.m.Y", strtotime($val[3])));
                            $tsigortacontrol++;
                        endif;
                    endif;
                endforeach;

                if($tsigortacontrol==0) :
                    array_push($icerikler[$key], "Girilmemiş!");
                    array_push($icerikler[$key], "Girilmemiş!");
                endif;

                foreach ($degerler2 as $val) :
                    if($deger["plaka"]==$val[0]) :
                        if($val[1]=="Kasko Sigortası") :
                            array_push($icerikler[$key], date("d.m.Y", strtotime($val[2])));
                            array_push($icerikler[$key], date("d.m.Y", strtotime($val[3])));
                            $ksigortacontrol++;
                        endif;
                    endif;
                endforeach;

                if($ksigortacontrol==0) :
                    array_push($icerikler[$key], "Girilmemiş!");
                    array_push($icerikler[$key], "Girilmemiş!");
                endif;

                array_push($icerikler[$key], date("d.m.Y", strtotime($deger["km_tarihi"])));
                array_push($icerikler[$key], $deger["sase_no"]);
                array_push($icerikler[$key], $deger["kullanici"]);
                array_push($icerikler[$key], $deger["telefon"]);

            endforeach;

            $this->DosyaCikti->excelAl("Araçlar", array("Marka", "Model", "Plaka", "Durum", "Kilometre", "Yakıt Tipi", "Şanzıman", "Bakıma Girdiği Kilometre", "Araç Yılı", "Araç Rengi", "Muayene Tarihi", "Sigorta Başlangıç Tarihi", "Kasko Başlangıç Tarihi", "Trafik Bitiş Tarihi", "Kasko Bitiş Tarihi", "Kilometre Tarihi", "Şase Numarası", "Kullanıcı", "Telefon"), $icerikler);
            
            Session::unset("excelaracsorgu");

            Session::unset("excelaracsigortasorgu");

        }

        function topluAracEkle ($son = false, $mevcutsayfa=false) {

            if($son):

                $sorgum = $this->DosyaIslemleri->jsonVerileriAyikla("dosya");

                $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
                $this->Pagination->paginationOlustur($this->model->sayfalama("arabalar"), $mevcutsayfa, $adet[0][0]);

                if(!empty($this->DosyaIslemleri->error)) :
                    
                    $this->View->goster("sayfalar/araclar/araclistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/araclar/aracListele", "BAŞARISIZ", "JSON DOSYASI AÇILAMADI", "warning"),
                        "araclar" => $this->model->aracListele("arabalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                        "sigortalar" => $this->model->gelismisArama("arac_id, sigorta_turu, baslangic_tarihi, bitis_tarihi", "sigortalar"),
                        "aracdurum" => $this->model->gelismisArama("arac_id", "kiralar"),
                        "toplamsayfa" => $this->Pagination->toplamsayfa,
                        "toplamveri" => $this->model->sayfalama("arabalar")
                    ));

                else:

                    $sonuc = $this->model->topluEkle(
                        "arabalar",
                        array("marka", "model", "plaka", "durum", "kilometre", "yakit_tipi", "sanziman", "yil", "renk", "bakim", "muayene_tarihi", "km_tarihi", "sase_no", "kullanici", "telefon"),
                        $sorgum
                    );

                    if($sonuc):

                        $this->View->goster("sayfalar/araclar/araclistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/araclar/aracListele", "BAŞARILI", "EKLEME BAŞARILI", "success"),
                            "araclar" => $this->model->aracListele("arabalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "sigortalar" => $this->model->gelismisArama("arac_id, sigorta_turu, baslangic_tarihi, bitis_tarihi", "sigortalar"),
                            "aracdurum" => $this->model->gelismisArama("arac_id", "kiralar"),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("arabalar")
                        ));

                    else:

                        $this->View->goster("sayfalar/araclar/araclistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/araclar/aracListele", "BAŞARISIZ", "EKLEME İŞLEMİNDE HATA OLUŞTU", "warning"),
                            "araclar" => $this->model->aracListele("arabalar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "sigortalar" => $this->model->gelismisArama("arac_id, sigorta_turu, baslangic_tarihi, bitis_tarihi", "sigortalar"),
                            "aracdurum" => $this->model->gelismisArama("arac_id", "kiralar"),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("arabalar")
                        ));

                    endif;

                endif;

            else:

                $this->View->goster("sayfalar/araclar/topluaracislemleri",
                    [ "topluAracEkleme" => true ]
                );

            endif;

        }
    }

?>