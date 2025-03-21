<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kriptografi Aksara Jawa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>🔐 Kriptografi Aksara Jawa</h2>
        <p>Masukkan teks untuk dienkripsi atau didekripsi:</p>
        
        <textarea id="inputText" placeholder="Masukkan teks di sini..."></textarea>
        
        <div class="buttons">
            <button onclick="processText('encrypt')">🔒 Enkripsi</button>
            <button onclick="processText('decrypt')">🔓 Dekripsi</button>
        </div>

        <h3>Hasil:</h3>
        <div id="output"></div>
    </div>

    <script src="script.js"></script>
</body>
</html>