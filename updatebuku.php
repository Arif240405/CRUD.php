<?php
	$buku = new Buku();
	if(isset($_REQUEST["txtkode"])){
		$x = $_REQUEST["txtkode"];
		$dtx = $buku->filter_by_kode($x);
		if(count($dtx) > 0){
			foreach($dtx as $y){
				$kode = $y["kode"];
				$judul = $y["judul"];
				$idpengarang = $y["idpengarang"];
				$idpenerbit = $y["idpenerbit"];
				$isbn = $y["isbn"];
				$tahun = $y["tahun"];
				$rak = $y["rak"];
			}
		}else{
			echo "<script>
				alert('Data Invalid');
				window.location = 'home';
			</script>";
		}
	}else{
		if(!isset($_REQUEST["btnsimpan"])){
			echo "<script>
				alert('Data Invalid');
				window.location = 'home';
			</script>";
		}
	}
?>
<div class="row mt-5">
	<div class="col-md-6 ml-auto mr-auto">
		<div class="card">
			<div class="card-header">
				<div class="card-title">Form Update Buku</div>
			</div>
			<div class="card-body">
				<form method="post">
					<div class="row">
						<input type="hidden" class="form-control" name="txtkodebuku" maxlength="6" value="<?= $kode; ?>" required readonly>
						<div class="col-md-12 jedaobyek">
							<div class="form-group">
								<label>Pengarang</label>
								<select class="form-control" name="cbopengarang" required>
									<option value="">Pilih Salah Satu</option>
									<?php
										$dtx = $buku->pengarang();
										foreach($dtx as $x){
											$id = $x["id"];
											$nama = $x["nama"];
											if($id == $idpengarang){
												echo '<option value="'.$id.'" selected>'.$nama.'</option>';
											}else{
												echo '<option value="'.$id.'">'.$nama.'</option>';
											}
										}
									?>
								</select>
							</div>
						</div>
						<div class="col-md-12 jedaobyek">
							<div class="form-group">
								<label>Judul Buku</label>
								<input type="text" class="form-control" name="txtjudul" value="<?= $judul; ?>" required>
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
											if($id == $idpenerbit){
												echo '<option value="'.$id.'" selected>'.$nama.'</option>';
											}else{
												echo '<option value="'.$id.'">'.$nama.'</option>';
											}
										}
									?>
								</select>
							</div>
						</div>
						<div class="col-md-4 jedaobyek">
							<div class="form-group">
								<label>Tahun</label>
								<input type="text" class="form-control" name="txttahun" value="<?= $tahun; ?>" maxlength="4" required>
							</div>
						</div>
						<div class="col-md-6 jedaobyek">
							<div class="form-group">
								<label>ISBN</label>
								<input type="text" class="form-control" name="txtisbn" value="<?= $isbn; ?>" required>
							</div>
						</div>
						<div class="col-md-6 jedaobyek">
							<div class="form-group">
								<label>Rak</label>
								<input type="text" class="form-control" name="txtrak" value="<?= $rak; ?>" required>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<button type="submit" name="btnsimpan" class="btn btn-primary">Update</button>
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
		$status = $buku->update($kode, $judul, $idpengarang, $idpenerbit, $isbn, $tahun, $rak);
		if($status){
			echo "<script>alert('Update Data Buku Berhasil');</script>";
		}else{
			echo "<script>alert('Update Data Buku Gagal');</script>";
		}
		echo "<script>window.location = 'home';</script>";
	}
?>
