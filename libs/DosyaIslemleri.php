<?php

    class DosyaIslemleri {

        public $oku, $sorgu, $sonuc, $sorgum, $gecici;

        // public $guncellemeSorgulari = array();

        function __construct () {

            $this->oku = new DOMDocument();
            
            $this->oku->preserveWhiteSpace = false;

        }

        // XML DOSYA VERİ AYIKLAMA

        function verileriAyikla ($name, $yol, array $elementler, $kriterler) { 

            if($this->oku->load($_FILES[$name]["tmp_name"])):

                $this->sorgu = new DOMXPath($this->oku);

                $this->sonuc = $this->sorgu->query($yol);

                if($this->sonuc->length!=0):
    
                    for($i=0; $i<$this->sonuc->length; $i++):
    
                        $this->gecici = "";
        
                        for ($j=0; $j < count($elementler); $j++) :
        
                            if($kriterler[$j]):
                                
                                $this->gecici .= "'".$this->oku->getElementsByTagName($elementler[$j])->item($i)->nodeValue."'".(count($elementler)-1 == $j ? "" : ", ");
                                
                            else:
        
                                $this->gecici .= $this->oku->getElementsByTagName($elementler[$j])->item($i)->nodeValue.(count($elementler)-1 == $j ? "" : ", ");
                            
                            endif;
        
                        endfor;
        
                        $this->sorgum .= "(".$this->gecici.($i==$this->sonuc->length-1 ? ")" : "),"); 
        
                    endfor;
        
                    return $this->sorgum;
                    
                else:

                    $this->error[] = "Sorgu hatası, Elemanlara Ulaşamadı!";

                endif;

            else:

                $this->error[] = "Yüklenen Dosya Açılamadı!";

            endif;

        }

        // JSON DOSYA VERİ AYIKLAMA
        
        function jsonVerileriAyikla ($name) {

            if($_FILES[$name]["tmp_name"]!=false):

                if(substr(strrchr($_FILES[$name]["name"],'.'),1) === "json") :

                    $jsonVeriler = file_get_contents($_FILES[$name]["tmp_name"]);

                    $jsonVeriler = json_decode($jsonVeriler, true);

                    foreach($jsonVeriler["araclar"] as $value):

                        $keys = array_keys($value);

                        foreach($keys as $key):

                            $desen = "/[*]+/";

                            preg_replace($desen, "", $key, -1, $sayi);

                            if($sayi === 0):
                                
                                $this->gecici .= "'".$value[$key]."',";
                                
                            else:

                                $this->gecici .= $value[$key].",";
                            
                            endif;

                        endforeach;

                        $this->gecici = rtrim($this->gecici, ",");

                        $this->sorgum .= "(".$this->gecici."),"; 

                        $this->gecici = "";
                        
                    endforeach;

                    $this->sorgum = rtrim($this->sorgum, ",");

                    return $this->sorgum;

                else:

                    $this->error[] = "Yüklenen Dosya Json Dosyası Değil!";

                endif;


            else:
                
                $this->error[] = "Dosya Yüklenmedi!";

            endif;

        }

        // XML TOPLU GÜNCELLEME

        function guncelleVerileriAyikla ($name, $yol, array $elementler) { 

            if($this->oku->load($_FILES[$name]["tmp_name"])):

                $this->sorgu = new DOMXPath($this->oku);

                $this->sonuc = $this->sorgu->query($yol);

                $guncellemeSorgulari[$this->sonuc->length-1] = array();

                if($this->sonuc->length!=0):

                    for($i=0; $i<$this->sonuc->length; $i++):

                        $this->gecici = "";

                        for ($j=0; $j < $this->sonuc->item($i)->childNodes->length; $j++) :

                            if(in_array($this->sonuc->item($i)->childNodes->item($j)->nodeName, $elementler)):
                                
                                $degerler = $this->sonuc->item($i)->childNodes->item($j);
                                
                                $desen = "/[*]+/";

                                preg_replace($desen, "", $degerler->nodeValue, -1, $sayi);
            
                                if($sayi > 0):
                                    
                                    $this->gecici .= $degerler->nodeName." = '".substr($degerler->nodeValue,1)."', ";
                                    
                                else:
            
                                    $this->gecici .= $degerler->nodeName." = ".$degerler->nodeValue.", ";
                                
                                endif;

                            endif;

                        endfor;

                        $this->gecici = rtrim($this->gecici, ", ");

                        $this->gecici .= " where id = ".$this->sonuc->item($i)->childNodes->item(0)->nodeValue;

                        $guncellemeSorgulari[$i] =$this->gecici;
                    
                    endfor;

                    return $guncellemeSorgulari;

                else:

                    $this->error[] = "Sorgu hatası, Elemanlara Ulaşamadı!";

                endif;

            else:

                $this->error[] = "Yüklenen Dosya Açılamadı!";

            endif;

        }

        // JSON TOPLU GÜNCELLEME

    // function jsonGuncelleVerileriAyikla ($name) {
    
        //     $jsonVeriler = file_get_contents($_FILES[$name]["tmp_name"]);

        //     $jsonVeriler = json_decode($jsonVeriler, true);

        //     if($this->oku->load($_FILES[$name]["tmp_name"])):

        //         $this->sorgu = new DOMXPath($this->oku);

        //         $this->sonuc = $this->sorgu->query($yol);

        //         $guncellemeSorgulari[$this->sonuc->length-1] = array();

        //         if($this->sonuc->length!=0):

        //             for($i=0; $i<$this->sonuc->length; $i++):

        //                 $this->gecici = "";

        //                 for ($j=0; $j < $this->sonuc->item($i)->childNodes->length; $j++) :

        //                     if(in_array($this->sonuc->item($i)->childNodes->item($j)->nodeName, $elementler)):
                                
        //                         $degerler = $this->sonuc->item($i)->childNodes->item($j);
                                
        //                         $desen = "/[*]+/";

        //                         preg_replace($desen, "", $degerler->nodeValue, -1, $sayi);
            
        //                         if($sayi > 0):
                                    
        //                             $this->gecici .= $degerler->nodeName." = '".substr($degerler->nodeValue,1)."', ";
                                    
        //                         else:
            
        //                             $this->gecici .= $degerler->nodeName." = ".$degerler->nodeValue.", ";
                                
        //                         endif;

        //                     endif;

        //                 endfor;

        //                 $this->gecici = rtrim($this->gecici, ", ");

        //                 $this->gecici .= " where id = ".$this->sonuc->item($i)->childNodes->item(0)->nodeValue;

        //                 $guncellemeSorgulari[$i] =$this->gecici;
                    
        //             endfor;

        //             return $guncellemeSorgulari;

        //         else:

        //             $this->error[] = "Sorgu hatası, Elemanlara Ulaşamadı!";

        //         endif;

        //     else:

        //         $this->error[] = "Yüklenen Dosya Açılamadı!";

        //     endif;

    // }

    }

?>