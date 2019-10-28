<?php

/*
 *  Copyright 2008-2015 Maarch
 *
 *  This file is part of Maarch Framework.
 *
 *  Maarch Framework is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  Maarch Framework is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with Maarch Framework.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * @brief Batch to extract data from last months
 *
 * @file
 * @author <dev@maarch.org>
 * @date $date$
 * @version $Revision$
 * @ingroup life_cycle
 */

/*****************************************************************************
WARNING : THIS BATCH ERASE RESOURCES IN DATABASE AND IN DOCSERVERS 
Please note this batch deletes resources in the database 
and storage spaces (docservers). 
You need to run only if it is set -> Make especially careful to 
define the where clause.
FOR THE CASE OF AIP : to be used only if the AIP are single resources.
*****************************************************************************/

/**
 * *****   LIGHT PROBLEMS without an error semaphore
 *  101 : Configuration file missing
 *  102 : Configuration file does not exist
 *  103 : Error on loading config file
 *  104 : SQL Query Error
 *  105 : a parameter is missing
 *  106 : Maarch_CLITools is missing
 *  107 : Stack empty for the request
 *  108 : There are still documents to be processed
 *  109 : An instance of the batch for the required policy and cyle is already
 *        in progress
 *  110 : Problem with collection parameter
 *  111 : Problem with the php include path
 *  112 : AIP not able to be purged
 *  113 : Security problem with where clause
 * ****   HEAVY PROBLEMS with an error semaphore
 *  13  : Docserver not found
 */

date_default_timezone_set('Europe/Paris');
try {
    include('load_extract_data.php');
} catch (IncludeFileError $e) {
    echo "Maarch_CLITools required ! \n (pear.maarch.org)\n";
    exit(106);
}

/******************************************************************************/

    $fichierDuJour = date('Y-m-d-Hi');
    $chemin = $GLOBALS['exportFolder'].'History_Stats_'.$fichierDuJour.'.csv';
    $delimiteur = ";";

    $extractData = fopen($chemin, 'w+');
    $GLOBALS['logger']->write('Create the file ' . $chemin, 'INFO');

    fprintf($extractData, chr(0xEF).chr(0xBB).chr(0xBF));
    fputcsv(
        $extractData, 
        array(
            "Num Chrono",  //0
            "Date d'arrivée", 
            "Objet du courrier", 
            "Type du courrier", 
            "Département",  //5
            "Mots clés", 
            "Thème", 
            "Sous Thème", 
            "Classement",
            "Nombre d'expéditeur",//10
            "Civilité de l'expéditeur", 
            "Prénom de l'expéditeur", 
            "Nom de l'expéditeur", 
            "Organisme de l'expéditeur", 
            "Type de contact",  //15
            "Prénom tiers bénéficiaire",
            "Nom tiers bénéficiaire",
            "Destinataire", 
            "Service destinataire", 
            "Services en copie", //20
            "Statut du courrier", 
            "Date limite de traitement", 
            "Priorité", 
            "Nombre de réponses", 
            "Numéro chrono réponse", //25 
            "Nature de réponse", 
            "Signataire", 
            "Date de signature", 
            "Date de départ", 
            "Modèle de réponse", //30 
            "Nombre de transmissions", 
            "Numéro chrono transmission 1", 
            "Destinataire transmission 1", 
            "Modèle de réponse 1", 
            "Date de retour attendue 1", //35
            "Date de retour 1", 
            "Numéro chrono transmission 2", 
            "Destinataire transmission 2", 
            "Modèle de réponse 2", 
            "Date de retour attendue 2", //40
            "Date de retour 2", 
            "Numéro chrono transmission 3", 
            "Destinataire transmission 3", 
            "Modèle de réponse 3", 
            "Date de retour attendue 3", //45
            "Date de retour 3", 
            "Numéro chrono transmission 4", 
            "Destinataire transmission 4", 
            "Modèle de réponse 4", 
            "Date de retour attendue 4", //50
            "Date de retour 4", 
        ),
        $delimiteur
    );

    $GLOBALS['logger']->write('Select incoming mails created from last ' . $GLOBALS['FromDate'], 'INFO');
    $querySelectedFile = "SELECT *  
                        FROM " . $GLOBALS['view'] . " WHERE creation_date > current_timestamp - interval '".$GLOBALS['FromDate']."' and category_id = 'incoming' and status <> 'DEL' and status <> 'NUM' ORDER BY creation_date";
    $stmt = Bt_doQuery(
        $GLOBALS['db'], 
        $querySelectedFile
    );

    $countMail = 0;
    while($selectedFile = $stmt->fetchObject()) {

        #### TAGS ####
        $stmt2 = Bt_doQuery(
            $GLOBALS['db'], 
            "SELECT tags.label FROM tags, tag_res WHERE tags.id = tag_res.tag_id and tag_res.res_id = ?", array($selectedFile->res_id)
        );

        $labelTags = "";
        $iTags = 0;
        while($resTags = $stmt2->fetchObject()){
            if ($iTags >0) {
                $labelTags .= ", ";
            }
            $labelTags .= $resTags->tag_label;
            $iTags++;
        }

        #### Contact type ####
        $stmt2 = Bt_doQuery(
            $GLOBALS['db'], 
            "SELECT ct.label FROM res_view_letterbox r LEFT JOIN contacts_v2 c ON c.contact_id = r.contact_id LEFT JOIN contact_types ct ON ct.id = c.contact_type WHERE r.res_id = ?", array($selectedFile->res_id)
        );

        $resContactType = $stmt2->fetchObject();
        $contactType = $resContactType->label;

        #### User Name ####
        $stmt2 = Bt_doQuery(
            $GLOBALS['db'], 
            "SELECT lastname, firstname FROM users WHERE user_id = ?", array($selectedFile->dest_user)
        );

        $userName = $stmt2->fetchObject();
        $userName = strtoupper($userName->lastname) . " " . ucfirst($userName->firstname);

        #### Status ####
        $stmt2 = Bt_doQuery(
            $GLOBALS['db'], 
            "SELECT label_status FROM status WHERE id = ?", array($selectedFile->status)
        );

        $LabelStatus = $stmt2->fetchObject();
        $LabelStatus = ucfirst($LabelStatus->label_status);

        #### Civility ####
        $stmt2 = Bt_doQuery(
            $GLOBALS['db'], 
            "SELECT c.title FROM contacts_v2 c left join res_view_letterbox res on c.contact_id = res.contact_id WHERE res.res_id = ?", array($selectedFile->res_id)
        );

        $LabelCivility = $stmt2->fetchObject();
        $LabelCivility = $LabelCivility->title;

        #### Department Full Name ####
        $department_name = "";
        if($selectedFile->department_number_id <> ""){
            $department_name = $selectedFile->department_number_id . " - " .$depts[$selectedFile->department_number_id];
        }

        #### Info contacts ####
        $stmt2 = Bt_doQuery(
            $GLOBALS['db'], 
            "SELECT count(*) as nb FROM contacts_res WHERE coll_id = 'letterbox_coll' and res_id = ?", array($selectedFile->res_id)
        );

        $Nb_contact = $stmt2->fetchObject();
        $Nb_contact = $Nb_contact->nb;

        $contact_lastname = "";
        $contact_firstname = "";
        $contact_title = "";
        $contact_society = "";
        $contact_type = "";

        if ($Nb_contact < 1) {
            $stmt2 = Bt_doQuery(
                $GLOBALS['db'], 
                "SELECT contact_id FROM res_view_letterbox WHERE res_id = ?", array($selectedFile->res_id)
            );

            $contact_id = $stmt2->fetchObject();
            $contact_id = $contact_id->contact_id;

            if ($contact_id <> "") {
                $Nb_contact = 1;
                $contact_lastname = $selectedFile->contact_lastname;
                $contact_firstname = $selectedFile->contact_firstname;
                $contact_title = $LabelCivility;
                $contact_society = $selectedFile->contact_society;
                $contact_type = $contactType;
            } else {
                $Nb_contact = 0;
            }
        } else {

            $stmt2 = Bt_doQuery(
                $GLOBALS['db'], 
                "SELECT contact_id FROM contacts_res WHERE coll_id = 'letterbox_coll' and res_id = ?", array($selectedFile->res_id)
            );

            $contactId = $stmt2->fetchObject();


            if(is_int($contactId->contact_id)){
                $stmt2 = Bt_doQuery(
                    $GLOBALS['db'], 
                    "SELECT lastname, firstname, title, society, contact_type FROM contacts_v2 WHERE contact_id = ?", array($contactId->contact_id)
                );
                $contact_1 = $stmt2->fetchObject();
                $contact_lastname = $contact_1->lastname;
                $contact_firstname = $contact_1->firstname;
                $contact_title = $contact_1->title;
                $contact_society = $contact_1->society;

                $stmt2 = Bt_doQuery(
                    $GLOBALS['db'], 
                    "SELECT label FROM contact_types WHERE id = ?", array($contact_1->contact_type)
                );
                $contactType = $stmt2->fetchObject();
                $contact_type = $contactType->label;
            }else{
                 $stmt2 = Bt_doQuery(
                    $GLOBALS['db'], 
                    "SELECT lastname, firstname, entity_id FROM users, users_entities WHERE users.user_id = ? AND users.user_id = users_entities.user_id AND users_entities.primary_entity = ? ", array($contactId->contact_id,'Y')
                );
                $contact_1 = $stmt2->fetchObject();
                $contact_lastname = $contact_1->lastname;
                $contact_firstname = $contact_1->firstname;
                $contact_title = '';
                $contact_society = $contact_1->entity_id;
                $contact_type = 'Interne';
            }
            

            
        }

        #### Service destinataire ####
        $stmt2 = Bt_doQuery(
            $GLOBALS['db'], 
            "SELECT short_label FROM entities WHERE entity_id = ?", array($selectedFile->destination)
        );

        $destination = $stmt2->fetchObject();
        $destination = $destination->short_label;

        #### Services en copies ####
        $stmt2 = Bt_doQuery(
            $GLOBALS['db'], 
            "SELECT e.short_label FROM entities e LEFT JOIN listinstance l on l.item_id = e.entity_id WHERE l.item_mode = 'cc' and l.item_type = 'entity_id' and res_id = ?", array($selectedFile->res_id)
        );        

        $array_entities_cc = array();
        while($entities = $stmt2->fetchObject()){
            $array_entities_cc[] = $entities->short_label;
        }

        $txt_entities_cc = implode(", ", $array_entities_cc);

        #### Projet de réponse ####
        $stmt2 = Bt_doQuery(
            $GLOBALS['db'], 
            "SELECT identifier, typist, creation_date FROM res_view_attachments WHERE attachment_type = 'response_project' and res_id_master = ? and status <> 'DEL' and status <> 'OBS' ORDER BY creation_date desc", array($selectedFile->res_id)
        );

        $arrayAttachments = array();
        $signed_response = $stmt2->fetchObject();

        #### Signataire Name ####
        $stmt2 = Bt_doQuery(
            $GLOBALS['db'], 
            "SELECT lastname, firstname FROM users WHERE user_id in (SELECT item_id FROM listinstance WHERE item_mode = 'sign' and res_id = ?)", array($selectedFile->res_id)
        );
        $signataire = $stmt2->fetchObject();

        array_push($arrayAttachments, array( "identifier" => $signed_response->identifier, "typist" => strtoupper($signataire->lastname) . " " . ucfirst($signataire->firstname), "creation_date" => format_date_db($signed_response->creation_date, "", $GLOBALS['databasetype'])));

        #### Nombre de Projet de réponse ####
        $stmt2 = Bt_doQuery(
            $GLOBALS['db'], 
            "SELECT count(*) as total FROM res_view_attachments WHERE attachment_type = 'response_project' and res_id_master = ? and status <> 'DEL' and status <> 'OBS'", array($selectedFile->res_id)
        );

        $NbResponseProject = $stmt2->fetchObject();
        $NbResponseProject = $NbResponseProject->total;

        #### Nb Transmission ####
        $stmt2 = Bt_doQuery(
            $GLOBALS['db'], 
            "SELECT count(*) as total FROM res_view_attachments WHERE attachment_type = 'transfer' and res_id_master = ? and status <> 'DEL' and status <> 'OBS'", array($selectedFile->res_id)
        );

        $NbTransmission = $stmt2->fetchObject();
        $NbTransmission = $NbTransmission->total;

        #### Transmission ####
        $stmt2 = Bt_doQuery(
            $GLOBALS['db'], 
            "SELECT identifier, dest_contact_id, validation_date FROM res_view_attachments WHERE attachment_type = 'transfer' and res_id_master = ? and status <> 'DEL' and status <> 'OBS' ORDER BY creation_date DESC LIMIT 4", array($selectedFile->res_id)
        );

        $arrayTransmission = array();

        while ($signed_response = $stmt2->fetchObject()){

            $stmt3 = Bt_doQuery(
                $GLOBALS['db'], 
                "SELECT lastname, firstname, society FROM contacts_v2 WHERE contact_id = ? ", array($signed_response->dest_contact_id)
            );
            $dest_contact = $stmt3->fetchObject();

            array_push($arrayTransmission, array( "identifier" => $signed_response->identifier, "dest_contact" => strtoupper($dest_contact->lastname) . " " . ucfirst($dest_contact->firstname) . " " . $dest_contact->society, "validation_date" => format_date_db($signed_response->validation_date, "", $GLOBALS['databasetype'])));
        }
                
        fputcsv(
            $extractData, 
            array(
                $selectedFile->alt_identifier, 
                format_date_db(str_replace("/", "-",$selectedFile->admission_date), "", $GLOBALS['databasetype']),
                $selectedFile->subject,             
                $selectedFile->type_label,
                $department_name,  //5
                $labelTags,
                $selectedFile->folder_name, 
                "",//"Sous Thème", 
                $selectedFile->doc_custom_t2,
                $Nb_contact, //nombre d'expéditeur   //10
                $GLOBALS['mail_titles'][$contact_title],//"Civilité de l'expéditeur"
                $contact_firstname,
                $contact_lastname, 
                $contact_society,
                $contact_type,  //15
                "", //prenom tiers benef
                "", //nom tiers benef
                $userName,
                $destination,
                $txt_entities_cc,// "Services en copie", 
                $LabelStatus,
                format_date_db(str_replace("/", "-",$selectedFile->process_limit_date), "", $GLOBALS['databasetype']),
                $GLOBALS['mail_priorities'][$selectedFile->priority],
                $NbResponseProject, 
                $arrayAttachments[0]['identifier'], //25 
                $answer, 
                $arrayAttachments[0]['typist'], 
                $arrayAttachments[0]['creation_date'], 
                format_date_db(str_replace("/", "-",$selectedFile->closing_date), "", $GLOBALS['databasetype']), // date de départ
                "", // Modèle de réponse //30 
                $NbTransmission, 
                $arrayTransmission[0]['identifier'], //"Numéro chrono transmission 1", 
                $arrayTransmission[0]['dest_contact'], //"Destinataire transmission 1", 
                "",//"Modèle de réponse 1", 
                "",//"Date de retour attendue 1", //35
                $arrayTransmission[0]['validation_date'],//"Date de retour 1", 
                $arrayTransmission[1]['identifier'], //"Numéro chrono transmission 2", 
                $arrayTransmission[1]['dest_contact'], //"Destinataire transmission 2", 
                "",//"Modèle de réponse 2", 
                "",//"Date de retour attendue 2", //40
                $arrayTransmission[1]['validation_date'], //"Date de retour 2", 
                $arrayTransmission[2]['identifier'], //"Numéro chrono transmission 3", 
                $arrayTransmission[2]['dest_contact'], //"Destinataire transmission 3", 
                "",// "Modèle de réponse 3", 
                "",// "Date de retour attendue 3", //45
                $arrayTransmission[2]['validation_date'], //"Date de retour 3", 
                $arrayTransmission[3]['identifier'], //"Numéro chrono transmission 4", 
                $arrayTransmission[3]['dest_contact'], //"Destinataire transmission 4", 
                "",// "Modèle de réponse 4", 
                "",// "Date de retour attendue 4", //50
                $arrayTransmission[3]['validation_date'] //"Date de retour 4", */
            ), 
            $delimiteur
        );
        $countMail++;
    }

    fclose($extractData);

$GLOBALS['logger']->write($countMail . ' incoming mails selected', 'INFO');
$GLOBALS['logger']->write('End of process', 'INFO');
// Bt_logInDataBase(
//     $GLOBALS['totalProcessedResources'], 0, 'process without error'
// );
unlink($GLOBALS['lckFile']);
exit($GLOBALS['exitCode']);

/**
* Returns a formated date for SQL queries
*
* @param  $date date Date to format
* @param  $insert bool If true format the date to insert in the database (true by default)
* @return Formated date or empty string if any error
*/
function format_date_db($date, $insert=true, $databasetype= '', $withTimeZone=false)
{
    if (isset($_SESSION['config']['databasetype'])
        && ! empty($_SESSION['config']['databasetype'])) {
        $databasetype = $_SESSION['config']['databasetype'];
    }

    if ($date <> "" ) {
        $var = explode('-', $date);

        if (preg_match('/\s/', $var[2])) {
            $tmp = explode(' ', $var[2]);
            $var[2] = $tmp[0];
            $var[3] = substr($tmp[1],0,8);
        }

        if (preg_match('/^[0-3][0-9]$/', $var[0])) {
            $day = $var[0];
            $month = $var[1];
            $year = $var[2];
            $hours = $var[3];
        } else {
            $year = $var[0];
            $month = $var[1];
            $day = substr($var[2], 0, 2);
            $hours = $var[3];
        }
        if ($year <= "1900") {
            return '';
        } else {
            if ($databasetype == "SQLSERVER") {
                if ($withTimeZone) {
                    return  $day . "-" . $month . "-" . $year . " &nbsp;  " . $hours;
                }else{
                    return  $day . "-" . $month . "-" . $year;
                }
                
            } else if ($databasetype == "POSTGRESQL") {
                if ($_SESSION['config']['lang'] == "fr") {
                    if ($withTimeZone) {
                        return $day . "-" . $month . "-" . $year . "  &nbsp; " . $hours;
                    }else{
                        return $day . "-" . $month . "-" . $year;
                    }
                } else {
                    if ($withTimeZone) {
                        return $year . "-" . $month . "-" . $day . "  &nbsp; " . $hours;
                    }else{
                        return $year . "-" . $month . "-" . $day;
                    }
                }
            } else if ($databasetype == "ORACLE") {
                
                return  $day . "-" . $month . "-" . $year;
            } else if ($databasetype == "MYSQL" && $insert) {
                return $year . "-" . $month . "-" . $day;
            } else if ($databasetype == "MYSQL" && !$insert) {
                return  $day . "-" . $month . "-" . $year;
            }
        }
    } else {
        return '';
    }
}
