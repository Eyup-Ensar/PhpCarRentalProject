<?php

    class admin_model extends Model {

        function __construct () {

            parent:: __construct(); 

        }

        function veriAl ($tabload, $kosul=false) {

            return $this->db->Listele($tabload, $kosul);

        }

        function giriskontrol ($tabload, $kosul) {

            return $this->db->GirisKontrol($tabload, $kosul);

        }

    }

?>