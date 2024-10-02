<?php 

    class ayarlar extends Controller {

        function __construct () {

            parent:: libsInclude(array("View", "Form", "Bilgi"));

            Session::init();

            @$this->ModelYukle("ayar");

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

        function sifreDegistir () {

            $this->View->goster("sayfalar/ayarlar/sifredegistir", 
                ["sifredegistir" => $this->model->veriAl("users", "where id=".Session::get("adminId"))]
            );

        }

        function sifreDegistirSon () {

            if($_POST):

                $mevcutSifre = $this->Form->get("mevcutsifre")->bosmu();

                $yeniSifre = $this->Form->get("yenisifre")->bosmu();

                $sifreTekrar = $this->Form->get("sifretekrar")->bosmu();

                if (!empty($this->Form->error)) :

                    $this->View->goster(
                        "sayfalar/ayarlar/sifredegistir", 
                        array("bilgi" => $this->Bilgi->sweetAlert(URL."/ayarlar/sifreDegistir", "BAŞARISIZ", "BOŞ ALAN BIRAKILAMAZ", "warning"))
                    ); 

                else:

                    if($yeniSifre == $sifreTekrar):

                        // sifrele

                        $mevcutSifre = $this->Form->sifrele($mevcutSifre);

                        $yeniSifre = $this->Form->sifrele($yeniSifre);

                        $sifreTekrar = $this->Form->sifrele($sifreTekrar);

                        $sonuc = $this->model->guncelle("users", array("password"), array($yeniSifre), "id='".Session::get("adminId")."' and password='".$mevcutSifre."'");
                        
                        if($sonuc):
                        
                            $this->View->goster("sayfalar/kiralistele",
                                array("bilgi" => $this->Bilgi->sweetAlert(URL."/kiralar/kiraListele", "BAŞARILI", "ŞİFRE DEĞİŞTİRME BAŞARILI", "success"),
                                    'kiralar' => $this->model->veriAl("kiralar")
                                ));
        
                        else:
        
                            $this->View->goster("sayfalar/ayarlar/sifredegistir", 
                                array("bilgi" => $this->Bilgi->sweetAlert(URL."/ayarlar/sifreDegistir", "BAŞARISIZ", "MEVCUT ŞİFRE HATALIDIR", "warning"))
                            ); 
        
                        endif;

                    else:

                        $this->View->goster("sayfalar/ayarlar/sifredegistir", 
                            array("bilgi" => $this->Bilgi->sweetAlert(URL."/ayarlar/sifreDegistir", "BAŞARISIZ", "ŞİFRE TEKRARINDA HATA YAPTINIZ", "warning"))); 

                    endif;
                
                endif;
                
            else:

                $this->Bilgi->direktYonlen("/ayarlar/sifreDegistir");
                
            endif;

        }

    }

?>