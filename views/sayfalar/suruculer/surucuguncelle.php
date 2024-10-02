<?php require "views/header.php"; ?>
<div  style="width:100%;">
  <nav class="container mt-3 mb-3">
    <div class="row text-left">  
      <div class="col-xl-12 col-md-12 text-left p-0 m-0 d-flex align-items-center">
          <a href="#!" class="menu-toggle me-2 mb-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 -960 960 960" class=" menusvg"><path d="M153.333-240q-14.166 0-23.75-9.617Q120-259.234 120-273.45q0-14.216 9.583-23.716 9.584-9.5 23.75-9.5h653.334q14.166 0 23.75 9.617Q840-287.432 840-273.216q0 14.216-9.583 23.716-9.584 9.5-23.75 9.5H153.333Zm0-206.667q-14.166 0-23.75-9.617Q120-465.901 120-480.117q0-14.216 9.583-23.716 9.584-9.5 23.75-9.5h653.334q14.166 0 23.75 9.617Q840-494.099 840-479.883q0 14.216-9.583 23.716-9.584 9.5-23.75 9.5H153.333Zm0-206.667q-14.166 0-23.75-9.617Q120-672.568 120-686.784q0-14.216 9.583-23.716 9.584-9.5 23.75-9.5h653.334q14.166 0 23.75 9.617Q840-700.766 840-686.55q0 14.216-9.583 23.716-9.584 9.5-23.75 9.5H153.333Z"/></svg>
          </a>
          <h1 class="h4 mb-0 mvc-renk"> 
            <svg xmlns="http://www.w3.org/2000/svg" height="36px" viewBox="0 0 24 24" width="36px" fill="#000000" class="baslikPanel" style="margin-top:-5px;">
              <path d="M0 0h24v24H0V0z" fill="none"/>
              <path d="M4 8h4V4H4v4zm6 12h4v-4h-4v4zm-6 0h4v-4H4v4zm0-6h4v-4H4v4zm6 0h4v-4h-4v4zm6-10v4h4V4h-4zm-6 4h4V4h-4v4zm6 6h4v-4h-4v4zm0 6h4v-4h-4v4z"/>
            </svg> 
            SÜRÜCÜ GÜNCELLE 
        </h1>
      </div> 
    </div>
    <div class="col-xl-12 col-md-12 mb-12 border-left-mvc text-left p-2 mb-2 navigasyonunanasi">
        <a href="<?php echo URL ?>/suruculer/surucuListele" class="navigasyon">Sürücüler</a> 
        / Sürücü Güncelleme
    </div>
    <form method="post" action="<?php echo URL ?>/suruculer/surucuGuncelleSon">
      <div class="mb-3">
        <label>Ad:</label>
        <input type="text" name="ad" class="form-control" value="<?php echo $veri["surucu"][0]["ad"];?>">
      </div>
      <div class="mb-3">
        <label>Soyad:</label>
        <input type="text" name="soyad" class="form-control" value="<?php echo $veri["surucu"][0]["soyad"];?>">
      </div>
      <div class="mb-3">
        <label>Telefon:</label>
        <input type="text" name="telefon" class="form-control" value="<?php echo $veri["surucu"][0]["telefon"];?>">
      </div>
      <div class="mb-3">
        <label>Mail Adresi:</label>
        <input type="text" name="mail_adresi" class="form-control" value="<?php echo $veri["surucu"][0]["mail_adresi"];?>">
      </div>
      <div class="mb-3">
        <label>Belge Türü:</label>
        <input type="text" name="belge_turu" class="form-control" value="<?php echo $veri["surucu"][0]["belge_turu"];?>">
      </div>
      <div class="mb-3">
        <label>Belge Numarası:</label>
        <input type="text" name="belge_numarasi" class="form-control" value="<?php echo $veri["surucu"][0]["belge_numarasi"];?>">
      </div>
      <div class="mb-3">
        <label>Belge STK:</label>
        <input type="date" name="belge_skt" class="form-control" value="<?php echo $veri["surucu"][0]["belge_skt"];?>">
      </div>
      <div class="d-grid">
        <input type="hidden" name="id" value="<?php echo $veri["surucu"][0]["id"];;?>">
        <button type="submit" name="submit" value="<?php $veri["surucu"][0]["id"]?>" class="btn btn-primary">Güncelle</button>
      </div>
    </form>
  </nav>
</div>
	
<?php require "views/footer.php"; ?>