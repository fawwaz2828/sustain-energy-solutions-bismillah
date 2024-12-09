<?php
// Load Composer's autoloader
require_once 'vendor/autoload.php';

// Inisialisasi Google Client
$client = new Google_Client();
$client->setClientId('1084069754802-37nq93lnp9odkc86dhbfv7o2q5prjjq6.apps.googleusercontent.com'); // Ganti dengan Client ID Anda
$client->setClientSecret('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'); // Ganti dengan Client Secret Anda
$client->setRedirectUri('http://localhost/Sustain-Energy-Solution-main/callback.php'); // Ganti dengan URL callback Anda
$client->addScope(Google_Service_Oauth2::USERINFO_PROFILE);
$client->addScope(Google_Service_Oauth2::USERINFO_EMAIL);

// Cek jika parameter "code" ada di URL, menandakan pengguna telah login
if (isset($_GET['code'])) {
    try {
        // Tukar kode dengan token akses
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        $client->setAccessToken($token['access_token']);

        // Dapatkan data profil pengguna dari Google
        $oauth = new Google_Service_Oauth2($client);
        $user = $oauth->userinfo->get();

        // Tampilkan data pengguna
        echo 'Nama: ' . htmlspecialchars($user->name) . '<br>';
        echo 'Email: ' . htmlspecialchars($user->email) . '<br>';
        echo 'Foto Profil: <img src="' . htmlspecialchars($user->picture) . '" /><br>';

        // Simpan data pengguna ke database (opsional)
        // Anda bisa menyimpan $user->name, $user->email, dll ke tabel "users" di database Anda

        // Redirect ke halaman utama setelah login berhasil
        header('Location: index.php');
        exit();
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
} else {
    // Jika belum ada "code", buat URL untuk login Google
    $authUrl = $client->createAuthUrl();
    echo '<a href="' . htmlspecialchars($authUrl) . '">Login dengan Google</a>';
}
?>
