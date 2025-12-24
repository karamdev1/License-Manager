import './bootstrap';

$(document).ready(function () {
    document.addEventListener('contextmenu', event => event.preventDefault());

    window.Toast = Swal.mixin({
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

    window.showMessage = function(type, message) {
        return Swal.fire({
            title: type,
            html: message,
            icon: type.toLowerCase(),
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
    };

    window.showPopup = function(type, message) {
        Toast.fire({
            html: message,
            icon: type.toLowerCase(),
        });
    }

    const logoutBtns = document.querySelectorAll('#logoutBtn');

    if (logoutBtns) {
        logoutBtns.forEach((btn) => {
            btn.addEventListener('click', function () {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Are you sure you want to logout',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, logout',
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('logoutForm').submit();
                    }
                });
            });
        });
    };
});