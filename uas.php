<?php
$buku = new Buku();
include "plugin/phpqrcode/qrlib.php";
$lokasi = "temp/qrcode/";


?>

<div class="row mt-5">
    <div class="col-md-10 ml-auto mr-auto">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Soal UAS SI-A</div>
            </div>
            <div class="card-body">
                <form method="post">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Kolom Filter</label>
                                <select class="form-control" name="cbofilter" required>
                                    <option value="">Pilih Salah Satu</option>
                                    <option value="judul">Judul</option>
                                    <option value="pengarang">Penulis</option>
                                    <option value="penerbit">Penerbit</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Keyword</label>
                                <input type="text" class="form-control" name="txtkeyword" required>
                            </div>
                        </div>
                        <div class="col-md-3 align-self-end">
                            <div class="form-group">
                                <button type="submit" name="btnsimpan" class="btn btn-primary">Filter</button>
                                <button type="reset" class="btn btn-danger"> <a href="cetakpdf"
                                        style="text-decoration: none; color: white;">Cetak PDF</a></button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row mt-4">
                    <?php
                    if (isset($_POST["btnsimpan"])) {
                        $filter = $_POST["cbofilter"];
                        $keyword = $_POST["txtkeyword"];

                        if ($filter == "pengarang") {
                            $dtx = $buku->pengarang($keyword);
                        } elseif ($filter == "penerbit") {
                            $dtx = $buku->penerbit($keyword);
                        } elseif ($filter == "judul") {
                            $dtx = $buku->judul($keyword);
                        }

                        foreach ($dtx as $x) {
                            $nama = $x["nama"];
                            $pengarang = $x["pengarang"];
                            $penerbit = $x["penerbit"];
                            $id = strtotime(date("Y-m-d H:i:s")) . "-" . $x["id"];
                            $path = $lokasi . $id . ".png";
                            QRcode::png($nama, $path, QR_ECLEVEL_H);

                            echo "<div class='col-md-4 mb-4'>
                                    <div class='qr-card'>
                                        <div class='d-flex'>
                                            <div class='mr-3'>
                                                <img src='$path' alt='QR Code'>
                                            </div>
                                            <div>
                                                <h5>Judul: $nama</h5>
                                                <p>Pengarang: $pengarang</p>
                                                <p>Penerbit: $penerbit</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>";
                        }
                    }
                    ?>
                </div>
                <div class="row mt-4">
                    <?php
                    $dtx = $buku->data_tabel();
                    foreach ($dtx as $x) {
                        $nama = $x["judul"];
                        $pengarang = $x["nama_pengarang"];
                        $penerbit = $x["nama_penerbit"];
                        $id = strtotime(date("Y-m-d H:i:s")) . "-" . $x["id"];
                        $path = $lokasi . $id . ".png";
                        QRcode::png($nama, $path, QR_ECLEVEL_H);

                        echo "<div class='col-md-4 mb-4'>
                                <div class='qr-card'>
                                    <div class='d-flex'>
                                        <div class='mr-3'>
                                            <img src='$path' alt='QR Code'>
                                        </div>
                                        <div>
                                            <h5>Judul: $nama</h5>
                                            <p>Pengarang: $pengarang</p>
                                            <p>Penerbit: $penerbit</p>
                                        </div>
                                    </div>
                                </div>
                            </div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>