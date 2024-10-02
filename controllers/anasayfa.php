<?php 

    class anasayfa extends Controller {

        function __construct () {

            parent:: libsInclude(array("View", "Form", "Bilgi", "Pagination"));

            Session::init();

            @$this->ModelYukle("anasayfa");

            if(!Session::get("adminAd") || !Session::get("adminId")): 

                $this->giris();

                exit();

            endif;

            $infoucret = $this->model->gelismisArama("ucret, testar, arac_id, teskm", "raporlar", "ORDER BY testar ASC");

            $ucrettext = $tarihtext = $aractext = $arackmtext = "";

            $toplamucret = 0;

            foreach ($infoucret as $key => $value) :

                $ucrettext .= $value[0]."_";

                $tarihtext .= $value[1]."_";
                
                $aractext .= $value[2]."_";

                $arackmtext .= $value[3]."_";
            
            endforeach;

            $ucrettext = rtrim($ucrettext, "_");

            $tarihtext = rtrim($tarihtext, "_");

            $aractext = rtrim($aractext, "_");

            $arackmtext = rtrim($arackmtext, "_");

            $text = $ucrettext."||".$tarihtext."||".$aractext."||".$arackmtext;

            $values = $this->model->gelismisArama("count(id)", "arabalar", "where yakit_tipi='Benzin'")[0][0]."_".
            $this->model->gelismisArama("count(id)", "arabalar", "where yakit_tipi='Dizel'")[0][0]."_".
            $this->model->gelismisArama("count(id)", "arabalar", "where yakit_tipi='Lpg'")[0][0]."_".
            $this->model->gelismisArama("count(id)", "arabalar", "where yakit_tipi='Eektrik'")[0][0]."_".
            $this->model->gelismisArama("count(id)", "arabalar", "where yakit_tipi='Hibrit'")[0][0];

            $kiraValues = $this->model->gelismisArama("count(id)", "arabalar", "where durum='Boşta'")[0][0]."_".
            $this->model->gelismisArama("count(id)", "arabalar", "where durum='Kirada'")[0][0];

            // Tarih bildirimleri

            // $dates = $this->model->gelismisArama(
            //     "plaka, DATEDIFF(trafik_bitis, DATE(NOW())) as diff_trafik_bitis, DATEDIFF(kasko_bitis, DATE(NOW())) as diff_kasko_bitis, DATEDIFF(imm_bitis, DATE(NOW())) as diff_imm_bitis",
            //     "arabalar", 
            //     "where DATEDIFF(trafik_bitis, DATE(NOW())) <= 30 OR DATEDIFF(kasko_bitis, DATE(NOW())) <= 30 OR DATEDIFF(imm_bitis, DATE(NOW())) <= 30;"
            // );
                // burayı düzenle
            $dates = $this->model->gelismisArama(
                "arac_id, DATEDIFF(baslangic_tarihi, DATE(NOW())) as baslangic_tarihi",
                "sigortalar", 
                "where DATEDIFF(baslangic_tarihi, DATE(NOW())) <= 30;"
            );  

            $dates2 = $this->model->gelismisArama(
                "arac_id, DATEDIFF(son_odeme_tarihi, DATE(NOW())) as son_odeme_tarihi",
                "cezalar", 
                "where DATEDIFF(son_odeme_tarihi, DATE(NOW())) <= 30;"
            );  

            $dates3 = $this->model->gelismisArama(
                "arac_id, DATEDIFF(sozbit, DATE(NOW())) as sozbit",
                "kiralar", 
                "where DATEDIFF(sozbit, DATE(NOW())) <= 30;"
            );  

            $dates4 = $this->model->gelismisArama(
                "arac_id, DATEDIFF(bitis_tarihi, DATE(NOW())) as bitis_tarihi",
                "sigortalar", 
                "where DATEDIFF(bitis_tarihi, DATE(NOW())) <= 30;"
            );  

            $plakatext = "";
            $trafiktext = "";
            $kaskotext = "";
            $immtext = "";
            $cezaplakatext = "";
            $cezasonodemetext = "";
            $kiraplakatext = "";
            $kirasozbit = "";

            foreach ($dates as $key => $value) {
                $plakatext .= $value[0]."_";
                $trafiktext .= $value[1]."_";
                // $kaskotext .= $value[2]."_";
                // $immtext .= $value[3]."_";
            }

            foreach ($dates2 as $key => $value) {
                $cezaplakatext .= $value[0]."_";
                $cezasonodemetext .= $value[1]."_";
            }

            foreach ($dates3 as $key => $value) {
                $kiraplakatext .= $value[0]."_";
                $kirasozbit .= $value[1]."_";
            }

            $plakatext = rtrim($plakatext, "_");
            $trafiktext = rtrim($trafiktext, "_");
            $kaskotext = rtrim($kaskotext, "_");
            $immtext = rtrim($immtext, "_");
            $cezaplakatext = rtrim($cezaplakatext, "_");
            $cezasonodemetext = rtrim($cezasonodemetext, "_");
            $kiraplakatext = rtrim($kiraplakatext, "_");
            $kirasozbit = rtrim($kirasozbit, "_");

            $geneltext = rtrim($plakatext, "_")."||".rtrim($trafiktext, "_")."||".rtrim($kaskotext, "_")."||".rtrim($immtext, "_");
            $cezageneltext = rtrim($cezaplakatext, "_")."||".rtrim($cezasonodemetext, "_");
            $kirageneltext = rtrim($kiraplakatext, "_")."||".rtrim($kirasozbit, "_");

            $this->View->goster("sayfalar/anasayfa", array(
                "anasayfa" => "anasayfa",
                "bostaAdet" => $this->model->gelismisArama("count(id)", "arabalar", "where durum='Boşta'"),
                "aktifAdet" => $this->model->gelismisArama("count(cus_id)", "firmalar", "where firma_durum='aktif'"),
                "suresiGecenAdet" => $this->model->gelismisArama("count(id)", "kiralar", "where DATEDIFF(now(), sozbit) > 0"),
                "values" => $values,
                "araclar" =>$this->model->gelismisArama("plaka", "arabalar"),
                "text" => $text,
                "kiraValues" => $kiraValues,
                "geneltext" => $geneltext,
                "cezageneltext" => $cezageneltext,
                "kirageneltext" => $kirageneltext
            ));

        }

        function giris () {

            if(Session::get("adminAd") && Session::get("adminId")): 

                $this->Bilgi->direktYonlen("/anasayfa");

            else:

                $this->View->goster("sayfalar/index");

            endif;
            
        }

    }

?>