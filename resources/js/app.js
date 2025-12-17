import './bootstrap';

document.addEventListener('contextmenu', event => event.preventDefault());

$(".after-card").hide();
$(document).ready(function () {
    $(".after-card").fadeIn("slow");
    $("input").change(function (e) {
        e.preventDefault();
        $(".form-text, .alert-danger, .form-group .text-danger").hide();
    });

    if (window.APP?.errors?.length) {
        window.APP.errors.forEach(error => {
            showPopup('Error', error);
        });
    }

    if (window.APP?.success) {
        showPopup('Success', window.APP.success);
    }

    if (window.APP?.warning) {
        showPopup('Warning', window.APP.warning);
    }

    if (window.APP?.info) {
        showPopup('Info', window.APP.info);
    }

    function showMessage(type, message) {
        return Swal.fire({
            title: type,
            html: message,
            icon: type.toLowerCase(),
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
    };

    function showPopup(type, message) {
        Toast.fire({
            html: message,
            icon: type.toLowerCase(),
        });
    }

    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener("mouseenter", Swal.stopTimer);
            toast.addEventListener("mouseleave", Swal.resumeTimer);
        },
    });

    document.getElementById('logoutBtn').addEventListener('click', function() {
        Swal.fire({
            title: 'Are you sure?',
            text: "Are you sure you want to logout",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, logout'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logoutForm').submit();
            }
        });
    });
});