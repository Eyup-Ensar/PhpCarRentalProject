<?php require 'views/header.php'; ?>

<!-- Begin Page Content -->
<div class="container-fluid mt-4 mt-4">
  <!-- Page Heading -->
  <div class="row">
    <div class="col-xl-12 col-md-12 text-center"> 
      <?php if (isset($veri["bilgi"])) :
          if(is_array($veri["bilgi"])) :
            foreach($veri["bilgi"] as $value):
			        echo '<div class="alert alert-danger mt-5 text-center">'.$value.'</div><br>';
              echo $veri["yonlen"];
            endforeach;
          else:
            echo $veri["bilgi"]; 
          endif;
      endif; ?>
      <!-- TOPLU ÜRÜN EKLEME -->
      <?php if(isset($veri["topluAracEkleme"])): ?>
        <div class="row text-left mb-2">  
      <div class="col-xl-12 col-md-12 text-left p-0 m-0 d-flex align-items-center">
        <a href="#!" class="menu-toggle me-2 mb-1">
          <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 -960 960 960" class=" menusvg"><path d="M153.333-240q-14.166 0-23.75-9.617Q120-259.234 120-273.45q0-14.216 9.583-23.716 9.584-9.5 23.75-9.5h653.334q14.166 0 23.75 9.617Q840-287.432 840-273.216q0 14.216-9.583 23.716-9.584 9.5-23.75 9.5H153.333Zm0-206.667q-14.166 0-23.75-9.617Q120-465.901 120-480.117q0-14.216 9.583-23.716 9.584-9.5 23.75-9.5h653.334q14.166 0 23.75 9.617Q840-494.099 840-479.883q0 14.216-9.583 23.716-9.584 9.5-23.75 9.5H153.333Zm0-206.667q-14.166 0-23.75-9.617Q120-672.568 120-686.784q0-14.216 9.583-23.716 9.584-9.5 23.75-9.5h653.334q14.166 0 23.75 9.617Q840-700.766 840-686.55q0 14.216-9.583 23.716-9.584 9.5-23.75 9.5H153.333Z"/></svg>
        </a>
        <h1 class="h4 mb-0 mvc-renk"> 
          <svg xmlns="http://www.w3.org/2000/svg" height="36px" viewBox="0 0 24 24" width="36px" fill="#000000" class="baslikPanel" style="margin-top:-5px;">
            <path d="M0 0h24v24H0V0z" fill="none"/>
            <path d="M4 8h4V4H4v4zm6 12h4v-4h-4v4zm-6 0h4v-4H4v4zm0-6h4v-4H4v4zm6 0h4v-4h-4v4zm6-10v4h4V4h-4zm-6 4h4V4h-4v4zm6 6h4v-4h-4v4zm0 6h4v-4h-4v4z"/>
          </svg> 
          TOPLU ARAÇ EKLE 
        </h1>
      </div> 
    </div>
    <div class="col-xl-12 col-md-12 mb-12 border-left-mvc text-left p-2 mb-2 navigasyonunanasi">
        <a href="<?php echo URL ?>/araclar/aracListele" class="navigasyon">Araçlar</a> 
        / Toplu Araç Ekleme
    </div>
        <div class="row text-center">
          <div class="col-xl-4 col-md-8 mx-auto">
            <div class="row bg-gradient-beyazimsi">
              <div class="col-12 bg-gradient-mvc pt-2 mvc-black">
                <h4>Dosyaları Ekle</h4>
              </div>
              <div class="col-12 formeleman nocizgi mvc-renk form-check">
                <form action="<?php echo URL."/araclar/topluAracEkle/son" ?>" enctype="multipart/form-data" class="form" method="post">
              </div>
              <div class="col-12 formeleman mvc-renk nocizgi pt-0">JSON Dosyası</div>
              <div class="col-12 mt-2">
                <input type="file" name="dosya" class="form-control">
              </div>
              <div class="col-12 formeleman nocizgi mt-2">
                <input type="submit" value="Yükle" class="btn btn-primary ps-3 pe-3">
              </form>
              </div>
            </div>
          </div>
        </div>
      <?php endif; ?>
      <!-- TOPLU ÜRÜN EKLEME -->
    </div> 
  </div>  
  <!-- /.row bitiyor -->
</div>
<!-- /.container-fluid -->

<?php require 'views/footer.php'; ?>