<?php
$buku = new Buku();
include "plugin/phpqrcode/qrlib.php";
$lokasi = "temp/qrcode/";
$filter = isset($_POST['cbofilter']) ? $_POST['cbofilter'] : '';
$keyword = isset($_POST['txtkeyword']) ? $_POST['txtkeyword'] : '';
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
                                <button type="reset" class="btn btn-danger"> <a
                                        href="cetakpdf?cbofilter=<?= $filter ?>&txtkeyword=<?= $keyword ?>"
                                        target="_blank" style=" text-decoration: none; color: white;">Cetak
                                        PDF</a></button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row mt-4">
                    <?php
                    $filteredData = $buku->pdffilter();
                    foreach ($filteredData as $x) {
                        $nama = $x["judul"];
                        $pengarang = $x["nama_pengarang"];
                        $penerbit = $x["nama_penerbit"];
                        $isbn = $x["isbn"];
                        $id = strtotime(date("Y-m-d H:i:s")) . "-" . $x["kode"];
                        $path = $lokasi . $id . ".png";
                        QRcode::png($nama, $path, QR_ECLEVEL_H);

                        echo "<div class='col-md-4 mb-4'>
                                    <div class='qr-card'>
                                        <div class='d-flex'>
                                            <div class='mr-3'>
                                                <img src='$path' alt='QR Code'>
                                                <p>ISBN: $isbn</p>
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
                <div class="row mt-4">
                    <?php
                    $dtx = $buku->data_tabel();
                    foreach ($dtx as $x) {
                        $nama = $x["judul"];
                        $pengarang = $x["nama_pengarang"];
                        $penerbit = $x["nama_penerbit"];
                        $isbn = $x["isbn"];
                        $id = strtotime(date("Y-m-d H:i:s")) . "-" . $x["kode"];
                        $path = $lokasi . $id . ".png";
                        QRcode::png($nama, $path, QR_ECLEVEL_H);

                        echo "<div class='col-md-4 mb-4'>
                                <div class='qr-card'>
                                    <div class='d-flex'>
                                        <div class='mr-3'>
                                            <img src='$path' alt='QR Code'>
                                            <p>ISBN: $isbn</p>
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

<?php
class Buku
{
    private $koneksi;

    public function __construct()
    {
        $this->koneksi = new mysqli("localhost", "username", "password", "database_name");
    }

    public function data_tabel()
    {
        $dtx = [];
        $sql = "SELECT a.*, b.Nama_Pengarang, c.Nama_Penerbit FROM buku AS a 
                LEFT JOIN pengarang AS b ON a.ID_Pengarang = b.ID_Pengarang 
                LEFT JOIN penerbit AS c ON a.ID_Penerbit = c.ID_Penerbit 
                ORDER BY a.Kode_Buku";
        $q = mysqli_query($this->koneksi, $sql);
        while ($x = mysqli_fetch_array($q)) {
            array_push($dtx, [
                "kode" => $x["Kode_Buku"],
                "judul" => $x["Judul"],
                "id_pengarang" => $x["ID_Pengarang"],
                "id_penerbit" => $x["ID_Penerbit"],
                "nama_pengarang" => $x["Nama_Pengarang"],
                "nama_penerbit" => $x["Nama_Penerbit"],
                "isbn" => $x["ISBN"],
                "tahun" => $x["Tahun_Terbit"],
                "rak" => $x["Rak"]
            ]);
        }
        return $dtx;
    }
}
?>