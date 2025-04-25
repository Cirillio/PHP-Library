<?php

$TITLE = "PHP Library";
$AUTH = false;

function setPageTitle($_title)
{
    global $TITLE;
    $TITLE = $_title . " | " . $TITLE;
}

function checkAuth()
{
    if (isset($_SESSION['user_id'])) {
        // header("Location: login");
        return true;
    }
    return false;
}
