<?php
/**
 * Created by PhpStorm.
 * User: Andre
 * Date: 14.10.2018
 * Time: 16:28
 */
session_start();

$destinataire ='';
$sujet ='';
$value='';

if(isset($_POST) && !empty($_POST['idMsg'])){
    try
    {
        /*** connect to SQLite database ***/

        $file_db = new PDO("sqlite:../../databases/database.sqlite");

    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
        echo "<br><br>Database -- NOT -- loaded successfully .. ";
        die( "<br><br>Query Closed !!!");
    }

    /***********    Connexion à la DB OK     ************/
    $user = $_SESSION["user_id"];
    $idMsg = $_POST['idMsg'];
        // Permet de récupérer tout les messages où l'on est le destinataire
    $result = $file_db->query("SELECT * FROM Messages INNER JOIN Message ON Messages.Message_id = Message.Message_id WHERE Messages.Destinataire='$user' AND Messages.Message_id='$idMsg' ");
    foreach ($result as $row) {
        $destinataire = $row['Expediteur'];
        $sujet = 'RE: '.$row['Sujet'];
        $value .= '&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;Le '
            .$row['Date']. ', '.$row['Expediteur'].'a écrit :'
            .'&#13;&#10;'
            . $row['Message'];
    }
    /***********    Déconnexion de la DB        ************/
    $file_db = null;

}
$string = '<form action="javascript:sendMessage()">'
        .'<label for="destinataire">Destinataire: </label>'
        .'<input type="text" id="destinataire" name="destinataire" placeholder="destinataire" value="'.$destinataire.'" required><br><br>'
        .'<label for="sujet">Sujet: </label>'
        .'<input type="text" id="sujet" name="sujet" placeholder="sujet" value="'.$sujet.'" required><br><br>'
        .'<label for="message">Message: </label><br>'
        .'<textarea id="message" name="message" placeholder="Le contenu du message" rows="8" cols="100">'.$value.' </textarea><br>'
        .'<input type="submit" value="Envoyer">'
        .'</form>';


$arrToSend = array();
array_push($arrToSend, '#content', $string) ;
echo json_encode($arrToSend);