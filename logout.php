<?php
session_start();

// casja ne variabla globale permes referencave ----->kerkese
$sess = &$_SESSION;

// Krijo një referencë për variablën 'loggedin' brenda sesionit
$loggedin = &$sess['loggedin'];

//perdorimi i funksionit unset------>kerkese
if (isset($loggedin)) {
    unset($loggedin);
}

header('Location: index.php'); 
exit;
?>
