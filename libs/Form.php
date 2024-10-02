<?php

    class Form extends Bilgi {

        public $deger, $veri;

        public $error = array(), $sonuc = array();

        function get ($key, $control=false) {

            if($control):

                $this->veri = htmlspecialchars(strip_tags($_POST[$key]));
    
                return $this->veri;

            else:

                $this->deger = $key;

                $this->veri = htmlspecialchars(strip_tags($_POST[$key]));
    
                return $this;

            endif;

        }
        
        function bosmu ($yol=null) { 

            if(empty($this->veri) && !is_numeric($this->veri)):

                $this->error[] = $this->deger." boş olamaz<br>";

                return $this;

            else:

                return $this->veri;

            endif;

        }

        function gercektenMailmi ($email) {

            getmxrr(substr($email, strpos($email, '@')+1), $this->sonuc);

            if(!count($this->sonuc)>0):
                
                $this->error[] = "Mail adresi geçersiz<br>";

            endif;

        }

        function sifrele ($veri) {

            return base64_encode($veri);

        }

        function coz ($veri) {
            
            return unserialize(gzuncompress(gzinflate(base64_decode($veri))));

        }

        function sifreKarsilastir ($deger1, $deger2) {

            if($deger1 != $deger2):
            
                $this->error[] = "Girilen şifreler uyuşmamaktadır<br>";

            else :

                return $this->sifrele($deger1);

            endif;

        }

        function checkBoxGet ($key) {

            if(!isset($_POST[$key])):

                return 0;

            else:

                if($_POST[$key] == "on"):
                    
                    return 1;

                endif;

            endif;

        } 

        function selectBoxGet ($key) {

            if($_POST[$key]==0) {

                $this->error[] = "Boş değer girilemez<br>";

            } else {

                return $_POST[$key];
            }

        } 

        function radioButtonGet($key) {

            return $_POST[$key];

        }
        
        // Form oluşturma

        public static function _form(array $veri) {

            echo "<form ";
            
            foreach ($veri as $key => $value):

                echo $key."='".$value."' ";

            endforeach;

            echo ">";

        }

        public static function formKapat() {

            echo "</form>";

        }

        public static function input(array $veri) {

            echo "<input ";
            
            foreach ($veri as $key => $value):

                if(($key!="0")):

                    echo $key."='".$value."' ";

                else:

                    echo $value!=null ? $value." " : "";

                endif;

            endforeach;

            echo ">";

        }

        public static function button(array $veri, $name=false) {

            echo "<button ";
            
            foreach ($veri as $key => $value):

                if(($key!="0")):

                    echo $key."='".$value."' ";

                else:

                    echo $value!=null ? $value." " : "";

                endif;

            endforeach;

            echo ">".$name."</button>";

        }

        public static function textarea(array $veri, $icerik=null) {

            echo "<textarea ";
            
            foreach ($veri as $key => $value):

                echo $key."='".$value."' ";

            endforeach;

            echo ">$icerik</textarea>";

        }

        public static function select(array $veri) {

            echo "<select ";
            
            foreach ($veri as $key => $value):

                echo $key."='".$value."' ";

            endforeach;

            echo ">";

        }

        public static function option(array $veri, array $icerik) {

            echo "<option ";
            
                foreach ($veri as $key => $value):

                    if(($key!="0")):

                        echo $key."='".$value."' ";

                    else:

                        echo $value!=null ? $value." " : "";

                    endif;

                endforeach;

            echo ">";

                echo (!isset($icerik[1])) ? $icerik[0] : "fazla değer girdin!!";
            
            echo "</option>";
           
        }

        public static function selectKapat() {

            echo "</select>";

        }



    }

?>
