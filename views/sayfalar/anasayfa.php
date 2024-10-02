  <?php if (isset($veri["bilgi"])) :
    echo $veri["bilgi"]; 
  endif; ?>
  <?php if (isset($veri["anasayfa"])) : ?>
    <?php require "views/header.php"; ?>
    <div style="width:100%; padding: 10px; margin-top:10px">
        <div class="row mb-2 d-flex align-items-center">  
            <div class="col-12 d-flex align-items-center">
            <a href="#!" class="menu-toggle me-2 mb-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 -960 960 960" class=" menusvg"><path d="M153.333-240q-14.166 0-23.75-9.617Q120-259.234 120-273.45q0-14.216 9.583-23.716 9.584-9.5 23.75-9.5h653.334q14.166 0 23.75 9.617Q840-287.432 840-273.216q0 14.216-9.583 23.716-9.584 9.5-23.75 9.5H153.333Zm0-206.667q-14.166 0-23.75-9.617Q120-465.901 120-480.117q0-14.216 9.583-23.716 9.584-9.5 23.75-9.5h653.334q14.166 0 23.75 9.617Q840-494.099 840-479.883q0 14.216-9.583 23.716-9.584 9.5-23.75 9.5H153.333Zm0-206.667q-14.166 0-23.75-9.617Q120-672.568 120-686.784q0-14.216 9.583-23.716 9.584-9.5 23.75-9.5h653.334q14.166 0 23.75 9.617Q840-700.766 840-686.55q0 14.216-9.583 23.716-9.584 9.5-23.75 9.5H153.333Z"/></svg>
            </a>
            <h1 class="h4 mb-0 mvc-renk baslik"> 
                <svg xmlns="http://www.w3.org/2000/svg" height="36px" viewBox="0 0 24 24" width="36px" fill="#000000" class="baslikPanel" style="margin-top:-5px;">
                <path d="M0 0h24v24H0V0z" fill="none"/>
                <path d="M4 8h4V4H4v4zm6 12h4v-4h-4v4zm-6 0h4v-4H4v4zm0-6h4v-4H4v4zm6 0h4v-4h-4v4zm6-10v4h4V4h-4zm-6 4h4V4h-4v4zm6 6h4v-4h-4v4zm0 6h4v-4h-4v4z"/>
                </svg> 
                ANASAYFA
            </h1>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 row">
                <div class="col-xxl-4 col-md-12">
                    <div class="card border-primary rounded-1">
                        <h5 class="card-header border-primary text-start">Araçlar</h5>
                        <div class="card-body">
                            <h5 class="card-title">Boşta Araç Adedi: <?php echo isset($veri["bostaAdet"]) ? $veri["bostaAdet"][0][0] : "" ?></h5>
                            <p class="card-text">Sistemde kayıtlı boşta olan araç adedi.</p>
                            <a href="<?php echo URL; ?>/araclar/aracArama/durum/bosta/1" class="text-primary fw-bold">Görüntüle</a>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-md-6 mt-4 mt-xxl-0">
                    <div class="card border-success rounded-1">
                        <h5 class="card-header border-success text-start">Firmalar</h5>
                        <div class="card-body">
                            <h5 class="card-title">Aktif Firma Adedi: <?php echo isset($veri["aktifAdet"]) ? $veri["aktifAdet"][0][0] : "" ?></h5>
                            <p class="card-text">Sistemde kayıtlı aktif durumda olan firma adedi.</p>
                            <a href="<?php echo URL; ?>/firmalar/firmaArama/firma_durum/aktif/1" class="text-success fw-bold">Görüntüle</a>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-md-6 mt-4 mt-xxl-0">
                    <div class="card border-danger rounded-1">
                        <h5 class="card-header border-danger text-start">Kiralar</h5>
                        <div class="card-body">
                            <h5 class="card-title">Süresi Geçen Kira Adedi: <?php echo isset($veri["suresiGecenAdet"]) ? $veri["suresiGecenAdet"][0][0] : "" ?></h5>
                            <p class="card-text">Sistemde kayıtlı süresi geçen kira adedi.</p>
                            <a href="<?php echo URL."/kiralar/kiraArama/sozbit/1453-05-29_".date('Y-m-d' ,strtotime('-1 day', strtotime(date('Y-m-d')))); ?>" class="text-danger fw-bold">Görüntüle</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="d-flex justify-content-around flex-wrap">
                <div class="mt-4 p-3 bildirimler">
                <div class="w-100" id="mailmessage">
            </div>
                    <div class="w-100 d-flex justify-content-between">
                        <div class="h4 mb-3">Tarih Bildirimleri</div>
                        <!-- <div class="mb-3">
                            <form method="post" action="<?php echo URL; ?>/anasayfa/mailGonder" class="">
                                <input type="hidden" name="listmailgonderhidden" id="listmailgonderhidden">
                                <input type="submit" class="btn btn-primary btn-sm" id="listmailgonder" value="Mail Gönder">
                            </form>
                        </div> -->
                    </div>
                    <div class="input-group mb-3">
                        <input type="hidden" id="datestext" value="<?php echo isset($veri["geneltext"]) ? $veri["geneltext"] : "" ?>">
                        <input type="hidden" id="cezadatestext" value="<?php echo isset($veri["cezageneltext"]) ? $veri["cezageneltext"] : "" ?>">
                        <input type="hidden" id="kiradatestext" value="<?php echo isset($veri["kirageneltext"]) ? $veri["kirageneltext"] : "" ?>">
                        <select name="plakaList" id="plakaList" class="form-control">
                            <option value="tumu">Tüm Araçlar</option>
                            <?php 
                                if(isset($veri["araclar"])) :
                                    foreach ($veri["araclar"] as $key => $value) :
                                        ?>
                                            <option value="<?php echo $value[0]; ?>"><?php echo $value[0] ?></option>
                                        <?php
                                    endforeach;
                                endif;
                            ?>
                        </select>
                        <select name="dateRangeList" id="dateRangeList" class="form-control">
                            <?php 
                                $arrayKey = [0, 3, 7, 15, 30];
                                $array = ["Tarihi Geçmiş Olanlar", "Son 3 Günü Kalanlar", "Son 7 Günü Kalanlar", "Son 15 Günü Kalanlar", "Son 30 Günü Kalanlar"];
                                for ($i=0; $i < count($array); $i++) :
                                    ?>
                                        <option value="<?php echo $arrayKey[$i]; ?>"><?php echo $array[$i] ?></option>
                                    <?php
                                endfor;
                            ?>
                        </select>
                        <select name="dateCriterionList" id="dateCriterionList" class="form-control">
                            <?php 
                                $arrayKey = ["tumu", "trafik_bitis", "kasko_bitis", "ceza_son_odeme", "kira_soz_bitis"];
                                $array = ["Tüm Tarihler", "Sigorta Bitiş Tarihi", "Araç Kaskosu Bitiş Tarihi", "Trafik Cezası Son Ödeme Tarihi", "Kira Sözleşme Bitiş Tarihi"];
                                for ($i=0; $i < count($array); $i++) :
                                    ?>
                                        <option value="<?php echo $arrayKey[$i]; ?>"><?php echo $array[$i] ?></option>
                                    <?php
                                endfor;
                            ?>
                        </select>   
                    </div>
                    <ul class="list-group list-main hover">
                    </ul>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center mt-3"></ul>
                    </nav>
                </div>
            </div>
            <div class="col-12">
                <div class="d-flex justify-content-around flex-wrap">
                    <div class="mt-4 p-3 kiragelirgrafik">
                        <input type="hidden" id="textValues" value="<?php echo isset($veri["text"]) ? $veri["text"] : "";?>">
                        <div>
                            <div class="h4 mb-3">Aylık Gelir Dağılımı</div>
                            <div class="input-group mb-3">
                                <select name="plakaGraphic" id="plakaGraphic" class="form-control">
                                    <option value="tumu">Tüm Araçlar</option>
                                    <?php 
                                        if(isset($veri["araclar"])) :
                                            foreach ($veri["araclar"] as $key => $value) :
                                                ?>
                                                    <option value="<?php echo $value[0]; ?>"><?php echo $value[0] ?></option>
                                                <?php
                                            endforeach;
                                        endif;
                                    ?>
                                </select>
                                <select name="yilGraphic" id="yilGraphic" class="form-control">
                                    <?php 
                                        $array = ["2023", "2022", "2021", "2020", "2019", "2018","2017", "2016", "2015", "2014", "2013", "2012","2011", "2010", "2009", "2008", "2007", "2006","2005","2004","2002","2001","2000" ];
                                        foreach ($array as $key => $value) :
                                            ?>
                                                <option value="<?php echo $value; ?>"><?php echo $value ?></option>
                                            <?php
                                        endforeach;
                                    ?>
                                </select>
                            </div>
                            <canvas id="myChart1"></canvas>
                            <div class="h5 mt-4 text-center">
                                Toplam : <span id="toplamKira"></span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 p-3 yakittipigrafik">
                        <input type="hidden" id="values" value="<?php echo isset($veri["values"]) ? $veri["values"] : "";?>">
                        <div>
                            <div class="h4 mb-3">Yakıt Tipine Göre Araç Dağılımı</div>
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
                <div  class="d-flex justify-content-around flex-wrap">
                    <div class="mt-4 p-3 kiragelirgrafik">
                        <div>
                            <div class="h4 mb-3">Aylık Katedilen Kilometre Dağılımı</div>
                            <div class="input-group mb-3">
                                <select name="plakaGraphic" id="plakaGraphicKm" class="form-control">
                                    <option value="tumu">Tüm Araçlar</option>
                                    <?php 
                                        if(isset($veri["araclar"])) :
                                            foreach ($veri["araclar"] as $key => $value) :
                                                ?>
                                                    <option value="<?php echo $value[0]; ?>"><?php echo $value[0] ?></option>
                                                <?php
                                            endforeach;
                                        endif;
                                    ?>
                                </select>
                                <select name="yilGraphic" id="yilGraphicKm" class="form-control">
                                    <?php 
                                        $array = ["2023", "2022", "2021", "2020", "2019", "2018","2017", "2016", "2015", "2014", "2013", "2012","2011", "2010", "2009", "2008", "2007", "2006","2005","2004","2002","2001","2000" ];
                                        foreach ($array as $key => $value) :
                                            ?>
                                                <option value="<?php echo $value; ?>"><?php echo $value ?></option>
                                            <?php
                                        endforeach;
                                    ?>
                                </select>
                            </div>
                            <canvas id="myChart2"></canvas>
                            <div class="h5 mt-4 text-center">
                                Toplam : <span id="toplamKM"></span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 p-3 yakittipigrafik">
                        <input type="hidden" id="kiraValues" value="<?php echo isset($veri["kiraValues"]) ? $veri["kiraValues"] : "";?>">
                        <div>
                            <div class="h4 mb-3">Kira Durumuna Göre Araç Dağılımı</div>
                            <canvas id="myChart3"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo URLdesign; ?>/views/design/js/anasayfa.js"></script>
  <?php endif; ?>
</div>
</body>
</html>