<?php
session_start();

function generateCSRF() {
    $_SESSION['csrf_token'] = $_SESSION['csrf_token'] ?? sha1(openssl_random_pseudo_bytes(20));
}

function verifyCSRF() {
    return $_SESSION['csrf_token'] && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token']);
}