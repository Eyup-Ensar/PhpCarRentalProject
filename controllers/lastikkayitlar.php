<?php 

    class lastikkayitlar extends Controller {

        function __construct () {

            parent:: libsInclude(array("View", "Form", "Bilgi", "Pagination", "DosyaCikti", "Session", "DosyaIslemleri"));

            @Session::init();

            @$this->ModelYukle("lastikkayit");

            if(!Session::get("adminAd") || !Session::get("adminId")): 
 
                $this->giris();

                exit();

            endif;

        }

        function giris () {

            if(Session::get("adminAd") && Session::get("adminId")): 

                $this->Bilgi->direktYonlen("/lastikkayitlar/lastikkayitListele");

            else:

                $this->View->goster("sayfalar/index");

            endif;
            
        }

        function lastikkayitListele($mevcutsayfa=false) {  

            $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
            $this->Pagination->paginationOlustur($this->model->sayfalama("lastikkayitlar"), $mevcutsayfa, $adet[0][0]);
            
            $this->View->goster("sayfalar/lastikkayitlar/lastikkayitlistele", array(
                "lastikkayitlar" => $this->model->listele("lastikkayitlar", " LIMIT ".($this->Pagination->limit>=0 ? $this->Pagination->limit : 0).", ".$this->Pagination->gosterilecekadet),
                "toplamsayfa" => $this->Pagination->toplamsayfa,
                "toplamveri" => $this->model->sayfalama("lastikkayitlar"),
                "araclar" => $this->model->gelismisArama("id, plaka", "arabalar"),
                "sorgu" => "",
            ));

        }

        function lastikkayitEkle() {

            $this->View->goster("sayfalar/lastikkayitlar/lastikkayitekle", array(
                "araclar" => $this->model->gelismisArama("plaka", "arabalar"),
            ));
            
        }

        function lastikkayitEkleSon ($mevcutsayfa=false) {

            if($_POST):

                $arac_id = $this->Form->get("arac_id")->bosmu();

                $lastik_degisim_tarihi = $this->Form->get("lastik_degisim_tarihi")->bosmu();

                $aks_yerbilgisi = $this->Form->get("aks_yerbilgisi")->bosmu();

                $cikarilan_lastik = $this->Form->get("cikarilan_lastik")->bosmu();

                $takilan_lastik = $this->Form->get("takilan_lastik")->bosmu();

                $gonderilern_depo = $this->Form->get("gonderilern_depo")->bosmu();

                $ucret = $this->Form->get("ucret")->bosmu();

                $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
                $this->Pagination->paginationOlustur($this->model->sayfalama("lastikkayitlar"), $mevcutsayfa, $adet[0][0]);

                if (!empty($this->Form->error)) :
                    
                    $this->View->goster("sayfalar/lastikkayitlar/lastikkayitlistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/lastikkayitlar/lastikkayitListele", "BAŞARISIZ", "BOŞ ALAN BIRAKILAMAZ", "warning"),
                        "lastikkayitlar" => $this->model->listele("lastikkayitlar", " LIMIT ".($this->Pagination->limit>=0 ? $this->Pagination->limit : 0).", ".$this->Pagination->gosterilecekadet),
                        "toplamsayfa" => $this->Pagination->toplamsayfa,
                        "toplamveri" => $this->model->sayfalama("lastikkayitlar"),
                        
                    ));
                    
                else:

                    $sonuc = $this->model->ekle("lastikkayitlar", array("arac_id", "lastik_degisim_tarihi", "aks_yerbilgisi", "cikarilan_lastik", "takilan_lastik", "gonderilern_depo", "ucret"), array($arac_id, $lastik_degisim_tarihi, $aks_yerbilgisi, $cikarilan_lastik, $takilan_lastik, $gonderilern_depo, $ucret));

                    if($sonuc):
                        
                        $this->View->goster("sayfalar/lastikkayitlar/lastikkayitlistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/lastikkayitlar/lastikkayitListele", "BAŞARILI", "EKLEME BAŞARILI", "success"),
                            "lastikkayitlar" => $this->model->listele("lastikkayitlar", " LIMIT ".($this->Pagination->limit>=0 ? $this->Pagination->limit : 0).", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("lastikkayitlar"),
                            
                        ));

                    else:

                        $this->View->goster("sayfalar/lastikkayitlar/lastikkayitlistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/lastikkayitlar/lastikkayitListele", "BAŞARISIZ", "EKLEME SIRASINDA HATA OLUŞTU", "warning"),
                            "lastikkayitlar" => $this->model->listele("lastikkayitlar", " LIMIT ".($this->Pagination->limit>=0 ? $this->Pagination->limit : 0).", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("lastikkayitlar"),
                            
                        ));

                    endif;
                
                endif;
                
            else:

                $this->Bilgi->direktYonlen("/lastikkayitlar/lastikkayitListele");
                
            endif;

        }

        function lastikkayitGuncelle($id) {

            $this->View->goster("sayfalar/lastikkayitlar/lastikkayitguncelle", array(
                'lastikkayit' => $this->model->listele("lastikkayitlar", "where id=".$id),
                "araclar" => $this->model->gelismisArama("plaka", "arabalar"),
                
            ));

        }
        
        function lastikkayitGuncelleSon ($mevcutsayfa=false) {

            if($_POST):

                $id = $this->Form->get("id")->bosmu();

                $arac_id = $this->Form->get("arac_id")->bosmu();

                $lastik_degisim_tarihi = $this->Form->get("lastik_degisim_tarihi")->bosmu();

                $aks_yerbilgisi = $this->Form->get("aks_yerbilgisi")->bosmu();

                $cikarilan_lastik = $this->Form->get("cikarilan_lastik")->bosmu();

                $takilan_lastik = $this->Form->get("takilan_lastik")->bosmu();

                $gonderilern_depo = $this->Form->get("gonderilern_depo")->bosmu();

                $ucret = $this->Form->get("ucret")->bosmu();

                $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
                $this->Pagination->paginationOlustur($this->model->sayfalama("lastikkayitlar"), $mevcutsayfa, $adet[0][0]);

                if (!empty($this->Form->error)) :
                
                    $this->View->goster("sayfalar/lastikkayitlar/lastikkayitlistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/lastikkayitlar/lastikkayitListele", "BAŞARISIZ", "BOŞ ALAN BIRAKILAMAZ", "warning"),
                        "lastikkayitlar" => $this->model->listele("lastikkayitlar", " LIMIT ".($this->Pagination->limit>=0 ? $this->Pagination->limit : 0).", ".$this->Pagination->gosterilecekadet),
                        "toplamsayfa" => $this->Pagination->toplamsayfa,
                        "toplamveri" => $this->model->sayfalama("lastikkayitlar"),
                    ));

                else:

                    $sonuc = $this->model->guncelle("lastikkayitlar",  array("arac_id", "lastik_degisim_tarihi", "aks_yerbilgisi", "cikarilan_lastik", "takilan_lastik", "gonderilern_depo", "ucret"), array($arac_id, $lastik_degisim_tarihi, $aks_yerbilgisi, $cikarilan_lastik, $takilan_lastik, $gonderilern_depo, $ucret), "id=".$id);

                    if($sonuc):

                        $this->View->goster("sayfalar/lastikkayitlar/lastikkayitlistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/lastikkayitlar/lastikkayitListele", "BAŞARILI", "GÜNCELLEME BAŞARILI", "success"),
                            "lastikkayitlar" => $this->model->listele("lastikkayitlar", " LIMIT ".($this->Pagination->limit>=0 ? $this->Pagination->limit : 0).", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("lastikkayitlar"),
                        ));

                    else:

                        $this->View->goster("sayfalar/lastikkayitlar/lastikkayitlistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/lastikkayitlar/lastikkayitListele", "BAŞARISIZ", "GÜNCELLEME SIRASINDA HATA OLUŞTU", "warning"),
                            "lastikkayitlar" => $this->model->listele("lastikkayitlar", " LIMIT ".($this->Pagination->limit>=0 ? $this->Pagination->limit : 0).", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("lastikkayitlar"),
                        ));

                    endif;
                
                endif;
                
            else:

                $this->Bilgi->direktYonlen("/lastikkayitlar/lastikkayitListele");
                
            endif;

        }

        function lastikkayitSil ($id, $mevcutsayfa=false) {

            $sonuc = $this->model->sil("lastikkayitlar", "id=".$id);

            $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
            $this->Pagination->paginationOlustur($this->model->sayfalama("lastikkayitlar"), $mevcutsayfa, $adet[0][0]);

            if ($sonuc):
            
                $this->View->goster("sayfalar/lastikkayitlar/lastikkayitlistele", array(
                    "bilgi" => $this->Bilgi->sweetAlert(URL."/lastikkayitlar/lastikkayitListele", "BAŞARILI", "SİLME İŞLEMİ BAŞARILI", "success"),
                    "lastikkayitlar" => $this->model->listele("lastikkayitlar", " LIMIT ".($this->Pagination->limit>=0 ? $this->Pagination->limit : 0).", ".$this->Pagination->gosterilecekadet),
                    "toplamsayfa" => $this->Pagination->toplamsayfa,
                    "toplamveri" => $this->model->sayfalama("lastikkayitlar")
                ));
            
            else:

                $this->View->goster("sayfalar/lastikkayitlar/lastikkayitlistele", array(
                    "bilgi" => $this->Bilgi->sweetAlert(URL."/lastikkayitlar/lastikkayitListele", "BAŞARISIZ", "SİLME SIRASINDA HATA OLUŞTU", "warning"),
                    "lastikkayitlar" => $this->model->listele("lastikkayitlar", " LIMIT ".($this->Pagination->limit>=0 ? $this->Pagination->limit : 0).", ".$this->Pagination->gosterilecekadet),
                    "toplamsayfa" => $this->Pagination->toplamsayfa,
                    "toplamveri" => $this->model->sayfalama("lastikkayitlar")
                ));

            endif;

        }

        function lastikkayitArama ($tercih=false, $kelime=false, $mevcutsayfa=false) {

            if($_POST || isset($kelime)):

                $tercihKontrol = "";

                $tarih1 = "";

                $tarih2 = "";

                $ara = "";

                $searchVal = "";

                $link = "";

                if($_POST):

                    $aramatercih = $this->Form->get("aramatercih")->bosmu();

                    if($aramatercih=="lastik_degisim_tarihi") {
                        
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

                    $this->View->goster("sayfalar/lastikkayitlar/lastikkayitlistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/lastikkayitlar/lastikkayitListele", "BAŞARISIZ", "ARAMA KISMI BOŞ BIRAKILAMAZ", "warning"),
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

                    $columnNames = ["arac_id", "lastik_degisim_tarihi", "aks_yerbilgisi", "cikarilan_lastik", "takilan_lastik", "gonderilern_depo", "ucret"];

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

                    $bilgicek = $this->model->arama("lastikkayitlar", $sorgu);

                    if(isset($bilgicek[0]["id"])):

                        $this->Pagination->paginationOlustur($this->model->sayfalama("lastikkayitlar", $sorgu), $mevcutsayfa, $adet[0][0]);

                        $this->View->goster("sayfalar/lastikkayitlar/lastikkayitlistele", array(
                            "lastikkayitlar" => $this->model->listele("lastikkayitlar", $sorgu." LIMIT ".($this->Pagination->limit>=0 ? $this->Pagination->limit : 0).", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("lastikkayitlar", $sorgu),
                            "lastikkayitarama" => $link,
                            "aramatercih" => $aramatercih,
                            "sorgu" => $sorgu,
                            
                        ));

                    else:
                        
                        $this->View->goster("sayfalar/lastikkayitlar/lastikkayitlistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/lastikkayitlar/lastikkayitListele", "BAŞARISIZ", "HİÇ BİR BİLGİ İLE UYUŞMADI", "warning"),
                        ));

                    endif;

                endif;

            else:

                $this->bilgi->direktYonlen("/lastikkayitlar/lastikkayitListele");
                
            endif;
            
        }

        function lastikkayitSirala($kriter=false, $tercih=false, $mevcutsayfa=false) {

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

                    $this->View->goster("sayfalar/lastikkayitlar/lastikkayitlistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/lastikkayitlar/lastikkayitListele", "BAŞARISIZ", "ARAMA KISMI BOŞ BIRAKILAMAZ", "warning"),
                    ));

                else:

                    $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);

                    $this->Pagination->paginationOlustur($this->model->sayfalama("lastikkayitlar"), $mevcutsayfa, $adet[0][0]);

                    if($siralamaTercih=="a-z"):

                        $this->View->goster("sayfalar/lastikkayitlar/lastikkayitlistele", array(
                            "lastikkayitlar" => $this->model->listele("lastikkayitlar", " ORDER BY ".$siralamaKriteri." ASC LIMIT ".($this->Pagination->limit>=0 ? $this->Pagination->limit : 0).", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("lastikkayitlar"),
                            "siralamakriteri" => $siralamaKriteri,
                            "siralamatercih" => $siralamaTercih,
                            "sorgu" => " ORDER BY ".$siralamaKriteri." ASC",
                            
                        ));

                    else:

                        $this->View->goster("sayfalar/lastikkayitlar/lastikkayitlistele", array(
                            "lastikkayitlar" => $this->model->listele("lastikkayitlar", " ORDER BY ".$siralamaKriteri." DESC LIMIT ".($this->Pagination->limit>=0 ? $this->Pagination->limit : 0).", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("lastikkayitlar"),
                            "siralamakriteri" => $siralamaKriteri,
                            "siralamatercih" => $siralamaTercih,
                            "sorgu" => " ORDER BY ".$siralamaKriteri." DESC",
                            
                        ));

                    endif;

                endif;
                
            else:

                $this->Bilgi->direktYonlen("/lastikkayitlar/lastikkayitListele");

            endif;

        }

        function lastikkayitlarExcelAl ($sorgu=false) {

            $degerler = $this->model->listele("lastikkayitlar", Session::get("excellastikkayitsorgu"));

            $icerikler = [];

            foreach ($degerler as $key => $deger) :

                $icerikler[] = array($deger["arac_id"], $deger["lastik_degisim_tarihi"], $deger["aks_yerbilgisi"], $deger["cikarilan_lastik"], $deger["takilan_lastik"], $deger["gonderilern_depo"], $deger["ucret"]);

            endforeach;

            $this->DosyaCikti->excelAl("Trafik Cezaları", array("Araç", "Lastik Değişim Tarihi", "AKS Yer Bilgisi", "Çıkarılan Lastik", "Takılan Lastik", "Gönderiler Depo", "Ücret"), $icerikler);

            Session::unset("excellastikkayitsorgu");
            
        }
        
        function topluCezaEkle ($son = false, $mevcutsayfa=false) {

            if($son):

                $sorgum = $this->DosyaIslemleri->jsonVerileriAyikla("dosya");

                $adet = $this->model->gelismisArama("sayfaadet", "ayarlar", false);
            
                $this->Pagination->paginationOlustur($this->model->sayfalama("lastikkayitlar"), $mevcutsayfa, $adet[0][0]);

                if(!empty($this->DosyaIslemleri->error)) :
                    
                    $this->View->goster("sayfalar/lastikkayitlar/lastikkayitlistele", array(
                        "bilgi" => $this->Bilgi->sweetAlert(URL."/lastikkayitlar/lastikkayitListele", "BAŞARISIZ", "JSON DOSYASI AÇILAMADI", "warning"),
                        "lastikkayitlar" => $this->model->listele("lastikkayitlar", " LIMIT ".($this->Pagination->limit>=0 ? $this->Pagination->limit : 0).", ".$this->Pagination->gosterilecekadet),
                        "toplamsayfa" => $this->Pagination->toplamsayfa,
                        "toplamveri" => $this->model->sayfalama("lastikkayitlar"),
                        
                    ));

                else:

                    $sonuc = $this->model->topluEkle(
                        "lastikkayitlar",
                        array("arac_id", "suruculer", "lastikkayit_tarihi", "teblig_tarihi", "son_odeme_tarihi", "lastikkayit_aciklama", "durum", "lastikkayit_tutari"),
                        $sorgum
                    );

                    if($sonuc):

                        $this->View->goster("sayfalar/lastikkayitlar/lastikkayitlistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/lastikkayitlar/lastikkayitListele", "BAŞARISIZ", "EKLEME BAŞARILI", "success"),
                            "lastikkayitlar" => $this->model->listele("lastikkayitlar", " LIMIT ".($this->Pagination->limit>=0 ? $this->Pagination->limit : 0).", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("lastikkayitlar"),
                            
                            ));

                    else:

                        $this->View->goster("sayfalar/lastikkayitlar/lastikkayitlistele", array(
                            "bilgi" => $this->Bilgi->sweetAlert(URL."/lastikkayitlar/lastikkayitListele", "BAŞARISIZ", "EKLEME İŞLEMİNDE HATA OLUŞTU", "warning"),
                            "lastikkayitlar" => $this->model->listele("lastikkayitlar", " LIMIT ".($this->Pagination->limit>=0 ? $this->Pagination->limit : 0).", ".$this->Pagination->gosterilecekadet),
                            "toplamsayfa" => $this->Pagination->toplamsayfa,
                            "toplamveri" => $this->model->sayfalama("lastikkayitlar"),
                            
                        ));

                    endif;

                endif;

            else:

                $this->View->goster("sayfalar/lastikkayitlar/toplulastikkayitislemleri",
                    [ "topluFirmaEkleme" => true ]
                );

            endif;

        }

    }

?>