<?php 

    class ekspertizkayitlar extends Controller {

        function __construct () {

            parent:: libsInclude(array("View", "Form", "Bilgi", "Pagination", "DosyaCikti", "Session", "DosyaIslemleri"));

            @Session::init();

            @$this->ModelYukle("ekspertizkayit");

            if(!Session::get("adminAd") || !Session::get("adminId")): 
 
                $this->giris();

                exit();

            endif;

        }

        function giris () {

            if(Session::get("adminAd") && Session::get("adminId")): 

                $this->Bilgi->direktYonlen("/ekspertizkayitlar/ekspertizkayitListele");

            else:

                $this->View->goster("sayfalar/index");

            endif;
            
        }

        function ekspertizkayitListele($mevcutsayfa=false) {  

            $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
            $this->Pagination->paginationOlustur($this->model->sayfalama("ekspertizkayitlar"), $mevcutsayfa, $adet[0][0]);
            
            $this->View->goster("sayfalar/ekspertizkayitlar/ekspertizkayitlistele", array(
                "ekspertizkayitlar" => $this->model->listele("ekspertizkayitlar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                "toplamsayfa" => $this->Pagination->toplamsayfa,
                "toplamveri" => $this->model->sayfalama("ekspertizkayitlar"),
                "araclar" => $this->model->gelismisArama("id, plaka", "arabalar"),
                "sorgu" => "",
            
            ));

        }

        function ekspertizkayitEkle() {

            $this->View->goster("sayfalar/ekspertizkayitlar/ekspertizkayitekle", array(
                "araclar" => $this->model->gelismisArama("plaka", "arabalar"),
            ));
            
        }

        function ekspertizkayitEkleSon ($mevcutsayfa=false) {

            if($_POST):

                $arac_id = $this->Form->get("arac_id")->bosmu();

                $ekspertiz_bayi	 = $this->Form->get("ekspertiz_bayi")->bosmu();

                $ekspertiz_tarihi = $this->Form->get("ekspertiz_tarihi")->bosmu();

                $aciklama = $this->Form->get("aciklama")->bosmu();

                $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
                $this->Pagination->paginationOlustur($this->model->sayfalama("ekspertizkayitlar"), $mevcutsayfa, $adet[0][0]);

                if (!empty($this->Form->error)) :
                    
                    $this->View->goster("sayfalar/ekspertizkayitlar/ekspertizkayitlistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/ekspertizkayitlar/ekspertizkayitListele", "BAŞARISIZ", "BOŞ ALAN BIRAKILAMAZ", "warning"),
                        "ekspertizkayitlar" => $this->model->listele("ekspertizkayitlar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                        "toplamsayfa" => $this->Pagination->toplamsayfa,
                        "toplamveri" => $this->model->sayfalama("ekspertizkayitlar"),
                    ));
                    
                else:

                    $sonuc = $this->model->ekle("ekspertizkayitlar", array("arac_id", "ekspertiz_bayi", "ekspertiz_tarihi", "aciklama"), array($arac_id, $ekspertiz_bayi, $ekspertiz_tarihi, $aciklama));

                    if($sonuc):
                        
                        $this->View->goster("sayfalar/ekspertizkayitlar/ekspertizkayitlistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/ekspertizkayitlar/ekspertizkayitListele", "BAŞARILI", "EKLEME BAŞARILI", "success"),
                            "ekspertizkayitlar" => $this->model->listele("ekspertizkayitlar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("ekspertizkayitlar"),
                        ));

                    else:

                        $this->View->goster("sayfalar/ekspertizkayitlar/ekspertizkayitlistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/ekspertizkayitlar/ekspertizkayitListele", "BAŞARISIZ", "EKLEME SIRASINDA HATA OLUŞTU", "warning"),
                            "ekspertizkayitlar" => $this->model->listele("ekspertizkayitlar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("ekspertizkayitlar"),
                        ));

                    endif;
                
                endif;
                
            else:

                $this->Bilgi->direktYonlen("/ekspertizkayitlar/ekspertizkayitListele");
                
            endif;

        }

        function ekspertizkayitGuncelle($id) {

            $this->View->goster("sayfalar/ekspertizkayitlar/ekspertizkayitguncelle", array(
                'ekspertizkayit' => $this->model->listele("ekspertizkayitlar", "where id=".$id),
                "araclar" => $this->model->gelismisArama("plaka", "arabalar"),
            ));

        }
        
        function ekspertizkayitGuncelleSon ($mevcutsayfa=false) {

            if($_POST):

                $id = $this->Form->get("id")->bosmu();

                $arac_id = $this->Form->get("arac_id")->bosmu();

                $ekspertiz_bayi	 = $this->Form->get("ekspertiz_bayi")->bosmu();

                $ekspertiz_tarihi = $this->Form->get("ekspertiz_tarihi")->bosmu();

                $aciklama = $this->Form->get("aciklama")->bosmu();

                $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
                $this->Pagination->paginationOlustur($this->model->sayfalama("ekspertizkayitlar"), $mevcutsayfa, $adet[0][0]);

                if (!empty($this->Form->error)) :
                
                    $this->View->goster("sayfalar/ekspertizkayitlar/ekspertizkayitlistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/ekspertizkayitlar/ekspertizkayitListele", "BAŞARISIZ", "BOŞ ALAN BIRAKILAMAZ", "warning"),
                        "ekspertizkayitlar" => $this->model->listele("ekspertizkayitlar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                        "toplamsayfa" => $this->Pagination->toplamsayfa,
                        "toplamveri" => $this->model->sayfalama("ekspertizkayitlar"),
                    ));

                else:

                    $sonuc = $this->model->guncelle("ekspertizkayitlar", array("arac_id", "ekspertiz_bayi", "ekspertiz_tarihi", "aciklama"), array($arac_id, $ekspertiz_bayi, $ekspertiz_tarihi, $aciklama), "id=".$id);

                    if($sonuc):

                        $this->View->goster("sayfalar/ekspertizkayitlar/ekspertizkayitlistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/ekspertizkayitlar/ekspertizkayitListele", "BAŞARILI", "GÜNCELLEME BAŞARILI", "success"),
                            "ekspertizkayitlar" => $this->model->listele("ekspertizkayitlar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("ekspertizkayitlar"),
                        ));

                    else:

                        $this->View->goster("sayfalar/ekspertizkayitlar/ekspertizkayitlistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/ekspertizkayitlar/ekspertizkayitListele", "BAŞARISIZ", "GÜNCELLEME SIRASINDA HATA OLUŞTU", "warning"),
                            "ekspertizkayitlar" => $this->model->listele("ekspertizkayitlar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("ekspertizkayitlar"),
                        ));

                    endif;
                
                endif;
                
            else:

                $this->Bilgi->direktYonlen("/ekspertizkayitlar/ekspertizkayitListele");
                
            endif;

        }

        function ekspertizkayitSil ($id, $mevcutsayfa=false) {

            $sonuc = $this->model->sil("ekspertizkayitlar", "id=".$id);

            $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
            $this->Pagination->paginationOlustur($this->model->sayfalama("ekspertizkayitlar"), $mevcutsayfa, $adet[0][0]);

            if ($sonuc):
            
                $this->View->goster("sayfalar/ekspertizkayitlar/ekspertizkayitlistele", array(
                    "bilgi" => $this->Bilgi->sweetAlert(URL."/ekspertizkayitlar/ekspertizkayitListele", "BAŞARILI", "SİLME İŞLEMİ BAŞARILI", "success"),
                    "ekspertizkayitlar" => $this->model->listele("ekspertizkayitlar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                    "toplamsayfa" => $this->Pagination->toplamsayfa,
                    "toplamveri" => $this->model->sayfalama("ekspertizkayitlar")
                ));
            
            else:

                $this->View->goster("sayfalar/ekspertizkayitlar/ekspertizkayitlistele", array(
                    "bilgi" => $this->Bilgi->sweetAlert(URL."/ekspertizkayitlar/ekspertizkayitListele", "BAŞARISIZ", "SİLME SIRASINDA HATA OLUŞTU", "warning"),
                    "ekspertizkayitlar" => $this->model->listele("ekspertizkayitlar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                    "toplamsayfa" => $this->Pagination->toplamsayfa,
                    "toplamveri" => $this->model->sayfalama("ekspertizkayitlar")
                ));

            endif;

        }

        function ekspertizkayitArama ($tercih=false, $kelime=false, $mevcutsayfa=false) {

            if($_POST || isset($kelime)):

                $tercihKontrol = "";

                $tarih1 = "";

                $tarih2 = "";

                $ara = "";

                $searchVal = "";

                $link = "";

                if($_POST):

                    $aramatercih = $this->Form->get("aramatercih")->bosmu();

                    if($aramatercih=="ekspertiz_tarihi") {
                        
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

                    $this->View->goster("sayfalar/ekspertizkayitlar/ekspertizkayitlistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/ekspertizkayitlar/ekspertizkayitListele", "BAŞARISIZ", "ARAMA KISMI BOŞ BIRAKILAMAZ", "warning"),
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

                    $columnNames = ["arac_id", "ekspertiz_bayi", "ekspertiz_tarihi", "aciklama"];

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

                    $bilgicek = $this->model->arama("ekspertizkayitlar", $sorgu);

                    if(isset($bilgicek[0]["id"])):

                        $this->Pagination->paginationOlustur($this->model->sayfalama("ekspertizkayitlar", $sorgu), $mevcutsayfa, $adet[0][0]);

                        $this->View->goster("sayfalar/ekspertizkayitlar/ekspertizkayitlistele", array(
                            "ekspertizkayitlar" => $this->model->listele("ekspertizkayitlar", $sorgu." LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("ekspertizkayitlar", $sorgu),
                            "ekspertizkayitarama" => $link,
                            "aramatercih" => $aramatercih,
                            "sorgu" => $sorgu,
                        ));

                    else:
                        
                        $this->View->goster("sayfalar/ekspertizkayitlar/ekspertizkayitlistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/ekspertizkayitlar/ekspertizkayitListele", "BAŞARISIZ", "HİÇ BİR BİLGİ İLE UYUŞMADI", "warning"),
                        ));

                    endif;

                endif;

            else:

                $this->bilgi->direktYonlen("/ekspertizkayitlar/ekspertizkayitListele");
                
            endif;
            
        }

        function ekspertizkayitSirala($kriter=false, $tercih=false, $mevcutsayfa=false) {

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

                    $this->View->goster("sayfalar/ekspertizkayitlar/ekspertizkayitlistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/ekspertizkayitlar/ekspertizkayitListele", "BAŞARISIZ", "ARAMA KISMI BOŞ BIRAKILAMAZ", "warning"),
                    ));

                else:

                    $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);

                    $this->Pagination->paginationOlustur($this->model->sayfalama("ekspertizkayitlar"), $mevcutsayfa, $adet[0][0]);

                    if($siralamaTercih=="a-z"):

                        $this->View->goster("sayfalar/ekspertizkayitlar/ekspertizkayitlistele", array(
                            "ekspertizkayitlar" => $this->model->listele("ekspertizkayitlar", " ORDER BY ".$siralamaKriteri." ASC LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("ekspertizkayitlar"),
                            "siralamakriteri" => $siralamaKriteri,
                            "siralamatercih" => $siralamaTercih,
                            "sorgu" => " ORDER BY ".$siralamaKriteri." ASC",
                        ));

                    else:

                        $this->View->goster("sayfalar/ekspertizkayitlar/ekspertizkayitlistele", array(
                            "ekspertizkayitlar" => $this->model->listele("ekspertizkayitlar", " ORDER BY ".$siralamaKriteri." DESC LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("ekspertizkayitlar"),
                            "siralamakriteri" => $siralamaKriteri,
                            "siralamatercih" => $siralamaTercih,
                            "sorgu" => " ORDER BY ".$siralamaKriteri." DESC",
                        ));

                    endif;

                endif;
                
            else:

                $this->Bilgi->direktYonlen("/ekspertizkayitlar/ekspertizkayitListele");

            endif;

        }

        function ekspertizkayitlarExcelAl ($sorgu=false) {

            $degerler = $this->model->listele("ekspertizkayitlar", Session::get("excelekspertizkayitsorgu"));

            $icerikler = [];

            foreach ($degerler as $key => $deger) :

                $icerikler[] = array($deger["arac_id"], $deger["ekspertiz_bayi"], $deger["ekspertiz_tarihi"], $deger["aciklama"]);
            
            endforeach;

            $this->DosyaCikti->excelAl("Ekspertiz Kayıtları", array("Araç", "Ekspertiz Bayi", "Ekspertiz Tarihi", "Açıklama"), $icerikler);

            Session::unset("excelekspertizkayitsorgu");
            
        }
        
        function topluCezaEkle ($son = false, $mevcutsayfa=false) {

            if($son):

                $sorgum = $this->DosyaIslemleri->jsonVerileriAyikla("dosya");

                $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
                $this->Pagination->paginationOlustur($this->model->sayfalama("ekspertizkayitlar"), $mevcutsayfa, $adet[0][0]);

                if(!empty($this->DosyaIslemleri->error)) :
                    
                    $this->View->goster("sayfalar/ekspertizkayitlar/ekspertizkayitlistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/ekspertizkayitlar/ekspertizkayitListele", "BAŞARISIZ", "JSON DOSYASI AÇILAMADI", "warning"),
                        "ekspertizkayitlar" => $this->model->listele("ekspertizkayitlar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                        "toplamsayfa" => $this->Pagination->toplamsayfa,
                        "toplamveri" => $this->model->sayfalama("ekspertizkayitlar"),
                    ));

                else:

                    $sonuc = $this->model->topluEkle(
                        "ekspertizkayitlar",
                        array("arac_id", "ekspertiz_bayi", "ekspertiz_tarihi", "aciklama"),
                        $sorgum
                    );

                    if($sonuc):

                        $this->View->goster("sayfalar/ekspertizkayitlar/ekspertizkayitlistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/ekspertizkayitlar/ekspertizkayitListele", "BAŞARISIZ", "EKLEME BAŞARILI", "success"),
                            "ekspertizkayitlar" => $this->model->listele("ekspertizkayitlar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("ekspertizkayitlar"),
                        ));

                    else:

                        $this->View->goster("sayfalar/ekspertizkayitlar/ekspertizkayitlistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/ekspertizkayitlar/ekspertizkayitListele", "BAŞARISIZ", "EKLEME İŞLEMİNDE HATA OLUŞTU", "warning"),
                            "ekspertizkayitlar" => $this->model->listele("ekspertizkayitlar", " LIMIT ".$this->Pagination->limit.", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("ekspertizkayitlar"),
                        ));

                    endif;

                endif;

            else:

                $this->View->goster("sayfalar/ekspertizkayitlar/topluekspertizkayitislemleri",
                    [ "topluEkspertizEkleme" => true ]
                );

            endif;

        }

    }

?>