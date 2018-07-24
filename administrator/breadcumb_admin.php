<?php
include "../configurasi/koneksi.php";

if ($_GET['module']=='home'){
  if ($_SESSION['leveluser']=='admin'){
      echo "<span class='judulhead'><b>Selamat Datang Admin</b></span>";
  }
  elseif ($_SESSION['leveluser']=='pengajar'){
      echo "<span class='judulhead'><b>Selamat Datang Pengajar</b></span>";
  }
}
elseif ($_GET['module']=='modul'){
      echo "<span class='judulhead'><b>Manajeman Modul</b></span>";
  }
elseif ($_GET['module']=='admin'){
      echo "<span class='judulhead'><b>Manajeman Admin</b></span>";
  }
elseif ($_GET['module']=='desa'){
      echo "<span class='judulhead'><b>Manajeman Desa</b></span>";
  }
elseif ($_GET['module']=='saw'){
      echo "<span class='judulhead'><b>Manajeman SAW</b></span>";
  }
elseif ($_GET['module']=='materi'){
      echo "<span class='judulhead'><b>Manajeman Materi</b></span>";
  }
elseif ($_GET['module']=='templates'){
      echo "<span class='judulhead'><b>Manajeman Template</b></span>";
  }
elseif($_GET['module']=='detaildesa'){
        $desa = mysql_query("SELECT * FROM desa WHERE id_desa = '$_GET[id]'");
        $s=mysql_fetch_array($desa);
	echo "<span class='judulhead'><b>Manajeman Desa &#187; Detail Desa &#187; $s[nama_desa]</b></span>";
}

elseif($_GET['module']=='daftardesa'){
        $desa = mysql_query("SELECT * FROM desa WHERE id_kelas = '$_GET[id]'");
        $s=mysql_fetch_array($desa);
	echo "<span class='judulhead'><b>Manajeman Desa &#187; Daftar Desa</b></span>";
}
?>
