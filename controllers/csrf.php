<?php

function generateCSRF() {
    $csrf = isset($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : "";
    if (!$csrf) {
        $csrf = sha1(openssl_random_pseudo_bytes(16));
        $_SESSION['csrf_token'] = $csrf;
    }
}

function verifyCSRF($csrf) {
    if (isset($_SESSION['csrf_token'])) {
        return hash_equals($_SESSION['csrf_token'], $csrf);
    }
    return false;
}