<?php
ob_start();
session_start();
include 'baglan.php';
if(isset($_POST['kayit'])){
    $username=$_POST['username'];
    $password=$_POST['password'];
    $password_agein=$_POST['password_again'];
    if(!$username){
        echo "lütfen kullanıcı adınızı girin";
        
    }elseif(!$password || !$password_agein){
        echo "lütfen şifreniz girin";
    }elseif($password !=$password_agein){
        echo "lütfen girdiğiniz şifreler uyuşmuyor";
    }
    else{
        $sorgu =$db->prepare('INSERT INTO users SET user_name=?,user_password=?');
        $ekle=$sorgu->execute([
            $username,$password
        ]);
        if($ekle){
            echo "kayıt başarıyla eklendi";
            header('Refresh:2; index.php');
        }
        else{
            echo "bir hata oluştu tekrar kontrol edin";
        }
    }
}
if(isset($_POST['giris'])){
    $username=$_POST['username'];
    $password=$_POST['password'];
    if(!$username){
        echo "kullanıcı adınızı giriniz";

    }
    elseif(!$password){
        echo "şifrenizi girin";
    }
    else{
        $kullanici_sor=$db->prepare('SELECT * FROM users WHERE user_name=? || user_password=?');
        $kullanici_sor->execute([
            $username,$password
        ]);
         $say=$kullanici_sor->rowCount();
         if($say==1){
            $kullanici=$kullanici_sor->fetch(PDO::FETCH_ASSOC);
            if($kullanici['user_name'] == $username && $kullanici['user_password'] == $password){
                $_SESSION['username']=$username;
                echo "başarıyla giriş yaptınız";
                header('Refresh:2; index.php');
            }
            else{
                echo "kullanıcı adı veya şifre yanlış";
            }
        }
        else{
            echo "kullanıcı adı veya şifre yanlış";
        }
        
    }
}
?>