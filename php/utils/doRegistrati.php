<?php
require_once('../session.php');
if (isset($_SESSION['Username'])) {
    header("location: ../../index.php");
} else {
    $registrazioneCompletata = false;
    if (!empty($_POST)) {
        $usernameError = null;
        $passwordError = null;
        $nomeError = null;
        $cognomeError = null;
        $valid = true;
        if (array_key_exists("username", $_REQUEST) && !empty($_REQUEST["username"]) && strlen($_REQUEST["username"]) <= 100) {
            $username = $_POST['username'];
            $data = $_POST['data'];
            $data = $_POST['email'];
        } else {
            $usernameError = 'Inserire un username';
            $valid = false;
        };
        if (array_key_exists("password", $_REQUEST) && !empty($_REQUEST["password"]) && strlen($_REQUEST["password"]) <= 200) {
            $password = $_POST['password'];
        } else {
            $passwordError = 'Inserire una password';
            $valid = false;
        };
        if (array_key_exists("nome", $_REQUEST) && !empty($_REQUEST["nome"]) && strlen($_REQUEST["nome"]) <= 100) {
            $nome = $_POST['nome'];
        } else {
            $nomeError = 'Inserire un nome';
            $valid = false;
        };
        if (array_key_exists("cognome", $_REQUEST) && !empty($_REQUEST["cognome"]) && strlen($_REQUEST["cognome"]) <= 100) {
            $cognome = $_POST['cognome'];
        } else {
            $cognomeError = 'Inserire un cognome';
            $valid = false;
        };

        if ($valid) {            
            try {
                include_once('database.php');
                $pdo = database::connect();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = $pdo->prepare("SELECT Count(*) FROM UTENTI WHERE Username='$username';");
                $stmt->execute();
                if ($stmt->fetchColumn() > 0) {
                    $usernameError = "Username già preso, cercane un altro. Sei già registrato? <a class='btn btn-default bg-light' href='./login.php?username=$username'>Accedi</a>";
                } else {
                    $sql = "INSERT INTO UTENTI(Username, Password, Email, Nome, Cognome, DataNascita, Privilegio) values(?,?,?,?,?,?,0)";
                    $q = $pdo->prepare($sql);
                    $q->execute(array($username, password_hash($password, PASSWORD_DEFAULT), $email, $nome, $cognome, $data, 0));
                    $registrazioneCompletata = true;
                    echo $registrazioneCompletata;
                }
                database::disconnect();
            } catch (PDOException $e) {
                echo 'Errore PDO e connessione DB: <br />';
                echo 'SQLQuery: ', $sql;
                echo 'Errore: ' . $e->getMessage();
            }
            if (isset($_SESSION['Username'])) {
                header("location: ../../index.php");
            }
        } else {
            header("location: ../registrati.php?errGen=1");
        }
    }
} ?>