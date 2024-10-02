<?php 

    class admin extends Controller {

        function __construct () {

            parent:: libsInclude(array("View", "Bilgi", "Form"));

            @Session::init();

            @$this->ModelYukle("admin");

        }

        function index() {
            
            $this->View->goster("sayfalar/index");

        }

        function giriskontrol () {

            if($_POST):

                $adminAd = $this->Form->get("adminAd")->bosmu();

                $adminSifre = $this->Form->get("adminSifre")->bosmu();

                if (!empty($this->Form->error)) :

                    $this->View->goster("sayfalar/index", array('bilgi' =>  $this->Bilgi->uyari("danger", "Ad veya şifre boş olamaz!!")));

                else:

                    $adminSifre = $this->Form->sifrele($adminSifre);

                    $sonuc = $this->model->giriskontrol("users", "username='$adminAd' and password='$adminSifre'");

                    if($sonuc):

                        Session::init();

                        Session::set("adminAd", $sonuc[0]["username"]);

                        Session::set("adminId", $sonuc[0]["id"]); // yönetici id'sini taşıyacağım

                        $this->Bilgi->direktYonlen("/anasayfa");

                    else:

                        $this->View->goster("sayfalar/index", array('bilgi' =>  $this->Bilgi->uyari("danger", "Kullanıcı adı veya şifre hatalı!!")));

                    endif;

                endif;

            else:

                $this->Bilgi->direktYonlen("/");

            endif;

        }

        function cikis () {

            Session::destroy();

            $this->Bilgi->direktYonlen("/admin");

        }

    }

?>