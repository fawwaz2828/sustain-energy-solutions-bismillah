<?php
// Load Composer's autoloader
require_once 'vendor/autoload.php';

// Setup Google Client
$client = new Google_Client();
$client->setClientId('1084069754802-37nq93lnp9odkc86dhbfv7o2q5prjjq6.apps.googleusercontent.com');  // Ganti dengan Client ID Anda
$client->setClientSecret('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');  // Ganti dengan Client Secret Anda
$client->setRedirectUri('http://localhost/Sustain-Energy-Solution-main/callback.php');  // Ganti dengan URL callback Anda

// Ambil token akses dari parameter "code"
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);

    // Mendapatkan informasi profil pengguna
    $oauth = new Google_Service_Oauth2($client);
    $user = $oauth->userinfo->get();

    // Tampilkan informasi pengguna
    echo 'Nama: ' . $user->name . '<br>';
    echo 'Email: ' . $user->email . '<br>';
    echo 'Foto Profil: <img src="' . $user->picture . '" /><br>';

    // Simpan data pengguna ke database (misalnya, untuk pertama kali login)
    // Contoh simpan ke database MySQL:
    $servername = "localhost";
    $username = "root";
    $password = "123";
    $dbname = "ses"; // Nama database Anda

    // Membuat koneksi
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Query untuk menyimpan data pengguna
    $stmt = $conn->prepare("INSERT INTO users (name, email, picture) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $user->name, $user->email, $user->picture);
    $stmt->execute();

    echo "Pengguna berhasil disimpan ke database!";
    $stmt->close();
    $conn->close();
} else {
    echo "Kode OAuth tidak ditemukan!";
}
?>
