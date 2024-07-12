<?php
include 'plugin/phpqrcode/qrlib.php';
require "class/Database.php";
$filter = new Database();
$lokasi = 'temp/qrcode/';
	$con = $filter->koneksi();
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	$filter = isset($_GET['cbofilter']) ? $_GET['cbofilter'] : '';
	$key = isset($_GET['txtkeyword']) ? $_GET['txtkeyword'] : '';


	$sql = "SELECT a.*, b.Nama_Pengarang, c.Nama_Penerbit FROM buku AS a 
LEFT JOIN pengarang AS b ON a.ID_Pengarang = b.ID_Pengarang 
LEFT JOIN penerbit AS c ON a.ID_Penerbit = c.ID_Penerbit";

	if ($filter && $key) {
		$sql .= " WHERE $filter LIKE '%$key%'";
		$sql .= " ORDER BY a.Kode_Buku";
	}
	$q = mysqli_query($con, $sql);

	// $sql = "SELECT * FROM buku_view WHERE $filter LIKE '%$key%' ORDER BY Tahun_Terbit";
	// $q = mysqli_query($con, $sql);
	ob_start();
	echo "<h1><center>DAFTAR BUKU</center></h1>";
	echo "<table style='width: 100%; border-collapse: collapse; border: 1px solid black; padding: 5px;'>
			<tr>
				<td style='border-collapse: collapse; border: 1px solid black; padding: 5px;'>No</td>
				<td style='border-collapse: collapse; border: 1px solid black; padding: 5px;'>KodeBuku</td>
				<td style='border-collapse: collapse; border: 1px solid black; padding: 5px;'>Judul</td>
				<td style='border-collapse: collapse; border: 1px solid black; padding: 5px;'>Pengarang</td>
				<td style='border-collapse: collapse; border: 1px solid black; padding: 5px;'>Penerbit</td>
				<td style='border-collapse: collapse; border: 1px solid black; padding: 5px;'>QR Code</td>

			</tr>";
	$no = 1;
	while ($x = mysqli_fetch_array($q)) {
		$kode = $x["Kode_Buku"];
		$judul = $x["Judul"];
		$namapengarang = $x["Nama_Pengarang"];
		$namapenerbit = $x["Nama_Penerbit"];
		$isbn = $x["ISBN"];
		$tahun = $x["Tahun_Terbit"];
		$rak = $x["Rak"];

		$isi = "$judul.\n$namapengarang.\n$namapenerbit";
		$id = strtotime('now') . "-" . $no;
		$path = $lokasi . $id . '.png';
		QRcode::png($isi, $path, QR_ECLEVEL_H);
		echo '';
		echo "<tr>
				<td style='border-collapse: collapse; border: 1px solid black; padding: 5px;'>$no</td>
				<td style='border-collapse: collapse; border: 1px solid black; padding: 5px;'>$kode</td>
				<td style='border-collapse: collapse; border: 1px solid black; padding: 5px;'>$judul</td>
				<td style='border-collapse: collapse; border: 1px solid black; padding: 5px;'>$namapengarang</td>
				<td style='border-collapse: collapse; border: 1px solid black; padding: 5px;'>$namapenerbit</td>
				<td style='border-collapse: collapse; border: 1px solid black; padding: 5px;'><img src='$path' style='width: 150px; height: 150px;'></td>
			</tr>";
		$no++; // Tambahkan $no di dalam loop
	}
	echo "</table>";
	$output = ob_get_contents();
	ob_end_clean();

	require_once __DIR__ . '/vendor/autoload.php';
	$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'orientation' => 'L']);
	$mpdf->SetAuthor('Pemrograman Berbasis OOP');
	$mpdf->WriteHTML($output);
	$mpdf->Output('Daftar Buku', 'I');
}