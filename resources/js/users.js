let users_table = null;

window.initUsersTable = function () {
    if (users_table) return;

    users_table = $('#users_table').DataTable({
        processing: true,
        responsive: true,
        deferLoading: 0,
        order: [[0,'desc']],
        ajax: {
            url: window.APP.routes.usersRegistrations,
            method: "POST",
        },
        columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'username' },
            { data: 'email' },
            { data: 'saldo' },
            { data: 'role' },
            { data: 'reff' },
            { data: 'registrar' },
            { data: 'created' },
            { 
                data: 'user_id',
                render: function(data) {
                    return `
                    <button type="button" class="px-2 py-1 border border-red-600 text-red-600 rounded hover:bg-red-600 hover:text-white transition-colors duration-200 cursor-pointer" id="deleteBtnUsers" data-id="${data}"><i class="bi bi-trash"></i></button>
                    <button type="button" class="px-2 py-1 border border-dark rounded hover:bg-dark hover:text-white transition-colors duration-200 cursor-pointer" id="updateBtnUsers" data-id="${data}"><i class="bi bi-pencil-square"></i></button>
                    `;
                }
            }
        ],
        columnDefs: [
            { targets: [7, 8], searchable: false },
            { targets: [0, 1, 2, 4], searchable: true },
            { targets: [5, 6], visible: false, searchable: true },
            { orderable: false, targets: -1 }
        ],
        scrollX: true,
        stripeClasses: [],
        createdRow: function (row) {
            $(row).find('td').removeClass('p-3').addClass('px-6 py-3 text-center text-sm font-semibold text-dark-text border border-gray-200');
        },
        language: {
            processing: `
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2
                            bg-primary text-white px-4 py-2 rounded shadow z-50">
                    Processing...
                </div>
            `
        }
    });
}

window.UsersTableReload = function () {
    if (users_table) {
        users_table.ajax.reload(null, false);
    }
}

window.createUser = function () {
    Swal.fire({
        title: 'Register User',
        html: `
            <input type="text" id="name" class="swal2-input" placeholder="Name">
            <input type="text" id="username" class="swal2-input" placeholder="Username">
            <input type="email" id="email" class="swal2-input" placeholder="Email">
            <input type="text" id="password" class="swal2-input" placeholder="Password">
            <select id="status" class="swal2-input">
                <option value="">-- Select Status --</option>
                <option value="Active" selected>Active</option>
                <option value="Inactive">Inactive</option>
            </select>
            <select id="role" class="swal2-input">
                <option value="">-- Select Role --</option>
                <option value="Owner" class="text-red-600">Owner</option>
                <option value="Manager" class="text-yellow-300">Manager</option>
                <option value="Reseller" class="text-primary" selected>Reseller</option>
            </select>
        `,
        confirmButtonText: 'Create',
        showCancelButton: true,
        cancelButtonText: 'Cancel',
        focusConfirm: false,
        preConfirm: () => {
            const name = document.getElementById('name').value.trim();
            const username = document.getElementById('username').value.trim();
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();
            const status = document.getElementById('status').value;
            const role = document.getElementById('role').value;

            if (!name) {
                Swal.showValidationMessage('Name is required');
                return false;
            }
            if (!username) {
                Swal.showValidationMessage('Username is required');
                return false;
            }
            if (!email) {
                Swal.showValidationMessage('Email is required');
                return false;
            }
            if (!password) {
                Swal.showValidationMessage('Password is required');
                return false;
            }
            if (!status) {
                Swal.showValidationMessage('Status must be selected');
                return false;
            }
            if (!role) {
                Swal.showValidationMessage('Role must be required');
                return false;
            }

            return { name, username, email, password, status, role };
        }
    }).then((result) => {
        if (!result.isConfirmed) return;
        Toast.fire({
            icon: 'info',
            html: 'Processing...',
        });

        $.ajax({
            url: window.APP.routes.usersRegister,
            method: 'POST',
            data: result.value,
            headers: {
                'X-CSRF-TOKEN': window.APP.csrf
            },
            success: function(res) {
                if (res.status == 0) {
                    window.showPopup('Success', res.message);
                    AppsTableReload();
                } else {
                    window.showPopup('Error', res.message);
                }
            },
            error: function(err) {
                const message = err.responseJSON?.message || 'Something went wrong';
                window.showPopup('Error', message);
            }
        });
    });
}

window.updateUserForm = function (id, app_id, app_name, app_status, app_price) {
    Swal.fire({
        title: 'Update User',
        html: `
            <input type="hidden" id="editId" value="${id}">
            <input type="text" id="appId" class="swal2-input" placeholder="App ID" value="${app_id}">
            <input type="text" id="appName" class="swal2-input" placeholder="App Name" value="${app_name}">
            <select id="appStatus" class="swal2-input">
                <option value="">-- Select Status --</option>
                <option value="Active" ${app_status === 'Active' ? 'selected' : ''}>Active</option>
                <option value="Inactive" ${app_status === 'Inactive' ? 'selected' : ''}>Inactive</option>
            </select>
            <input type="number" id="appPrice" class="swal2-input" placeholder="Price" value="${app_price}">
        `,
        confirmButtonText: 'Update',
        showCancelButton: true,
        cancelButtonText: 'Cancel',
        focusConfirm: false,
        preConfirm: () => {
            const edit_id = document.getElementById('editId').value;
            const app_id = document.getElementById('appId').value.trim();
            const name = document.getElementById('appName').value.trim();
            const status = document.getElementById('appStatus').value;
            const price = document.getElementById('appPrice').value;

            if (!edit_id) {
                Swal.showValidationMessage('Edit ID is required');
                return false;
            }
            if (!app_id) {
                Swal.showValidationMessage('App ID is required');
                return false;
            }
            if (!name) {
                Swal.showValidationMessage('App Name is required');
                return false;
            }
            if (!status) {
                Swal.showValidationMessage('Status must be selected');
                return false;
            }
            if (!price) {
                Swal.showValidationMessage('Price is required');
                return false;
            }

            return { edit_id, app_id, name, status, price };
        }
    }).then((result) => {
        if (!result.isConfirmed) return;
        Toast.fire({
            icon: 'info',
            html: 'Processing...',
        });

        $.ajax({
            url: window.APP.routes.userUpdate,
            method: 'POST',
            data: result.value,
            headers: {
                'X-CSRF-TOKEN': window.APP.csrf
            },
            success: function(res) {
                if (res.status == 0) {
                    window.showPopup('Success', res.message);
                    AppsTableReload();
                } else {
                    window.showPopup('Error', res.message);
                }
            },
            error: function(err) {
                const message = err.responseJSON?.message || 'Something went wrong';
                window.showPopup('Error', message);
            }
        });
    });
};

window.updateUser = function (id) {
    $.ajax({
        url: window.APP.routes.userData,
        method: 'POST',
        data: { id: id },
        success: function(res) {
            if (res.status == 0) {
                updateAppForm(id, res.app_id, res.app_name, res.app_status, res.price);
            } else {
                window.showPopup('Error', res.message);
            }
        },
        error: function(err) {
            const message = err.responseJSON?.message || 'Something went wrong';
            window.showPopup('Error', message);
        }
    });
};

window.deleteUser = function (id, name) {
    Swal.fire({
        icon: 'info',
        title: 'Delete User',
        html: `Are you sure you want to delete user <b>${name}</b>?`,
        confirmButtonText: 'Delete',
        showCancelButton: true,
        cancelButtonText: 'Cancel',
        focusConfirm: false,
    }).then((result) => {
        if (!result.isConfirmed) return;
        Toast.fire({
            icon: 'info',
            html: 'Processing...',
        });

        $.ajax({
            url: window.APP.routes.usersDelete,
            method: 'POST',
            data: { edit_id: id },
            headers: {
                'X-CSRF-TOKEN': window.APP.csrf
            },
            success: function(res) {
                if (res.status == 0) {
                    window.showPopup('Success', res.message);
                    AppsTableReload();
                } else {
                    window.showPopup('Error', res.message);
                }
            },
            error: function(err) {
                const message = err.responseJSON?.message || 'Something went wrong';
                window.showPopup('Error', message);
            }
        });
    });
};

$(document).ready(function () {
    $('#reloadBtnUsers').on('click', () => {
        UsersTableReload();
    });

    $('#createBtnUsers').on('click', () => {
        createUser();
    });

    $(document).on('click', '#editBtnUsers', async function() {
        const id = $(this).data('id');
        updateUser(id);
    });

    $(document).on('click', '#deleteBtnUsers', async function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        deleteUser(id, name);
    });

    $("#blur-out-users").click(function() {
        if ($(".Blur-User").hasClass("blur")) {
            $(".Blur-User").removeClass("blur");
            $("#blur-out").html(`<i class="bi bi-eye"></i>`);
        } else {
            $(".Blur-User").addClass("blur");
            $("#blur-out").html(`<i class="bi bi-eye-slash"></i>`);
        }
    });

    $(document).on('click', '.copy-user', async function() {
        const copy = $(this).data('copy');

        const code = await copyToClipboard(copy);

        let message = "";
        let icon = "error";

        switch (code) {
            case 0:
                message = `<b>User</b> ${copy} <b>Successfully Copied</b>`;
                icon = "success";
                break;
            case 1:
                message = "Clipboard API failed.";
                break;
            case 2:
                message = "Fallback copy failed.";
                break;
            case 3:
                message = "Clipboard API not available (HTTP or insecure context).";
                break;
        }

        Toast.fire({
            html: message,
            icon: icon,
        });
    });
});