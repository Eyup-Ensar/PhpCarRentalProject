<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<?php $Harici = new HariciFonksiyonlar(); ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
<!-- Custom Theme files -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Medicom Araç Takip Sistemi</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- <link href="<?php echo URL; ?>/views/design/css/menu.css" rel="stylesheet"/> -->
<link rel="icon" href="<?php echo URLdesign; ?>/views/design/images/favicon.ico" type="image/x-icon" />
<link href="<?php echo URLdesign; ?>/views/design/css/styles.css" rel="stylesheet"/>
<link href="<?php echo URLdesign; ?>/views/design/css/style.css" rel="stylesheet"/>
<script src="<?php echo URLdesign; ?>/views/design/js/sweetalert.js"></script>
<script src="<?php echo URLdesign; ?>/views/design/js/jquery.min.js"></script>
<script src="<?php echo URLdesign; ?>/views/design/js/bizim.js"></script>
<script src="<?php echo URLdesign; ?>/views/design/js/menu.js"></script>
</head>
<body>

<?php 
	$url = $_SERVER['REQUEST_URI']; 
	$active = explode("/", $_SERVER['REQUEST_URI']) 
?>
<div  style="display:flex; justify-content: space-between">
<div class='dashboard' style="display: inline-block">
	<div class="dashboard-nav">
		<header>
			<a href="#!" class="menu-toggle">
				<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="#fff">
					<path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/>
				</svg>
			</a>
			<a href="#" class="brand-logo">
				<i class="fas fa-anchor"></i> 
				<span id="tables" class="text-center">MEDİCOM</span>
			</a>
		</header>
		<nav class="dashboard-nav-list">
			<a href="<?php echo URL; ?>/anasayfa" class="dashboard-nav-item <?php echo $active[2]==="anasayfa" ? " active" : ""; ?>">
				<svg xmlns="http://www.w3.org/2000/svg"  height="24" viewBox="0 -960 960 960" width="24" fill="white" class="me-3"><path d="M240-200h120v-200q0-17 11.5-28.5T400-440h160q17 0 28.5 11.5T600-400v200h120v-360L480-740 240-560v360Zm-80 0v-360q0-19 8.5-36t23.5-28l240-180q21-16 48-16t48 16l240 180q15 11 23.5 28t8.5 36v360q0 33-23.5 56.5T720-120H560q-17 0-28.5-11.5T520-160v-200h-80v200q0 17-11.5 28.5T400-120H240q-33 0-56.5-23.5T160-200Zm320-270Z"/></svg>
				Anasayfa 
			</a>
			<a href="<?php echo URL; ?>/araclar/aracListele" class="dashboard-nav-item <?php echo $active[2]==="araclar" ? " active" : ""; ?>">
				<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="white" class="me-3"><path d="M240-200v20q0 25-17.5 42.5T180-120q-25 0-42.5-17.5T120-180v-286q0-7 1-14t3-13l75-213q8-24 29-39t47-15h410q26 0 47 15t29 39l75 213q2 6 3 13t1 14v286q0 25-17.5 42.5T780-120q-25 0-42.5-17.5T720-180v-20H240Zm-8-360h496l-42-120H274l-42 120Zm-32 80v200-200Zm100 160q25 0 42.5-17.5T360-380q0-25-17.5-42.5T300-440q-25 0-42.5 17.5T240-380q0 25 17.5 42.5T300-320Zm360 0q25 0 42.5-17.5T720-380q0-25-17.5-42.5T660-440q-25 0-42.5 17.5T600-380q0 25 17.5 42.5T660-320Zm-460 40h560v-200H200v200Z"/></svg>
				Araç Yönetimi
			</a>
			<a href="<?php echo URL; ?>/firmalar/firmaListele" class="dashboard-nav-item <?php echo $active[2]==="firmalar" ? " active" : ""; ?>">
				<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="white" class="me-3"><path d="M120-120v-560h160v-160h400v320h160v400H520v-160h-80v160H120Zm80-80h80v-80h-80v80Zm0-160h80v-80h-80v80Zm0-160h80v-80h-80v80Zm160 160h80v-80h-80v80Zm0-160h80v-80h-80v80Zm0-160h80v-80h-80v80Zm160 320h80v-80h-80v80Zm0-160h80v-80h-80v80Zm0-160h80v-80h-80v80Zm160 480h80v-80h-80v80Zm0-160h80v-80h-80v80Z"/></svg>
				Firma Yönetimi
			</a>
			<a href="<?php echo URL; ?>/suruculer/surucuListele" class="dashboard-nav-item <?php echo $active[2]==="suruculer" ? " active" : ""; ?>">
				<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="white" class="me-3"><path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47Zm240 320H240q-33 0-56.5-23.5T160-240v-32q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v32q0 33-23.5 56.5T720-160Zm-480-80h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0-80Zm0 400Z"/></svg>
				Sürücü Yönetimi
			</a>
			<a href="<?php echo URL; ?>/kiralar/kiraListele" class="dashboard-nav-item <?php echo $active[2]==="kiralar" ? " active" : ""; ?>">
				<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="white" class="me-3"><path d="M320-680q-50 0-85-35t-35-85q0-50 35-85t85-35q38 0 69 22.5t45 57.5h286q17 0 28.5 11.5T760-800q0 16-14.5 22.5T720-760v40q0 17-11.5 28.5T680-680q-17 0-28.5-11.5T640-720v-40H434q-14 35-45 57.5T320-680Zm0-80q17 0 28.5-11.5T360-800q0-17-11.5-28.5T320-840q-17 0-28.5 11.5T280-800q0 17 11.5 28.5T320-760Zm40 500q17 0 28.5-11.5T400-300q0-17-11.5-28.5T360-340q-17 0-28.5 11.5T320-300q0 17 11.5 28.5T360-260Zm240 0q17 0 28.5-11.5T640-300q0-17-11.5-28.5T600-340q-17 0-28.5 11.5T560-300q0 17 11.5 28.5T600-260ZM280-160v40q0 17-11.5 28.5T240-80q-17 0-28.5-11.5T200-120v-243q0-7 1-13.5t3-12.5l54-157q8-24 29-39t47-15h292q26 0 47 15t29 39l54 157q2 6 3 12.5t1 13.5v243q0 17-11.5 28.5T720-80q-17 0-28.5-11.5T680-120v-40H280Zm26-280h348l-28-80H334l-28 80Zm-26 80v120-120Zm0 120h400v-120H280v120Z"/></svg>
				Kira Yönetimi
			</a>
			<a href="<?php echo URL; ?>/servisler/servisListele" class="dashboard-nav-item <?php echo $active[2]==="servisler" ? " active" : ""; ?>">
			<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="white" class="me-3"><path d="M756-120 537-339l84-84 219 219-84 84Zm-552 0-84-84 276-276-68-68-28 28-51-51v82l-28 28-121-121 28-28h82l-50-50 142-142q20-20 43-29t47-9q24 0 47 9t43 29l-92 92 50 50-28 28 68 68 90-90q-4-11-6.5-23t-2.5-24q0-59 40.5-99.5T701-841q15 0 28.5 3t27.5 9l-99 99 72 72 99-99q7 14 9.5 27.5T841-701q0 59-40.5 99.5T701-561q-12 0-24-2t-23-7L204-120Z"/></svg>
				Servisler
			</a>
			<a href="<?php echo URL; ?>/sigortalar/sigortaListele" class="dashboard-nav-item <?php echo $active[2]==="sigortalar" ? " active" : ""; ?>">
				<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="white" class="me-3"><path d="M480-706 367-818l56-57 57 57 142-142 56 56-198 198ZM160 0q-17 0-28.5-11.5T120-40v-320l84-240q6-18 21.5-29t34.5-11h440q19 0 34.5 11t21.5 29l84 240v320q0 17-11.5 28.5T800 0h-40q-17 0-28.5-11.5T720-40v-40H240v40q0 17-11.5 28.5T200 0h-40Zm72-440h496l-42-120H274l-42 120Zm-32 80v200-200Zm100 160q25 0 42.5-17.5T360-260q0-25-17.5-42.5T300-320q-25 0-42.5 17.5T240-260q0 25 17.5 42.5T300-200Zm360 0q25 0 42.5-17.5T720-260q0-25-17.5-42.5T660-320q-25 0-42.5 17.5T600-260q0 25 17.5 42.5T660-200Zm-460 40h560v-200H200v200Z"/></svg>
				Sigortalar
			</a>
			<a href="<?php echo URL; ?>/cezalar/cezaListele" class="dashboard-nav-item <?php echo $active[2]==="cezalar" ? " active" : ""; ?>">
				<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="white" class="me-3"><path d="m40-120 440-760 440 760H40Zm138-80h604L480-720 178-200Zm302-40q17 0 28.5-11.5T520-280q0-17-11.5-28.5T480-320q-17 0-28.5 11.5T440-280q0 17 11.5 28.5T480-240Zm-40-120h80v-200h-80v200Zm40-100Z"/></svg>
				Trafik Cezaları
			</a>
			<a href="<?php echo URL; ?>/kazalar/kazaListele" class="dashboard-nav-item <?php echo $active[2]==="kazalar" ? " active" : ""; ?>">
				<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="white" class="me-3"><path d="M720-520q-83 0-141.5-58.5T520-720q0-82 58-141t142-59q83 0 141.5 58.5T920-720q0 83-58.5 141.5T720-520Zm-20-160h40v-160h-40v160ZM160-160q-17 0-28.5-11.5T120-200v-320l84-240q6-18 21.5-29t34.5-11h192q-6 19-9 39t-3 41H274l-42 120h235q11 23 25.5 43t32.5 37H200v200h560v-123q21-3 41-9t39-15v267q0 17-11.5 28.5T800-160h-40q-17 0-28.5-11.5T720-200v-40H240v40q0 17-11.5 28.5T200-160h-40Zm560-440q8 0 14-6t6-14q0-8-6-14t-14-6q-8 0-14 6t-6 14q0 8 6 14t14 6ZM300-360q25 0 42.5-17.5T360-420q0-25-17.5-42.5T300-480q-25 0-42.5 17.5T240-420q0 25 17.5 42.5T300-360Zm360 0q25 0 42.5-17.5T720-420q0-5-.5-10t-2.5-10q-27 0-52.5-5T616-460q-8 8-12 18.5t-4 21.5q0 25 17.5 42.5T660-360Zm-460 40v-200 200Z"/></svg>
				Kazalar
			</a>
			<a href="<?php echo URL; ?>/yakitlar/yakitListele" class="dashboard-nav-item <?php echo $active[2]==="yakitlar" ? " active" : ""; ?>">
				<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="white" class="me-3"><path d="M760-640q-17 0-28.5-11.5T720-680q0-8 3.5-15.5T732-708q12-12 55-27l43-15q-8 23-15 43-6 17-13.5 33T788-652q-5 5-12.5 8.5T760-640ZM160-120q-33 0-56.5-23.5T80-200v-560q0-33 23.5-56.5T160-840h240q33 0 56.5 23.5T480-760v327q9-3 19-5t21-2q50 0 85 35t35 85v80q0 17 11.5 28.5T680-200q17 0 28.5-11.5T720-240v-200h-40v-57q-54-23-87-72t-33-111q0-83 58.5-141.5T760-880q83 0 141.5 58.5T960-680q0 62-33 111t-87 72v57h-40v200q0 50-35 85t-85 35q-50 0-85-35t-35-85v-80q0-17-11.5-28.5T520-360q-17 0-28.5 11.5T480-320v120q0 33-23.5 56.5T400-120H160Zm600-440q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35ZM160-200h240v-80l-80 80v-113l80-80v-87l-80 80v-113l80-80v-87l-80 80v-113l47-47H193l47 47v113l-80-80v87l80 80v113l-80-80v87l80 80v113l-80-80v80Zm120-280Z"/></svg>
				Yakıt Kayıtları
			</a>
			<a href="<?php echo URL; ?>/ekspertizkayitlar/ekspertizkayitListele" class="dashboard-nav-item <?php echo $active[2]==="ekspertizkayitlar" ? " active" : ""; ?>">
				<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="white" class="me-3"><path d="M720-120H280v-520l280-280 50 50q7 7 11.5 19t4.5 23v14l-44 174h258q32 0 56 24t24 56v80q0 7-2 15t-4 15L794-168q-9 20-30 34t-44 14Zm-360-80h360l120-280v-80H480l54-220-174 174v406Zm0-406v406-406Zm-80-34v80H160v360h120v80H80v-520h200Z"/></svg>
				Ekspertiz Kayıtları
			</a>
			<a href="<?php echo URL; ?>/lastikkayitlar/lastikkayitListele" class="dashboard-nav-item <?php echo $active[2]==="lastikkayitlar" ? " active" : ""; ?>">
 				<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="white" class="me-3"><path d="M480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm200-500 54-18 16-54q-32-48-77-82.5T574-786l-54 38v56l160 112Zm-400 0 160-112v-56l-54-38q-54 17-99 51.5T210-652l16 54 54 18Zm-42 308 46-4 30-54-58-174-56-20-40 30q0 65 18 118.5T238-272Zm242 112q26 0 51-4t49-12l28-60-26-44H378l-26 44 28 60q24 8 49 12t51 4Zm-90-200h180l56-160-146-102-144 102 54 160Zm332 88q42-50 60-103.5T800-494l-40-28-56 18-58 174 30 54 46 4Z"/></svg>
				Lastik Kayıtları
			</a>
			<a href="<?php echo URL; ?>/raporlar/raporListele" class="dashboard-nav-item <?php echo $active[2]==="raporlar" ? " active" : ""; ?>">
				<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="white" class="me-3"><path d="M320-240h320v-80H320v80Zm0-160h320v-80H320v80ZM240-80q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h320l240 240v480q0 33-23.5 56.5T720-80H240Zm280-520v-200H240v640h480v-440H520ZM240-800v200-200 640-640Z"/></svg>
				Raporlar
			</a>
			<div class='dashboard-nav-dropdown <?php echo $active[2]==="ayarlar" ? " show" : ""; ?>'>
				<a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle">
					<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="white" class="me-3"><path d="M555-80H405q-15 0-26-10t-13-25l-12-93q-13-5-24.5-12T307-235l-87 36q-14 5-28 1t-22-17L96-344q-8-13-5-28t15-24l75-57q-1-7-1-13.5v-27q0-6.5 1-13.5l-75-57q-12-9-15-24t5-28l74-129q7-14 21.5-17.5T220-761l87 36q11-8 23-15t24-12l12-93q2-15 13-25t26-10h150q15 0 26 10t13 25l12 93q13 5 24.5 12t22.5 15l87-36q14-5 28-1t22 17l74 129q8 13 5 28t-15 24l-75 57q1 7 1 13.5v27q0 6.5-2 13.5l75 57q12 9 15 24t-5 28l-74 128q-8 13-22.5 17.5T738-199l-85-36q-11 8-23 15t-24 12l-12 93q-2 15-13 25t-26 10Zm-73-260q58 0 99-41t41-99q0-58-41-99t-99-41q-59 0-99.5 41T342-480q0 58 40.5 99t99.5 41Zm0-80q-25 0-42.5-17.5T422-480q0-25 17.5-42.5T482-540q25 0 42.5 17.5T542-480q0 25-17.5 42.5T482-420Zm-2-60Zm-40 320h79l14-106q31-8 57.5-23.5T639-327l99 41 39-68-86-65q5-14 7-29.5t2-31.5q0-16-2-31.5t-7-29.5l86-65-39-68-99 42q-22-23-48.5-38.5T533-694l-13-106h-79l-14 106q-31 8-57.5 23.5T321-633l-99-41-39 68 86 64q-5 15-7 30t-2 32q0 16 2 31t7 30l-86 65 39 68 99-42q22 23 48.5 38.5T427-266l13 106Z"/></svg>
					Ayarlar 
				</a>
				<div class='dashboard-nav-dropdown-menu <?php echo $active[3]==="sifreDegistir" ? " active" : ""; ?>'>
					<a href="<?php echo URL; ?>/ayarlar/sifreDegistir" class="dashboard-nav-dropdown-item">Şifre Değiştir</a>
				</div>
			</div>
			<div class="nav-item-divider"></div>
			<a href="<?php echo URL."/admin/cikis" ?>" class="dashboard-nav-item">
			<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" width="24" fill="white" class="me-3"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h240q17 0 28.5 11.5T480-800q0 17-11.5 28.5T440-760H200v560h240q17 0 28.5 11.5T480-160q0 17-11.5 28.5T440-120H200Zm487-320H400q-17 0-28.5-11.5T360-480q0-17 11.5-28.5T400-520h287l-75-75q-11-11-11-27t11-28q11-12 28-12.5t29 11.5l143 143q12 12 12 28t-12 28L669-309q-12 12-28.5 11.5T612-310q-11-12-10.5-28.5T613-366l74-74Z"/></svg>
				Oturumu Kapat 
			</a>
		</nav>
	</div>
</div>