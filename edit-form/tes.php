<?php
// mengkoneksi database
$host = "localhost"; //Host yang dipakai
$username = "root"; // Nama Pengguna
$password = ""; // Kata Sandi
$database = "tutor_edit"; // Nama database

// fungsi konek database
mysql_connect($host, $username, $password) or die ('FS: Error pada user SQL');
mysql_select_db($database) or die ('Tidak dapat memilih database');

//fungsi filter sql injection
function cek($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = strip_tags($data);
    $data = mysql_real_escape_string($data);
    //$data = htmlentities($data);
    //$data = htmlspecialchars($data);
    return $data;
}

//memulai session
session_start();
//menemukan parameter id
//fungsi anti sql injection
$id = abs((int)isset($_GET['id'])? $_GET['id'] : '');

//jika id ada
if($id){
    //jika persyaratan terpenuhi
	if(isset($_POST['kirim'])&&isset($_POST['token'])&&isset($_SESSION['token'])&&
 	$_POST['token'] == $_SESSION['token']){
 	$judul = isset($_POST['judul']) ? cek($_POST['judul']) : '';
 	$isi = isset($_POST['isi']) ? cek($_POST['isi']) : '';	
 	 mysql_query("UPDATE `pesan` SET
                    `judul` = '$judul',
                    `isi` = '" . $isi . "',
                    `tgl` = '" . time() . "'
                    WHERE `id` = '$id'
                ");	
 	echo 'Berhasil';
	}elseif(isset($_POST['token'])&&isset($_SESSION['token'])&&$_POST['token'] !== $_SESSION['token']){
        //akan menampilkan error
        //jika post token tidak sama dengan session token
        echo 'Error';
    }else{
		$req = mysql_query("SELECT * FROM `pesan` WHERE `id` = '$id'");
        $res = mysql_fetch_assoc($req);
        //random token
		$token = mt_rand(1000, 100000);
        //set random token di session
        $_SESSION['token'] = $token;

        echo'<form name="form" method="POST" action="'. $_SERVER['PHP_SELF'].'?id='.$id.'">
        <input type="text" name="judul" value="' . $res['judul'] . '"/><br/>
        <textarea name="isi">'. $res['isi'] .'</textarea><br/>
        <input type="submit" name="kirim" value="kirim">
        <input type="hidden" name="token" value="' . $token . '"/>
        </form>';
	}
}else{
    echo'this is end';
}

?>
