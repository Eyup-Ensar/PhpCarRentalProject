<?php

    class kira_model extends Model {

        function __construct () {

            parent:: __construct(); 

        }

        function listele ($tabload, $kosul="") {

            return $this->db->Listele($tabload, $kosul);

        }

        function gelismisArama ($getir, $tabload, $kosul="") {

            return $this->db->GelismisArama($getir, $tabload, $kosul);

        }

        function arama ($tabload, $kosul) {

            return $this->db->Arama($tabload, $kosul); 
        }

        function guncelle ($tabload, $sutunlar, $veri, $kosul) {

            return $this->db->GuncelSon($tabload, $sutunlar, $veri, $kosul); 
        
        }

        function basitGuncelle ($tabload, $veriler, $kosul) {

            return $this->db->BasitGuncelle($tabload, $veriler, $kosul); 
        
        }

        function ekle ($tabload, $sutunadlari, $veriler) {

            return $this->db->Ekle($tabload, $sutunadlari, $veriler);

        }

        function sil ($tabload, $kosul) {

            return $this->db->Sil($tabload, $kosul);

        }

        function sayfalama ($tabload, $kosul=false) {

            return $this->db->SayfalamaAdet($tabload, $kosul);

        }

        function tabloSecListele ($getir, $tabload, $kosul) {

            return $this->db->TabloSecListele($getir, $tabload, $kosul);

        }

    }

?>