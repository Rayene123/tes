<?php
require_once("../session.php");
if (isset($_SESSION["Username"])){
    try {
        include_once('./database.php');
        $pdo = database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $dataScadenza = date('Y-m-d', strtotime($dataInizio. ' + 90 days'));
        $sql = 'INSERT INTO EVENTO_UTENTE VALUES("'. $_SESSION["Username"] .'", "'. $_GET["IdEvento"] .'",  "'. date("Y-m-d") .'");';
        $query = $pdo->prepare($sql);
        $query->execute();
        database::disconnect();
        header('location: ../../thankYouBooking.php');
    } catch (PDOException $e) {
        echo 'Errore PDO e connessione DB: <br />';
        echo 'SQLQuery: ', $sql;
        echo 'Errore: ' . $e->getMessage();
    }
}
// header('location: ../../index.php');

?>