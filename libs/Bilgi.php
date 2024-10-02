<?php

    class Bilgi {

        function basarili($deger, $yol, $sure = 3) {

			return '<div class="alert alert-success mt-5 text-center">'.$deger.'</div>'.header("Refresh:".$sure."; url=".URL.$yol);

		}
		
		function hata($deger = false, $yol, $sure = 3) {
			
			return '<div class="alert alert-danger mt-5 text-center">'.$deger.'</div>'.header("Refresh:".$sure."; url=".URL.$yol);

		}

		function uyari($tur, $metin, $id = false) {
			
			return '<div class="alert alert-'.$tur.' mt-5 text-center" '.$id.'>'.$metin.'</div>';

		}

		function sureliYonlen($yol, $sure = 3) {

			return header("Refresh:".$sure."; url=".URL.$yol);

		}

		function direktYonlen($yol) {

			return header("Location:".URL.$yol);

		}

		// SWEET ALERT

		function sweetAlert($link, $baslık, $metin, $durum) {

			return 
			'<script> BilgiPenceresi(
				"'.$link.'",
				"'.$baslık.'",
				"'.$metin.'",
				"'.$durum.'"
			); </script>';

		}
		
    }

?>