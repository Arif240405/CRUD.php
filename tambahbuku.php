<?php
	$buku = new Buku();
?>
<div class="row mt-5">
	<div class="col-md-6 ml-auto mr-auto">
		<div class="card">
			<div class="card-header">
				<div class="card-title">Form Tambah Buku</div>
			</div>
			<div class="card-body">
				<form method="post">
					<div class="row">
						<div class="col-md-4 jedaobyek">
							<div class="form-group">
								<label>Kode Buku</label>
								<input type="text" class="form-control" name="txtkodebuku" maxlength="6" required>
							</div>
						</div>
						<div class="col-md-8 jedaobyek">
							<div class="form-group">
								<label>Pengarang</label>
								<select class="form-control" name="cbopengarang" required>
									<option value="">Pilih Salah Satu</option>
									<?php
										$dtx = $buku->pengarang();
										foreach($dtx as $x){
											$id = $x["id"];
											$nama = $x["nama"];
											echo '<option value="'.$id.'">'.$nama.'</option>';
										}
									?>
								</select>
							</div>
						</div>
						<div class="col-md-12 jedaobyek">
							<div class="form-group">
								<label>Judul Buku</label>
								<input type="text" class="form-control" name="txtjudul" required>
							</div>
						</div>
						<div class="col-md-8 jedaobyek">
							<div class="form-group">
								<label>Penerbit</label>
								<select class="form-control" name="cbopenerbit" required>
									<option value="">Pilih Salah Satu</option>
									<?php
										$dtx = $buku->penerbit();
										foreach($dtx as $x){
											$id = $x["id"];
											$nama = $x["nama"];
											echo '<option value="'.$id.'">'.$nama.'</option>';
										}
									?>
								</select>
							</div>
						</div>
						<div class="col-md-4 jedaobyek">
							<div class="form-group">
								<label>Tahun</label>
								<input type="text" class="form-control" name="txttahun" maxlength="4" required>
							</div>
						</div>
						<div class="col-md-6 jedaobyek">
							<div class="form-group">
								<label>ISBN</label>
								<input type="text" class="form-control" name="txtisbn" required>
							</div>
						</div>
						<div class="col-md-6 jedaobyek">
							<div class="form-group">
								<label>Rak</label>
								<input type="text" class="form-control" name="txtrak" required>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<button type="submit" name="btnsimpan" class="btn btn-primary">Tambahkan</button>
								<button type="reset" class="btn btn-danger">Reset</button>
								<a href="home" class="btn btn-secondary">Kembali</a>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<?php
	if(isset($_REQUEST["btnsimpan"])){
		$kode = $_REQUEST["txtkodebuku"];
		$idpengarang = $_REQUEST["cbopengarang"];
		$judul = $_REQUEST["txtjudul"];
		$idpenerbit = $_REQUEST["cbopenerbit"];
		$tahun = $_REQUEST["txttahun"];
		$isbn = $_REQUEST["txtisbn"];
		$rak = $_REQUEST["txtrak"];
		$status = $buku->add($kode, $judul, $idpengarang, $idpenerbit, $isbn, $tahun, $rak);
		if($status){
			echo "<script>alert('Simpan Data Buku Berhasil');</script>";
		}else{
			echo "<script>alert('Simpan Data Buku Gagal');</script>";
		}
		echo "<script>window.location = '';</script>";
	}
?>
