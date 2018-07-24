<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href=../css/style.css rel=stylesheet type=text/css>";
  echo "<div class='error msg'>Untuk mengakses Modul anda harus login.</div>";
}
else{

include "../../../configurasi/class_paging.php";

$aksi="modul/mod_desa/aksi_desa.php";
$aksi_desa = "administrator/modul/mod_desa/aksi_desa.php";
switch($_GET[act]){
  // Tampil Siswa
  default:
    if ($_SESSION[leveluser]=='admin' || $_SESSION[leveluser]=='dpl'){
      $tampil_desa = mysql_query("SELECT * FROM desa");
	  ?>
			
			
			<div class="box box-danger box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">Data Desa</h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div><!-- /.box-tools -->
				</div>
				<div class="box-body">
					<a  class ='btn  btn-success btn-flat' href='?module=desa&act=tambahdesa'>Tambah Data </a>
					<br><br><br>
					
					
					<table id="example1" class="table table-bordered table-striped" >
						<thead>
							<tr>
								<th>No</th>
								<th>Nama Desa</th>
								<th>Kecamatan</th>
								<th>Kabupaten</th>
								<th>Provinsi</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
						<?php 
								$no=1;
								while ($r=mysql_fetch_array($tampil_desa)){
									echo "<tr class='warnabaris' >
											<td>$no</td>
											<td>$r[nama_desa]</td>
											<td>$r[kecamatan]</td>
											<td>$r[kabupaten]</td>
											<td>$r[provinsi]</td>
											 <td><a href='?module=desa&act=editdesa&id=$r[id_desa]' title='Edit' class='btn btn-warning btn-xs'>Edit</a> 
											 <a href=javascript:confirmdelete('$aksi?module=desa&act=hapus&id=$r[id_desa]') title='Hapus' class='btn btn-danger btn-xs'>Hapus </a>
											</td>
										</tr>";
								$no++;
								}
						echo "</tbody></table>";
					?>
				</div>
			</div>	
<?php
    
    }
    break;

case "tambahdesa":
    if ($_SESSION[leveluser]=='admin' || $_SESSION[leveluser]=='dpl'){
        $tampil = mysql_query("SELECT * FROM desa WHERE id_desa = '$_GET[id]'");
		if($_GET['message'] =='success'){
			$pesan = "
				<div class='alert alert-success alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <h4><i class='icon fa fa-check'></i> Alert!</h4>
                    Data Berhasil Disimpan !!
                </div>
			
			
			";
		}
        echo "
		  <div class='box box-danger box-solid'>
				<div class='box-header with-border'>
					<h3 class='box-title'>Tambah Data Desa</h3>
					<div class='box-tools pull-right'>
						<button class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-minus'></i></button>
                    </div><!-- /.box-tools -->
				</div>
				<div class='box-body'>
						<form method=POST action='$aksi?module=desa&act=input_desa' enctype='multipart/form-data' class='form-horizontal'>
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Nama Desa</label>        		
									 <div class='col-sm-6'>
										<input type=text name='nama_desa' class='form-control' Placeholder='Nama Desa' required='required'>
									 </div>
							  </div>
							 <div class='form-group'>
									<label class='col-sm-2 control-label'>Kecamatan</label>        		
									 <div class='col-sm-9'>
										<input type=text name='kecamatan' class='form-control' Placeholder='Kecamatan' required='required'>
									 </div>
							  </div>
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Kabupaten</label>        		
									 <div class='col-sm-9'>
										<input type=text name='kabupaten' class='form-control' Placeholder='Kabupaten' required='required'>
									 </div>
							  </div>
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Provinsi</label>        		
									 <div class='col-sm-9'>
										<input type=text name='provinsi' class='form-control' Placeholder='Provinsi' required='required'>
									 </div>
							  </div>
							  <div class='buttons'>
							  <input class='btn btn-primary' type=submit value=Simpan>
							  <input class='btn btn-danger' type=button value=Batal onclick=self.history.back()>
							  </div>
							  </form>
							  
				</div> 
				
			</div>";
					
	}
    break;

  // case "nis_ada":
  //    if ($_SESSION[leveluser]=='admin' ){
  //        echo "<span class='judulhead'><p class='garisbawah'>nis SUDAH PERNAH DIGUNAKAN<br>
  //              <input type=button value=Kembali onclick=self.history.back()></p></span>";
  //    }
  //    break;

  case "editdesa":
    $edit=mysql_query("SELECT * FROM desa WHERE id_desa='$_GET[id]'");
    $r=mysql_fetch_array($edit);
    
	
	$get_kelas = mysql_query("SELECT * FROM kelas WHERE id_kelas = '$r[id_kelas]'");
    $kelas = mysql_fetch_array($get_kelas);

    if ($_SESSION[leveluser]=='admin' || $_SESSION[leveluser]=='dpl'){
		echo "
		  <div class='box box-danger box-solid'>
				<div class='box-header with-border'>
					<h3 class='box-title'>Edit Data Desa</h3>
					<div class='box-tools pull-right'>
						<button class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-minus'></i></button>
                    </div><!-- /.box-tools -->
				</div>
				<div class='box-body'>
						<form method=POST method=POST action=$aksi?module=desa&act=update_desa  enctype='multipart/form-data' class='form-horizontal'>
							  <input type=hidden name=id value='$r[id_desa]'>
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Nama Lengkap</label>        		
									 <div class='col-sm-6'>
										<input type=text name='nama' class='form-control'  value='$r[nama_desa]'>
									 </div>
							  </div>
							  
							 <div class='form-group'>
									<label class='col-sm-2 control-label'>Kecamatan</label>        		
									 <div class='col-sm-9'>
										<input type=text name='kecamatan' class='form-control' Placeholder='Nama Kecamatan' value='$r[kecamatan]'>
									 </div>
							  </div>
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Kabupaten</label>        		
									 <div class='col-sm-9'>
										<input type=text name='kabupaten' class='form-control' Placeholder='Nama Kabupaten' value='$r[kabupaten]'>
									 </div>
							  </div>
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Provinsi</label>        		
									 <div class='col-sm-9'>
										<input type=text name='provinsi' class='form-control' Placeholder='Nama Provinsi' value='$r[provinsi]'>
									 </div>
							  </div>
							  <div class='buttons'>
							  <input class='btn btn-primary' type=submit value=Simpan>
							  <input class='btn btn-danger' type=button value=Batal onclick=self.history.back()>
							  </div>
							  </form>
							  
				</div> 
				
			</div>";	
    }
    elseif ($_SESSION[leveluser]=='desa' ) {
     echo"<br><b class='judul'>Edit Profil</b><br><p class='garisbawah'></p>";
     echo"<form method=POST action=$aksi_desa?module=desa&act=update_profil_desa enctype='multipart/form-data'>
          <input type=hidden name=id value='$r[id_desa]'>
          <table>
          <tr><td>Nama</td>     <td> : <input type=text name='nama' value='$r[nama_desa]' size=40></td></tr>          
          <tr><td>Alamat</td>       <td> : <input type=text name='alamat' size=80 value='$r[alamat]'></td></tr>
          <tr><td>Foto</td>   <td> : ";
            if ($r[foto]!=''){
              echo "<img src='foto_desa/medium_$r[foto]'>";
          }echo "</td></tr>
          <tr><td>Ganti Foto</td>       <td> : <input type=file name='fupload' size=40>
                                           <br>**) Tipe foto harus JPG/JPEG dan ukuran lebar maks: 400 px<br>
                                                ***) Apabila foto tidak diganti, dikosongkan saja</td></tr>
          <tr><td colspan=2><input type=submit class='tombol' value='Update'>
                            <input type=button class='tombol' value='Batal'
                            onclick=self.history.back()>
                            </td></tr>
          </table></form>";
    }
    break;
    
 case "detaildesa":
    if ($_SESSION[leveluser]=='admin' ){
       $detail=mysql_query("SELECT * FROM desa WHERE id_desa='$_GET[id]'");
       $desa=mysql_fetch_array($detail);
      echo "
		  <div class='box box-danger box-solid'>
				<div class='box-header with-border'>
					<h3 class='box-title'>Detail Desa</h3>
					<div class='box-tools pull-right'>
						<button class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-minus'></i></button>
                    </div><!-- /.box-tools -->
				</div>
				<div class='box-body'>
					<div class='col-md-3'>
						<div class='box box-danger'>
							<div class='box-body box-profile'>";
							    if ($desa[foto]!=''){
									echo "<img class='profile-user-img img-responsive img-circle' src='../foto_desa/medium_$desa[foto]' alt='User profile picture'>";
								}
	
      
              
							
							  
							 echo "		 
							  <h3 class='profile-username text-center'>$desa[nama_desa]</h3>
							  <ul class='list-group list-group-unbordered'>
								<li class='list-group-item'>
								  <b>Username </b> <a class='pull-right'>$desa[username_login]</a>
								</li>
							  </ul>
							  <input class='btn btn-primary btn-block' type=button value=Kembali onclick=self.history.back()>
							  
							</div><!-- /.box-body -->
						</div><!-- /.box -->
					</div>
					<div class='col-md-9'>	
						<div class='nav-tabs-custom'>
							<ul class='nav nav-tabs'>
								<li class='active'><a href='#activity' data-toggle='tab'>Profil Lengkap</a></li>
								
							</ul>	
								
								<div class='tab-content'>
									<div class='active tab-pane' id='activity'>
										<div class='post'>
											
											
											<p><label class='col-sm-2 control-label'>Nama</label> $desa[nama_desa] </p>     		
											<p><label class='col-sm-2 control-label'>Alamat</label> $desa[alamat]<br> </p>   		
										</div>	
								
								    </div>
									
						</div>
					</div>
				
				</div>
			</div>";
	  
	  
    }

    elseif ($_SESSION[leveluser]=='desa'){
       $detail=mysql_query("SELECT * FROM desa WHERE id_desa='$_GET[id]'");
       $desa=mysql_fetch_array($detail);

      echo"<br><b class='judul'>Detail Desa</b><br><p class='garisbawah'></p>
       <table>
             <tr><td rowspan='14'>";if ($desa[foto]!=''){
              echo "<img src='foto_desa/medium_$desa[foto]'>";
          }echo "<tr><td>Nama</td>        <td> : $desa[nama_desa]</td></tr>          
          <tr><td>alamat</td>             <td> : $desa[alamat]</td></tr>";
          echo"<tr><td colspan='3'><input type=button class='tombol' value='Kembali'
          onclick=self.history.back()></td></tr></table>";

    }
    break;

case "detailprofildesa":
    if ($_SESSION[leveluser]=='desa'){
       $detail=mysql_query("SELECT * FROM desa WHERE id_desa='$_GET[id]'");
       $desa=mysql_fetch_array($detail);
       $tgl_lahir   = tgl_indo($desa[tgl_lahir]);

       $get_kelas = mysql_query("SELECT * FROM kelas WHERE id_kelas = '$desa[id_kelas]'");
       $kelas = mysql_fetch_array($get_kelas);

      echo"<br><b class='judul'>Detail Siswa</b><br><p class='garisbawah'></p>
       <table>
             <tr><td rowspan='14'>";if ($desa[foto]!=''){
              echo "<img src='foto_desa/medium_$desa[foto]'>";
          }echo "</td><td>nis</td>        <td> : $desa[nis]</td></tr>
          <tr><td>Nama</td>               <td> : $desa[nama_desa]</td></tr>
          <tr><td>alamat</td>             <td> : $desa[alamat]</td></tr>";
          echo"<tr><td colspan='3'><input type=button class='tombol' value='Edit Profil' onclick=\"window.location.href='?module=desa&act=editdesa&id=$desa[id_desa]';\"></td></tr></table>";
    }
    break;

case "detailaccount":
    if ($_SESSION[leveluser]=='desa'){
        $detail=mysql_query("SELECT * FROM desa WHERE id_desa='$_GET[id]'");
        $desa=mysql_fetch_array($detail);
        echo"<form method=POST action=$aksi_desa?module=desa&act=update_account_desa>";
        echo"<br><b class='judul'>Edit Account Login</b><br><p class='garisbawah'></p>
        <table>
        <tr><td colspan=2><input type=submit class='tombol' value='Update'></td></tr>
        </table>";
    }
    break;
}
}
?>
