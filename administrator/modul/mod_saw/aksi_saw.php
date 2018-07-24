<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
include "../../../configurasi/koneksi.php";

$module=$_GET['module'];
$act=$_GET['act'];

// Input mapel
if ($module=='saw' AND $act=='input_saw'){
    mysql_query("INSERT INTO tbl_kriteria(kriteria,
                                 bobot
								 )
	                       VALUES('$_POST[nm_kriteria]',
                                '$_POST[bobot]')");
  header('location:../../media_admin.php?module='.$module);
}


if ($module=='saw' AND $act=='input_himpunan'){
    mysql_query("INSERT INTO tbl_himpunankriteria(id_kriteria,nama,keterangan, 
                                 nilai
								 )
	                       VALUES(
								'$_POST[id_kriteria]',
								'$_POST[nama]',
								'$_POST[ket]',
                                '$_POST[nilai]')");
  header('location:../../media_admin.php?module='.$module.'&act=listhimpunankriteria&id='.$_POST['id_kriteria']);
}



elseif ($module=='saw' AND $act=='update_saw'){
   mysql_query("UPDATE tbl_kriteria SET kriteria  = '$_POST[nm_kriteria]',
                                          bobot   = '$_POST[bobot]' WHERE id='$_POST[id]'");
  header('location:../../media_admin.php?module='.$module);
}



elseif ($module=='saw' AND $act=='update_himpunan'){
   mysql_query("UPDATE tbl_himpunankriteria SET nama  = '$_POST[nama]',keterangan  = '$_POST[ket]',  
											nilai   = '$_POST[nilai]' WHERE id_hk='$_POST[id_hk]'");
  header('location:../../media_admin.php?module='.$module.'&act=listhimpunankriteria&id='.$_POST['id_kriteria']);
}




elseif ($module=='saw' AND $act=='hapus'){
  mysql_query("DELETE FROM tbl_kriteria WHERE id = '$_GET[id]'");
  mysql_query("DELETE FROM tbl_himpunankriteria WHERE id_kriteria = '$_GET[id]'");
  header('location:../../media_admin.php?module='.$module);
}

elseif ($module=='saw' AND $act=='hapus_himpunan'){
  mysql_query("DELETE FROM tbl_himpunankriteria WHERE id_hk = '$_GET[id]'");
  
  header('location:../../media_admin.php?module='.$module.'&act=listhimpunankriteria&id='.$_GET['id_kriteria']);
}

elseif ($module=='saw' AND $act=='input_klasifikasi'){
  
  $jumkriteria = $_POST['jumkriteria'];
  echo $jumkriteria;
  
 $cek = mysql_query("SELECT * FROM tbl_klasifikasi WHERE id_desa='$_POST[id]'");
 $row = mysql_num_rows($cek);
  if($row == 0){
	  for ($i=1; $i<=$jumkriteria; $i++)
		{
			$idhk = $_POST['id_hk'.$i];
			//$idhk = $_POST['idhk'.$i];
			
			echo $idhk.'<br>';
			
			mysql_query("INSERT INTO tbl_klasifikasi(id_desa,
	                                 id_hk
									 )
		                       VALUES('$_POST[id]',
	                                '$idhk'
									 )");	
		}
  }else{
  	mysql_query("DELETE FROM tbl_klasifikasi WHERE id_desa = '$_POST[id]'");
  	for ($i=1; $i<=$jumkriteria; $i++)
		{
			$idhk = $_POST['id_hk'.$i];
			//$idhk = $_POST['idhk'.$i];
			
			echo $idhk.'<br>';
			
			mysql_query("INSERT INTO tbl_klasifikasi(id_desa,
	                                 id_hk
									 )
		                       VALUES('$_POST[id]',
	                                '$idhk'
									 )");	
		}
  }
  $tampil_klasifikasi = mysql_query("SELECT * FROM tbl_klasifikasi GROUP by id_desa");
  while ($r=mysql_fetch_array($tampil_klasifikasi)){
  	$h = mysql_fetch_array(mysql_query("SELECT * FROM desa WHERE id_desa ='$r[id_desa]'"));
  	$klasifikasi = mysql_query("SELECT * FROM v_analisa WHERE id_desa = '$r[id_desa]'");
  	$totalnilai = 0;
  	while ($n=mysql_fetch_array($klasifikasi)){
  		$crmax = mysql_fetch_array(mysql_query("SELECT max(nilai) as nilaimax FROM v_analisa WHERE id_kriteria='$n[id_kriteria]'"));
  		$himpunankriteria = mysql_fetch_array(mysql_query("SELECT * FROM tbl_himpunankriteria WHERE id_hk ='$n[id_hk]'"));
  		$bobot = mysql_fetch_array(mysql_query("SELECT * FROM tbl_kriteria WHERE id = '$n[id_kriteria]'"));
  	
    //	 mencari nilai himpunan kriteria kemudian di bagi dengan jumlah max dari seluruh nilai himpunan
      $nilaiok = $himpunankriteria['nilai'] / $crmax['nilaimax'];
  		
      //hasil dari matrik himpunan kriteria di kalikan dengan bobot nilai kriteria
      $rank = $nilaiok * $bobot['bobot'];									
  		//hasil perkalian dengan bobot kriteria di jumlahkan dan di urutkan
      $totalnilai = $totalnilai + $rank;	
  	}
    //tahun otomatis
  	$thn = date("Y");
  	$cek = mysql_query("SELECT * FROM hasil WHERE nama_desa LIKE '%$h[nama_desa]%' AND  tahun=$thn");
  	$row = mysql_num_rows($cek);
  	if($row == 0){
  		mysql_query("INSERT INTO hasil(id_desa,
  			nama_desa,
  			kecamatan,
  			tahun,
  			nilai
  		)
  		VALUES('$h[id_desa]',
  		'$h[nama_desa]',
  		'$h[kecamatan]',
  		'$thn',
  		'$totalnilai'
  	)");
  	}else{
  		mysql_query("DELETE FROM hasil WHERE nama_desa LIKE '%$h[nama_desa]%' AND tahun =$thn");
  		mysql_query("INSERT INTO hasil(id_desa,
  			nama_desa,
  			kecamatan,
  			tahun,
  			nilai
  		)
  		VALUES('$h[id_desa]',
  		'$h[nama_desa]',
  		'$h[kecamatan]',
  		'$thn',
  		'$totalnilai'
  	)");
  	}
  }
  header('location:../../media_admin.php?module='.$module.'&act=klasifikasi');
}

elseif($module=='saw' AND $act=='input_ujian'){
		
		mysql_query("INSERT INTO jadwalujian(
								 kodematkul,
                                 tglujian,
								 jenis,
                                 tingkat
								 )
	                       VALUES(
								'$_POST[kodematkul]',
                                '$_POST[tglujian]',
								'$_POST[jenis]',
                                '$_POST[tingkat]')");
  header('location:../../media_admin.php?module='.$module.'&act=jadwalujian');

}elseif($module=='saw' AND $act=='hapusujian'){
	 mysql_query("DELETE FROM jadwalujian WHERE id_jadwalujian = '$_GET[id]'");
	 header('location:../../media_admin.php?module='.$module.'&act=jadwalujian');
}elseif($module=='saw' AND $act=='editujian'){
	 mysql_query("UPDATE jadwalujian SET tglujian='$_POST[tglujian]' WHERE id_jadwalujian = '$_POST[id]'");
	 header('location:../../media_admin.php?module='.$module.'&act=jadwalujian');

}
}
?>
