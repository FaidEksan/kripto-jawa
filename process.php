<?php
// Susunan aksara Jawa dalam 4 baris & 5 kolom
$aksaraJawa = [
    ['ha', 'na', 'ca', 'ra', 'ka'],
    ['da', 'ta', 'sa', 'wa', 'la'],
    ['pa', 'dha', 'ja', 'ya', 'nya'],
    ['ma', 'ga', 'ba', 'tha', 'nga'],
];

// Unicode aksara Jawa
$aksaraJawaUnicode = [
    "ha" => "ꦲ", "na" => "ꦤ", "ca" => "ꦕ", "ra" => "ꦫ", "ka" => "ꦏ",
    "da" => "ꦢ", "ta" => "ꦠ", "sa" => "ꦱ", "wa" => "ꦮ", "la" => "ꦭ",
    "pa" => "ꦥ", "dha" => "ꦣ", "ja" => "ꦗ", "ya" => "ꦪ", "nya" => "ꦚ",
    "ma" => "ꦩ", "ga" => "ꦒ", "ba" => "ꦧ", "tha" => "ꦛ", "nga" => "ꦔ",
];

// Pemetaan fonetik jika suku kata tidak ditemukan
$pemetaanFonetik = [
    "mu" => "ma",
    "mi" => "ma",
    "me" => "ma",
    "fa" => "pa",
    "i" => "ha",
    "d" => "da",
    "tu" => "ta",
    "ti" => "ta",
    "su" => "sa",
    "si" => "sa",
    "du" => "da",
    "di" => "da"
];

// Fungsi untuk normalisasi teks agar sesuai dengan aksara Jawa
function normalisasiTeks($teks) {
    global $pemetaanFonetik;
    $kata = explode(" ", strtolower($teks));
    $hasil = [];

    foreach ($kata as $sukuKata) {
        if (isset($pemetaanFonetik[$sukuKata])) {
            $hasil[] = $pemetaanFonetik[$sukuKata]; // Ganti dengan fonetik yang ada
        } else {
            $hasil[] = $sukuKata;
        }
    }

    return implode(" ", $hasil);
}

// Fungsi mencari posisi huruf dalam tabel aksara Jawa
function cariPosisi($huruf, $aksaraJawa) {
    foreach ($aksaraJawa as $baris => $kolom) {
        $index = array_search($huruf, $kolom);
        if ($index !== false) {
            return [$baris, $index];
        }
    }
    return null;
}

// Fungsi Enkripsi / Dekripsi
function prosesKriptografi($teks, $aksaraJawa) {
    $teks = normalisasiTeks($teks); // Normalisasi dulu agar sesuai
    $hasil = [];
    $kata = explode(" ", $teks);

    foreach ($kata as $huruf) {
        $posisi = cariPosisi($huruf, $aksaraJawa);
        if ($posisi) {
            list($baris, $kolom) = $posisi;
            
            // Tukar Baris: (1 <-> 3) dan (2 <-> 4)
            if ($baris == 0) $barisBaru = 2;
            elseif ($baris == 1) $barisBaru = 3;
            elseif ($baris == 2) $barisBaru = 0;
            elseif ($baris == 3) $barisBaru = 1;

            $hasil[] = $aksaraJawa[$barisBaru][$kolom];
        } else {
            $hasil[] = $huruf; // Jika tidak ditemukan, biarkan tetap sama
        }
    }

    return implode(" ", $hasil);
}

// Fungsi Konversi ke Aksara Jawa Unicode
function konversiKeUnicode($teks) {
    global $aksaraJawaUnicode;
    $kata = explode(" ", $teks);
    $hasil = [];

    foreach ($kata as $huruf) {
        if (isset($aksaraJawaUnicode[$huruf])) {
            $hasil[] = $aksaraJawaUnicode[$huruf];
        } else {
            $hasil[] = $huruf;
        }
    }

    return implode("", $hasil);
}

// Terima request dari AJAX
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST["action"];
    $text = $_POST["text"];

    if ($action === "encrypt" || $action === "decrypt") {
        $hasilKriptografi = prosesKriptografi($text, $aksaraJawa);
        $hasilUnicode = konversiKeUnicode($hasilKriptografi);
        echo json_encode(["text" => $hasilKriptografi, "unicode" => $hasilUnicode]);
    } else {
        echo json_encode(["error" => "Aksi tidak valid!"]);
    }
}
?>