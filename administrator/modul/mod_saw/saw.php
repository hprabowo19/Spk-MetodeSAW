<script>
function confirmdelete(delUrl) {
if (confirm("Anda yakin ingin menghapus?")) {
document.location = delUrl;
}
}
</script>

<script language="JavaScript" type="text/JavaScript">

 function showpel()
 {
 <?php

 // membaca semua kelas
 $query = "SELECT * FROM kelas";
 $hasil = mysql_query($query);

 // membuat if untuk masing-masing pilihan kelas beserta isi option untuk combobox kedua
 while ($data = mysql_fetch_array($hasil))
 {
   $idkelas = $data['id_kelas'];

   // membuat IF untuk masing-masing kelas
   echo "if (document.form_materi.id_kelas.value == \"".$idkelas."\")";
   echo "{";

   // membuat option saw untuk masing-masing kelas
   $query2 = "SELECT * FROM mata_kuliah WHERE id_kelas = '$idkelas' AND id_pengajar = '0'";
   $hasil2 = mysql_query($query2);
   $content = "document.getElementById('pelajaran').innerHTML = \"<select name='".kodematkul."'>";
   while ($data2 = mysql_fetch_array($hasil2))
   {
       $content .= "<option value='".$data2['kodematkul']."'>".$data2['nama']."</option>";
   }
   $content .= "</select>\";";
   echo $content;
   echo "}\n";
 }

 ?>
 }
</script>

<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href=../css/style.css rel=stylesheet type=text/css>";
  echo "<div class='error msg'>Untuk mengakses Modul anda harus login.</div>";
}
else{

$aksi="modul/mod_saw/aksi_saw.php";
switch($_GET[act]){
// Tampil Mata Kuliah
  default:
    if ($_SESSION[leveluser]=='admin'){
	
	 $tampil_kriteria = mysql_query("SELECT * FROM tbl_kriteria ");
	
     ?>
	 <div class="col-md-8">
	 <div class="box box-danger box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">Data Kriteria</h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div><!-- /.box-tools -->
				</div>
				<div class="box-body">
					<a  class ='btn  btn-success btn-flat' href='?module=saw&act=tambahkriteria'>Tambah Data </a>
					<br><br><br>
					
					
					<table id="example1" class="table table-bordered table-striped" >
						<thead>
							<tr>
								
								<th>No</th>
								<th>Nama Kriteria</th>
								<th>Bobot</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
						<?php 
							$no=1;
							  while ($r=mysql_fetch_array($tampil_kriteria)){
								echo "
								
								<td>$no</td>
								<td>$r[kriteria]</td>
								 <td>$r[bobot]</td>
							
								
								 <td><a href='?module=saw&act=editkriteria&id=$r[id]' title='Edit' class='btn btn-primary btn-xs'>Edit</a> |
									 <a href=javascript:confirmdelete('$aksi?module=saw&act=hapus&id=$r[id]') title='Hapus'  class='btn btn-danger btn-xs'>Hapus</a></td></tr>";
								$no++;
								}
						echo "</tbody></table>";
					?>
				</div>
			</div>	
             
	 <?php	 
    }

    if ($_SESSION[leveluser]=='dpl'){
	
	 $tampil_kriteria = mysql_query("SELECT * FROM tbl_kriteria ");
	
     ?>
	 <div class="col-md-8">
	 <div class="box box-danger box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">Data Kriteria</h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div><!-- /.box-tools -->
				</div>
				<div class="box-body">
					<table id="example1" class="table table-bordered table-striped" >
						<thead>
							<tr>
								
								<th>No</th>
								<th>Nama Kriteria</th>
								<th>Bobot</th>
							</tr>
						</thead>
						<tbody>
						<?php 
							$no=1;
							  while ($r=mysql_fetch_array($tampil_kriteria)){
								echo "
								
								<td>$no</td>
								<td>$r[kriteria]</td>
								 <td>$r[bobot]</td></tr>";
								$no++;
								}
						echo "</tbody></table>";
					?>
				</div>
			</div>	
             
	 <?php	 
    }

	
	
    break;

case "tambahkriteria":
    if ($_SESSION[leveluser]=='admin'){
         echo "
		  <div class='col-md-8'>
		  <div class='box box-danger box-solid'>
				<div class='box-header with-border'>
					<h3 class='box-title'>Tambah Data Kriteria</h3>
					<div class='box-tools pull-right'>
						<button class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-minus'></i></button>
                    </div><!-- /.box-tools -->
				</div>
				<div class='box-body'>
						<form method=POST action='$aksi?module=saw&act=input_saw' enctype='multipart/form-data' class='form-horizontal'>
							  <div class='form-group'>
									<label class='col-sm-3 control-label'>Nama Kriteria</label>        		
									 <div class='col-sm-4'>
										<input type=text name='nm_kriteria' class='form-control' Placeholder='Nama Kriteria' required='required'>
									 </div>
							  </div>
							  <div class='form-group'>
									<label class='col-sm-3 control-label'>Bobot</label>        		
									 <div class='col-sm-2'>
										<input type=text name='bobot' class='form-control' Placeholder='Bobot' required='required'>
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

case "editkriteria":
    if ($_SESSION[leveluser]=='admin'){
        $kriteria=mysql_query("SELECT * FROM tbl_kriteria WHERE id = '$_GET[id]'");
        $m=mysql_fetch_array($kriteria);
        
        
        echo "
		   <div class='col-md-8'>
		  <div class='box box-danger box-solid'>
				<div class='box-header with-border'>
					<h3 class='box-title'>Edit Data Kriteria</h3>
					<div class='box-tools pull-right'>
						<button class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-minus'></i></button>
                    </div><!-- /.box-tools -->
				</div>
				<div class='box-body'>
						<form method=POST action='$aksi?module=saw&act=update_saw'  class='form-horizontal'>
							  <input type=hidden name=id value='$m[id]'>
							  <div class='form-group'>
									<label class='col-sm-3 control-label'>Nama Kriteria</label>        		
									 <div class='col-sm-4'>
										<input type=text name='nm_kriteria' class='form-control' Placeholder='Nama Kriteria' value='$m[kriteria]'>
									 </div>
							  </div>
							  <div class='form-group'>
									<label class='col-sm-3 control-label'>Bobot</label>        		
									 <div class='col-sm-3'>
										<input type=text name='bobot' class='form-control' Placeholder='Bobot' value='$m[bobot]'>
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
case "detailpelajaran":
    if ($_SESSION[leveluser]=='admin'){
        $detail =mysql_query("SELECT * FROM mata_kuliah WHERE kodematkul = '$_GET[id]'");
        echo "<div class='information msg'>Detail Mata Kuliah</div>
          <br><table id='table1' class='gtable sortable'><thead>
          <tr><th>No</th><th>Id Mapel</th><th>Nama</th><th>Kelas</th><th>Pengajar</th><th>Deskripsi</th><th>Aksi</th></tr></thead>";
        $no=1;
    while ($r=mysql_fetch_array($detail)){
       echo "<tr><td>$no</td>
             <td>$r[kodematkul]</td>
             <td>$r[nama]</td>";
             $kelas = mysql_query("SELECT * FROM kelas WHERE id_kelas = '$r[id_kelas]'");
             $cek_kelas = mysql_num_rows($kelas);
             if(!empty($cek_kelas)){
             while($k=mysql_fetch_array($kelas)){
                 echo "<td><a href=?module=kelas&act=detailkelas&id=$r[id_kelas] title='Detail Kelas'>$k[nama]</td>";
             }
             }else{
                 echo"<td></td>";
             }
             $pengajar = mysql_query("SELECT * FROM pengajar WHERE id_pengajar = '$r[id_pengajar]'");
             $cek_pengajar = mysql_num_rows($pengajar);
             if(!empty($cek_pengajar)){
             while($p=mysql_fetch_array($pengajar)){
             echo "<td><a href=?module=admin&act=detailpengajar&id=$r[id_pengajar] title='Detail Pengajar'>$p[nama_lengkap]</a></td>";
             }
             }else{
                 echo"<td></td>";
             }
             echo "<td>$r[deskripsi]</td>
             <td><a href='?module=saw&act=editsaw&id=$r[id]' title='Edit'><img src='images/icons/edit.png' alt='Edit' /></a> |
                 <a href=javascript:confirmdelete('$aksi?module=saw&act=hapus&id=$r[id]') title='Hapus'><img src='images/icons/cross.png' alt='Delete' /></a></td></tr>";
      $no++;
    }
    echo "</table>
    <div class='buttons'>
    <br><input class='button blue' type=button value=Kembali onclick=self.history.back()>
    </div>";
    }else{
      $detail =mysql_query("SELECT * FROM mata_kuliah WHERE kodematkul = '$_GET[id]'");
        echo "<span class='judulhead'><p class='garisbawah'>Detail Mata Kuliah</p></span>
          <table>
          <tr><th>no</th><th>nama</th><th>kelas</th><th>pengajar</th><th>deskripsi</th></tr>";
                    $no=1;
    while ($r=mysql_fetch_array($detail)){
       echo "<tr><td>$no</td>             
             <td>$r[nama]</td>";
             $kelas = mysql_query("SELECT * FROM kelas WHERE id_kelas = '$r[id_kelas]'");
             $cek_kelas = mysql_num_rows($kelas);
             if(!empty($cek_kelas)){
             while($k=mysql_fetch_array($kelas)){
                 echo "<td><a href=?module=kelas&act=detailkelas&id=$r[id_kelas] title='Detail Kelas'>$k[nama]</td>";
             }
             }else{
                 echo"<td></td>";
             }
             $pengajar = mysql_query("SELECT * FROM pengajar WHERE id_pengajar = '$r[id_pengajar]'");
             $cek_pengajar = mysql_num_rows($pengajar);
             if(!empty($cek_pengajar)){
             while($p=mysql_fetch_array($pengajar)){
             echo "<td><a href=?module=admin&act=detailpengajar&id=$r[id_pengajar] title='Detail Pengajar'>$p[nama_lengkap]</a></td>";
             }
             }else{
                 echo"<td></td>";
             }
             echo "<td>$r[deskripsi]</td></tr>";
             
      $no++;
    }
    echo "</table>
    <input type=button value=Kembali onclick=self.history.back()>";
    }
    break;
	
	case "himpunankriteria":
	if ($_SESSION[leveluser]=='admin' || $_SESSION['leveluser']=='dpl'){
	
	 $tampil_kriteria = mysql_query("SELECT * FROM tbl_kriteria ");
	
     ?>
	 <div class="col-md-8">
	 <div class="box box-danger box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">Data Kriteria</h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div><!-- /.box-tools -->
				</div>
				<div class="box-body">
					
	
					
					
					<table id="example1" class="table table-bordered table-striped" >
						<thead>
							<tr>
								
								<th>No</th>
								<th>Nama Kriteria</th>
								
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
						<?php 
							$no=1;
							  while ($r=mysql_fetch_array($tampil_kriteria)){
								echo "
								
								<td>$no</td>
								<td>$r[kriteria]</td>
								
							
								
								 <td><a href='?module=saw&act=listhimpunankriteria&id=$r[id]' title='input Data Kriteria' class='btn btn-primary btn-xs'>Input Data Kriteria</a> 
									</td></tr>";
								$no++;
								}
						echo "</tbody></table>";
					?>
				</div>
			</div>	
             
	 <?php
		 
    }
	break;
	
	
	case "listhimpunankriteria":
	if ($_SESSION[leveluser]=='admin' || $_SESSION['leveluser']=='dpl'){
	
	 $tampil_kriteria = mysql_query("SELECT * FROM tbl_kriteria WHERE id ='$_GET[id]'");
	 $a = mysql_fetch_array($tampil_kriteria);
	 
	 $tampil_himpunankriteria = mysql_query("SELECT * FROM tbl_himpunankriteria WHERE id_kriteria='$_GET[id]'");
	?>
	 <div class="col-md-8">
	 <div class="box box-danger box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">Data Himpunan Kriteria <?php echo $a['kriteria']; ?> </h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						
					</div><!-- /.box-tools -->
				</div>
				<div class="box-body">
					
					<a  class ='btn  btn-success btn-flat' href='?module=saw&act=tambahhimpunan&id=<?php echo $a['id']; ?> '>Tambah Data </a>
					<br><br><br>
					
					<table id="example1" class="table table-bordered table-striped" >
						<thead>
							<tr>
								
								<th>No</th>
								<th>List</th>
								<th>Keterangan</th>
								<th>Nilai</th>
								
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
						<?php 
							$no=1;
							  while ($r=mysql_fetch_array($tampil_himpunankriteria)){
								echo "
								
								<td>$no</td>
								<td>$r[nama]</td>
								<td>$r[keterangan]</td>
								<td>$r[nilai]</td>
								
							
								
								<td><a href='?module=saw&act=edithimpunankriteria&id=$r[id_hk]' title='Edit' class='btn btn-primary btn-xs'>Edit</a> 
									 <a href='$aksi?module=saw&act=hapus_himpunan&id=$r[id_hk]&id_kriteria=$r[id_kriteria]' title='Hapus'  class='btn btn-danger btn-xs'>Hapus</a></td></tr>";
								$no++;
								}
						echo "</tbody></table>";
					?>
				</div>
			</div>	
             
	 <?php
		 
    }
	break;
	
	case "tambahhimpunan":
	if ($_SESSION[leveluser]=='admin'){
	
	$tampil_kriteria = mysql_query("SELECT * FROM tbl_kriteria WHERE id ='$_GET[id]'");
	 $a = mysql_fetch_array($tampil_kriteria);
		
		
	echo "
		  <div class='col-md-8'>
		  <div class='box box-danger box-solid'>
				<div class='box-header with-border'>
					<h3 class='box-title'>Tambah Data Himpunan Kriteria $a[kriteria]</h3>
					<div class='box-tools pull-right'>
						<button class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-minus'></i></button>
                    </div><!-- /.box-tools -->
				</div>
				<div class='box-body'>
						<form method=POST action='$aksi?module=saw&act=input_himpunan' class='form-horizontal'>
							<input type=hidden name='id_kriteria' class='form-control' Placeholder='Masukan Data' value='$a[id]'>							 
							 <div class='form-group'>
									<label class='col-sm-3 control-label'>Masukan Data</label>        		
									 <div class='col-sm-4'>
										<input type=text name='nama' class='form-control' Placeholder='Masukan Data' required='required'>
									 </div>
							  </div>
							  <div class='form-group'>
									<label class='col-sm-3 control-label'>Keterangan</label>        		
									 <div class='col-sm-4'>
										<input type=text name='ket' class='form-control' Placeholder='Keterangan' required='required'>
									 </div>
							  </div>
							  <div class='form-group'>
									<label class='col-sm-3 control-label'>Nilai</label>        		
									 <div class='col-sm-2'>
										<input type=text name='nilai' class='form-control' Placeholder='Nilai' required='required'>
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
	
	
	case "edithimpunankriteria":
	if ($_SESSION[leveluser]=='admin'){
	
	$tampil_hk = mysql_query("SELECT * FROM tbl_himpunankriteria WHERE id_hk = '$_GET[id]'");
	$f = mysql_fetch_array($tampil_hk);
	
	$tampil_kriteria = mysql_query("SELECT * FROM tbl_kriteria WHERE id ='$f[id_kriteria]'");
	$a = mysql_fetch_array($tampil_kriteria);
		
		
	echo "
		  <div class='col-md-8'>
		  <div class='box box-danger box-solid'>
				<div class='box-header with-border'>
					<h3 class='box-title'>Edit Data Himpunan Kriteria $a[kriteria]</h3>
					<div class='box-tools pull-right'>
						<button class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-minus'></i></button>
                    </div><!-- /.box-tools -->
				</div>
				<div class='box-body'>
						<form method=POST action='$aksi?module=saw&act=update_himpunan' class='form-horizontal'>
							<input type=hidden name='id_kriteria' class='form-control' Placeholder='Masukan Data' value='$a[id]'>							 
							<input type=hidden name='id_hk' class='form-control' Placeholder='Masukan Data' value='$f[id_hk]'>							 
							 <div class='form-group'>
									<label class='col-sm-3 control-label'>Masukan Data</label>        		
									 <div class='col-sm-4'>
										<input type=text name='nama' class='form-control' Placeholder='Masukan Data' value='$f[nama]'>
									 </div>
							  </div>
							  
							  <div class='form-group'>
									<label class='col-sm-3 control-label'>Keterangan</label>        		
									 <div class='col-sm-4'>
										<input type=text name='ket' class='form-control' Placeholder='Keterangan' value='$f[keterangan]'>
									 </div>
							  </div>
							  
							  <div class='form-group'>
									<label class='col-sm-3 control-label'>Nilai</label>        		
									 <div class='col-sm-2'>
										<input type=text name='nilai' class='form-control' Placeholder='Nilai' value='$f[nilai]'>
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
	
	
	case "klasifikasi":
	if ($_SESSION[leveluser]=='admin' || $_SESSION[leveluser]=='dpl'){

  
      $tampil_desa = mysql_query("SELECT * FROM desa");
      
	  ?>
			
			<div class='col-md-8'>
			<div class="box box-danger box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">Data Klasifikasi</h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div><!-- /.box-tools -->
				</div>
				<div class="box-body">
					
					
					
					<table id="example1" class="table table-bordered table-striped" >
						<thead>
							<tr>
								<th>No</th>
								<th>Nama</th>
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
											 <td><a href=?module=saw&act=editklasifikasi&id=$r[id_desa] class='btn btn-primary btn-xs'>Edit Klasifikasi</a> 
											 
				  
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
	
	case "editklasifikasi":
    if ($_SESSION[leveluser]=='admin' || $_SESSION[leveluser]=='dpl'){
       $detail=mysql_query("SELECT * FROM desa WHERE id_desa='$_GET[id]'");
       $desa=mysql_fetch_array($detail);
      echo "
		  <div class='box box-danger box-solid'>
				<div class='box-header with-border'>
					<h3 class='box-title'>Edit Klasifikasi</h3>
					<div class='box-tools pull-right'>
						<button class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-minus'></i></button>
                    </div><!-- /.box-tools -->
				</div>
				<div class='box-body'>
					<div class='col-md-3'>
						<div class='box box-danger'>
							<div class='box-body box-profile'>";
							 echo "		 
							  <h3 class='profile-username text-center'>$desa[nama_desa]</h3>
							  <ul class='list-group list-group-unbordered'>
								<li class='list-group-item'>
								  <b>Kecamatan </b> <a class='pull-right'>$desa[kecamatan]</a>
								</li>
								<li class='list-group-item'>
								  <b>Kabupaten </b> <a class='pull-right'>$desa[kabupaten]</a>
								</li>
								<li class='list-group-item'>
								  <b>Provinsi </b> <a class='pull-right'>$desa[provinsi]</a>
								</li>
							  </ul>
							  <input class='btn btn-primary btn-block' type=button value=Kembali onclick=self.history.back()>
							  
							</div><!-- /.box-body -->
						</div><!-- /.box -->
					</div>
					<div class='col-md-9'>	
						<div class='nav-tabs-custom'>
							<ul class='nav nav-tabs'>
								<li class='active'><a href='#activity' data-toggle='tab'>Edit Klasifikasi</a></li>
								
							</ul>	
								
								<div class='tab-content'>
									<div class='active tab-pane' id='activity'>
										<div class='post'>
										<form method=POST action='$aksi?module=saw&act=input_klasifikasi' ' class='form-horizontal'>
										<input type='hidden' value ='$desa[id_desa]' name='id'>
										";
											
											$kriteria = mysql_query("SELECT * FROM tbl_kriteria");
											$i=1;
											while ($f = mysql_fetch_array($kriteria)){
												
												$forms = mysql_query("SELECT * FROM tbl_himpunankriteria WHERE id_kriteria='$f[id]'");
												
												echo "<p>
												<div class='form-group'>
													<label class='col-sm-3 control-label'>$f[kriteria]</label> 
													<div class='col-sm-2'>
													
													<select name='id_hk$i' class=' form-control  '  >
														 ";
														
														 while($r=mysql_fetch_array($forms)){
														 echo "<option value=$r[id_hk]>$r[nama]</option>";
														 
														 }
													
													echo "</select>
													
												</div>
												</div>
												</p>
												
												";     
												$i++;
											}
											
										$jumkriteria = mysql_num_rows(mysql_query("SELECT * FROM tbl_kriteria"));
										
										echo"
											<div class='buttons'>
												<input type='hidden' value='$jumkriteria' name='jumkriteria' >
												<input class='btn btn-success' type=submit value=Prosess>
											</div>
											</form>
										</div>	
								    </div>
						</div>
					</div>
				</div>
			</div>";
    }
	break;
	
	case "analisa":
	if ($_SESSION[leveluser]=='admin'){
			//Rangking
			
			$tampil_desa = mysql_query("SELECT * FROM desa");	
			$tampil_kriteria = mysql_query("SELECT * FROM tbl_kriteria ");
			$tampil_klasifikasi = mysql_query("SELECT * FROM tbl_klasifikasi GROUP by id_desa");
			$thn_skrg=date("Y");
			?>
			
			 <div class="box box-danger box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">Rangking</h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div><!-- /.box-tools -->
				</div>
				<div class="box-body">
					
					<form method='post' action=''>
						<table class='table table-hover table-bordered'>
							<tr>
								<td>Pilih Tahun</td>
								<td> : <select id=tahun name=tahun>
								<option value=''>Tahun</option>
								<?php
								for ($ang=2018; $ang<=$thn_skrg;$ang++) {
									echo "<option value=$ang>$ang</option>";
								}
								echo "</select>";
								?>
							</tr>
							<tr>
								<td>Nama Kecamatan</td>
								<td> : <select id=kecamatan name=kecamatan>
									<option value=''>Pilih Kecamatan</option>";
									<?php
									$sql=mysql_query("SELECT DISTINCT kecamatan FROM desa");
									while ($data=mysql_fetch_array($sql))
									{
										echo "<option value=$data[kecamatan]>$data[kecamatan]</option>";
									}
								echo "</select>";
							?>
							<input type='submit' class='btn btn-primary' value='Cari'/></td></tr>
						</table>
						</form>
					
						<?php
						if(isset($_POST['tahun']) AND ($_POST['kecamatan'])){
						$cek = mysql_query("SELECT * FROM hasil WHERE tahun ='$_POST[tahun]' AND kecamatan LIKE '%$_POST[kecamatan]%'");
						$row = mysql_num_rows($cek);
						if($row > 0){
							echo"
							<button><a href='../print.php?&data=$_POST[kecamatan]&tahun=$_POST[tahun]' target='_blank' rel='noopener noreferrer'>Cetak Laporan</a></button>
							<br><br>";
						}
						echo"<table id='example4' class='table table-bordered table-striped' >
						<thead>
							<tr>
								
								<th>No</th>
								<th>Nama Desa</th>
								<th>Kecamatan</th>
								<th>Kabupaten</th>
								<th>Provinsi</th>
								<th>Tahun</th>
								<th>Total Nilai</th>
						
								
							</tr>
						</thead>
							<tbody>";
							$tampil=mysql_query("SELECT * FROM hasil WHERE tahun ='$_POST[tahun]' AND kecamatan LIKE '%$_POST[kecamatan]%'");
							$no=1;
							  while ($r=mysql_fetch_array($tampil)){
							  	if($r['nilai'] > 50){
									$h = mysql_fetch_array(mysql_query("SELECT * FROM desa WHERE id_desa ='$r[id_desa]'"));
									$nilai = round($r[nilai]);
									echo "
									<td>$no</td>
									<td>$h[nama_desa]</td>
									<td>$h[kecamatan]</td>
									<td>$h[kabupaten]</td>
									<td>$h[provinsi]</td>
									<td>$r[tahun]</td>
									<td>$nilai</td>";
									echo"
									</tr>";
							  	}
								$no++;
								}
						echo "</tbody></table>";
					}elseif(isset($_POST['tahun'])){
						$cek = mysql_query("SELECT * FROM hasil WHERE tahun ='$_POST[tahun]'");
						$row = mysql_num_rows($cek);
						if($row > 0){
							echo"<a href='../print.php?&data=$_POST[kecamatan]&tahun=$_POST[tahun]' target='_blank' rel='noopener noreferrer'>Cetak Laporan</a>
							<br><br>";
						}
						echo"<table id='example4' class='table table-bordered table-striped' >
						<thead>
							<tr>
								
								<th>No</th>
								<th>Nama Desa</th>
								<th>Kecamatan</th>
								<th>Kabupaten</th>
								<th>Provinsi</th>
								<th>Tahun</th>
								<th>Total Nilai</th>
						
								
							</tr>
						</thead>
							<tbody>";
							$tampil=mysql_query("SELECT * FROM hasil WHERE tahun ='$_POST[tahun]'");
							$no=1;
							  while ($r=mysql_fetch_array($tampil)){
							  	if($r['nilai'] > 50){
									$h = mysql_fetch_array(mysql_query("SELECT * FROM desa WHERE id_desa ='$r[id_desa]'"));
									$nilai = round($r[nilai]);
									echo "
									<td>$no</td>
									<td>$h[nama_desa]</td>
									<td>$h[kecamatan]</td>
									<td>$h[kabupaten]</td>
									<td>$h[provinsi]</td>
									<td>$r[tahun]</td>
									<td>$nilai</td>";
									echo"
									</tr>";
							  	}
								$no++;
								}
								echo "</tbody></table>";
					}
						?>
				</div>
			</div>
			<?php
			 $tampil_desa = mysql_query("SELECT * FROM desa");	
			 $tampil_kriteria = mysql_query("SELECT * FROM tbl_kriteria ");
			 $tampil_klasifikasi = mysql_query("SELECT * FROM tbl_klasifikasi GROUP by id_desa");
			?>
	 		<div class="box box-danger box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">Matrik Awal</h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div><!-- /.box-tools -->
				</div>
				<div class="box-body">
					
					
					<table id="example1" class="table table-bordered table-striped" >
						<thead>
							<tr>
								
								<th>No</th>
								<th>Nama Desa</th>
						<?php 
							$a = 1;
							while($f= mysql_fetch_array($tampil_kriteria)){
								
								echo "<th>C$a</th>";
							
							$a++;
							}	
						
						?>
								
							</tr>
						</thead>
						<tbody>
						<?php 
							$no=1;
							  while ($r=mysql_fetch_array($tampil_klasifikasi)){
								$h = mysql_fetch_array(mysql_query("SELECT * FROM desa WHERE id_desa ='$r[id_desa]'"));
								
								
								echo "
								
								<td>$no</td>
								<td>$h[nama_desa]</td>";
								
								$klasifikasi = mysql_query("SELECT * FROM tbl_klasifikasi WHERE id_desa = '$r[id_desa]'");
								while ($n=mysql_fetch_array($klasifikasi)){
									
										$himpunankriteria = mysql_fetch_array(mysql_query("SELECT * FROM tbl_himpunankriteria WHERE id_hk ='$n[id_hk]'"));
										
										echo "<td>$himpunankriteria[nama]</td>";
										
									
								}
								
								echo"
								
								
								
								</tr>";
								$no++;
								}
						echo "</tbody></table>";
					?>
				</div>
			</div>	
			
			<?php

			$tampil_desa = mysql_query("SELECT * FROM desa");	
			$tampil_kriteria = mysql_query("SELECT * FROM tbl_kriteria ");
			$tampil_klasifikasi = mysql_query("SELECT * FROM tbl_klasifikasi GROUP by id_desa")
			?>
			
			 <div class="box box-danger box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">Matrik Awal</h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div><!-- /.box-tools -->
				</div>
				<div class="box-body">
					
					
					
					<table id="example2" class="table table-bordered table-striped" >
						<thead>
							<tr>
								
								<th>No</th>
								<th>Nama</th>
						<?php 
							$a = 1;
							while($f= mysql_fetch_array($tampil_kriteria)){
								
								echo "<th>C$a</th>";
							
							$a++;
							}	
						
						?>
								
							</tr>
						</thead>
						<tbody>
						<?php 
							$no=1;
							  while ($r=mysql_fetch_array($tampil_klasifikasi)){
								$h = mysql_fetch_array(mysql_query("SELECT * FROM desa WHERE id_desa ='$r[id_desa]'"));
								
								
								echo "
								
								<td>$no</td>
								<td>$h[nama_desa]</td>";
								
								$klasifikasi = mysql_query("SELECT * FROM tbl_klasifikasi WHERE id_desa = '$r[id_desa]'");
								while ($n=mysql_fetch_array($klasifikasi)){
									
										$himpunankriteria = mysql_fetch_array(mysql_query("SELECT * FROM tbl_himpunankriteria WHERE id_hk ='$n[id_hk]'"));
										
										echo "<td>$himpunankriteria[nilai]</td>";
										
									
								}
								
								echo"
								
								
								
								</tr>";
								$no++;
								}
						echo "</tbody></table>";
					?>
				</div>
			</div>	
			
			
			<?php

			//Normalisai
			
			$tampil_desa = mysql_query("SELECT * FROM desa");	
			$tampil_kriteria = mysql_query("SELECT * FROM tbl_kriteria ");
			$tampil_klasifikasi = mysql_query("SELECT * FROM tbl_klasifikasi GROUP by id_desa")
			?>
			
			 <div class="box box-danger box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">Normalisasi</h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div><!-- /.box-tools -->
				</div>
				<div class="box-body">
					
					
					
					<table id="example3" class="table table-bordered table-striped" >
						<thead>
							<tr>
								
								<th>No</th>
								<th>Nama</th>
						<?php 
							$a = 1;
							while($f= mysql_fetch_array($tampil_kriteria)){
								
								echo "<th>C$a</th>";
							
							$a++;
							}	
						
						?>
								
							</tr>
						</thead>
						<tbody>
						<?php 
							$no=1;
							  while ($r=mysql_fetch_array($tampil_klasifikasi)){
								$h = mysql_fetch_array(mysql_query("SELECT * FROM desa WHERE id_desa ='$r[id_desa]'"));
								
								
								echo "
								
								<td>$no</td>
								<td>$h[nama_desa]</td>";
								
								$klasifikasi = mysql_query("SELECT * FROM v_analisa WHERE id_desa = '$r[id_desa]'");
								while ($n=mysql_fetch_array($klasifikasi)){
									$crmax = mysql_fetch_array(mysql_query("SELECT max(nilai) as nilaimax FROM v_analisa WHERE id_kriteria='$n[id_kriteria]'"));
									$himpunankriteria = mysql_fetch_array(mysql_query("SELECT * FROM tbl_himpunankriteria WHERE id_hk ='$n[id_hk]'"));
									
									$nilaiok = $himpunankriteria['nilai'] / $crmax['nilaimax'];
										
										echo "<td>$nilaiok</td>";
									
									
								}
								
								echo"
								
								
								
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
}
}
?>
