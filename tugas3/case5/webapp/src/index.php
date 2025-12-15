<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Case 5: Guestbook</title>
    <style>
        body { font-family: sans-serif; container: centered; max-width: 600px; margin: auto; background-color: #f4f4f4; padding: 20px; }
        .post { border: 1px solid #ccc; padding: 10px; margin-bottom: 10px; background-color: white; border-radius: 5px; }
        form { margin-top: 20px; }
        input, textarea { width: 100%; padding: 8px; margin-bottom: 10px; border-radius: 4px; border: 1px solid #ddd; }
        button { background-color: #007bff; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; }
    </style>
</head>
<body>
    <h1>Case 5: Buku Tamu Multi-Container</h1>
    <p>Data di sini disimpan dalam container MySQL terpisah.</p>

    <?php
    // --- Konfigurasi Database ---
    $db_host = 'db'; // Ini adalah nama service database dari docker-compose.yml
    $db_user = 'user';
    $db_pass = 'password';
    $db_name = 'guestbook_db';
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    // Tampilkan pesan error jika koneksi gagal
    if ($conn->connect_error) {
        die("<div class='post' style='background-color: #ffdddd;'>Koneksi Database Gagal: " . $conn->connect_error . ". Mohon tunggu beberapa saat hingga database siap.</div>");
    }

    // Proses Form jika ada data yang dikirim
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['nama']) && !empty($_POST['pesan'])) {
        $nama = $conn->real_escape_string($_POST['nama']);
        $pesan = $conn->real_escape_string($_POST['pesan']);
        $conn->query("INSERT INTO messages (nama, pesan) VALUES ('$nama', '$pesan')");
    }

    // Buat tabel jika belum ada
    $conn->query("CREATE TABLE IF NOT EXISTS messages (id INT AUTO_INCREMENT PRIMARY KEY, nama VARCHAR(50), pesan TEXT, timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP)");

    // Tampilkan semua pesan dari database
    $result = $conn->query("SELECT nama, pesan, timestamp FROM messages ORDER BY timestamp DESC");
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='post'><strong>" . htmlspecialchars($row['nama']) . "</strong><small style='float:right;'>" . $row['timestamp'] . "</small><hr><p>" . nl2br(htmlspecialchars($row['pesan'])) . "</p></div>";
        }
    } else {
        echo "<p>Belum ada pesan. Jadilah yang pertama!</p>";
    }
    $conn->close();
    ?>

    <!-- Form untuk mengirim pesan -->
    <form action="index.php" method="post">
        <h3>Tinggalkan Pesan</h3>
        <input type="text" name="nama" placeholder="Nama Anda" required>
        <textarea name="pesan" rows="4" placeholder="Pesan Anda" required></textarea>
        <button type="submit">Kirim Pesan</button>
    </form>
</body>
</html>
