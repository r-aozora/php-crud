// Ambil elemen yang dibutuhkan
let keyword = document.getElementById('keyword-ajax')
let searchButton = document.getElementById('search-button-ajax')
let container = document.getElementById('container')

// Tambahkan event ketika keyword ditulis
keyword.addEventListener('keyup', function() {
    // Hilangkan tombol cari
    searchButton.style.display = 'none'

    // Buat objek ajax
    let xhr = new XMLHttpRequest()

    // Cek kesiapan ajax
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            container.innerHTML = xhr.responseText
        }
    }

    // Eksekusi ajax
    xhr.open('GET', `ajax/buku.php?keyword=${keyword.value}`, true)
    xhr.send()

})