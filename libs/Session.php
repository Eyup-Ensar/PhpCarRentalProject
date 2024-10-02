<?php

    class Session {

        public static $db;

        public static function init () {

            self::$db = new Database();

            session_start();

        }

        public static function set ($key, $value) {

            $_SESSION[$key] = $value;

        }

        public static function unset ($key) {

           unset($_SESSION[$key]);

        }

        public static function get ($key) {

            if(isset($_SESSION[$key])):

                return $_SESSION[$key];

            endif;

        }

        public static function destroy () {

            session_destroy();

        }

        public static function oturumKontrol ($tabload, $ad, $id) {

            $sonuc = self::$db->Listele($tabload, "where ad='".$ad."' and id='".$id."'");

            if(!isset($sonuc[0])):

                self::destroy();

            endif;

        }   

    }

?>