<?php

function statusColor($status) {
    if ($status == 'Active') {
        return 'green';
    } elseif ($status == 'Inactive') {
        return 'red';
    } else {
        return 'yellow';
    }
}

function permissionColor($perm) {
    if ($perm == 'Owner') {
        return 'red';
    } elseif ($perm == 'Manager') {
        return 'yellow';
    } elseif ($perm == 'Reseller') {
        return 'primary';
    } else {
        return 'dark-text';
    }
}