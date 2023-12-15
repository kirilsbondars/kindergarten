<?php

function is_user_and_admin(): bool
{
    global $current_user;
    return $current_user and $current_user->isAdmin();
}