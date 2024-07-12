<?php
	require "assets/SimpleXLSXGen.php";
	require "class/Buku.php";
	$buku = new Buku();
	$dtx = $buku->pdf_excel();
	$dtjson = [];
	array_push($dtjson,['<style font-size="20"><b><center>DAFTAR BUKU</center></b></style>']);
	array_push($dtjson,[
		'<style border="#000000"><b><center>Kode Buku</center></b></style>',
		'<style border="#000000"><b>Judul</b></style>',
		'<style border="#000000"><b>Pengarang</b></style>',
		'<style border="#000000"><b>Penerbit</b></style>',
		'<style border="#000000"><b><center>ISBN</center></b></style>',
		'<style border="#000000"><b><center>Tahun Terbit</center></b></style>',
		'<style border="#000000"><b>Rak</b></style>']);
	foreach($dtx as $x){
		$kode = $x["kode"];
		$judul = $x["judul"];
		$pengarang = $x["pengarang"];
		$penerbit = $x["penerbit"];
		$isbn = $x["isbn"];
		$tahun = $x["tahun"];
		$rak = $x["rak"];
		array_push($dtjson,[
			'<style border="#000000"><center>'.$kode.'</center></style>',
			'<style border="#000000">'.$judul.'</style>',
			'<style border="#000000">'.$pengarang.'</style>',
			'<style border="#000000">'.$penerbit.'</style>',
			'<style border="#000000"><center>'.$isbn.'</center></style>',
			'<style border="#000000"><center>'.$tahun.'</center></style>',
			'<style border="#000000">'.$rak.'</style>']);
	}
	$xlsx = Shuchkin\SimpleXLSXGen::fromArray($dtjson);
	$xlsx->mergeCells("A1:G1");
	$xlsx->downloadAs('Daftar Buku.xlsx');
?>