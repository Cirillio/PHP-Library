<?php

$AUTH = false;
function checkAuth()
{
    if (!isset($_SESSION['user_id'])) {
        // header("Location: login");
        return false;
    }
    return true;
}
