<?php

$confirm = true;

$etapes = ['form'];

function get_form_txt($values, $path_manage_action, $id_action, $table, $module, $coll_id, $mode)
{
    $config = getXml();

    $html = '<form name="sendToExternalSB" id="sendToExternalSB" method="post" class="forms" action="#">';
    $html .= '<input type="hidden" name="chosen_action" id="chosen_action" value="end_action" />';
    if (!empty($config)) {
        if ($config['id'] == 'ixbus') {
            include_once 'modules/visa/class/IxbusController.php';

            $html .= IxbusController::getModal($config);
        } elseif ($config['id'] == 'iParapheur') {
            include_once 'modules/visa/class/IParapheurController.php';

            $html .= IParapheurController::getModal($config);
        } elseif ($config['id'] == 'fastParapheur') {
            include_once 'modules/visa/class/FastParapheurController.php';

            $html .= FastParapheurController::getModal($config);
        }
    }

    $html .='<div align="center">';
    $html .=' <input type="button" name="validate" id="validate" value="'._VALIDATE.'" class="button" ' .
            'onclick="valid_action_form(\'sendToExternalSB\', \'' . $path_manage_action .
            '\', \'' . $id_action . '\', \'' . $values[0] . '\', \'res_letterbox\', \'null\', \'letterbox_coll\', \'' .
            $mode . '\');" />';
    $html .='<input type="button" name="cancel" id="cancel" class="button" value="'._CANCEL.'" onclick="pile_actions.action_pop();destroyModal(\'modal_'.$id_action.'\');"/>';

    $html .='</div>';
    $html .='</form>';

    return addslashes($html);
}

function check_form($form_id, $values)
{
    return true;
}

function manage_form($arr_id, $history, $id_action, $label_action, $status, $coll_id, $table, $values_form)
{
    $result = '';
    $config = getXml();

    $circuit_visa = new visa();
    $coll_id = $_SESSION['current_basket']['coll_id'];

    foreach ($arr_id as $res_id) {
        if (!empty($config)) {
            if ($config['id'] == 'ixbus') {
                include_once 'modules/visa/class/IxbusController.php';
                $attachmentToFreeze = IxbusController::sendDatas(['config' => $config, 'resIdMaster' => $res_id]);
            } elseif ($config['id'] == 'iParapheur') {
                include_once 'modules/visa/class/IParapheurController.php';
                $attachmentToFreeze = IParapheurController::sendDatas(['config' => $config, 'resIdMaster' => $res_id]);
            } elseif ($config['id'] == 'fastParapheur') {
                include_once 'modules/visa/class/FastParapheurController.php';
                $attachmentToFreeze = FastParapheurController::sendDatas(['config' => $config, 'resIdMaster' => $res_id]);
            }
        }

        foreach ($attachmentToFreeze as $resId => $externalId) {
            \Attachment\models\AttachmentModel::freezeAttachment(['resId' => $resId, 'table' => 'res_attachments', 'externalId' => $externalId]);
        }

        $stmt = $db->query('SELECT status FROM res_letterbox WHERE res_id = ?', array($res_id));
        $resource = $stmt->fetchObject();
        $message = '';
        if ($resource->status == 'EVIS' || $resource->status == 'ESIG') {
            $sequence = $circuit_visa->getCurrentStep($res_id, $coll_id, 'VISA_CIRCUIT');
            $stepDetails = array();
            $stepDetails = $circuit_visa->getStepDetails($res_id, $coll_id, 'VISA_CIRCUIT', $sequence);
    
            $message = $circuit_visa->processVisaWorkflow(['stepDetails' => $stepDetails, 'res_id' => $res_id]);
        }
    }

    return ['result' => $result, 'history_msg' => $message];
}

function getXml()
{
    if (file_exists("custom/{$_SESSION['custom_override_id']}/modules/visa/xml/remoteSignatoryBooks.xml")) {
        $path = "custom/{$_SESSION['custom_override_id']}/modules/visa/xml/remoteSignatoryBooks.xml";
    } else {
        $path = 'modules/visa/xml/remoteSignatoryBooks.xml';
    }

    $config = [];
    if (file_exists($path)) {
        $loadedXml = simplexml_load_file($path);
        if ($loadedXml) {
            $config['id']               = (string)$loadedXml->signatoryBookEnabled;
            foreach ($loadedXml->signatoryBook as $value) {
                if ($value->id == $config['id']) {
                    $config['data'] = (array)$value;
                }
            }
        }
    }

    return $config;
}
