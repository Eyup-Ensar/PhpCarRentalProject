<?php require "views/header.php"; ?>
<div  style="width:100%;">
  <div class="container mt-3 mb-3">
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
          ARAÇ EKLE 
        </h1>
      </div> 
    </div>
    <div class="col-xl-12 col-md-12 mb-12 border-left-mvc text-left p-2 mb-2 navigasyonunanasi">
        <a href="<?php echo URL ?>/araclar/aracListele" class="navigasyon">Araçlar</a> 
        / Araç Ekleme
    </div>
    <form method="post" action="<?php echo URL."/araclar/aracEkleSon"?>" enctype="multipart/form-data">
      <div class="mb-3 mt-3">
        <label>Marka:</label>
        <input type="text" name="marka" class="form-control">
      </div>
      <div class="mb-3">
        <label>Model:</label>
        <input type="text" name="model" class="form-control">
      </div>
      <div class="mb-3">
        <label>Plaka:</label>
        <input type="text" name="plaka" class="form-control">
      </div>
      <div class="mb-3">
        <label>Kilometre:</label>
        <input type="number" name="kilometre" class="form-control">
      </div>
      <div class="mb-3">
        <label>Yakıt Tipi Seç:</label>
        <select name="yakit_tipi" class="form-control">
          <option value="0">Yakıt Tipi Seç</option>
          <option value="Dizel">Dizel</option>
          <option value="Benzin">Benzin</option>
          <option value="Lpg">Lpg</option>
          <option value="Elektrik">Elektrik</option>
          <option value="Hibrit">Hibrit</option>
        </select>
      </div>
      <div class="mb-3">
        <label>Şanzıman Seç:</label>
        <select name="sanziman" class="form-control">
          <option value="0">Şanzıman Seç</option>
          <option value="Manuel">Manuel</option>
          <option value="Otomatik">Otomatik</option>
        </select>
      </div>
      <div class="mb-3">
        <label>Araç Yılı:</label>
        <input type="number" name="yil" class="form-control">
      </div>
      <div class="mb-3">
        <label>Araç Rengi:</label>
        <input type="text" name="renk" class="form-control">
      </div>
      <div class="mb-3">
        <label>Bakıma Girdiği Kilometre:</label>
        <input type="number" name="bakim" class="form-control">
      </div>
      <div class="mb-3">
        <label>Muayene Tarihi:</label>
        <input type="date" name="muayene_tarihi" class="form-control">
      </div>
      <div class="row p-0 m-0">
        <div class="mb-3 col-6">
          <label>Sigorta Başlangıç Tarihi:</label>
          <input type="date" name="sigorta_bas" class="form-control">
        </div>
        <div class="mb-3 col-6">
          <label>Sigorta Bitiş Tarihi:</label>
          <input type="date" name="sigorta_bit" class="form-control">
        </div>
        <div class="mb-3 col-6">
          <label>Kasko Başlangıç Tarihi:</label>
          <input type="date" name="kasko_bas" class="form-control">
        </div>
        <div class="mb-3 col-6">
          <label>Kasko Bitiş Tarihi:</label>
          <input type="date" name="kasko_bit" class="form-control">
        </div>
      </div>
      <div class="mb-3">
        <label>KM Tarihi:</label>
        <input type="date" name="km_tarihi" class="form-control">
      </div>
      <div class="mb-3">
        <label>Şase No:</label>
        <input type="text" name="sase_no" class="form-control">
      </div>
      <div class="mb-3">
          <label>Kullanıcı:</label>
          <input type="text" name="kullanici" class="form-control">
        </div>
      <div class="mb-3">
        <label>Telefon:</label>
        <input type="text" name="telefon" class="form-control">
      </div>
      <div class="d-grid">
        <button type="submit" name="submit" value="Ekle" class="btn btn-primary">Ekle</button>
      </div>
    </form>
  </div>
</div>

<?php require "views/footer.php"; ?>