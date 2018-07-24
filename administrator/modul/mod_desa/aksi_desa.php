<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
include "../../../configurasi/koneksi.php";
include "../../../configurasi/fungsi_thumb.php";
include "../../../configurasi/library.php";

$module=$_GET['module'];
$act=$_GET['act'];
// Input admin
if ($module=='desa' AND $act=='input_desa'){
    mysql_query("INSERT INTO desa(nama_desa,
                                 kecamatan,
                                 kabupaten,
                                 provinsi)
                         VALUES('$_POST[nama_desa]',
                                '$_POST[kecamatan]',
                                '$_POST[kabupaten]',
                                '$_POST[provinsi]')");
    $cek = mysql_query("SELECT * FROM desa WHERE nama_desa LIKE '%$_POST[nama_desa]%'");
    $r = mysql_fetch_array($cek);
    $id = $r['id_desa'];
    header('location:../../media_admin.php?module=saw&act=editklasifikasi&id='.$id);
}elseif ($module=='desa' AND $act=='update_desa'){
      mysql_query("UPDATE desa SET
                        
                                  nama_desa    = '$_POST[nama]',
                                  kecamatan          = '$_POST[kecamatan]',
                                  kabupaten          = '$_POST[kabupaten]',
                                  provinsi          = '$_POST[provinsi]'
                           WHERE  id_desa        = '$_POST[id]'");
     header('location:../../media_admin.php?module=saw&act=editklasifikasi&id='.$_POST['id']);
  
}elseif ($module=='desa' AND $act=='hapus'){
  mysql_query("DELETE FROM desa WHERE id_desa = '$_GET[id]'");
  mysql_query("DELETE FROM tbl_klasifikasi WHERE id_desa = '$_GET[id]'");
  header('location:../../media_admin.php?module='.$module);
}elseif ($module=='desa' AND $act=='update_profil_desa'){
  $lokasi_file    = $_FILES['fupload']['tmp_name'];
  $tipe_file      = $_FILES['fupload']['type'];
  $nama_file      = $_FILES['fupload']['name'];
  $direktori_file = "../../../foto_desa/$nama_file";

  $tgl_lahir=$_POST[thn].'-'.$_POST[bln].'-'.$_POST[tgl];

  $cek_nim = mysql_query("SELECT * FROM desa WHERE id_desa = '$_POST[id]'");
  $ketemu=mysql_fetch_array($cek_nim);

  if($_POST['nim']==$ketemu['nim']){

   //apabila foto tidak diubah
  if (empty($lokasi_file)){
      mysql_query("UPDATE desa SET
                                  nama_desa    = '$_POST[nama]',                                  
                                  alamat          = '$_POST[alamat]'
                           WHERE  id_desa        = '$_POST[id]'");

  }
  //apabila foto diubah
  elseif(!empty($lokasi_file)){
      if (file_exists($direktori_file)){
            echo "<script>window.alert('Nama file gambar sudah ada, mohon diganti dulu');
            window.location=(href='../../../media.php?module=desa&act=detailprofildesa&id=$_SESSION[iddesa]')</script>";
         }else{
            if($tipe_file != "image/jpeg" AND
               $tipe_file != "image/jpg"){
                     echo "<script>window.alert('Tipe File tidak di ijinkan.');
                     window.location=(href='../../../media.php?module=desa&act=detailprofildesa&id=$_SESSION[iddesa]')</script>";
            }else{
            $cek = mysql_query("SELECT * FROM desa WHERE id_desa = '$_POST[id]'");
            $r = mysql_fetch_array($cek);

            if(!empty($r[foto])){
            $img = "../../../foto_desa/$r[foto]";
            unlink($img);
            $img2 = "../../../foto_desa/medium_$r[foto]";
            unlink($img2);
            $img3 = "../../../foto_desa/small_$r[foto]";
            unlink($img3);

            UploadImage_desa($nama_file);
            mysql_query("UPDATE desa SET
                                  nama_desa     = '$_POST[nama]',                                  
                                  alamat           = '$_POST[alamat]',
                                  foto             = '$nama_file'
                           WHERE  id_desa         = '$_POST[id]'");
            }else{
                UploadImage_desa($nama_file);
                mysql_query("UPDATE desa SET
                                  nama_desa     = '$_POST[nama]',                                  
                                  alamat           = '$_POST[alamat]',
                                  foto             = '$nama_file'
                           WHERE  id_desa         = '$_POST[id]'");
            }
         }
         }
  }
  header('location:../../../media.php?module=desa&act=detailprofildesa&id='.$_SESSION[iddesa]);
  }
  elseif($_POST['nim']!= $ketemu['nim']){
      $cek_nim = mysql_query("SELECT * FROM desa WHERE nim = '$_POST[nim]'");
      $c = mysql_num_rows($cek_nim);
      //apabila nim tersedia
      if(empty($c)){
          //apabila foto tidak diubah
  if (empty($lokasi_file)){
      mysql_query("UPDATE desa SET
                                  nama_desa    = '$_POST[nama]',                                  
                                  alamat          = '$_POST[alamat]'
                           WHERE  id_desa        = '$_POST[id]'");

  }
  //apabila foto diubah
  elseif(!empty($lokasi_file)){
      if (file_exists($direktori_file)){
            echo "<script>window.alert('Nama file gambar sudah ada, mohon diganti dulu');
            window.location=(href='../../../media.php?module=desa&act=detailprofildesa&id=$_SESSION[iddesa]')</script>";
         }else{
            if($tipe_file != "image/jpeg" AND
               $tipe_file != "image/jpg"){
                     echo "<script>window.alert('Tipe File tidak di ijinkan.');
                     window.location=(href='../../../media.php?module=desa&act=detailprofildesa&id=$_SESSION[iddesa]')</script>";
            }else{
            $cek = mysql_query("SELECT * FROM desa WHERE id_desa = '$_POST[id]'");
            $r = mysql_fetch_array($cek);

            if(!empty($r[foto])){
            $img = "../../../foto_desa/$r[foto]";
            unlink($img);
            $img2 = "../../../foto_desa/medium_$r[foto]";
            unlink($img2);
            $img3 = "../../../foto_desa/small_$r[foto]";
            unlink($img3);

            UploadImage_desa($nama_file);
            mysql_query("UPDATE desa SET
                                  nama_desa     = '$_POST[nama]',                                  
                                  alamat           = '$_POST[alamat]',
                                  foto             = '$nama_file'
                           WHERE  id_desa         = '$_POST[id]'");
            }else{
                UploadImage_desa($nama_file);
                mysql_query("UPDATE desa SET
                                  nama_desa     = '$_POST[nama]',                                  
                                  alamat           = '$_POST[alamat]',
                                  foto             = '$nama_file'
                           WHERE  id_desa         = '$_POST[id]'");
            }
         }
         }
  }
  header('location:../../../media.php?module=desa&act=detailprofildesa&id='.$_SESSION[iddesa]);
    }
      else{
        echo "<script>window.alert('nim sudah pernah digunakan.');
        window.location=(href='../../../media.php?module=desa&act=detailprofildesa&id=$_SESSION[iddesa]')</script>";
      }
  }
}elseif ($module=='desa' AND $act=='update_account_desa'){
    //jika username dan password tidak diubah
    if (empty($_POST[username]) AND empty($_POST[password])){
        header('location:../../../media.php?module=desa&act=detailaccount');
    }
    //jika username diubah dan pasword tidak diubah
    elseif (!empty($_POST[username]) AND empty($_POST[password])){
        $username = mysql_query("SELECT * FROM desa WHERE id_desa = '$_SESSION[iddesa]'");
        $data_username = mysql_fetch_array($username);
           
        //jika username sama dengan username yang ada di datbase
        if ($_POST[username] == $data_username[username_login]){
        mysql_query("UPDATE desa SET username_login = '$_POST[username]'
                                  WHERE id_desa     = '$_SESSION[iddesa]'");

        echo "<script>window.alert('Username berhasil diubah');
                    window.location=(href='../../../media.php?module=home')</script>";
        }
        //jika username tidak sama username di database
        elseif ($_POST[username] != $data_username[username_login]){
            $username2 = mysql_query("SELECT * FROM desa WHERE username_login = '$_POST[username]'");
            $data_username2 = mysql_num_rows($username2);
            //jika username tersedia
            if (empty($data_username2)){
                mysql_query("UPDATE desa SET username_login = '$_POST[username]'
                                  WHERE id_desa     = '$_SESSION[iddesa]'");

                echo "<script>window.alert('Username berhasil diubah');
                              window.location=(href='../../../media.php?module=home')</script>";
            }
            //jika username tiak tersedia
            else{
                echo "<script>window.alert('Username sudah digunakan mohon diganti');
                              window.location=(href='../../../media.php?module=desa&act=detailaccount')</script>";
            }
        }
    }
    //jika username tidak di ubah dan pasword di ubah
    elseif (empty($_POST[username]) AND !empty($_POST[password])){
        $pass = md5($_POST[password]);
        mysql_query("UPDATE desa SET password_login = '$pass'
                                  WHERE id_desa     = '$_SESSION[iddesa]'");

        echo "<script>window.alert('Password berhasil diubah');
                    window.location=(href='../../../media.php?module=home')</script>";
    }
    //jika username di ubah dan password di ubah
    elseif (!empty($_POST[username]) AND !empty($_POST[password])){
        $username = mysql_query("SELECT * FROM desa WHERE username_login = '$_POST[username]'");
        $data_username = mysql_fetch_array($username);
        //jika username sama dengan di database
        if ($_POST[username] == $data_username[username_login]){
        $pass = md5($_POST[password]);
        mysql_query("UPDATE desa SET username_login = '$_POST[username]',
                                      password_login = '$pass'
                                  WHERE id_desa     = '$_SESSION[iddesa]'");

        echo "<script>window.alert('Username & Password berhasil diubah');
                    window.location=(href='../../../media.php?module=home')</script>";
        }
        //jika username tidak sama dengan username di database
        elseif ($_POST[username] != $data_username[username_login]){
            $username2 = mysql_query("SELECT * FROM desa WHERE username_login = '$_POST[username]'");
            $data_username2 = mysql_num_rows($username2);
            //jika username tersedia
            if (empty($data_username2)){
                $pass = md5($_POST[password]);
                mysql_query("UPDATE desa SET username_login = '$_POST[username]',
                                      password_login = '$pass'
                                  WHERE id_desa     = '$_SESSION[iddesa]'");

                echo "<script>window.alert('Username & Password berhasil diubah');
                                window.location=(href='../../../media.php?module=home')</script>";
            }
            //jika username tidak tersedia
            else{
                echo "<script>window.alert('Username sudah digunakan mohon diganti');
                              window.location=(href='../../../media.php?module=desa&act=detailaccount')</script>";
            }
        }
    }
}
}
?>
