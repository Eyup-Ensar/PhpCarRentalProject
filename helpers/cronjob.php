<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once("./mail/src/Exception.php");

require_once("./mail/src/PHPMailer.php");

require_once("./mail/src/SMTP.php");

$sunucu = "localhost";
$kullanici = "root";
$sifre = "";
$database = "abtfilo_rent";

$mhost = "admin";
$musername = "index";
$msifre = "index";
$gondericimail = "index";
$alicimail = "eyupensar.yoruk@gmail.com";
$mport = 465;

try {
    $db = new PDO("mysql:host=$sunucu;dbname=$database", $kullanici, $sifre);
    // Hata Yakalama
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sorgu = $db->prepare("SELECT plaka, kasko_bitis FROM arabalar where DATEDIFF(kasko_bitis, DATE(NOW())) <= 50 && DATEDIFF(kasko_bitis, DATE(NOW())) >= 0;");

    $sorgu->execute();

    $sorgu2 = $db->prepare("SELECT plaka, trafik_bitis FROM arabalar where DATEDIFF(trafik_bitis, DATE(NOW())) <= 50 && DATEDIFF(trafik_bitis, DATE(NOW())) >= 0;");

    $sorgu2->execute();

    $sorgu3 = $db->prepare("SELECT plaka, imm_bitis FROM arabalar where DATEDIFF(imm_bitis, DATE(NOW())) <= 50 && DATEDIFF(imm_bitis, DATE(NOW())) >= 0;");

    $sorgu3->execute();

    $sorgu4 = $db->prepare("SELECT arac, son_odeme_tarihi FROM cezalar where DATEDIFF(son_odeme_tarihi, DATE(NOW())) <= 50 && DATEDIFF(son_odeme_tarihi, DATE(NOW())) >= 0;");

    $sorgu4->execute();

    $sorgu5 = $db->prepare("SELECT arac, sozbit FROM kiralar where DATEDIFF(sozbit, DATE(NOW())) <= 50 && DATEDIFF(sozbit, DATE(NOW())) >= 0;");

    $sorgu5->execute();

    $bugün = new DateTime(date('d.m.Y'));

    foreach ($sorgu->fetchAll() as $key => $value) :
        $fark = $bugün->diff(new DateTime($value[1]))->format('%a');
        if($fark=="15") :
            $mail = new PHPMailer(true);
            try {
                //sunucu ayarlama
                $mail = new PHPMailer(true);
                $mail->SMTPDebug  = SMTP::DEBUG_SERVER;          
                $mail->isSMTP();                                       
                $mail->Host       = $mhost;                     
                $mail->SMTPAuth   = true;                                    
                $mail->Username   = $musername;          
                $mail->Password   = $msifre;            
                $mail->SMTPSecure = 'ssl';                  
                $mail->Port       = $mport;                
                $mail->SetLanguage("tr");                     
                // $mail->SMTPDebug  = 0;                
                $mail->CharSet    ="utf-8";      
                $mail->Encoding = 'base64';   
                //Recipients
                $mail->setFrom($gondericimail, 'ABTFILO');  
                $mail->addAddress($alicimail);            
                //içerik
                $mail->isHTML(true);        
                $mail->Subject = 'Tarih Bildirimleri';
                $mail->Body = $value[0]." plakalı aracın kasko bitiş tarihine".$fark." gün kaldı. Son tarih ".$value[1]."!";
                $mail->send();
                return true;
            } catch (Exception $e) {
                return false;
            }
        elseif($fark=="2"):
            $mail = new PHPMailer(true);
            try {
                //sunucu ayarlama
                $mail = new PHPMailer(true);
                $mail->SMTPDebug  = SMTP::DEBUG_SERVER;          
                $mail->isSMTP();                                       
                $mail->Host       = $mhost;                     
                $mail->SMTPAuth   = true;                                    
                $mail->Username   = $musername;          
                $mail->Password   = $msifre;            
                $mail->SMTPSecure = 'ssl';                  
                $mail->Port       = $mport;                
                $mail->SetLanguage("tr");                     
                // $mail->SMTPDebug  = 0;                
                $mail->CharSet    ="utf-8";      
                $mail->Encoding = 'base64';   
                //Recipients
                $mail->setFrom($gondericimail, 'ABTFILO');  
                $mail->addAddress($alicimail);            
                //içerik
                $mail->isHTML(true);        
                $mail->Subject = 'Tarih Bildirimleri';
                $mail->Body = $value[0]." plakalı aracın kasko bitiş tarihine".$fark." gün kaldı. Son tarih ".$value[1]."!";
                $mail->send();
                return true;
            } catch (Exception $e) {
                return false;
            }
        endif;
    endforeach;

    foreach ($sorgu2->fetchAll() as $key => $value) :
        $fark = $bugün->diff(new DateTime($value[1]))->format('%a');
        if($fark=="15") :
            $mail = new PHPMailer(true);
            try {
                //sunucu ayarlama
                $mail = new PHPMailer(true);
                $mail->SMTPDebug  = SMTP::DEBUG_SERVER;          
                $mail->isSMTP();                                       
                $mail->Host       = $mhost;                     
                $mail->SMTPAuth   = true;                                    
                $mail->Username   = $musername;          
                $mail->Password   = $msifre;            
                $mail->SMTPSecure = 'ssl';                  
                $mail->Port       = $mport;                
                $mail->SetLanguage("tr");                     
                // $mail->SMTPDebug  = 0;                
                $mail->CharSet    ="utf-8";      
                $mail->Encoding = 'base64';   
                //Recipients
                $mail->setFrom($gondericimail, 'ABTFILO');  
                $mail->addAddress($alicimail);            
                //içerik
                $mail->isHTML(true);        
                $mail->Subject = 'Tarih Bildirimleri';
                $mail->Body = $value[0]." plakalı aracın sigorta bitiş tarihine".$fark." gün kaldı. Son tarih ".$value[1]."!";
                $mail->send();
                return true;
            } catch (Exception $e) {
                return false;
            }
        elseif($fark=="2"):
            $mail = new PHPMailer(true);
            try {
                //sunucu ayarlama
                $mail = new PHPMailer(true);
                $mail->SMTPDebug  = SMTP::DEBUG_SERVER;          
                $mail->isSMTP();                                       
                $mail->Host       = $mhost;                     
                $mail->SMTPAuth   = true;                                    
                $mail->Username   = $musername;          
                $mail->Password   = $msifre;            
                $mail->SMTPSecure = 'ssl';                  
                $mail->Port       = $mport;                
                $mail->SetLanguage("tr");                     
                // $mail->SMTPDebug  = 0;                
                $mail->CharSet    ="utf-8";      
                $mail->Encoding = 'base64';   
                //Recipients
                $mail->setFrom($gondericimail, 'ABTFILO');  
                $mail->addAddress($alicimail);            
                //içerik
                $mail->isHTML(true);        
                $mail->Subject = 'Tarih Bildirimleri';
                $mail->Body = $value[0]." plakalı aracın sigorta bitiş tarihine".$fark." gün kaldı. Son tarih ".$value[1]."!";
                $mail->send();
                return true;
            } catch (Exception $e) {
                return false;
            }
        endif;
    endforeach;

    foreach ($sorgu3->fetchAll() as $key => $value) :
        $fark = $bugün->diff(new DateTime($value[1]))->format('%a');
        if($fark=="15") :
            $mail = new PHPMailer(true);
            try {
                //sunucu ayarlama
                $mail = new PHPMailer(true);
                $mail->SMTPDebug  = SMTP::DEBUG_SERVER;          
                $mail->isSMTP();                                       
                $mail->Host       = $mhost;                     
                $mail->SMTPAuth   = true;                                    
                $mail->Username   = $musername;          
                $mail->Password   = $msifre;            
                $mail->SMTPSecure = 'ssl';                  
                $mail->Port       = $mport;                
                $mail->SetLanguage("tr");                     
                // $mail->SMTPDebug  = 0;                
                $mail->CharSet    ="utf-8";      
                $mail->Encoding = 'base64';   
                //Recipients
                $mail->setFrom($gondericimail, 'ABTFILO');  
                $mail->addAddress($alicimail);            
                //içerik
                $mail->isHTML(true);        
                $mail->Subject = 'Tarih Bildirimleri';
                $mail->Body = $value[0]." plakalı aracın imm bitiş tarihine".$fark." gün kaldı. Son tarih ".$value[1]."!";
                $mail->send();
                return true;
            } catch (Exception $e) {
                return false;
            }
        elseif($fark=="2"):
            $mail = new PHPMailer(true);
            try {
                //sunucu ayarlama
                $mail = new PHPMailer(true);
                $mail->SMTPDebug  = SMTP::DEBUG_SERVER;          
                $mail->isSMTP();                                       
                $mail->Host       = $mhost;                     
                $mail->SMTPAuth   = true;                                    
                $mail->Username   = $musername;          
                $mail->Password   = $msifre;            
                $mail->SMTPSecure = 'ssl';                  
                $mail->Port       = $mport;                
                $mail->SetLanguage("tr");                     
                // $mail->SMTPDebug  = 0;                
                $mail->CharSet    ="utf-8";      
                $mail->Encoding = 'base64';   
                //Recipients
                $mail->setFrom($gondericimail, 'ABTFILO');  
                $mail->addAddress($alicimail);            
                //içerik
                $mail->isHTML(true);        
                $mail->Subject = 'Tarih Bildirimleri';
                $mail->Body = $value[0]." plakalı aracın imm bitiş tarihine".$fark." gün kaldı. Son tarih ".$value[1]."!";
                $mail->send();
                return true;
            } catch (Exception $e) {
                return false;
            }
        endif;
    endforeach;

    foreach ($sorgu4->fetchAll() as $key => $value) :
        $fark = $bugün->diff(new DateTime($value[1]))->format('%a');
        if($fark=="15") :
            $mail = new PHPMailer(true);
            try {
                //sunucu ayarlama
                $mail = new PHPMailer(true);
                $mail->SMTPDebug  = SMTP::DEBUG_SERVER;          
                $mail->isSMTP();                                       
                $mail->Host       = $mhost;                     
                $mail->SMTPAuth   = true;                                    
                $mail->Username   = $musername;          
                $mail->Password   = $msifre;            
                $mail->SMTPSecure = 'ssl';                  
                $mail->Port       = $mport;                
                $mail->SetLanguage("tr");                     
                // $mail->SMTPDebug  = 0;                
                $mail->CharSet    ="utf-8";      
                $mail->Encoding = 'base64';   
                //Recipients
                $mail->setFrom($gondericimail, 'ABTFILO');  
                $mail->addAddress($alicimail);            
                //içerik
                $mail->isHTML(true);        
                $mail->Subject = 'Tarih Bildirimleri';
                $mail->Body = $value[0]." plakalı aracın ceza son ödeme tarihine".$fark." gün kaldı. Son tarih ".$value[1]."!";
                $mail->send();
                return true;
            } catch (Exception $e) {
                return false;
            }
        elseif($fark=="2"):
            $mail = new PHPMailer(true);
            try {
                //sunucu ayarlama
                $mail = new PHPMailer(true);
                $mail->SMTPDebug  = SMTP::DEBUG_SERVER;          
                $mail->isSMTP();                                       
                $mail->Host       = $mhost;                     
                $mail->SMTPAuth   = true;                                    
                $mail->Username   = $musername;          
                $mail->Password   = $msifre;            
                $mail->SMTPSecure = 'ssl';                  
                $mail->Port       = $mport;                
                $mail->SetLanguage("tr");                     
                // $mail->SMTPDebug  = 0;                
                $mail->CharSet    ="utf-8";      
                $mail->Encoding = 'base64';   
                //Recipients
                $mail->setFrom($gondericimail, 'ABTFILO');  
                $mail->addAddress($alicimail);            
                //içerik
                $mail->isHTML(true);        
                $mail->Subject = 'Tarih Bildirimleri';
                $mail->Body = $value[0]." plakalı aracın ceza son ödeme tarihine".$fark." gün kaldı. Son tarih ".$value[1]."!";
                $mail->send();
                return true;
            } catch (Exception $e) {
                return false;
            }
        endif;
    endforeach;

    foreach ($sorgu5->fetchAll() as $key => $value) :
        $fark = $bugün->diff(new DateTime($value[1]))->format('%a');
        if($fark=="12") :
            $mail = new PHPMailer(true);
            try {
                //sunucu ayarlama
                $mail = new PHPMailer(true);
                $mail->SMTPDebug  = SMTP::DEBUG_SERVER;          
                $mail->isSMTP();                                       
                $mail->Host       = $mhost;                     
                $mail->SMTPAuth   = true;                                    
                $mail->Username   = $musername;          
                $mail->Password   = $msifre;            
                $mail->SMTPSecure = 'ssl';                  
                $mail->Port       = $mport;                
                $mail->SetLanguage("tr");                     
                // $mail->SMTPDebug  = 0;                
                $mail->CharSet    ="utf-8";      
                $mail->Encoding = 'base64';   
                //Recipients
                $mail->setFrom($gondericimail, 'ABTFILO');  
                $mail->addAddress($alicimail);            
                //içerik
                $mail->isHTML(true);        
                $mail->Subject = 'Tarih Bildirimleri';
                $mail->Body = $value[0]." plakalı aracın kira sözleşme bitiş tarihine".$fark." gün kaldı. Son tarih ".$value[1]."!";
                $mail->send();
                return true;
            } catch (Exception $e) {
                return false;
            }
        elseif($fark=="5"):
            $mail = new PHPMailer(true);
            try {
                //sunucu ayarlama
                $mail = new PHPMailer(true);
                $mail->SMTPDebug  = SMTP::DEBUG_SERVER;          
                $mail->isSMTP();                                       
                $mail->Host       = $mhost;                     
                $mail->SMTPAuth   = true;                                    
                $mail->Username   = $musername;          
                $mail->Password   = $msifre;            
                $mail->SMTPSecure = 'ssl';                  
                $mail->Port       = $mport;                
                $mail->SetLanguage("tr");                     
                // $mail->SMTPDebug  = 0;                
                $mail->CharSet    ="utf-8";      
                $mail->Encoding = 'base64';   
                //Recipients
                $mail->setFrom($gondericimail, 'ABTFILO');  
                $mail->addAddress($alicimail);            
                //içerik
                $mail->isHTML(true);        
                $mail->Subject = 'Tarih Bildirimleri';
                $mail->Body = $value[0]." plakalı aracın kira sözleşme bitiş tarihine".$fark." gün kaldı. Son tarih ".$value[1]."!";
                $mail->send();
                return true;
            } catch (Exception $e) {
                return false;
            }
        endif;
    endforeach;

    $db = $sorgu = $sorgu2 = $sorgu3 = $sorgu4 = $sorgu5 = null;

} catch(PDOException $e) {
  echo "Bağlantı Hatası: " . $e->getMessage();
}