$(document).ready(function() {
    // Hilangkan tombol cari
    $('#search-button-jquery').hide()

    // Event ketika keyword ditulis
    $('#keyword-jquery').on('keyup', function() {
        // Tampilkan icon loading
        $('.loading').show()

        // AJAX menggunakan load
        // $('#container').load('ajax/buku.php?keyword=' + $('#keyword-jquery').val())

        // $.get()
        $.get('ajax/buku.php?keyword=' + $('#keyword-jquery').val(), function(data) {

            $('#container').html(data)
            $('.loading').hide()

        })
    })

})