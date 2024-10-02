<?php

    class ayar_model extends Model {

        function __construct () {

            parent:: __construct(); 

        }

        function veriAl ($tabload, $kosul=false) {

            return $this->db->Listele($tabload, $kosul);

        }

        function guncelle ($tabload, $sutunlar, $veri, $kosul) {

            return $this->db->GuncelSon($tabload, $sutunlar, $veri, $kosul); 
        
        }

    }

?>