<?php require "views/header.php"; ?>
    <?php 
    if (isset($veri["bilgi"])) :
      echo $veri["bilgi"]; 
    endif; 
    ?>
    <?php if (isset($veri["lastikkayitlar"])) : ?>
    <?php 

      if(isset($veri["sorgu"])):
        Session::set("excellastikkayitsorgu", $veri["sorgu"]);
      endif;

      $tarih1 = "";
      $tarih2 = "";
      $search = "";

      if(isset($veri["lastikkayitarama"])) {
        $ayir = explode("-", $veri["lastikkayitarama"]);
        if(count($ayir)>=4){
          $parca = explode("_", $veri["arama"]);
          $tarih1 = $parca[0];
          $tarih2 = $parca[1];
        }else {
          $search = $veri["lastikkayitarama"];
        }
      }

      $optValues = ["arac_id", "lastik_degisim_tarihi", "aks_yerbilgisi", "cikarilan_lastik", "takilan_lastik", "gonderilern_depo", "ucret"];

      $optNames = ["Araç", "Lastik Değişim Tarihi", "AKS Yer Bilgisi", "Çıkarılan Lastik", "Takılan Lastik", "Gönderiler Depo", "Ücret"];

      $optClasses = ["", "optdate", "", "", "", "", ""];

    ?>

  <div style="width:100%; padding: 10px; margin-top:10px">
      <div class="row mb-2 d-flex align-items-center">  
          <div class="col-8 col-xxl-3 col-md-6 d-flex align-items-center">
            <a href="#!" class="menu-toggle me-2 mb-1">
              <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 -960 960 960" class=" menusvg"><path d="M153.333-240q-14.166 0-23.75-9.617Q120-259.234 120-273.45q0-14.216 9.583-23.716 9.584-9.5 23.75-9.5h653.334q14.166 0 23.75 9.617Q840-287.432 840-273.216q0 14.216-9.583 23.716-9.584 9.5-23.75 9.5H153.333Zm0-206.667q-14.166 0-23.75-9.617Q120-465.901 120-480.117q0-14.216 9.583-23.716 9.584-9.5 23.75-9.5h653.334q14.166 0 23.75 9.617Q840-494.099 840-479.883q0 14.216-9.583 23.716-9.584 9.5-23.75 9.5H153.333Zm0-206.667q-14.166 0-23.75-9.617Q120-672.568 120-686.784q0-14.216 9.583-23.716 9.584-9.5 23.75-9.5h653.334q14.166 0 23.75 9.617Q840-700.766 840-686.55q0 14.216-9.583 23.716-9.584 9.5-23.75 9.5H153.333Z"/></svg>
            </a>
            <h1 class="h4 mb-0 mvc-renk baslik"> 
              <svg xmlns="http://www.w3.org/2000/svg" height="36px" viewBox="0 0 24 24" width="36px" fill="#000000" class="baslikPanel" style="margin-top:-5px;">
                <path d="M0 0h24v24H0V0z" fill="none"/>
                <path d="M4 8h4V4H4v4zm6 12h4v-4h-4v4zm-6 0h4v-4H4v4zm0-6h4v-4H4v4zm6 0h4v-4h-4v4zm6-10v4h4V4h-4zm-6 4h4V4h-4v4zm6 6h4v-4h-4v4zm0 6h4v-4h-4v4z"/>
              </svg> 
              LASTİK KAYITLARI
            </h1>
          </div>
          <div class="col-4 col-md-6 d-xxl-none text-end">
            <div class="dropdown">
              <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                İşlemler
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li><a class="dropdown-item" href="<?php echo URL; ?>/lastikkayitlar/lastikkayitEkle">Lastik Kayıt Ekle</a></li>
                <li>
                    <a type="submit" class="dropdown-item" href="<?php echo URL; ?>/lastikkayitlar/lastikkayitlarExcelAl">Excel Çıktısı Al</a>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-12 col-xxl-4 col-md-6  mb-2 mb-xxl-0 mt-3 mt-xxl-0 pe-md-3">
            <form action="<?php echo URL."/lastikkayitlar/lastikkayitArama" ?>" method="post">
              <div class="input-group">
                  <select name="aramatercih" class="form-control searchSelect">
                    <?php for ($i=0; $i < count($optValues); $i++) : ?> 
                      <option 
                        value="<?php echo $optValues[$i] ?>"
                        class="<?php echo $optClasses[$i] ?>"
                        <?php if(isset($veri["aramatercih"]) && $veri["aramatercih"]==$optValues[$i]) {echo 'selected="selected"';} ?>
                      >
                        <?php echo $optNames[$i] ?>
                      </option>
                    <?php endfor; ?>
                  </select>
                  <input type="text" name="ara" class="form-control normalsearch" placeholder="Ceza Ara" value="<?php echo isset($_POST["ara"]) ? $_POST["ara"] : ($search!=="" ? $search : "") ?>">
                  <input type="date" name="tarih1" class="form-control datesearch d-none" placeholder="Ceza Ara" value="<?php echo isset($_POST["tarih1"]) ? $_POST["tarih1"] : ($tarih1!=="" ? $tarih1 : "") ?>">
                  <input type="date" name="tarih2" class="form-control datesearch d-none" placeholder="Ceza Ara" value="<?php echo isset($_POST["tarih2"]) ? $_POST["tarih2"] : ($tarih2!=="" ? $tarih2 : "") ?>">
                  <div class="input-group-append">
                    <button type="submit" class="btn btn-outline-primary searchHover">
                      <svg xmlns="http://www.w3.org/2000/svg" height="22px" viewBox="0 0 24 24" width="22px" fill="#0d6efd">
                          <path d="M0 0h24v24H0V0z" fill="none"/><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                      </svg>
                    </button>
                  </div>
              </div> 
            </form>
          </div>
          <div class="col-12 col-xxl-3 col-md-6 mb-2 mb-xxl-0 mt-3 mt-xxl-0 ps-md-3">
            <form action="<?php echo URL."/lastikkayitlar/lastikkayitSirala" ?>" method="post">
              <div class="input-group">
                  <select name="siralamakriteri" class="form-control">
                    <?php for ($i=0; $i < count($optValues); $i++) : ?> 
                      <option 
                        value="<?php echo $optValues[$i] ?>"
                        <?php if(isset($veri["siralamakriteri"]) && $veri["siralamakriteri"]==$optValues[$i]) {echo 'selected="selected"';} ?>
                      >
                        <?php echo $optNames[$i] ?>
                      </option>
                    <?php endfor; ?>
                  </select>
                  <select name="siralamatercih" class="form-control ">
                    <option value="a-z" <?php if(isset($veri["siralamatercih"])) { if($veri["siralamatercih"]=="a-z")  {echo 'selected="selected"';}} ?>>A-Z</option>
                    <option value="z-a" <?php if(isset($veri["siralamatercih"])) { if($veri["siralamatercih"]=="z-a")  {echo 'selected="selected"';}} ?>>Z-A</option>
                  </select>
                  <div class="input-group-append">
                      <button type="submit" class="btn btn-outline-primary searchHover">
                      <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="#0d6efd"><path d="M440-240q-17 0-28.5-11.5T400-280q0-17 11.5-28.5T440-320h80q17 0 28.5 11.5T560-280q0 17-11.5 28.5T520-240h-80ZM280-440q-17 0-28.5-11.5T240-480q0-17 11.5-28.5T280-520h400q17 0 28.5 11.5T720-480q0 17-11.5 28.5T680-440H280ZM160-640q-17 0-28.5-11.5T120-680q0-17 11.5-28.5T160-720h640q17 0 28.5 11.5T840-680q0 17-11.5 28.5T800-640H160Z"/></svg>
                      </button>
                  </div>
              </div> 
            </form>
          </div>
          <div class="d-none d-xxl-block col-xxl-2 text-end">
            <div class="dropdown">
              <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                İşlemler
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li><a class="dropdown-item" href="<?php echo URL; ?>/lastikkayitlar/lastikkayitEkle">Lastik Kayıt Ekle</a></li>
                <li>
                    <a type="submit" class="dropdown-item" href="<?php echo URL; ?>/lastikkayitlar/lastikkayitlarExcelAl">Excel Çıktısı Al</a>
                </li>
              </ul>
            </div>
          </div>
      </div>
      <table class="table">
        <thead>
          <tr class="theadtd">
            <?php 
              foreach ($optNames as $value) :
                echo "<td>".$value."</td>" ;
              endforeach;
            ?>
            <td>İşlemler</td>
          </tr>
        </thead>
        <?php 
          $sayac = 0;
          $kontrol = 0;
          echo "<tbody>";
          foreach($veri["lastikkayitlar"] as $value):
                echo '<tr class="tbodytd" id="'.$value['id'].'">';
                  foreach ($veri["araclar"] as $key => $val) :
                    if($value["arac_id"]===$val[0]) {
                      echo '<td>'.$val[1].'</td>';
                    } else {
                      $kontrol++;
                    }
                  endforeach;
                  if($kontrol=== count($veri["araclar"])) {
                    echo '<td class="text-danger">Plaka Bulunamadı!</td>';
                  } 
                  echo '<td>'.date("d.m.Y", strtotime($value["lastik_degisim_tarihi"])).'</td>';
                  echo '<td>'.$value["aks_yerbilgisi"].'</td>';
                  echo '<td>'.$value["cikarilan_lastik"].'</td>';
                  echo '<td>'.$value["takilan_lastik"].'</td>';
                  echo '<td>'.$value["gonderilern_depo"].'</td>';
                  echo '<td>'.number_format($value["ucret"],2,",",".").' TL</td>';
          ?>
          <td class="d-flex justify-content-evenly">
            <a onclick="silmedenSor('<?php echo URL.'/lastikkayitlar/lastikkayitSil/'.$value['id']; ?>'); return false" class="mr-2">
              <form method="post">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" id="iconDanger">
                    <path d="M0 0h24v24H0V0z" fill="none"/>
                    <path d="M16 9v10H8V9h8m-1.5-6h-5l-1 1H5v2h14V4h-3.5l-1-1zM18 7H6v12c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7z"/>
                </svg>
              </form>
            </a>
            <a href="<?php echo URL; ?>/lastikkayitlar/lastikkayitGuncelle/<?php echo $value['id']?>">
              <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" id="iconSuccess">
                <path d="M480-120q-75 0-140.5-28.5t-114-77q-48.5-48.5-77-114T120-480q0-75 28.5-140.5t77-114q48.5-48.5 114-77T480-840q82 0 155.5 35T760-706v-94h80v240H600v-80h110q-41-56-101-88t-129-32q-117 0-198.5 81.5T200-480q0 117 81.5 198.5T480-200q105 0 183.5-68T756-440h82q-15 137-117.5 228.5T480-120Zm112-192L440-464v-216h80v184l128 128-56 56Z"/>
              </svg>
            </a>
            <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal" class="openModal" id="<?php echo $value['id']?>">
              <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" id="<?php echo $sayac===0 ? "iconPrimary" : "iconDanger"; ?>">
                <path d="M480-280q17 0 28.5-11.5T520-320v-160q0-17-11.5-28.5T480-520q-17 0-28.5 11.5T440-480v160q0 17 11.5 28.5T480-280Zm0-320q17 0 28.5-11.5T520-640q0-17-11.5-28.5T480-680q-17 0-28.5 11.5T440-640q0 17 11.5 28.5T480-600Zm0 520q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/>
              </svg>
            </a>
          </td></tr>
        <?php endforeach; ?>
        </tbody>
      </table>
      <!-- Modal -->
      <div class="modal fade" id="exampleModalImage" tabindex="-1" aria-labelledby="exampleModalImageLabel" aria-hidden="true">
        <div class="modal-dialog image-modal  modal-dialog-centered"></div>
      </div>
      <!-- Modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Detaylı Bilgi</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
            </div>
          </div>
        </div>
      </div>
      <?php 
        if(isset($veri["lastikkayitarama"]) && isset($veri["aramatercih"])) : 
          $link = '/lastikkayitlar/lastikkayitArama/'.$Harici->seo($veri["aramatercih"]).'/'.$Harici->seo($veri["lastikkayitarama"]).'/';
        elseif(isset($veri["siralamakriteri"]) && isset($veri["siralamatercih"])):
          $link = '/lastikkayitlar/lastikkayitSirala/'.$Harici->seo($veri["siralamakriteri"]).'/'.$Harici->seo($veri["siralamatercih"]).'/';
        else:
          $link = '/lastikkayitlar/lastikkayitListele/';
        endif;
        if(isset($veri["toplamsayfa"])) : 
          Pagination::paginationNumaralar($veri["toplamsayfa"], $link);
        endif; ?>
<?php endif; ?>
</div>

<?php require "views/footer.php"; ?>