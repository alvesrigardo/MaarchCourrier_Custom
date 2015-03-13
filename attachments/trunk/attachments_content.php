<?php
/**
* File : attachments_content.php
*
* Add an answer in the process
*
* @package Maarch 1.5
* @since 11/2014
* @license GPL
* @author <dev@maarch.org>
*/

require_once "core/class/class_security.php";
require_once "core/class/class_request.php";
require_once "core/class/class_resource.php";
require_once "apps" . DIRECTORY_SEPARATOR . $_SESSION['config']['app_id']
    . DIRECTORY_SEPARATOR . "class" . DIRECTORY_SEPARATOR
    . "class_indexing_searching_app.php";
require_once "core/class/docservers_controler.php";
require_once 'modules/attachments/attachments_tables.php';
require_once "core/class/class_history.php";

$core = new core_tools();
$core->load_lang();
$sec = new security();
$func = new functions();
$req = new request();
$docserverControler = new docservers_controler();

$req->connect();

$_SESSION['error'] = "";

$status = 0;
$error = $content = $js = $parameters = '';

function _parse($text) {
    $text = str_replace("\r\n", "\n", $text);
    $text = str_replace("\r", "\n", $text);
    $text = str_replace("\n", "\\n ", $text);
    return $text;
}

if (isset($_POST['add']) && $_POST['add']) {

    if (empty($_SESSION['upfile']['tmp_name'])) {
        $_SESSION['error'] .= _FILE_MISSING . ". ";
    } elseif ($_SESSION['upfile']['size'] == 0) {
        $_SESSION['error'] .= _FILE_EMPTY . ". ";
    }

    if ($_SESSION['upfile']['error'] == 1) {
        $filesize = $func->return_bytes(ini_get("upload_max_filesize"));
        $_SESSION['error'] = _ERROR_FILE_UPLOAD_MAX . "(" . round(
            $filesize / 1024, 2
        ) . "Ko Max).<br />";
    }

    $attachment_types = '';
    if (! isset($_REQUEST['attachment_types']) || empty($_REQUEST['attachment_types'])) {
        $_SESSION['error'] .= _ATTACHMENT_TYPES . ' ' . _MANDATORY . ". ";
    } else {
        $attachment_types = $func->protect_string_db($_REQUEST['attachment_types']);
    }

    $title = '';
    if (! isset($_REQUEST['title']) || empty($_REQUEST['title'])) {
        $_SESSION['error'] .= _OBJECT . ' ' . _MANDATORY . ". ";
    } else {
        $title = $func->protect_string_db($_REQUEST['title']);
    }
    
    if (empty($_SESSION['error'])) {
        require_once 'core/docservers_tools.php';
        $arrayIsAllowed = array();
        $arrayIsAllowed = Ds_isFileTypeAllowed(
            $_SESSION['config']['tmppath'] . $_SESSION['upfile']['fileNameOnTmp']
        );
        if ($arrayIsAllowed['status'] == false) {
            $_SESSION['error'] = _WRONG_FILE_TYPE
                . ' ' . $arrayIsAllowed['mime_type'];
            $_SESSION['upfile'] = array();
        } else {
            if (! isset($_SESSION['collection_id_choice'])
                || empty($_SESSION['collection_id_choice'])
            ) {
                $_SESSION['collection_id_choice'] = $_SESSION['user']['collections'][0];
            }

            $docserver = $docserverControler->getDocserverToInsert(
                $_SESSION['collection_id_choice']
            );
            if (empty($docserver)) {
                $_SESSION['error'] = _DOCSERVER_ERROR . ' : '
                    . _NO_AVAILABLE_DOCSERVER . ". " . _MORE_INFOS . ".";
                $location = "";
            } else {
                // some checking on docserver size limit
                $newSize = $docserverControler->checkSize(
                    $docserver, $_SESSION['upfile']['size']
                );
                if ($newSize == 0) {
                    $_SESSION['error'] = _DOCSERVER_ERROR . ' : '
                        . _NOT_ENOUGH_DISK_SPACE . ". " . _MORE_INFOS . ".";
                    ?>
                    <script type="text/javascript">
                        var eleframe1 =  window.parent.top.document.getElementById('list_attach');
                        eleframe1.location.href = '<?php
                    echo $_SESSION['config']['businessappurl'];
                    ?>index.php?display=true&module=attachments&page=frame_list_attachments&mode=normal&load';
                    </script>
                    <?php
                    exit();
                } else {
                    $fileInfos = array(
                        "tmpDir"      => $_SESSION['config']['tmppath'],
                        "size"        => $_SESSION['upfile']['size'],
                        "format"      => $_SESSION['upfile']['format'],
                        "tmpFileName" => $_SESSION['upfile']['fileNameOnTmp'],
                    );

                    $storeResult = array();
                    $storeResult = $docserverControler->storeResourceOnDocserver(
                        $_SESSION['collection_id_choice'], $fileInfos
                    );

                    if (isset($storeResult['error']) && $storeResult['error'] <> '') {
                        $_SESSION['error'] = $storeResult['error'];
                    } else {
                        $resAttach = new resource();
                        $_SESSION['data'] = array();
                        array_push(
                            $_SESSION['data'],
                            array(
                                'column' => "typist",
                                'value' => $_SESSION['user']['UserId'],
                                'type' => "string",
                            )
                        );
                        array_push(
                            $_SESSION['data'],
                            array(
                                'column' => "format",
                                'value' => $_SESSION['upfile']['format'],
                                'type' => "string",
                            )
                        );
                        array_push(
                            $_SESSION['data'],
                            array(
                                'column' => "docserver_id",
                                'value' => $storeResult['docserver_id'],
                                'type' => "string",
                            )
                        );
                        array_push(
                            $_SESSION['data'],
                            array(
                                'column' => "status",
                                'value' => 'A_TRA',
                                'type' => "string",
                            )
                        );
                        array_push(
                            $_SESSION['data'],
                            array(
                                'column' => "offset_doc",
                                'value' => ' ',
                                'type' => "string",
                            )
                        );
                        array_push(
                            $_SESSION['data'],
                            array(
                                'column' => "logical_adr",
                                'value' => ' ',
                                'type' => "string",
                            )
                        );
                        array_push(
                            $_SESSION['data'],
                            array(
                                'column' => "title",
                                'value' => $title,
                                'type' => "string",
                            )
                        );
                        array_push(
                            $_SESSION['data'],
                            array(
                                'column' => "attachment_type",
                                'value' => $attachment_types,
                                'type' => "string",
                            )
                        );
                        array_push(
                            $_SESSION['data'],
                            array(
                                'column' => "coll_id",
                                'value' => $_SESSION['collection_id_choice'],
                                'type' => "string",
                            )
                        );
                        array_push(
                            $_SESSION['data'],
                            array(
                                'column' => "res_id_master",
                                'value' => $_SESSION['doc_id'],
                                'type' => "integer",
                            )
                        );
                        if ($_SESSION['origin'] == "scan") {
                            array_push(
                                $_SESSION['data'],
                                array(
                                    'column' => "scan_user",
                                    'value' => $_SESSION['user']['UserId'],
                                    'type' => "string",
                                )
                            );
                            array_push(
                                $_SESSION['data'],
                                array(
                                    'column' => "scan_date",
                                    'value' => $req->current_datetime(),
                                    'type' => "function",
                                )
                            );
                        }
                        if (isset($_REQUEST['back_date']) && $_REQUEST['back_date'] <> '') {
                            array_push(
                                $_SESSION['data'],
                                array(
                                    'column' => "validation_date",
                                    'value' => $func->format_date_db($_REQUEST['back_date']),
                                    'type' => "date",
                                )
                            );
                        }

                        if (isset($_REQUEST['contactidAttach']) && $_REQUEST['contactidAttach'] <> '') {
                            array_push(
                                $_SESSION['data'],
                                array(
                                    'column' => "dest_contact_id",
                                    'value' => $_REQUEST['contactidAttach'],
                                    'type' => "integer",
                                )
                            );
                        }

                        if (isset($_REQUEST['addressidAttach']) && $_REQUEST['addressidAttach'] <> '') {
                            array_push(
                                $_SESSION['data'],
                                array(
                                    'column' => "dest_address_id",
                                    'value' => $_REQUEST['addressidAttach'],
                                    'type' => "integer",
                                )
                            );
                        }
                        array_push(
                            $_SESSION['data'],
                            array(
                                'column' => "identifier",
                                'value' => $_REQUEST['chrono'],
                                'type' => "string",
                            )
                        );
                        array_push(
                            $_SESSION['data'],
                            array(
                                'column' => "type_id",
                                'value' => 0,
                                'type' => "int",
                            )
                        );

                        array_push(
                            $_SESSION['data'],
                            array(
                                'column' => "relation",
                                'value' => 1,
                                'type' => "int",
                            )
                        );

                        $id = $resAttach->load_into_db(
                            RES_ATTACHMENTS_TABLE,
                            $storeResult['destination_dir'],
                            $storeResult['file_destination_name'] ,
                            $storeResult['path_template'],
                            $storeResult['docserver_id'], $_SESSION['data'],
                            $_SESSION['config']['databasetype']
                        );
						
						//copie de la version PDF de la pièce si mode de conversion sur le client
						if ($_SESSION['modules_loaded']['attachments']['convertPdf'] == "client" && $_SESSION['upfile']['fileNamePdfOnTmp'] != ''){
							$file = $_SESSION['config']['tmppath'].$_SESSION['upfile']['fileNamePdfOnTmp'];
							$newfile = $storeResult['path_template'].str_replace('#',"/",$storeResult['destination_dir']).substr ($storeResult['file_destination_name'], 0, strrpos  ($storeResult['file_destination_name'], "." )).".pdf";
							
							copy($file, $newfile);
						}
						
                        if ($id == false) {
                            $_SESSION['error'] = $resAttach->get_error();
                        } else {
                            if ($_SESSION['history']['attachadd'] == "true") {
                                $hist = new history();
                                $view = $sec->retrieve_view_from_coll_id(
                                    $_SESSION['collection_id_choice']
                                );
                                $hist->add(
                                    $view, $_SESSION['doc_id'], "ADD", 'attachadd',
                                    ucfirst(_DOC_NUM) . $id . ' '
                                    . _NEW_ATTACH_ADDED . ' ' . _TO_MASTER_DOCUMENT
                                    . $_SESSION['doc_id'],
                                    $_SESSION['config']['databasetype'],
                                    'apps'
                                );
                                $_SESSION['info'] = _NEW_ATTACH_ADDED;
                                $hist->add(
                                    RES_ATTACHMENTS_TABLE, $id, "ADD",'attachadd',
                                    $_SESSION['info'] . " (" . $title
                                    . ") ",
                                    $_SESSION['config']['databasetype'],
                                    'attachments'
                                );
                            }
                        }
                    }
                }
            }
            
            if ( empty($_SESSION['error']) || $_SESSION['error'] == _NEW_ATTACH_ADDED ) {
                $new_nb_attach = 0;
                $req->connect();
                $req->query("select res_id from "
                    . $_SESSION['tablename']['attach_res_attachments']
                    . " where status <> 'DEL' and res_id_master = " . $_SESSION['doc_id']);
                if ($req->nb_result() > 0) {
                    $new_nb_attach = $req->nb_result();
                }
                if (isset($_REQUEST['fromDetail']) && $_REQUEST['fromDetail'] == 'create') {
                    $js .= "window.parent.top.location.reload()";
                } else {
                    $js .= 'var eleframe1 =  window.parent.top.document.getElementById(\'list_attach\');';
                    $js .= 'eleframe1.src = \''.$_SESSION['config']['businessappurl'].'index.php?display=true&module=attachments&page=frame_list_attachments&load\';';
                    $js .= 'var nb_attach = '. $new_nb_attach.';';
                    $js .= 'window.parent.top.document.getElementById(\'nb_attach\').innerHTML = nb_attach;';
                }
            } else {
                $error = $_SESSION['error'];
                $status = 1;
            }
        }
    } else {
        $error = $_SESSION['error'];
        $status = 1;
    }
    echo "{status : " . $status . ", content : '" . addslashes(_parse($content)) . "', error : '" . addslashes($error) . "', exec_js : '".addslashes($js)."'}";
    exit();
} else if (isset($_POST['edit']) && $_POST['edit']) {
    $title = '';

    if (!isset($_REQUEST['title']) || empty($_REQUEST['title'])) {
        $_SESSION['error'] .= _OBJECT . ' ' . _MANDATORY . ". ";
        $status = 1;
    } else {
        $title = $func->protect_string_db($_REQUEST['title']);
    }

    if ($status <> 1) {
        if ($_REQUEST['new_version'] == "yes") {

            if ((int)$_REQUEST['relation'] > 1) {
                $column_res = 'res_id_version';
            } else {
                $column_res = 'res_id';
            }

            $req->query("SELECT attachment_type, identifier, relation, attachment_id_master 
                            FROM res_view_attachments 
                            WHERE ".$column_res." = ".$_REQUEST['res_id']." and res_id_master = ".$_SESSION['doc_id']."
                            ORDER BY relation desc");
            $previous_attachment = $req->fetch_object();

            $fileInfos = array(
                "tmpDir"      => $_SESSION['config']['tmppath'],
                "size"        => $_SESSION['upfile']['size'],
                "format"      => $_SESSION['upfile']['format'],
                "tmpFileName" => $_SESSION['upfile']['fileNameOnTmp'],
            );

            $storeResult = array();
            $storeResult = $docserverControler->storeResourceOnDocserver(
                $_SESSION['collection_id_choice'], $fileInfos
            );

            if (isset($storeResult['error']) && $storeResult['error'] <> '') {
                $_SESSION['error'] = $storeResult['error'];
            } else {
                $resAttach = new resource();
                $_SESSION['data'] = array();
                array_push(
                    $_SESSION['data'],
                    array(
                        'column' => "typist",
                        'value' => $_SESSION['user']['UserId'],
                        'type' => "string",
                    )
                );
                array_push(
                    $_SESSION['data'],
                    array(
                        'column' => "format",
                        'value' => $_SESSION['upfile']['format'],
                        'type' => "string",
                    )
                );
                array_push(
                    $_SESSION['data'],
                    array(
                        'column' => "docserver_id",
                        'value' => $storeResult['docserver_id'],
                        'type' => "string",
                    )
                );
                array_push(
                    $_SESSION['data'],
                    array(
                        'column' => "status",
                        'value' => 'A_TRA',
                        'type' => "string",
                    )
                );
                array_push(
                    $_SESSION['data'],
                    array(
                        'column' => "offset_doc",
                        'value' => ' ',
                        'type' => "string",
                    )
                );
                array_push(
                    $_SESSION['data'],
                    array(
                        'column' => "logical_adr",
                        'value' => ' ',
                        'type' => "string",
                    )
                );
                array_push(
                    $_SESSION['data'],
                    array(
                        'column' => "title",
                        'value' => $title,
                        'type' => "string",
                    )
                );
                array_push(
                    $_SESSION['data'],
                    array(
                        'column' => "attachment_type",
                        'value' => $previous_attachment->attachment_type,
                        'type' => "string",
                    )
                );
                array_push(
                    $_SESSION['data'],
                    array(
                        'column' => "coll_id",
                        'value' => $_SESSION['collection_id_choice'],
                        'type' => "string",
                    )
                );
                array_push(
                    $_SESSION['data'],
                    array(
                        'column' => "res_id_master",
                        'value' => $_SESSION['doc_id'],
                        'type' => "integer",
                    )
                );
                if ((int)$previous_attachment->attachment_id_master == 0) {
                    array_push(
                        $_SESSION['data'],
                        array(
                            'column' => "attachment_id_master",
                            'value' => $_REQUEST['res_id'],
                            'type' => "integer",
                        )
                    );
                } else {
                    array_push(
                        $_SESSION['data'],
                        array(
                            'column' => "attachment_id_master",
                            'value' => (int)$previous_attachment->attachment_id_master,
                            'type' => "integer",
                        )
                    );                    
                }

                if ($_SESSION['origin'] == "scan") {
                    array_push(
                        $_SESSION['data'],
                        array(
                            'column' => "scan_user",
                            'value' => $_SESSION['user']['UserId'],
                            'type' => "string",
                        )
                    );
                    array_push(
                        $_SESSION['data'],
                        array(
                            'column' => "scan_date",
                            'value' => $req->current_datetime(),
                            'type' => "function",
                        )
                    );
                }
                if (isset($_REQUEST['back_date']) && $_REQUEST['back_date'] <> '') {
                    array_push(
                        $_SESSION['data'],
                        array(
                            'column' => "validation_date",
                            'value' => $func->format_date_db($_REQUEST['back_date']),
                            'type' => "date",
                        )
                    );
                }

                if (isset($_REQUEST['contactidAttach']) && $_REQUEST['contactidAttach'] <> '') {
                    array_push(
                        $_SESSION['data'],
                        array(
                            'column' => "dest_contact_id",
                            'value' => $_REQUEST['contactidAttach'],
                            'type' => "integer",
                        )
                    );
                }

                if (isset($_REQUEST['addressidAttach']) && $_REQUEST['addressidAttach'] <> '') {
                    array_push(
                        $_SESSION['data'],
                        array(
                            'column' => "dest_address_id",
                            'value' => $_REQUEST['addressidAttach'],
                            'type' => "integer",
                        )
                    );
                }
                array_push(
                    $_SESSION['data'],
                    array(
                        'column' => "identifier",
                        'value' => $previous_attachment->identifier,
                        'type' => "string",
                    )
                );
                array_push(
                    $_SESSION['data'],
                    array(
                        'column' => "type_id",
                        'value' => 0,
                        'type' => "int",
                    )
                );

                $relation = (int)$previous_attachment->relation;
                $relation++;

                array_push(
                    $_SESSION['data'],
                    array(
                        'column' => "relation",
                        'value' => $relation,
                        'type' => "int",
                    )
                );

                $id = $resAttach->load_into_db(
                    'res_version_attachments',
                    $storeResult['destination_dir'],
                    $storeResult['file_destination_name'] ,
                    $storeResult['path_template'],
                    $storeResult['docserver_id'], $_SESSION['data'],
                    $_SESSION['config']['databasetype']
                );
                $req->connect();
                if ($previous_attachment->relation == 1) {
                    $req->query("UPDATE res_attachments set status = 'OBS' WHERE res_id = ".$_REQUEST['res_id']);
                } else {
                    $req->query("UPDATE res_version_attachments set status = 'OBS' WHERE res_id = ".$_REQUEST['res_id']);
                }

            }
        } else {
            $set_update = "";
            $set_update = " title = '".$title."'";

            if (isset($_REQUEST['back_date']) && $_REQUEST['back_date'] <> "") {
                $set_update .= ", validation_date = '".$req->format_date_db($_REQUEST['back_date'])."'";
            } else {
                $set_update .= ", validation_date = null";
            }

            if (isset($_REQUEST['contactidAttach']) && $_REQUEST['contactidAttach'] <> "") {
                $set_update .= ", dest_contact_id = ".$_REQUEST['contactidAttach'].", dest_address_id = ".$_REQUEST['addressidAttach'];
            } else {
                $set_update .= ", dest_contact_id = null, dest_address_id = null";
            }

            if ($_SESSION['upfile']['upAttachment'] == true) {
                $fileInfos = array(
                    "tmpDir"      => $_SESSION['config']['tmppath'],
                    "size"        => $_SESSION['upfile']['size'],
                    "format"      => $_SESSION['upfile']['format'],
                    "tmpFileName" => $_SESSION['upfile']['fileNameOnTmp'],
                );

                $storeResult = array();
                $storeResult = $docserverControler->storeResourceOnDocserver(
                    $_SESSION['collection_id_choice'], $fileInfos
                );

                $filetmp = $storeResult['path_template'];
                $tmp = $storeResult['destination_dir'];
                $tmp = str_replace('#',DIRECTORY_SEPARATOR,$tmp);
                $filetmp .= $tmp;
                $filetmp .= $storeResult['file_destination_name'];
                require_once 'core/class/docserver_types_controler.php';
                require_once 'core/docservers_tools.php';
                $docserverTypeControler = new docserver_types_controler();
                $docserver = $docserverControler->get($storeResult['docserver_id']);
                $docserverTypeObject = $docserverTypeControler->get($docserver->docserver_type_id);
                $fingerprint = Ds_doFingerprint($filetmp, $docserverTypeObject->fingerprint_mode);
                $filesize = filesize($filetmp);
                $set_update .= ", fingerprint = '".$fingerprint."'";
                $set_update .= ", filesize = ".$filesize;
                $set_update .= ", path = '".$storeResult['destination_dir']."'";
                $set_update .= ", filename = '".$storeResult['file_destination_name']."'";
                // $set_update .= ", docserver_id = ".$storeResult['docserver_id'];
            }

            $set_update .= ", doc_date = ".$req->current_datetime().", updated_by = '".$_SESSION['user']['UserId']."'";

            if (isset($storeResult['error']) && $storeResult['error'] <> '') {
                $_SESSION['error'] = $storeResult['error'];
            } else {
                $req->connect();
                if ((int)$_REQUEST['relation'] == 1) {
                    $req->query("UPDATE res_attachments SET " . $set_update . " WHERE res_id = ".$_REQUEST['res_id']);
                } else {
                    $req->query("UPDATE res_version_attachments SET " . $set_update . " WHERE res_id = ".$_REQUEST['res_id']);
                }
            }
            
        }
        
        if ($_SESSION['history']['attachup'] == "true") {
            $hist = new history();
            $view = $sec->retrieve_view_from_coll_id(
                $_SESSION['collection_id_choice']
            );
            $hist->add(
                $view, $_SESSION['doc_id'], "UP", 'attachup',
                ucfirst(_DOC_NUM) . $id . ' '
                . _ATTACH_UPDATED,
                $_SESSION['config']['databasetype'],
                'apps'
            );
            $_SESSION['info'] = _ATTACH_UPDATED;
            $hist->add(
                RES_ATTACHMENTS_TABLE, $id, "UP",'attachup',
                $_SESSION['info'] . " (" . $title
                . ") ",
                $_SESSION['config']['databasetype'],
                'attachments'
            );
        }

        if (empty($_SESSION['error'])) {
            $js .= 'var eleframe1 =  window.top.document.getElementsByName(\'list_attach\');';
            if (isset($_REQUEST['fromDetail']) && $_REQUEST['fromDetail'] == 'attachments') {
                $js .= 'eleframe1[0].src = \''.$_SESSION['config']['businessappurl'].'index.php?display=true&module=attachments&page=frame_list_attachments&load';
                $js .= '&attach_type_exclude=response_project,outgoing_mail_signed&fromDetail=attachments';
            } else if (isset($_REQUEST['fromDetail']) && $_REQUEST['fromDetail'] == 'response'){
                $js .= 'eleframe1[1].src = \''.$_SESSION['config']['businessappurl'].'index.php?display=true&module=attachments&page=frame_list_attachments&load';
                $js .= '&attach_type=response_project,outgoing_mail_signed&fromDetail=response';
            } else {
                $js .= 'eleframe1[0].src = \''.$_SESSION['config']['businessappurl'].'index.php?display=true&module=attachments&page=frame_list_attachments&load';
            }
            $js .='\';';
        } else {
            $error = $_SESSION['error'];
            $status = 1;
        }

    } else {
        $error = $_SESSION['error'];
        $status = 1;
    }

    echo "{status : " . $status . ", content : '" . addslashes(_parse($content)) . "', error : '" . addslashes($error) . "', exec_js : '".addslashes($js)."'}";
    exit();
}

if (isset($_REQUEST['id'])) {

    if ((int)$_REQUEST['relation'] > 1) {
        $column_res = 'res_id_version';
    } else {
        $column_res = 'res_id';
    }

    $req->connect();
    $req->query("SELECT validation_date, title, dest_contact_id, dest_address_id, relation 
                    FROM res_view_attachments 
                    WHERE ".$column_res." = ".$_REQUEST['id']." and res_id_master = ".$_SESSION['doc_id']."
                    ORDER BY relation desc");
    $data_attachment = $req->fetch_object();

    if ($data_attachment->relation == 1) {
        $res_table = 'res_attachments';
    } else {
        $res_table = 'res_version_attachments';  
    }

    $viewResourceArr = $docserverControler->viewResource(
        $_REQUEST['id'], 
        $res_table, 
        'adr_x', 
        false
    );

    $_SESSION['upfile']['size'] = filesize($viewResourceArr['file_path']);
    $_SESSION['upfile']['format'] = $viewResourceArr['ext'];
    $fileNameOnTmp = str_replace($viewResourceArr['tmp_path'].DIRECTORY_SEPARATOR, '', $viewResourceArr['file_path']);
    $_SESSION['upfile']['fileNameOnTmp'] = $fileNameOnTmp;

} else {
    $req->query("SELECT subject, exp_contact_id, address_id FROM res_view_letterbox WHERE res_id = ".$_SESSION['doc_id']);
    $data_attachment = $req->fetch_object();

    unset($_SESSION['upfile']);
}

if ($data_attachment->dest_contact_id <> "") {
    $req->connect();
    $req->query('SELECT is_corporate_person, is_private, contact_lastname, contact_firstname, society, society_short, address_num, address_street, address_town, lastname, firstname 
                    FROM view_contacts 
                    WHERE contact_id = ' . $data_attachment->dest_contact_id . ' and ca_id = ' . $data_attachment->dest_address_id);
} else if ($data_attachment->exp_contact_id <> "") {
    $req->connect();
    $req->query('SELECT is_corporate_person, is_private, contact_lastname, contact_firstname, society, society_short, address_num, address_street, address_town, lastname, firstname 
                    FROM view_contacts 
                    WHERE contact_id = ' . $data_attachment->exp_contact_id . ' and ca_id = ' . $data_attachment->address_id);       
}

if ($data_attachment->exp_contact_id <> '' || $data_attachment->dest_contact_id <> '') {
    $res = $req->fetch_object();
    if ($res->is_corporate_person == 'Y') {
        $data_contact = $res->society;
        if (!empty ($res->society_short)) {
            $data_contact .= ' ('.$res->society_short.')';
        }
        if (!empty($res->lastname) || !empty($res->firstname)) {
            $data_contact .= ' - ' . $res->lastname . ' ' . $res->firstname;
        }
        $data_contact .= ', ';
    } else {
        $data_contact .= $res->contact_lastname . ' ' . $res->contact_firstname;
        if (!empty ($res->society)) {
            $data_contact .= ' (' .$res->society . ')';
        }
        $data_contact .= ', ';
    }
    if ($res->is_private == 'Y') {
        $data_contact .= '('._CONFIDENTIAL_ADDRESS.')';
    } else {
        $data_contact .= $res->address_num .' ' . $res->address_street .' ' . strtoupper($res->address_town);                         
    }
}

//$content .= '<div class="block" style="width:2000px">';
    $content .= '<div class="error" >' . $_SESSION['error'];
    $_SESSION['error'] = "";

//require 'modules/templates/class/templates_controler.php';
//$templatesControler = new templates_controler();
//$templates = array();
//$templates = $templatesControler->getAllTemplatesForProcess($_SESSION['destination_entity']);
$objectTable = $sec->retrieve_table_from_coll($_SESSION['collection_id_choice']);
    $content .= '</div>';
    if (isset($_REQUEST['id'])) {
        $title = _MODIFY_ANSWER;
    } else {
        $title = _ATTACH_ANSWER;        
    }
    $content .= '<h2>&nbsp;' . $title . '</h2>'; 

    $content .= '<form enctype="multipart/form-data" method="post" name="formAttachment" id="formAttachment" action="#" class="forms" style="width:30%;float:left;margin-left:-5px;background-color:#deedf3">';
    $content .= '<hr style="width:85%;margin-left:0px">';
        $content .= '<input type="hidden" id="category_id" value="outgoing"/>';
    if (isset($_REQUEST['id'])) {
        $content .= '<input type="hidden" name="res_id" id="res_id" value="'.$_REQUEST['id'].'"/>';
        $content .= '<input type="hidden" name="relation" id="relation" value="'.$_REQUEST['relation'].'"/>';
    }
    $content .= '<input type="hidden" name="fromDetail" id="fromDetail" value="'.$_REQUEST['fromDetail'].'"/>';

    if (!isset($_REQUEST['id'])) {
        $content .= '<p>';
            $content .= '<label>' . _ATTACHMENT_TYPES . '</label>';
            $content .= '<select name="attachment_types" id="attachment_types" onchange="affiche_chrono();select_template(\'' . $_SESSION['config']['businessappurl']
                . 'index.php?display=true&module=templates&page='
                . 'select_templates\', this.options[this.selectedIndex].value)"/>';
                $content .= '<option value="">' . _CHOOSE_ATTACHMENT_TYPE . '</option>';
                    foreach(array_keys($_SESSION['attachment_types']) as $attachmentType) {
                        $content .= '<option value="' . $attachmentType . '" with_chrono = "'. $_SESSION['attachment_types_attribute'][$attachmentType].'">';
                            $content .= $_SESSION['attachment_types'][$attachmentType];
                        $content .= '</option>';
                    }

            $content .= '</select>&nbsp;<span class="red_asterisk" id="attachment_types_mandatory"><i class="fa fa-star"></i></span>';
        $content .= '</p>';
        $content .= '<br/>';
        $content .= '<p>';
            $content .= '<label id="chrono_label" style="display:none">'. _CHRONO_NUMBER.'</label>';
            $content .= '<input type="text" name="chrono" id="chrono" style="display:none"/>';
        $content .= '</p>';
        $content .= '<br/>';
        $content .= '<p>';
            $content .= '<label>'. _MODEL.'</label>';
            $content .= '<select name="templateOffice" id="templateOffice" onchange="showEditButton();">';
                $content .= '<option value="">'. _CHOOSE_MODEL.'</option>';
/*                    for ($i=0;$i<count($templates);$i++) {
                        if ($templates[$i]['TYPE'] == 'OFFICE' && ($templates[$i]['TARGET'] == 'attachments' || $templates[$i]['TARGET'] == '')) {
                           $content .= '<option value="'. $templates[$i]['ID'].'">';
                            $content .= $templates[$i]['LABEL'];
                        }
                        $content .= '</option>';
                    }*/
            $content .= '</select>&nbsp;<span class="red_asterisk" id="templateOffice_mandatory"><i class="fa fa-star"></i></span>';
        $content .= '</p>';
        $content .= '<br/>';
        $content .= '<p>';
            $content .= '<label>&nbsp;</label>';
            $content .=  _OR;
        $content .= '</p>';
        $content .= '<br/>';
        $content .= '<p>';
            $content .= '<label>'. _ATTACH_FILE.'</label>';
            $content .= '<iframe style="width:210px" name="choose_file" id="choose_file" frameborder="0" scrolling="no" height="25" src="' . $_SESSION['config']['businessappurl']
                            . 'index.php?display=true&module=attachments&page=choose_attachment"></iframe>';
            $content .= '<input type="text" name="not_enabled" id="not_enabled" disabled value="'. _ALREADY_MODEL_SELECTED.'" style="display:none" />';
            $content .= '<i class="fa fa-check-square fa-2x" style="display:none;margin-top:-15px" id="file_loaded"></i>';
        $content .= '</p>';
        $content .= '<br/>';
    }
        $content .= '<p>';
            $content .= '<label>'. _OBJECT .'</label>';
            $content .= '<input type="text" name="title" id="title" value="';
            if (isset($_REQUEST['id'])) {
                $content .= $req->show_string($data_attachment->title);
            } else {
                $content .= $req->show_string($data_attachment->subject);
            }
            $content .= '"/>&nbsp;<span class="red_asterisk" id="templateOffice_mandatory"><i class="fa fa-star"></i></span>';
        $content .= '</p>';
        if (!isset($_REQUEST['id'])) {
            $content .= '<hr style="width:85%;margin-left:0px">';
        } else {
            $content .= '<br/>';
        }
        $content .= '<p>';
            $content .= '<label>'. _BACK_DATE.'</label>';
            $content .= '<input type="text" name="back_date" id="back_date" onClick="showCalender(this);" value="';
            if (isset($_REQUEST['id'])) {
                $content .= $req->format_date_db($data_attachment->validation_date);
            }

            $content .='"/>';
        $content .= '</p>';
        $content .= '<br/>';
        $content .= '<p>';
            $content .= '<label>'. _DEST_USER;
            if ($core->test_admin('my_contacts', 'apps', false)) {
                $content .= ' <a href="#" id="create_multi_contact" title="' . _CREATE_CONTACT
                        . '" onclick="new Effect.toggle(\'create_contact_div_attach\', '
                        . '\'blind\', {delay:0.2});return false;" '
                        . 'style="display:inline;" ><i class="fa fa-pencil fa-2x" title="' . _CREATE_CONTACT . '"></i></a>';
            }
           $content .='<a href="#" id="contact_card_attach" title="'._CONTACT_CARD.'" onclick="document.getElementById(\'info_contact_iframe_attach\').src=\'' . $_SESSION['config']['businessappurl']
                . 'index.php?display=false&dir=my_contacts&page=info_contact_iframe&contactid=\'+document.getElementById(\'contactidAttach\').value+\'&addressid=\'+document.getElementById(\'addressidAttach\').value+\'&fromAttachmentContact=Y\';new Effect.toggle(\'info_contact_div_attach\', '
                . '\'blind\', {delay:0.2});return false;"'
                . ' style="visibility:hidden;padding-left:35%"><i class="fa fa-book fa-2x"></i></a>';
            $content .= '</label>';
            $content .= '<input type="text" name="contact_attach" onblur="display_contact_card(\'visible\', \'contact_card_attach\');" onkeyup="erase_contact_external_id(\'contact_attach\', \'contactidAttach\');erase_contact_external_id(\'contact_attach\', \'addressidAttach\');" id="contact_attach" value="';
                $content .= $data_contact;
            $content .= '"/>';
            $content .= '<div id="show_contacts_attach" class="autocomplete autocompleteIndex"></div>';
        $content .= '</p>';
        $content .= '<input type="hidden" id="contactidAttach" name="contactidAttach" value="';
                if (isset($_REQUEST['id'])) {
                    $content .= $data_attachment->dest_contact_id;
                } else if ($data_attachment->exp_contact_id){
                    $content .= $data_attachment->exp_contact_id;
                }
        $content .= '"/>';
        $content .= '<input type="hidden" id="addressidAttach" name="addressidAttach" value="';
            if (isset($_REQUEST['id'])) {
                $content .= $data_attachment->dest_address_id;
            } else if ($data_attachment->address_id <> ''){
                $content .= $data_attachment->address_id;
            }
        $content .= '"/>';
        $content .= '<br/>';
    if (isset($_REQUEST['id'])) {
         $content .= '<p>';
            $content .= '<label>'. _CREATE_NEW_ATTACHMENT_VERSION.'</label>';
            $content .= '<input type="radio" name="new_version" id="new_version_yes" value="yes"/>'._YES;
            $content .= '&nbsp;&nbsp;';
            $content .= '<input type="radio" name="new_version" id="new_version_no" checked value="no"/>'._NO;
        $content .= '</p>';
        $content .= '<br/>';   
    }
        $content .= '<p class="buttons">';
            $content .= '<input type="button" value="';
                $content .=  _VALIDATE;
                if (isset($_REQUEST['id'])) {
                    $content .= '" name="edit" id="edit" class="button" onclick="ValidAttachmentsForm(\'' . $_SESSION['config']['businessappurl'] ;
                } else {
                    $content .= '" name="add" id="add" class="button" onclick="ValidAttachmentsForm(\'' . $_SESSION['config']['businessappurl'] ;                   
                }

                $content .= 'index.php?display=true&module=attachments&page=attachments_content\', \'formAttachment\')"/>';
                $content .= '&nbsp;';
            $content .= '<input type="button" value="';
                $content .=  _CANCEL;
                $content .= '" name="cancel" class="button"  onclick="destroyModal(\'form_attachments\');"/>';
                $content .= '&nbsp;';
                $content .= '&nbsp;';
            $content .= '<input type="button" value="';
                $content .= _EDIT_MODEL;

            if (isset($_REQUEST['id'])) {
                    $content .= '" name="edit" id="edit" class="button" onclick="window.open(\''
                                    . $_SESSION['config']['businessappurl'] . 'index.php?display=true&module=content_management&page=applet_popup_launcher&objectType=attachmentUpVersion&objectId='.$_REQUEST['id'].'&objectTable=res_view_attachments&resMaster='.$_SESSION['doc_id']
                                    .'\', \'\', \'height=200, width=250,scrollbars=no,resizable=no,directories=no,toolbar=no\');"/>';
            } else {
                $content .= '" name="edit" id="edit" style="display:none" class="button" '
                                .'onclick="window.open(\''. $_SESSION['config']['businessappurl'] . 'index.php?display=true&module=content_management&page=applet_popup_launcher&objectType=attachmentVersion&objectId=\'+$(\'templateOffice\').value+\'&objectTable='. $objectTable .'&resMaster='.$_SESSION['doc_id']
                                .'\', \'\', \'height=200, width=250,scrollbars=no,resizable=no,directories=no,toolbar=no\');"/>';            
            }

        $content .= '</p>';
    $content .= '</form>';

    if (!isset($_REQUEST['id'])) {
        $content .= '<script>launch_autocompleter_contacts_v2("'. $_SESSION['config']['businessappurl'].'index.php?display=true&dir=indexing_searching&page=autocomplete_contacts", "contact_attach", "show_contacts_attach", "", "contactidAttach", "addressidAttach")</script>';
    } else {
        $content .= '<script>launch_autocompleter2_contacts_v2("'. $_SESSION['config']['businessappurl'].'index.php?display=true&dir=indexing_searching&page=autocomplete_contacts", "contact_attach", "show_contacts_attach", "", "contactidAttach", "addressidAttach")</script>';
    }

    $content .= '<script>display_contact_card(\'visible\', \'contact_card_attach\');</script>';

    // $content .= '<script>$(\'title\').value=</script>';

    if ($core->test_admin('my_contacts', 'apps', false)) {
        $content .= '<div id="create_contact_div_attach" style="display:none;float:left;width:65%;background-color:#deedf3">';
            $content .= '<iframe width="100%" height="550" src="' . $_SESSION['config']['businessappurl']
                    . 'index.php?display=false&dir=my_contacts&page=create_contact_iframe&fromAttachmentContact=Y" name="contact_iframe" id="contact_iframe"'
                    . ' scrolling="auto" frameborder="0" style="display:block;">'
                    . '</iframe>';
        $content .= '</div>';
    }
    $content .= '<div id="info_contact_div_attach" style="display:none;float:left;width:70%;background-color:#deedf3">';
        $content .= '<iframe width="100%" height="800" name="info_contact_iframe_attach" id="info_contact_iframe_attach"'
                . ' scrolling="auto" frameborder="0" style="display:block;">'
                . '</iframe>';
    $content .= '</div>';
//$content .= '</div>';

echo "{status : " . $status . ", content : '" . addslashes(_parse($content)) . "', error : '" . addslashes($error) . "', exec_js : '".addslashes($js)."'}";
exit ();