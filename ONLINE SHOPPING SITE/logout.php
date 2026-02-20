<?php
/**
 * Logout Page
 * ADIEYEFEH ONLINE SHOPPING
 */

require_once 'config.php';

// Destroy session
session_destroy();

// Redirect to home
redirect('index.php');
