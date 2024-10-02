<?php

  class DosyaCikti {

    function excelAl($tabloBaslik, $columns=array(), $data=array(), array $enaltsatir=null) {

      $filename = date("d.m.Y");

      header('Content-Encoding: UTF-8');
  
      header('Content-Type: text/plain; charset=utf-8');
  
      header('Content-disposition: attachment; filename='.$filename.'.xls');
  
      echo "\xEF\xBB\xBF"; // bom
  
      $sayim = count($columns);
      
      echo '<table border="1">';
        echo '<th style="background:#0049b6">';
          echo '<font color="white">'.$tabloBaslik.'</font>';
        echo '</th>';
        // BAŞLIKLAR
        echo '<tr>';
          foreach ($columns as $veri) :
            echo '<td style="background:rgb(230, 242, 255)">'.trim($veri).'</td>' ;
          endforeach;
        echo '</tr>';
        // VERİLER
        foreach ($data as $val) :
          echo '<tr>';
            for($i=0; $i<$sayim; $i++):
              echo '<td>'.$val[$i].'</td>' ;
            endfor;
          echo '</tr>';
        endforeach;
        //SONUÇ
        if($enaltsatir!=null):
          echo '<tr>';
            foreach ($enaltsatir as $veri) :
              echo '<td style="background:#ddb446">'.trim($veri).'</td>' ;
            endforeach;
          echo '</tr>';
        endif;
        echo '</table>';
      
    }

    function txtOlustur($icerikler) {

      $filename = date("d.m.Y");

      header('Content-Encoding: UTF-8');
  
      header('Content-Type: text/plain; charset=utf-8');
  
      header('Content-disposition: attachment; filename='.$filename.'.txt');
      
      echo "\xEF\xBB\xBF"; // bom

      foreach ($icerikler as $value) :

        echo $value["mailadres"]."\r\n" ;

      endforeach;
      
    }

    function veriTabaniYedekIndir($icerikler) {

      $filename = date("d.m.Y");

      header('Content-Encoding: UTF-8');
  
      header('Content-Type: text/plain; charset=utf-8');
  
      header('Content-disposition: attachment; filename='.$filename.'.sql');
      
      echo "\xEF\xBB\xBF"; // bom

      echo $icerikler ;

    }
  
  }

?>