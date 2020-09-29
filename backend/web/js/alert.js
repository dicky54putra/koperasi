const flashdata = $('.success').data('flashdata');
const flashdata2 = $('.error').data('flashdata');

if (flashdata) {
    Swal.fire({
        icon: 'success',
        title: 'Data Berhasil ' + flashdata,
        text: '',
        timer: 1500,
        customClass: 'swal-wide', // agar bisa saya edit ukuran popupnya
    })
}
if (flashdata2) {
    Swal.fire({
        icon: 'error',
        title: flashdata2,
        text: '',
        // timer: 1500,
        customClass: 'swal-wide', // agar bisa saya edit ukuran popupnya
    })
}

// Ketika Dihapus
$(".tombol-hapus").click(function (e) {
    console.log = e;
    e.preventDefault(); // untuk menghentikan href
    e.stopImmediatePropagation();
    const href = $(this).attr('href');
    Swal.fire({
        title: 'Apakah anda yakin?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Hapus data',
        customClass: 'swal-wide',
    }).then((result) => {
        if (result.isConfirmed) {
            document.location.href = href;
        }
    })
});