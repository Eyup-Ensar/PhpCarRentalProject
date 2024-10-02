<?php require "views/header.php"; ?>
  <?php if (isset($veri["bilgi"])) :
    echo $veri["bilgi"];
  endif; ?>
  <?php if (isset($veri["kiralar"])) : ?>
    <?php 

      if(isset($veri["sorgu"])):
        Session::set("excelkirasorgu", $veri["sorgu"]);
      endif;

      $tarih1 = "";
      $tarih2 = "";
      $search = "";
      if(isset($veri["kiraarama"])) {

        $ayir = explode("-", $veri["kiraarama"]);
        if(count($ayir)>=4){
          $parca = explode("_", $veri["kiraarama"]);
          $tarih1 = $parca[0];
          $tarih2 = $parca[1];
        }else {
          $search = $veri["kiraarama"];
        }
      }

      $optValues = ["arac_id", "firma","sozbas","sozbit","sozbaskm","ucret"];

      $optNames = ["Araç", "Firma","Sözleşme Başlangıç Tarihi","Sözleşme Bitiş Tarihi","Sözleşme Başlangıç KM","Kiralama Ücreti"];

      $optClasses = ["", "","optdate","optdate","",""];

    ?>
    <div style="width:100%; padding: 10px; margin-top:10px">
      <div class="row mb-2 d-flex align-items-center">  
          <div class="col-8 col-xxl-3 col-md-6 d-flex align-items-center">
            <a href="#!" class="menu-toggle me-2 mb-1">
              <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 -960 960 960" class="menusvg"><path d="M153.333-240q-14.166 0-23.75-9.617Q120-259.234 120-273.45q0-14.216 9.583-23.716 9.584-9.5 23.75-9.5h653.334q14.166 0 23.75 9.617Q840-287.432 840-273.216q0 14.216-9.583 23.716-9.584 9.5-23.75 9.5H153.333Zm0-206.667q-14.166 0-23.75-9.617Q120-465.901 120-480.117q0-14.216 9.583-23.716 9.584-9.5 23.75-9.5h653.334q14.166 0 23.75 9.617Q840-494.099 840-479.883q0 14.216-9.583 23.716-9.584 9.5-23.75 9.5H153.333Zm0-206.667q-14.166 0-23.75-9.617Q120-672.568 120-686.784q0-14.216 9.583-23.716 9.584-9.5 23.75-9.5h653.334q14.166 0 23.75 9.617Q840-700.766 840-686.55q0 14.216-9.583 23.716-9.584 9.5-23.75 9.5H153.333Z"/></svg>
            </a>
            <h1 class="h4 mb-0 mvc-renk baslik"> 
              <svg xmlns="http://www.w3.org/2000/svg" height="36px" viewBox="0 0 24 24" width="36px" fill="#000000" class="baslikPanel" style="margin-top:-5px;">
                <path d="M0 0h24v24H0V0z" fill="none"/>
                <path d="M4 8h4V4H4v4zm6 12h4v-4h-4v4zm-6 0h4v-4H4v4zm0-6h4v-4H4v4zm6 0h4v-4h-4v4zm6-10v4h4V4h-4zm-6 4h4V4h-4v4zm6 6h4v-4h-4v4zm0 6h4v-4h-4v4z"/>
              </svg> 
              KİRALAR
            </h1>
          </div>
          <div class="col-4 col-md-6 d-xxl-none text-end">
            <div class="dropdown">
              <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                İşlemler
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li><a class="dropdown-item" href="<?php echo URL; ?>/kiralar/kiraBaslat">Kira Başlat</a></li>
                <li>
                    <a type="submit" class="dropdown-item" href="<?php echo URL; ?>/kiralar/kiralarExcelAl">Excel Çıktısı Al</a>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-12 col-xxl-4 col-md-6  mb-2 mb-xxl-0 mt-3 mt-xxl-0 pe-md-3">
            <form action="<?php echo URL."/kiralar/kiraArama" ?>" method="post">
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
                  <input type="text" name="ara" class="form-control normalsearch" placeholder="Kira Ara" value="<?php echo isset($_POST["ara"]) ? $_POST["ara"] : ($search!=="" ? $search : "") ?>">
                  <input type="date" name="tarih1" class="form-control datesearch d-none" value="<?php echo isset($_POST["tarih1"]) ? $_POST["tarih1"] : ($tarih1!=="" ? $tarih1 : "") ?>">
                  <input type="date" name="tarih2" class="form-control datesearch d-none" value="<?php echo isset($_POST["tarih2"]) ? $_POST["tarih2"] : ($tarih2!=="" ? $tarih2 : "") ?>">
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
            <form action="<?php echo URL."/kiralar/kiraSirala" ?>" method="post">
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
                <li><a class="dropdown-item" href="<?php echo URL; ?>/kiralar/kiraBaslat">Kira Başlat</a></li>
                <li>
                    <a type="submit" class="dropdown-item" href="<?php echo URL; ?>/kiralar/kiralarExcelAl">Excel Çıktısı Al</a>
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
            <td>Kalan Süre</td>
            <td>İşlemler</td>
          </tr>
        </thead>
        <?php 
          $today = new DateTime();
          foreach($veri["kiralar"] as $value) :
          $sayac = 0;
          $kontrol = 0;
          echo '<tbody>';
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
              $kontrol = 0;
              foreach ($veri["firmalar"] as $key => $val) :
                if($value["firma_id"]===$val[0]) {
                  echo '<td>'.$val[1].'</td>';
                } else {
                  $kontrol++;
                }
              endforeach;
              if($kontrol=== count($veri["firmalar"])) {
                echo '<td class="text-danger">Firma Bulunamadı!</td>';
              } 
              echo '<td>'.date("d.m.Y", strtotime($value["sozbas"])).'</td>';
              echo '<td>'.date("d.m.Y", strtotime($value["sozbit"])).'</td>';
              echo '<td>'.$value["sozbaskm"].'</td>';
              echo '<td>'.number_format($value["ucret"],2,",",".").' TL</td>';
          if (empty($value['sozbit'])) {
            $sayac += 1;
            echo '<td class="text-danger">Girilmemiş!</td>';
          } else {
            $sozbit = new DateTime($value['sozbit']); // ??
            $diff = $sozbit->diff($today);
            if ($sozbit < $today) {
              $sayac += 1;
            echo '<td class="text-danger">' . $diff->days . ' gün geçti!</td>';
            } else {
                echo '<td class="text-success">' . $diff->days . ' gün kaldı</td>'; 
            }
          }
        ?>
        <td class="d-flex justify-content-evenly">
          <a onclick="silmedenSor('<?php echo URL.'/kiralar/kiraSil/'.$value['id']; ?>'); return false" class="mr-2">
            <form method="post">
              <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" id="iconDanger">
                  <path d="M0 0h24v24H0V0z" fill="none"/>
                  <path d="M16 9v10H8V9h8m-1.5-6h-5l-1 1H5v2h14V4h-3.5l-1-1zM18 7H6v12c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7z"/>
              </svg>
            </form>
          </a>
          <a href="<?php echo URL; ?>/kiralar/kiraGuncelle/<?php echo $value['id']?>">
            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="#51ad19" id="iconSuccess"><path d="M480-120q-75 0-140.5-28.5t-114-77q-48.5-48.5-77-114T120-480q0-75 28.5-140.5t77-114q48.5-48.5 114-77T480-840q82 0 155.5 35T760-706v-94h80v240H600v-80h110q-41-56-101-88t-129-32q-117 0-198.5 81.5T200-480q0 117 81.5 198.5T480-200q105 0 183.5-68T756-440h82q-15 137-117.5 228.5T480-120Zm112-192L440-464v-216h80v184l128 128-56 56Z"/></svg>
          </a>
          <a href="<?php echo URL; ?>/kiralar/aracTeslim/<?php echo $value['id']?>">
            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="#6c757d" id="iconSecondary"><path d="M475-160q4 0 8-2t6-4l328-328q12-12 17.5-27t5.5-30q0-16-5.5-30.5T817-607L647-777q-11-12-25.5-17.5T591-800q-15 0-30 5.5T534-777l-11 11 74 75q15 14 22 32t7 38q0 42-28.5 70.5T527-522q-20 0-38.5-7T456-550l-75-74-175 175q-3 3-4.5 6.5T200-435q0 8 6 14.5t14 6.5q4 0 8-2t6-4l136-136 56 56-135 136q-3 3-4.5 6.5T285-350q0 8 6 14t14 6q4 0 8-2t6-4l136-135 56 56-135 136q-3 2-4.5 6t-1.5 8q0 8 6 14t14 6q4 0 7.5-1.5t6.5-4.5l136-135 56 56-136 136q-3 3-4.5 6.5T454-180q0 8 6.5 14t14.5 6Zm-1 80q-37 0-65.5-24.5T375-166q-34-5-57-28t-28-57q-34-5-56.5-28.5T206-336q-38-5-62-33t-24-66q0-20 7.5-38.5T149-506l232-231 131 131q2 3 6 4.5t8 1.5q9 0 15-5.5t6-14.5q0-4-1.5-8t-4.5-6L398-777q-11-12-25.5-17.5T342-800q-15 0-30 5.5T285-777L144-635q-9 9-15 21t-8 24q-2 12 0 24.5t8 23.5l-58 58q-17-23-25-50.5T40-590q2-28 14-54.5T87-692l141-141q24-23 53.5-35t60.5-12q31 0 60.5 12t52.5 35l11 11 11-11q24-23 53.5-35t60.5-12q31 0 60.5 12t52.5 35l169 169q23 23 35 53t12 61q0 31-12 60.5T873-437L545-110q-14 14-32.5 22T474-80Zm-99-560Z"/></svg>
          </a>
          <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal" class="openModal" id="<?php echo $value['id']?>">
            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="#0d6efd" id="<?php echo $sayac===0 ? "iconPrimary" : "iconDanger"; ?>">
              <path d="M480-280q17 0 28.5-11.5T520-320v-160q0-17-11.5-28.5T480-520q-17 0-28.5 11.5T440-480v160q0 17 11.5 28.5T480-280Zm0-320q17 0 28.5-11.5T520-640q0-17-11.5-28.5T480-680q-17 0-28.5 11.5T440-640q0 17 11.5 28.5T480-600Zm0 520q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/>
            </svg>
          </a>
        </td></tr></tbody>
        <?php endforeach; ?>
      </table>
      <!-- Modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Detaylı Bilgi</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
            </div>
          </div>
        </div>
      </div>
      <?php 
        if(isset($veri["kiraarama"]) && isset($veri["aramatercih"])) : 
          $link = '/kiralar/kiraArama/'.$Harici->seo($veri["aramatercih"]).'/'.$Harici->seo($veri["kiraarama"]).'/';
        elseif(isset($veri["siralamakriteri"]) && isset($veri["siralamatercih"])):
          $link = '/kiralar/kiraSirala/'.$Harici->seo($veri["siralamakriteri"]).'/'.$Harici->seo($veri["siralamatercih"]).'/';
        else:
          $link = '/kiralar/kiraListele/';
        endif;
        if(isset($veri["toplamsayfa"])) : 
          Pagination::paginationNumaralar($veri["toplamsayfa"], $link);
      endif; ?>
  <?php endif; ?>
  </div>
<?php require "views/footer.php"; ?>