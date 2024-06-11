// Navigation functions
function highlightCurrentPage() {
    var currentPage = window.location.pathname.split('/').pop().split('.').shift() + window.location.search;

    var navItems = document.querySelectorAll('.navbar-nav .nav-item');

    navItems.forEach(function (navItem) {
        var navLink = navItem.querySelector('.nav-link');
        var navItemHref = navLink.getAttribute('href').split('/').pop().split('.').shift();

        // Check if the current page matches the nav-link
        if (currentPage === navItemHref) {
            navItem.classList.add('active');
        }

        // Check if the current page matches any dropdown-item
        var dropdownItems = navItem.querySelectorAll('.dropdown-menu .dropdown-item');
        dropdownItems.forEach(function (item) {
            var itemHref = decodeURIComponent(item.getAttribute('href')).split('/').pop().split('.').shift();
            if (currentPage === itemHref) {
                navItem.classList.add('active');
            }
        });
    });
}



// Login and Logout functions
function login() {
    window.location.href = 'pages/login.php';
}

function register() {
    window.location.href = 'pages/register.php';
}

function logout() {
    window.location.href = 'includes/logout.php';
}

// Show Password function
function togglePasswordVisibility(passID, eyeIconID, offIconID) {
    var passField = document.getElementById(passID);
    var eyeIcon = document.getElementById(eyeIconID);
    var eyeOffIcon = document.getElementById(offIconID);

    if (passField.type === 'password') {
        passField.type = 'text';
        eyeIcon.style.display = 'none';
        eyeOffIcon.style.display = 'inline';
    } else {
        passField.type = 'password';
        eyeIcon.style.display = 'inline';
        eyeOffIcon.style.display = 'none';
    }
}

// Display selected image function
function displaySelectedImage(event, elementId) {
    const selectedImage = document.getElementById(elementId);
    const fileInput = event.target;

    if (fileInput.files && fileInput.files[0]) {
        const reader = new FileReader();

        reader.onload = function (e) {
            selectedImage.src = e.target.result;
        };

        reader.readAsDataURL(fileInput.files[0]);
    }
}

// Preloader function
function Preloader() {
    setTimeout(function () {
        var preloader = document.querySelector(".preloader");
        preloader.classList.add("fade-out");
        setTimeout(function () {
            preloader.style.display = "none";
        }, 500);
    }, 1500);
}



// Event listeners
document.addEventListener("DOMContentLoaded", function () {
    highlightCurrentPage();
    Preloader();
});
