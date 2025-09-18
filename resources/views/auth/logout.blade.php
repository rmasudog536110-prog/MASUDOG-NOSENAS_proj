<?php
/**
 * User Logout
 */



// Clear session and redirect
SessionManager::logout();
echo("You have been successfully logged out.");

exit;
?>