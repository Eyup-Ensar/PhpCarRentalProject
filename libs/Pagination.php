<?php

    class Pagination {

        public $limit, $toplamsayfa, $sayfa, $gosterilecekadet;

        function paginationOlustur ($verisayisi, $mevcutsayfa, $adet) {
          
            $this->gosterilecekadet = $adet;

            if($adet!==0):

              $this->toplamsayfa = ceil($verisayisi / $this->gosterilecekadet);

              $this->sayfa = is_numeric($mevcutsayfa) ? $this->sayfa = $mevcutsayfa : $this->sayfa = 1;

              ($this->sayfa < 1) ? $this->sayfa = 1 : null;

              ($this->sayfa > $this->toplamsayfa) ? $this->sayfa = $this->toplamsayfa : null;

              $this->limit = ($this->sayfa - 1) * $this->gosterilecekadet;

            else:

              $this->limit = 0;

            endif;

        }

        public static function paginationNumaralar ($toplamsayfa, $url) {
          $mevcutLink = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
          echo '<nav aria-label="Page navigation example">
            <ul class="pagination mx-auto border mt-1">';
              $sayac = 0;
              for ($i=1; $i <= $toplamsayfa ; $i++) : 
                URL.$url.$i == $mevcutLink ? $sayac++ : null;
              endfor;
              for ($s = 1; $s <= $toplamsayfa; $s++) :
                echo '
                <li class="page-item m-1';
                  echo URL.$url.$s == $mevcutLink ? " active" : "";
                  echo $sayac < 1 ? ($s==1 ? " active" : "") : "";
                echo '">
                  <a class="page-link" href="'.URL.$url.$s.'">'.$s.'</a>
                </li>';
              endfor;
            echo '</ul>
          </nav>';  
        }

    }

?>