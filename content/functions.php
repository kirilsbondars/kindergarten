<?php

function isUserAuthorized(): bool
{
    global $current_user;
    if($current_user) {
        return true;
    } else {
        return false;
    }
}

function isUserAndAdmin(): bool
{
    global $current_user;
    return $current_user and $current_user->isAdmin();
}