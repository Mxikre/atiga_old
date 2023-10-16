document.addEventListener('DOMContentLoaded', function () {
    // code akan berjalan setelah DOM selesai dimuat
    const form = document.getElementById('registrationForm');
    if (form) {
        form.addEventListener('submit', function (event) {
            const password = document.getElementById('pass').value;
            const confirmPassword = document.getElementById('cpass').value;

            if (password !== confirmPassword) {
                alert('Konfirmasi password tidak sesuai.');
                event.preventDefault();
            }
        });
    }
});
