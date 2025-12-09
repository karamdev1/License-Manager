<?php

function statusColor($status) {
    if ($status == 'Active') {
        return 'success';
    } elseif ($status == 'Inactive') {
        return 'danger';
    } else {
        return 'warning';
    }
}

function permissionColor($perm) {
    if ($perm == 'Owner') {
        return 'danger';
    } elseif ($perm == 'Manager') {
        return 'warning';
    } elseif ($perm == 'Reseller') {
        return 'primary';
    } else {
        return 'dark';
    }
}