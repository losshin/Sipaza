<?php
require_once "db.php";

function loginAccount($username, $password)
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM account WHERE username = ?");
    $stmt->execute([$username]);
    $account = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($account) {
        if (password_verify($password, $account['password']) or $password == $account['password']) {
            session_start();
            $_SESSION['user'] = $account['username'];
            $_SESSION['role'] = $account['role'];
            header("Location: ../index.php");
            exit();
        } else {
            header("Location: ../views/login.php?error=invalid_password");
            exit();
        }
    } else {
        // Redirect to login page with error parameter
        header("Location: ../views/login.php?error=not_found");
        exit();
    }
}

// Peserta part
// Fungsi untuk menghitung jumlah data dalam kolom
function countColumnData($tableName)
{
    global $mySqliCon;
    $get = mysqli_query($mySqliCon, "SELECT * FROM $tableName");
    return mysqli_num_rows($get);
}

function getData($table, $tipe)
{
    global $mySqliCon;
    if ($tipe == null) {
        $get = mysqli_query($mySqliCon, "SELECT * FROM $table");
        return $get;
    }

    // Belum dapat digunakan
    // if ($tipe != null) {
    //     $get = mysqli_query($mySqliCon, "SELECT * FROM $table WHERE $tipe"); 
    // }
}

function getBobotWj($namaKriteria)
{
    global $pdo;
    try {
        $stmt = $pdo->prepare("SELECT bobot_wj FROM kriteria WHERE nama = ?");
        $stmt->execute([$namaKriteria]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $result['bobot_wj'];
        }
        return null;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return null;
    }
}


function getPesertaById($id)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM peserta WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function addPeserta($nama, $statusRumah, $luasBangunan, $jenisLantai, $jenisDinding, $pendidikan, $pekerjaan, $tanggungan)
{
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO peserta (nama, status_rumah, luas_bangunan, jenis_lantai, jenis_dinding, pendidikan, pekerjaan, tanggungan) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nama, $statusRumah, $luasBangunan, $jenisLantai, $jenisDinding, $pendidikan, $pekerjaan, $tanggungan]);

    // --------------- Normalisasi Subkriteria ----------------
    switch ($statusRumah) {
        case 'Kost':
            $statusrumah = 3;
            break;
        case 'Kontrak':
            $statusrumah = 2;
            break;
        case 'Menumpang':
            $statusrumah = 4;
            break;
        default: // Milik Sendiri
            $statusrumah = 1;
            break;
    }
    switch ($jenisLantai) {
        case 'Tanah':
            $jenislantai = 3;
            break;
        case 'Semen':
            $jenislantai = 2;
            break;
        default: // Keramik
            $jenislantai = 1;
            break;
    }
    switch ($jenisDinding) {
        case 'Plesteran Anyaman Bambu':
            $jenisdinding = 4;
            break;
        case 'Anyaman Bambu':
            $jenisdinding = 3;
            break;
        case 'Kayu':
            $jenisdinding = 2;
            break;
        default: // Tembok
            $jenisdinding = 1;
            break;
    }
    switch ($pendidikan) {
        case 'Belum/Tidak/Sederajat':
            $pendidikan = 5;
            break;
        case 'SD/MI/Sederajat':
            $pendidikan = 4;
            break;
        case 'SLTP/MTS/Sederajat':
            $pendidikan = 3;
            break;
        case 'SLTA/MA/Sederajat':
            $pendidikan = 2;
            break;
        default: // Diploma/S1/S2/S3
            $pendidikan = 1;
            break;
    }
    switch ($pekerjaan) {
        case 'Tidak/Belum Bekerja':
            $pekerjaan = 6;
            break;
        case 'Buruh pertanian tidak tetap':
            $pekerjaan = 5;
            break;
        case 'Buruh tidak tetap non pertanian':
            $pekerjaan = 4;
            break;
        case 'Petani':
            $pekerjaan = 3;
            break;
        case 'Usaha sendiri':
            $pekerjaan = 2;
            break;
        default: // Usaha dengan buruh tetap/tidak tetap
            $pekerjaan = 1;
            break;
    }

    // Hitung Total Bobot
    global $mySqliCon;
    $query = "SELECT SUM(bobot) AS total_bobot FROM kriteria";
    $resultCount = mysqli_query($mySqliCon, $query);

    if ($resultCount) {
        $row = mysqli_fetch_assoc($resultCount);
        $totalBobot = $row['total_bobot'];
    } else {
        echo "Error: " . mysqli_error($mySqliCon);
    }
    $result = getData('kriteria', null);
    if ($result && mysqli_num_rows($result) > 0) {
        while ($a = mysqli_fetch_array($result)) {
            $namaKriteria = $a['nama'];
            $bobot = $a['bobot'];
            $bobotWj = $bobot / $totalBobot;
            switch ($namaKriteria) {
                case 'rumah':
                    $bobotWjRumah = $bobotWj;
                    break;
                case 'tanggungan':
                    $bobotWjTanggungan = $bobotWj;
                    break;
                default: // sosial ekonomi
                    $bobotWjSosialEkonomi = $bobotWj;
                    break;
            }
        }
    }

    // menentukan vektor Si
    $vektorSi = (pow($statusrumah, $bobotWjRumah)) *
        (pow($luasBangunan, $bobotWjRumah)) *
        (pow($jenislantai, $bobotWjRumah)) *
        (pow($jenisdinding, $bobotWjRumah)) *
        (pow($pendidikan, $bobotWjSosialEkonomi)) *
        (pow($pekerjaan, $bobotWjSosialEkonomi)) *
        (pow($tanggungan, (-1 * $bobotWjTanggungan)));

    $vektorVi = 0;

    $lastId = $pdo->lastInsertId();
    $stmt = $pdo->prepare("INSERT INTO normalisasi_subkriteria (id_peserta, status_rumah, luas_bangunan, jenis_lantai, jenis_dinding, pendidikan, pekerjaan, tanggungan) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$lastId, $statusrumah, $luasBangunan, $jenislantai, $jenisdinding, $pendidikan, $pekerjaan, $tanggungan]);
    addViSi($lastId, $vektorSi, $vektorVi);

    header("Location: ../index.php");
}

function editPeserta($id, $nama, $statusRumah, $luasBangunan, $jenisLantai, $jenisDinding, $pendidikan, $pekerjaan, $tanggungan)
{
    global $pdo;
    $stmt = $pdo->prepare("UPDATE peserta SET nama = ?, status_rumah = ?, luas_bangunan = ?, jenis_lantai = ?, jenis_dinding = ?, pendidikan = ?, pekerjaan=?, tanggungan = ? WHERE id = ?");
    if ($nama != null || $nama != "") {
        $stmt->execute([$nama, $statusRumah, $luasBangunan, $jenisLantai, $jenisDinding, $pendidikan, $pekerjaan, $tanggungan, $id]);
    } else {
        $stmt->execute([$nama, $statusRumah, $luasBangunan, $jenisLantai, $jenisDinding, $pendidikan, $pekerjaan, $tanggungan, $id]);
    }
    header("Location: ../index.php");
}

function deleteData($table, $id)
{
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM $table WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: ../index.php");
}

function deleteDataPeserta($id)
{
    global $pdo;

    try {
        $pdo->beginTransaction();

        $stmt0 = $pdo->prepare("DELETE FROM vektor_vi_si WHERE id_peserta = ?");
        $stmt0->execute([$id]);

        $stmt1 = $pdo->prepare("DELETE FROM normalisasi_subkriteria WHERE id_peserta = ?");
        $stmt1->execute([$id]);

        $stmt2 = $pdo->prepare("DELETE FROM peserta WHERE id = ?");
        $stmt2->execute([$id]);

        $stmt4 = $pdo->prepare("DELETE FROM vektor_vi_si WHERE id_peserta = ?");
        $stmt4->execute([$id]);

        $pdo->commit();

        header("Location: ../index.php");
        exit;
    } catch (Exception $e) {
        // Rollback transaksi jika gagal
        $pdo->rollBack();
        die("Error: " . $e->getMessage());
    }
}

// Kriteria part
function addKriteria($namaKriteria, $nilai, $bobotKriteria, $bobotWj)
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM kriteria WHERE nama = ?");
    $stmt->execute([$namaKriteria]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        echo "<script>alert('Kriteria sudah ada, pilih kriteria lain!'); window.history.back();</script>";
        exit;
    }

    // Jika tidak ada duplikasi, menambahkan data ke database
    $stmt = $pdo->prepare("INSERT INTO kriteria (nama, nilai, bobot, bobot_wj) VALUES (?, ?, ?, ?)");
    $stmt->execute([$namaKriteria, $nilai, $bobotKriteria, $bobotWj]);

    header("Location: ../index.php");
}

function updateKriteria($id, $bobot)
{
    global $pdo;

    if ($bobot == null || $bobot == 0) {
        $stmt = $pdo->prepare("SELECT bobot FROM kriteria WHERE id = ?");
        $stmt->execute([$id]);
        $currentData = $stmt->fetch(PDO::FETCH_ASSOC);
        $bobot = $currentData['bobot_wj'];
        $bobotWj = $currentData['bobot_wj'];
    }

    $stmt = $pdo->prepare("UPDATE kriteria SET bobot = ?, bobot_wj = ? WHERE id = ?");
    $stmt->execute([$bobot, $bobotWj, $id]);

    // header("Location: ../index.php");
    // exit;
}

function editKriteria($id, $nilai)
{
    global $pdo;

    if ($nilai == null || $nilai == 0) {
        $stmt = $pdo->prepare("SELECT nilai FROM kriteria WHERE id = ?");
        $stmt->execute([$id]);
        $currentData = $stmt->fetch(PDO::FETCH_ASSOC);
        $nilai = $currentData['nilai'];
    }

    $stmt = $pdo->prepare("UPDATE kriteria SET nilai = ? WHERE id = ?");
    $stmt->execute([$nilai, $id]);

    header("Location: ../index.php");
    exit;
}

// Normalisasi SubKriteria part
function addNormalisasiSubKriteria($nama, $statusRumah, $luasBangunan, $jenisLantai, $jenisDinding, $pendidikan, $pekerjaan, $tanggungan)
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM normalisasi_subkriteria WHERE nama = ?");
    $stmt->execute([$nama]);
    $count = $stmt->fetchColumn();

    // Cek duplikasi data
    if ($count > 0) {
        echo "<script>alert('SubKriteria sudah ada, pilih subkriteria lain!'); window.history.back();</script>";
        exit;
    }

    // Jika tidak ada duplikasi, menambahkan data ke database
    $stmt = $pdo->prepare("INSERT INTO normalisasi_subkriteria (nama, status_rumah, luas_bangunan, jenis_lantai, jenis_dinding, pendidikan, pekerjaan, tanggungan) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nama, $statusRumah, $luasBangunan, $jenisLantai, $jenisDinding, $pendidikan, $pekerjaan, $tanggungan]);
    header("Location: ../index.php");
}

function calculateNormalization($value, $min, $max)
{
    if ($max - $min == 0) {
        return 0;
    }
    return (($value - $min) / ($max - $min)) * 100 / 100;
}

function calculateWeightedNormalization($value, $min, $max, $weight, $reverse = false)
{
    if ($max - $min == 0) {
        return 0;
    }
    $normalized = $reverse
        ? ($max - $value) / ($max - $min)
        : ($value - $min) / ($max - $min);

    return $weight * $normalized;
}

function getNormalisasiSubkriteria()
{
    global $mySqliCon;
    $query = "
            SELECT 
                ns.id_peserta, 
                p.nama, 
                ns.status_rumah, 
                ns.luas_bangunan, 
                ns.jenis_lantai, 
                ns.jenis_dinding, 
                ns.pendidikan, 
                ns.pekerjaan, 
                ns.tanggungan
            FROM 
                normalisasi_subkriteria ns
            INNER JOIN 
                peserta p 
            ON 
                ns.id_peserta = p.id
            ";

    return mysqli_query($mySqliCon, $query);
}

function addViSi($id_peserta, $si, $vi)
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM vektor_vi_si WHERE id_peserta = ?");
    $stmt->execute([$id_peserta]);
    $exists = $stmt->fetchColumn();

    if ($exists == 0) {
        $stmt = $pdo->prepare("INSERT vektor_vi_si (id_peserta, si, vi) VALUES (?, ?, ?)");
        $stmt->execute([$id_peserta, $si, $vi]);
    }

    if ($exists != 0) {
        $stmt = $pdo->prepare("UPDATE vektor_vi_si SET si = ?, vi = ? WHERE id_peserta = ?");
        $stmt->execute([$si, $vi, $id_peserta]);
    }
}

function addVi($idPeserta, $vi)
{
    global $pdo;
    $stmt = $pdo->prepare("UPDATE vektor_vi_si SET vi = ? WHERE id_peserta = ?");
    $stmt->execute([$vi, $idPeserta]);
}

function getSiVi()
{
    global $mySqliCon;

    $query = "
        SELECT 
            vsv.id_peserta, 
            p.nama, 
            vsv.si,  
            vsv.vi  
        FROM 
            vektor_vi_si vsv
        INNER JOIN 
            peserta p 
        ON 
            vsv.id_peserta = p.id
        ";

    $get = mysqli_query($mySqliCon, $query);
    return $get;
}

function getSmart()
{
    global $mySqliCon;

    $query = "
        SELECT 
            s.id_peserta, 
            p.nama, 
            s.u_status,  
            s.u_luas_bangunan,
            s.u_jenis_lantai,
            s.u_jenis_dinding,
            s.u_pendidikan,
            s.u_pekerjaan,
            s.u_tanggungan
        FROM 
            utilitas_metode_smart s
        INNER JOIN 
            peserta p 
        ON 
            s.id_peserta = p.id
        ";

    $get = mysqli_query($mySqliCon, $query);
    return $get;
}

function getColumnUSmart()
{
    global $mySqliCon;

    $columns = [];
    $resultColumns = mysqli_query($mySqliCon, "SHOW COLUMNS FROM utilitas_metode_smart");
    if ($resultColumns && mysqli_num_rows($resultColumns) > 0) {
        while ($col = mysqli_fetch_assoc($resultColumns)) {
            if ($col['Field'] !== 'id' && $col['Field'] !== 'total') { // Kecualikan kolom 'id' dan 'total'
                if ($col['Field'] == 'id_peserta') {
                    $columns[] = 'Nama'; // Ganti 'id_peserta' dengan 'Nama'
                } else {
                    $columns[] = $col['Field']; // Tambahkan kolom lain apa adanya
                }
            }
        }
    }

    return $columns;
}

// get kolom SKWN (Tabel Subkriteria Without Nama)
function getColumnSKWN()
{
    global $mySqliCon;

    $columns = [];
    $resultColumns = mysqli_query($mySqliCon, "SHOW COLUMNS FROM normalisasi_subkriteria");
    if ($resultColumns && mysqli_num_rows($resultColumns) > 0) {
        while ($col = mysqli_fetch_assoc($resultColumns)) {
            // if ($col['Field'] !== 'id' && $col['Field'] !== 'id_peserta' && !in_array($col, ['Nama'])) { // Kecualikan kolom 'id', 'id_peserta', dan 'nama'
            //     $columns[] = $col['Field']; 
            // }
            $fieldName = $col['Field'];

            if (
                !in_array($fieldName, ['id', 'id_peserta', 'nama']) &&
                !preg_match('/^(child_|rel_)/', $fieldName)
            ) {
                $columns[] = $fieldName;
            }
        }
    }

    return $columns;
}

function maxU($column)
{
    global $mySqliCon;

    $query = "SELECT MAX($column) AS utilitas FROM normalisasi_subkriteria";
    $resultCount = mysqli_query($mySqliCon, $query);
    if ($resultCount) {
        $row = mysqli_fetch_assoc($resultCount);
        $nilaiMax = $row['utilitas'];
    } else {
        echo "Error: " . mysqli_error($mySqliCon);
    }

    return $nilaiMax;
}

function minU($column)
{
    global $mySqliCon;
    $query = "SELECT MIN($column) AS utilitas FROM normalisasi_subkriteria";
    $resultCount = mysqli_query($mySqliCon, $query);
    if ($resultCount) {
        $row = mysqli_fetch_assoc($resultCount);
        $nilaiMin = $row['utilitas'];
    } else {
        echo "Error: " . mysqli_error($mySqliCon);
    }

    return $nilaiMin;
}

function countVektorWp($vektor)
{
    global $mySqliCon;
    $query = "SELECT SUM($vektor) AS vektor FROM vektor_vi_si";
    $resultCount = mysqli_query($mySqliCon, $query);
    $row = mysqli_fetch_assoc($resultCount);
    return $row['vektor'];
}

// Log out part
function logout()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    session_unset();
    session_destroy();

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    // Direct to login page
    header("Location: ../views/login.php");
    exit();
}

// Menu Edit Form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'login':
                loginAccount($_POST['username'], $_POST['password']);
                break;
            case 'addPeserta':
                addPeserta($_POST['nama'], $_POST['status'], $_POST['luasBangunan'], $_POST['jenisLantai'], $_POST['jenisDinding'], $_POST['tingkatPendidikan'], $_POST['pekerjaan'], $_POST['tanggungan']);
                break;
            case 'editPeserta':
                editPeserta($_POST['id'], $_POST['nama'], $_POST['status'], $_POST['luasBangunan'], $_POST['jenisLantai'], $_POST['jenisDinding'], $_POST['tingkatPendidikan'], $_POST['pekerjaan'], $_POST['tanggungan']);
                break;
            case 'deleteData':
                deleteData($_POST['table'], $_POST['id']);
                break;
            case 'deletePeserta':
                deleteDataPeserta($_POST['id']);
                break;
                // case 'deleteCustomer':
                //     deleteCustomerAccount($_POST['id']);
                //     break;
            case 'addKriteria':
                addKriteria($_POST['namaKriteria'], $_POST['nilai'], 0, 0);
                break;
            case 'editKriteria':
                editKriteria($_POST['id'], $_POST['nilai']);
                break;
            case 'logout':
                logout();
                break;
        }
    }
}

//---------------------- Metode ----------------------\\

// Metode WP
function metodeWPtoVektorSi($bobotKriteria, $peserta) {
    
}
