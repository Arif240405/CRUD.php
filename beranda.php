<?php
$buku = new Buku();
$dt = $buku->data_dashboard();
$jml = $dt[0];
$jml_pengarang = $dt[1];
$jml_penerbit = $dt[2];
?>
<div class="panel-header bg-primary-gradient">
	<div class="page-inner py-5">
		<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
			<div>
				<h2 class="text-white pb-2 fw-bold">Beranda</h2>
				<h5 class="text-white op-7 mb-2">Halaman Beranda Informasi Sistem</h5>
			</div>
		</div>
	</div>
</div>
<div class="page-inner mt--5">
	<div class="row mt--2">
		<div class="col-md-2">
			<div class="card card-success">
				<div class="card-header">
					<div class="card-title">Jumlah Buku</div>
				</div>
				<div class="card-body pb-0">
					<div class="mb-4 mt-2">
						<h1><?= $jml; ?></h1>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-2">
			<div class="card card-info">
				<div class="card-header">
					<div class="card-title">Jumlah Penerbit</div>
				</div>
				<div class="card-body pb-0">
					<div class="mb-4 mt-2">
						<h1><?= $jml_pengarang; ?></h1>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-2">
			<div class="card card-warning">
				<div class="card-header">
					<div class="card-title">Jumlah Pengarang</div>
				</div>
				<div class="card-body pb-0">
					<div class="mb-4 mt-2">
						<h1><?= $jml_penerbit; ?></h1>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-2" style="cursor: pointer;">
			<a href="tambahbuku" style="text-decoration: none;">
				<div class="card card-secondary">
					<div class="card-header">
						<div class="card-title">Tambah Data</div>
					</div>
					<div class="card-body pb-0">
						<div class="mb-4 mt-2">
							<h1><i class='icon-plus'></i></h1>
						</div>
					</div>
				</div>
			</a>
		</div>
		<div class="col-md-2" style="cursor: pointer;">
			<a href="cetakpdf" style="text-decoration: none;">
				<div class="card card-danger">
					<div class="card-header">
						<div class="card-title">Cetak PDF</div>
					</div>
					<div class="card-body pb-0">
						<div class="mb-4 mt-2">
							<h1><i class='icon-printer'></i></h1>
						</div>
					</div>
				</div>
			</a>
		</div>
		<div class="col-md-2" style="cursor: pointer;">
			<a href="cetakexcel" style="text-decoration: none;">
				<div class="card card-success">
					<div class="card-header">
						<div class="card-title">Cetak Excel</div>
					</div>
					<div class="card-body pb-0">
						<div class="mb-4 mt-2">
							<h1><i class='icon-printer'></i></h1>
						</div>
					</div>
				</div>
			</a>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<div class="table-responsive">
						<table id="tbl-xdt" class="display table table-striped table-hover">
							<thead>
								<tr>
									<th style="width: 10%;">Aksi</th>
									<th style="width: 7%;">Kode Buku</th>
									<th style="width: 28%;">Judul</th>
									<th style="width: 15%;">Pengarang</th>
									<th style="width: 15%;">Penerbit</th>
									<th style="width: 10%;">ISBN</th>
									<th style="width: 8%;">Tahun Terbit</th>
									<th style="width: 7%;">Rak</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$dtx = $buku->data_tabel();
								foreach ($dtx as $x) {
									$kode = $x["kode"];
									$judul = $x["judul"];
									$idpengarang = $x["id_pengarang"];
									$idpenerbit = $x["id_penerbit"];
									$namapengarang = $x["nama_pengarang"];
									$namapenerbit = $x["nama_penerbit"];
									$isbn = $x["isbn"];
									$tahun = $x["tahun"];
									$rak = $x["rak"];
									echo "<tr>
											<td>
												<form method='post' action='updatebuku'>
													<input type='hidden' value='" . $kode . "' name='txtkode'>
													<button type='submit' class='btn btn-icon btn-round btn-primary btn-sm'>
														<i class='icon-pencil'></i>
													</button>
													<button type='button' class='btn btn-icon btn-round btn-danger btn-sm' data-toggle='modal' data-target='#modald$kode'>
														<i class='icon-trash'></i>
													</button>
												</form>
											</td>
											<td>$kode</td>
											<td>$judul</td>
											<td>$namapengarang</td>
											<td>$namapenerbit</td>
											<td>$isbn</td>
											<td>$tahun</td>
											<td>$rak</td>
										</tr>";
									echo "<div class='modal fade' role='dialog' id='modald$kode'>
											<div class='modal-dialog' role='document'>
												<div class='modal-content'>
													<form method='post'>
														<div class='modal-header btn-danger'>
															<h5 class='modal-title'>Hapus Buku</h5>
														</div>
														<div class='modal-body'>
															<input type='hidden' name='txthid' value='$kode'>
															Anda Yakin Ingin Menghapus Data Buku dengan Judul <b>`$judul`</b> ?
														</div>
														<div class='modal-footer'>
															<button type='submit' name='btnhapus' class='btn btn-danger'>Ya</button>
															<button type='button' class='btn btn-secondary' data-dismiss='modal'>Tutup</button>
														</div>
													</form>
												</div>
											</div>
										</div>";
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$('#tbl-xdt').DataTable();
</script>
<?php
if (isset($_REQUEST["btnhapus"])) {
	$kode = $_REQUEST["txthid"];
	$status = $buku->delete($kode);
	if ($status) {
		echo "<script>alert('Hapus Data Buku Berhasil');</script>";
	} else {
		echo "<script>alert('Hapus Data Buku Gagal');</script>";
	}
	echo "<script>window.location = '';</script>";
}
?>