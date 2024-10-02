<?php require 'views/header.php'; ?>

<!-- Begin Page Content -->
<div class="container-fluid mt-4  p-0 m-0">
  <!-- Page Heading -->
  <div class="row">
    <div class="col-xl-12 col-md-12 mb-12 text-center"> 
    <?php if (isset($veri["bilgi"])) :
        echo $veri["bilgi"];
    endif; ?>
          <!-- BAŞLIK -->
          <div class="row text-left border-bottom-mvc mb-2 p-0 m-0">  
        	  <div class="col-xl-12 col-md-12 mb-12 border-left-mvc text-left p-2 mb-3 p-0 m-0">
            <h1 class="h4 mb-0 mvc-renk d-flex align-items-center">
                <a href="#!" class="menu-toggle me-2 mb-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 -960 960 960" class=" menusvg"><path d="M153.333-240q-14.166 0-23.75-9.617Q120-259.234 120-273.45q0-14.216 9.583-23.716 9.584-9.5 23.75-9.5h653.334q14.166 0 23.75 9.617Q840-287.432 840-273.216q0 14.216-9.583 23.716-9.584 9.5-23.75 9.5H153.333Zm0-206.667q-14.166 0-23.75-9.617Q120-465.901 120-480.117q0-14.216 9.583-23.716 9.584-9.5 23.75-9.5h653.334q14.166 0 23.75 9.617Q840-494.099 840-479.883q0 14.216-9.583 23.716-9.584 9.5-23.75 9.5H153.333Zm0-206.667q-14.166 0-23.75-9.617Q120-672.568 120-686.784q0-14.216 9.583-23.716 9.584-9.5 23.75-9.5h653.334q14.166 0 23.75 9.617Q840-700.766 840-686.55q0 14.216-9.583 23.716-9.584 9.5-23.75 9.5H153.333Z"/></svg>
                </a>
                <svg xmlns="http://www.w3.org/2000/svg" height="36px" viewBox="0 0 24 24" width="36px" fill="#000000" class="baslikPanel" style="margin-top:-5px;">
                    <path d="M0 0h24v24H0V0z" fill="none"/>
                    <path d="M4 8h4V4H4v4zm6 12h4v-4h-4v4zm-6 0h4v-4H4v4zm0-6h4v-4H4v4zm6 0h4v-4h-4v4zm6-10v4h4V4h-4zm-6 4h4V4h-4v4zm6 6h4v-4h-4v4zm0 6h4v-4h-4v4z"/>
                </svg> 
                ŞİFRE DEĞİŞTİR
            </h1>
                </h1>
            </div>
          </div>
          <!-- BAŞLIK --> 	
          <!--  FORMUN İSKELETİ-->
          <div class="col-xl-12 col-md-12  text-center  p-0 m-0"> 
            <div class="row text-center  p-0 m-0">  
        	    <div class="col-xl-4 col-lg-6 col-md-8 col-sm-10 mx-auto  p-0 m-0">
                    <div class="row bg-gradient-beyazimsi">
                        <div class="col-lg-12 col-md-12 col-sm-12 bg-light pt-2 mvc-black"><h4>Şifre Değiştir</h4></div>
                        <div class="col-lg-12 col-md-12 col-sm-12   mvc-renk">
                            <form action="<?php echo URL; ?>/ayarlar/sifreDegistirSon" method="post">
                                <div class="col-lg-12 col-md-12 col-sm-12  mb-2 mt-2">Mevcut Şifre</div>
                                    <input type="password" name="mevcutsifre" class="form-control mb-2 mt-2">
                                    <div class="col-lg-12 col-md-12 col-sm-12 ">Yeni Şifre</div>
                                    <input type="password" name="yenisifre" class="form-control mb-2 mt-2">
                                    <div class="col-lg-12 col-md-12 col-sm-12 ">Yeni Şifre (Tekrar)</div>
                                    <input type="password" name="sifretekrar" class="form-control mb-2 mt-2">
                                </div>
                                <div class="d-flex justify-content-center w-100">
                                <input type="submit" value="Şifre Değiştir" class="btn btn-primary mb-2 mt-2"></div>
                            </form>
                        </div>  
                    </div>
                </div>
            </div>
          </div>
           <!--  FORMUN İSKELETİ-->
    </div> 
  </div>  
  <!-- /.row bitiyor -->
</div>
<!-- /.container-fluid -->
     
<?php require 'views/footer.php'; ?>