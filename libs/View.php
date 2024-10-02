<?php

    class View {

        function __construct () {

        }

        public function goster ($dosyaad, array $veri=null) {

            require "views/".$dosyaad.'.php';

        }

    }

?>