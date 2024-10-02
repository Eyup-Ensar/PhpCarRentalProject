<?php 

	$url = explode("/", $_SERVER['REQUEST_URI'])[3];
    
    $arama_sonucu = strstr($url, "Listele");

    $arama_sonucu2 = strstr($url, "Son");

    $arama_sonucu3 = strstr($url, "Sil");

    $arama_sonucu4 = strstr($url, "toplu");

    $arama_sonucu5 = strstr($url, "Sirala");

    $arama_sonucu6 = strstr($url, "Arama");

?>

<?php if($arama_sonucu || $arama_sonucu2 || $arama_sonucu3 || $arama_sonucu5 || $arama_sonucu6): ?>

    <script src="<?php echo URLdesign; ?>/views/design/js/list.js"></script>

<?php else: ?>

    <script src="<?php echo URLdesign; ?>/views/design/js/formscript.js"></script>

<?php endif; ?>

</body>
</html>