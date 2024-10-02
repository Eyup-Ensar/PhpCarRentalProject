<?php

    class Upload {

        public $inputname, $uploadLimit;

        public $error = array(), $yuklenenler = array();

        // public $izinVerilenUzanti = array(); hata var kontrol et 

        function __construct () {

            include 'config/Upload.php';

            $this->uploadLimit = $UploadConfig["UploadLimit"];

            $this->izinVerilenUzanti = $UploadConfig["izinVerilenUzanti"];

            $this->ZipIzinVerilenUzanti = $UploadConfig["zipIzinVerilenUzanti"];
        
        }
        
        function uploadControl ($key) {

            if(!empty($_FILES[$key]["name"])):

                return true;

            else:

                return false;

            endif;

        }

        function dosyaGuncelle ($newname, $oldname) {

            $newfiles = $_FILES[$newname];

            $oldname = explode(",", $oldname);

            $eklenecekler = [];

            $silinecekler = [];

            $sayi = 0;

            if(count($newfiles["name"])) :

                $sayi = count($newfiles["name"])===1 ? count($newfiles["name"]) : count($newfiles["name"]) - 1;

            endif;

            for ($i = 0; $i < $sayi; $i++) :

                if(empty($newfiles["name"][$i])):

                    $this->error[] = ($i + 1).". resim boş";

                endif;

            endfor;

            $this->boyutBak($newname, count($newfiles["name"]) - 1);

            $this->uzantiBak($newname, count($newfiles["name"]) - 1);

            if(empty($this->error)):

                foreach ($newfiles["name"] as $key => $value) : 

                    $sayac = 0;

                    foreach ($oldname as $val) :

                        if(empty($value) || $value===$val) :

                            $sayac++;

                        endif;

                    endforeach;

                    if($sayac===0) :

                        array_push($eklenecekler, $newfiles["tmp_name"][$key]);
                        
                    endif;

                endforeach;

                foreach ($oldname as $key => $value) : 

                    $sayac = 0;

                    foreach ($newfiles["name"] as $val) :

                        if($value===$val) :

                            $sayac++;

                        endif;

                    endforeach;

                    if($sayac===0) :
                        
                        array_push($silinecekler, $value);
                        
                    endif;

                    if($sayac!==0):

                        $this->yuklenenler[] = $value;

                    endif;

                endforeach;

                foreach($eklenecekler as $key => $deger):

                    $uzanti = explode(".", $newfiles["name"][$key]);

                    $randDeger = md5(mt_rand(0, 999943174));

                    $isim = $randDeger.".".end($uzanti);

                    move_uploaded_file($deger, RESIMYOL.$isim);

                    $this->yuklenenler[] = $isim;

                endforeach;

                foreach ($silinecekler as $key => $value) :
                    
                    if(file_exists(RESIMYOL.$value)):

                        unlink(RESIMYOL.$value);

                    endif;

                endforeach;

                return $this->yuklenenler;
            
            else:

                return $this->error;

            endif;
        
        }

        function dosyaEkle ($name) {

            $this->inputname = $name;

            $sayi = 0;

            if(count($_FILES[$name]["name"])) :
                $sayi = count($_FILES[$name]["name"])===1 ? count($_FILES[$name]["name"]) : count($_FILES[$name]["name"]) - 1;
            endif;

            for ($i = 0; $i < $sayi; $i++) :

                if(empty($_FILES[$name]["name"][$i])):

                    $this->error[] = ($i + 1).". resim boş";

                endif;

            endfor;

            if(empty($this->error)):

                $this->boyutBak($name, $sayi);

                $this->uzantiBak($name, $sayi);

                if(empty($this->error)):
                
                    return $this->inputname;

                else:
        
                    return $this->error;
        
                endif;

            else:

                return $this->error;

            endif;

        }

        // function dosyaGuncelle ($name) {
                
        //     $this->inputname=$name;

        //     if(empty($_FILES[$name]["name"])):

        //         $this->error[] = "Resim yüklenemedi";

        //     else:

        //         $this->boyutBak($name, false, true);

        //         $this->uzantiBak($name, false, true);

        //         if(empty($this->error)):
                
        //             return true;

        //         else:
        
        //             return false;
        
        //         endif;

        //     endif;

        // }

        function dosyaSil ($dosyalar) {

            $dosyalar = explode(",", $dosyalar);

            foreach ($dosyalar as $key => $value) :
                    
                if(file_exists(RESIMYOL.$value)):

                    unlink(RESIMYOL.$value);

                endif;

            endforeach;

        }

        function boyutBak ($dizideger = false, $sayi = false, $guncel = false) {

            if ($guncel):

                if($_FILES[$dizideger]["size"] > $this->uploadLimit):

                    $this->error[] = "Yüklenen dosyanın boyutu fazladır.";

                endif;

            else:

                for ($i = 0; $i < $sayi; $i++) :
                    
                    if($_FILES[$dizideger]["size"][$i] > $this->uploadLimit):

                        $this->error[] = ($i + 1).". sıradaki yüklenen dosyanın boyutu fazladır.";

                    endif;

                endfor;

                return $this->error;

            endif;

        }
        
        // * * * * İZİN VERİLEN UZANTI KISMINI TEKRAR İNCELE * * * *
        
        function uzantiBak ($dizideger = false, $sayi = false, $guncel = false) {

            if ($guncel):

                if(!in_array($_FILES[$dizideger]["type"], $this->izinVerilenUzanti)):

                    $this->error[] = "Yüklenen dosyada uzantı hatası var.";

                endif;

            else:

                for ($i = 0; $i < $sayi; $i++) :
                    
                    if(!in_array($_FILES[$dizideger]["type"][$i], $this->izinVerilenUzanti)):

                        $this->error[] = ($i + 1).". sıradaki dosyada uzantı hatası var.";

                    endif;

                endfor;

                return $this->error;
            
            endif;

        }

        function yukle ($name = false, $guncel = false) {

            if(empty($this->error)):

                if ($guncel):

                    $uzanti = explode(".", $_FILES[$name]["name"]);

                    $randDeger = md5(mt_rand(0, 999943174));

                    $isim = $randDeger.".".end($uzanti);

                    move_uploaded_file($_FILES[$name]["tmp_name"], RESIMYOL.$isim);

                    return $isim;
        
                else:

                    foreach($_FILES[$this->inputname]["tmp_name"] as $key => $deger):

                        if(!empty($_FILES[$this->inputname]["name"][$key])) :

                            $uzanti = explode(".", $_FILES[$this->inputname]["name"][$key]);

                            $randDeger = md5(mt_rand(0, 999943174));

                            $isim = $randDeger.".".end($uzanti);

                            move_uploaded_file($deger, RESIMYOL.$isim);

                            $this->yuklenenler[] = $isim;

                        endif;

                    endforeach;

                    return $this->yuklenenler;

                endif;

            else:

                return $this->error;

            endif;

        } 

        // ZİP DOSYA HATA KONTROLÜ

        function zipControl($name) {

            $dosyaAd = $_FILES[$name]["name"];

            $tur = $_FILES[$name]["type"];

            $yuklemeyeri = RESIMYOL.$dosyaAd;

            $isim = explode(".", $dosyaAd);

            if(end($isim) != "zip"):

                $this->error[] = "İzin Verilmeyen Uzantı!";
            
            else:

                if(!in_array($tur, $this->ZipIzinVerilenUzanti)):

                    $this->error[] = "Dosya Türü Hatası!";

                else:

                    return $yuklemeyeri;

                endif;

            endif;

        }

        // ZİP DOSYA YÜKLEME SON

        function zipYukle ($name, $yuklemeyeri) {

            $kaynak = $_FILES[$name]["tmp_name"];

            move_uploaded_file($kaynak, $yuklemeyeri);

            $zip = new ZipArchive();

            $dosyam = $zip->open($yuklemeyeri);

            if($dosyam === true):

                $zip->extractTo(RESIMYOL);

                $zip->close();

                unlink($yuklemeyeri);

            else:

                $this->error[] = "Dosya Açılamadı!";

            endif;

        }

    }

?>
