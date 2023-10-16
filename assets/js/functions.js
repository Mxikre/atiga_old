
// LOGIN BUTTOM
function login() {
    window.location.href = 'pages/login.php';
}

function logout() {
    window.location.href = 'assets/logout.php';
}

// SHOW PASSWORD
function togglePasswordVisibility() {
    var passField = document.getElementById('pass');
    var eyeIcon = document.getElementById('eyeIcon');
    var eyeOffIcon = document.getElementById('eyeOffIcon');

    if (passField.type === 'password') {
        passField.type = 'text';
        eyeIcon.style.display = 'inline';
        eyeOffIcon.style.display = 'none';
    } else {
        passField.type = 'password';
        eyeIcon.style.display = 'none';
        eyeOffIcon.style.display = 'inline';
    }
}