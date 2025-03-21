function processText(action) {
    let inputText = document.getElementById("inputText").value;

    if (inputText.trim() === "") {
        alert("Masukkan teks terlebih dahulu!");
        return;
    }

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "process.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let response = JSON.parse(xhr.responseText);
            if (response.error) {
                document.getElementById("output").innerHTML = "<p style='color:red'>" + response.error + "</p>";
            } else {
                document.getElementById("output").innerHTML = 
                    "<strong>Hasil:</strong> " + response.text + "<br>" +
                    "<strong>Aksara Jawa:</strong> <span style='font-size:2em'>" + response.unicode + "</span>";
            }
        }
    };

    xhr.send("action=" + action + "&text=" + encodeURIComponent(inputText));
}