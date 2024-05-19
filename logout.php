<?php
session_start();

// Përdorimi i funksionit unset përmes referencave
// Krijo një referencë për variablën globale $_SESSION
//kerkesa per me iu cas variablave globale me referenca
$sess = &$_SESSION;

// Krijo një referencë për variablën 'loggedin' brenda sesionit
$loggedin = &$sess['loggedin'];

// Nëse 'loggedin' është e vendosur, pastroje atë
//kerkesa per perdorimin e funksionit unset
if (isset($loggedin)) {
    unset($loggedin);
}

// Krijo një referencë për variablën globale $_POST
$post = &$_POST;

// Ridrejto përdoruesin në faqen kryesore
header('Location: index.php'); 
exit;
?>
