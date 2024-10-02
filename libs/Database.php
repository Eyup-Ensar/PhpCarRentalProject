<?php

    class Database extends PDO {

        protected $dizi;

        protected $Gdizi;

        function __construct () {
            
            // parent:: __construct("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET."", DB_USER, DB_PASS);
            
            $dsn = "mysql:dbname=".DB_NAME.";host=".DB_HOST;
            
            parent:: __construct($dsn, DB_USER, DB_PASS);

            $this->bilgi = new Bilgi();
             
        }

        function Ekle ($tabload, $sutunadlari, $veriler) {

            $this->dizi = "";

            $sutunsayisi = count($sutunadlari);

            for($i=0; $i<$sutunsayisi; $i++):

                $this->dizi .= "?,";

            endfor;

            $values = rtrim($this->dizi, ",");

            $sutunadlari = join(",", $sutunadlari);

            $sorgu = $this->prepare("insert into ".$tabload." (".$sutunadlari.") VALUES(".$values.")");

            if($sorgu->execute($veriler)):

                return 1;

            else:

                return 0;

            endif;

        }

        function TopluEkle ($tabload, $sutunadlari, $veriler) {

            $sutunadlari = join(",", $sutunadlari);

            $sorgu = $this->prepare("insert into ".$tabload." (".$sutunadlari.") VALUES ".$veriler);


            if($sorgu->execute()):

                return true;

            else:

                return false;

            endif;

        }

        function Listele ($tabload, $kosul=false) {

            if($kosul):

                $sorgu = $this->prepare("SELECT * FROM ".$tabload." ".$kosul);

                // echo "SELECT * FROM ".$tabload." ".$kosul;

            else:

                $sorgu = $this->prepare("SELECT * FROM ".$tabload);

            endif;

            $sorgu->execute();

            return $sorgu->fetchAll();

        }

        function Sil ($tabload, $kosul) {

            $sorgu = $this->prepare("DELETE FROM ".$tabload." where ".$kosul);

            if($sorgu->execute()):

                return true;

            else:

                return false;

            endif;

        }

        function Guncelle ($tabload, $kosul) {

            $sorgu = $this->prepare("SELECT * FROM ".$tabload." where ".$kosul);

            $sorgu->execute();

            return $sorgu->fetchAll();

        }

        function GuncelSon ($tabload, $sutunadlari, $veriler, $kosul) {

            $this->dizi = "";

            $sutunsayisi = count($sutunadlari);

            for($i=0; $i<$sutunsayisi; $i++):

                $this->dizi .= $sutunadlari[$i]."=?,";

            endfor;

            $values = rtrim($this->dizi, ",");

            $sorgu = $this->prepare("UPDATE ".$tabload." SET ".$values." where ".$kosul);

            $sorgu->execute($veriler);

            return $sorgu->rowCount()>0 ? true : false;

        }

        function BasitGuncelle ($tabload, $veriler, $kosul) {

            $sorgu = $this->prepare("UPDATE ".$tabload." SET ".$veriler." WHERE ".$kosul);

            $sorgu->execute();

            return $sorgu->rowCount()>0 ? true : false;

        }

        function topluGuncelle ($tabload, $sorgum) {

            $sayac = 0;

            for ($i=0; $i<count($sorgum); $i++) :

                $sorgu = $this->prepare("UPDATE ".$tabload." SET ".$sorgum[$i]);
                
                $sorgu->execute();

                if($sorgu->rowCount()>0):

                    $sayac++;
    
                endif;

            endfor;

            return $sayac==0 ? false : true;

        }

        function Arama ($tabload, $kosul) {

            $sorgu = $this->prepare("SELECT * FROM ".$tabload." ".$kosul);

            $sorgu->execute();

            return $sorgu->fetchAll();

        }

        function GelismisArama ($getir, $tabload, $kosul) {

            $sorgu = $this->prepare("SELECT ".$getir." FROM ".$tabload." ".$kosul);

            $sorgu->execute();

            return $sorgu->fetchAll();

        }

        function TabloSecListele ($getir, $tabload, $kosul) {

            $sorgu = $this->prepare("SELECT ".$getir." FROM ".$tabload." ".$kosul);

            $sorgu->execute();

            return $sorgu->fetchAll();

        }

        function TabloBirlestirListele ($getir, $tabload1, $tabload2, $kosul) {

            $sorgu = $this->prepare("SELECT ".$getir." FROM ".$tabload1.", ".$tabload2." ".$kosul);

            $sorgu->execute();

            return $sorgu->fetchAll();

        }

        function CokluBirlestirListele ($ekozellik=false, $sutungetir, $tabload, $kosul) {

            $Gsutun = "";

            $Gtablo = "";

            foreach($sutungetir as $val):

                $Gsutun .= $val.", ";

            endforeach;

            foreach($tabload as $val):

                $Gtablo .= $val.", ";

            endforeach;
            
            $sutunlar = rtrim($Gsutun, ", ");

            $tablolar = rtrim($Gtablo, ", ");

            $sorgu = $this->prepare("SELECT ".$ekozellik." ".$sutunlar." FROM ".$tablolar." ".$kosul);

            $sorgu->execute();

            return $sorgu->fetchAll();

        }

        function GirisKontrol ($tabload, $kosul) {

            $sorgu = $this->prepare("SELECT * FROM ".$tabload." where ".$kosul);

            $sorgu->execute();
 
            if($sorgu->rowCount()>0):

                return $sorgu->fetchAll();
            
            else:

                return false;

            endif;

        }

        // * özel durum *

        function SiparisTamamla ($veriler = []) {

            $sorgu = $this->prepare("insert into siparisler (siparis_no, adresid, uyeid, urunad, urunadet,
            urunfiyat, toplamfiyat, odemeturu, tarih) VALUES(?,?,?,?,?,?,?,?,?)");

            $sorgu->execute($veriler);

        }

        function StokGuncelle ($veriler = [], $kosul) {

            $sorgu = $this->prepare("UPDATE urunler SET stok = ?, satisadet = ? WHERE ".$kosul);

            $sorgu->execute($veriler);

        }
        
        // * özel durum *

        function SistemBakim ($deger) {

            $sorgu = $this->prepare("SHOW TABLES");

            if($sorgu->execute()):

                $tablolar = $sorgu->fetchAll();

                foreach ($tablolar as  $tabloadi) :

                    $this->query("REPAIR TABLE ".$tabloadi["Tables_in_".$deger]);

                    $this->query("OPTIMIZE TABLE ".$tabloadi["Tables_in_".$deger]);

                endforeach;

                $tarih = date("d.m.Y-H:i");

                $tarihGuncelle = $this->prepare("update ayarlar set bakimTarih = '".$tarih."'");

                $tarihGuncelle->execute();

                return true;
            
            else:

                return false;

            endif;

        }

        function VeriTabaniYedekle ($deger) {

            $tables = array();

            $return = "";

            $sorgu = $this->prepare("SHOW TABLES");

            $durum = $sorgu->execute() ? true : false;

            while ($row = $sorgu->fetch(PDO::FETCH_ASSOC)):

                $tables[] = $row["Tables_in_".$deger];

            endwhile;

            $return .= "SET NAMES utf8;";

            foreach ($tables as $table) :

                $result = $this->prepare("select * from ".$table);

                $result->execute();

                $numColumns = $result->columnCount();

                $return .= "DROP TABLE IF EXISTS '".$table."';";

                $result2 = $this->prepare("SHOW CREATE TABLE ".$table);

                $result2->execute();

                $row2 = $result2->fetch(PDO::FETCH_ASSOC);

                $return .= "\n\n".$row2["Create Table"].";\n\n"; 

                for ($i=0; $i<$numColumns; $i++) :

                    while ($row = $result->fetch(PDO::FETCH_NUM)) :

                        $return .= "INSERT INTO ".$table." VALUES(";
                        
                        for ($j=0; $j<$numColumns; $j++) :

                            $return .= isset($row[$j]) ? '"'.$row[$j].'"' : '""';

                            $return .= ($j < $numColumns-1) ? ', ' : '';

                        endfor;

                        $return .= ");\n";

                    endwhile;

                endfor;

                $return .= "\n\n\n";

            endforeach;

            if($durum) :

                $tarih = date("d.m.Y-H:i");

                $tarihGuncelle = $this->prepare("update ayarlar set yedekTarih = '".$tarih."'");

                $tarihGuncelle->execute();

            endif;

            return array($durum, $return);

        }

        function SayfalamaAdet ($tabload, $kosul=false) {

            if(!$kosul):

                $sorgu = $this->prepare("SELECT COUNT(*) AS toplam FROM ".$tabload);

            else:

                $sorgu = $this->prepare("SELECT COUNT(*) AS toplam FROM ".$tabload." ".$kosul);

            endif;

            $sorgu->execute();

            $son = $sorgu->fetch(PDO::FETCH_ASSOC);

            return $son["toplam"];

        }

    }

?>