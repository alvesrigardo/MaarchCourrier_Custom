<?php

/**
* Copyright Maarch since 2008 under licence GPLv3.
* See LICENCE.txt file at the root folder for more details.
* This file is part of Maarch software.

* @brief   ExportSEDATrait
* @author  dev <dev@maarch.org>
* @ingroup core
*/

namespace ExportSeda\controllers;

use Attachment\models\AttachmentModel;
use Docserver\models\DocserverModel;
use Docserver\models\DocserverTypeModel;
use Doctype\models\DoctypeModel;
use Entity\models\EntityModel;
use Entity\models\ListInstanceModel;
use ExportSeda\controllers\ExportSEDATrait;
use ExportSeda\controllers\SedaController;
use MessageExchange\models\MessageExchangeModel;
use Note\controllers\NoteController;
use Resource\controllers\StoreController;
use Resource\controllers\SummarySheetController;
use Resource\models\ResModel;
use setasign\Fpdi\Tcpdf\Fpdi;
use SrcCore\models\CoreConfigModel;
use SrcCore\models\ValidatorModel;

trait ExportSEDATrait
{
    public static function sendToRecordManagement(array $args)
    {
        ValidatorModel::notEmpty($args, ['resId']);
        ValidatorModel::intVal($args, ['resId']);

        $resource = ResModel::getById(['resId' => $args['resId'], 'select' => ['res_id', 'destination', 'type_id', 'subject', 'linked_resources']]);
        if (empty($resource)) {
            return ['errors' => ['resource does not exists']];
        } elseif (empty($resource['destination'])) {
            return ['errors' => ['resource has no destination']];
        }

        $doctype = DoctypeModel::getById(['id' => $resource['type_id'], 'select' => ['description', 'retention_rule', 'retention_final_disposition']]);
        if (empty($doctype['retention_rule']) || empty($doctype['retention_final_disposition'])) {
            return ['errors' => ['retention_rule or retention_final_disposition is empty for doctype']];
        }
        $entity = EntityModel::getByEntityId(['entityId' => $resource['destination'], 'select' => ['producer_service', 'entity_label']]);
        if (empty($entity['producer_service'])) {
            return ['errors' => ['producer_service is empty for this entity']];
        }

        $config = CoreConfigModel::getJsonLoaded(['path' => 'apps/maarch_entreprise/xml/config.json']);
        if (empty($config['exportSeda']['senderOrgRegNumber'])) {
            return ['errors' => ['No senderOrgRegNumber found in config.json']];
        }

        if (empty($args['data']['packageName'])) {
            return ['errors' => ['packageName is empty']];
        }
        if (empty($args['data']['archivalAgreement'])) {
            return ['errors' => ['archivalAgreement is empty']];
        }
        if (empty($args['data']['slipId'])) {
            return ['errors' => ['slipId is empty']];
        }
        if (empty($args['data']['entityArchiveRecipient'])) {
            return ['errors' => ['entityArchiveRecipient is empty']];
        }
        if (empty($args['data']['archiveDescriptionLevel'])) {
            return ['errors' => ['archiveDescriptionLevel is empty']];
        }

        foreach ($args['data']['archives'] as $archiveUnit) {
            if (empty($archiveUnit['id']) or empty($archiveUnit['descriptionLevel'])) {
                return ['errors' => ['Missing id or descriptionLevel for an archiveUnit']];
            }
        }

        $initData = SedaController::initArchivalData([
            'resource'           => $resource,
            'senderOrgRegNumber' => $config['exportSeda']['senderOrgRegNumber'],
            'entity'             => $entity,
            'doctype'            => $doctype,
            'getFile'            => true
        ]);

        if (!empty($initData['errors'])) {
            return ['errors' => $initData['errors']];
        } else {
            $initData = $initData['archivalData'];
        }

        $dataObjectPackage = [];
        $initialArchiveUnits = $initData['archiveUnits'];
        foreach ($initialArchiveUnits as $archiveUnit) {
            $archiveFound = false;
            foreach ($args['data']['archives'] as $userArchiveUnit) {
                if ($userArchiveUnit['id'] == $archiveUnit['id']) {
                    $archiveUnit['descriptionLevel'] = $userArchiveUnit['descriptionLevel'];
                    $dataObjectPackage[]             = $archiveUnit;
                    $archiveFound                    = true;
                    break;
                }
            }
            if (!$archiveFound) {
                $archiveUnit['descriptionLevel'] = 'Item';
                $dataObjectPackage = $archiveUnit;
            }
        }

        $data = [
            'type' => 'ArchiveTransfer',
            'messageObject' => [
                'messageIdentifier'  => $initData['data']['slipInfo']['slipId'],
                'archivalAgreement'  => $args['data']['archivalAgreement'],
                'dataObjectPackage'  => [],
                'archivalAgency'     => $args['data']['entityArchiveRecipient'],
                'transferringAgency' => $initData['data']['entity']['senderArchiveEntity']
            ]
        ];

        $controller = ExportSEDATrait::generateSEDAPackage(['data' => $data]);
        if (!empty($controller['errors'])) {
            return ['errors' => [$controller['errors']]];
        }

        // TODO : SEND PACKAGE TO RM

        return true;
    }

    public static function getAttachmentFilePath($args = [])
    {
        $document['docserver_id'] = $args['data']['docserver_id'];
        $document['path']         = $args['data']['path'];
        $document['filename']     = $args['data']['filename'];
        $document['fingerprint']  = $args['data']['fingerprint'];

        $docserver = DocserverModel::getByDocserverId(['docserverId' => $document['docserver_id'], 'select' => ['path_template', 'docserver_type_id']]);
        if (empty($docserver['path_template']) || !file_exists($docserver['path_template'])) {
            return ['errors' => 'Docserver does not exist'];
        }

        $pathToDocument = $docserver['path_template'] . str_replace('#', DIRECTORY_SEPARATOR, $document['path']) . $document['filename'];

        if (!file_exists($pathToDocument)) {
            return ['errors' => 'Attachment not found on docserver'];
        }

        $docserverType = DocserverTypeModel::getById(['id' => $docserver['docserver_type_id'], 'select' => ['fingerprint_mode']]);
        $fingerprint   = StoreController::getFingerPrint(['filePath' => $pathToDocument, 'mode' => $docserverType['fingerprint_mode']]);
        if (empty($document['fingerprint'])) {
            AttachmentModel::update(['set' => ['fingerprint' => $fingerprint], 'where' => ['res_id = ?'], 'data' => [$args['resId']]]);
            $document['fingerprint'] = $fingerprint;
        }

        if (!empty($document['fingerprint']) && $document['fingerprint'] != $fingerprint) {
            return ['errors' => 'Fingerprints do not match'];
        }

        $fileContent = file_exists($pathToDocument);
        if ($fileContent === false) {
            return ['errors' => 'Document not found on docserver'];
        }

        return ['filePath' => $pathToDocument];
    }

    public static function getNoteFilePath($args = [])
    {
        $encodedDocument = NoteController::getEncodedPdfByIds(['ids' => [$args['id']]]);

        $tmpPath  = CoreConfigModel::getTmpPath();
        $filePath = $tmpPath . 'note_' . $args['id'] . '.pdf';
        file_put_contents($filePath, base64_decode($encodedDocument['encodedDocument']));

        return ['filePath' => $filePath];
    }

    public static function getEmailFilePath($args = [])
    {
        $body   = str_replace('###', ';', $args['data']['body']);
        $sender = json_decode($args['data']['sender'], true);
        $data   = "Courriel n°" . $args['data']['id'] . "\nDe : " . $sender['email'] . "\nPour : " . implode(", ", json_decode($args['data']['recipients'], true)) . "\nObjet : " . $args['data']['object'] . "\n\n" . strip_tags(html_entity_decode($body));

        $pdf = new Fpdi('P', 'pt');
        $pdf->setPrintHeader(false);
        $pdf->AddPage();
        $pdf->MultiCell(0, 10, $data, 0, 'L');

        $tmpPath  = CoreConfigModel::getTmpPath();
        $filePath = $tmpPath . 'email_' . $args['data']['id'] . '.pdf';
        $pdf->Output($filePath, "F");

        return ['filePath' => $filePath];
    }

    public static function getSummarySheetFilePath($args = [])
    {
        $units   = [];
        $units[] = ['unit' => 'primaryInformations'];
        $units[] = ['unit' => 'secondaryInformations',       'label' => _SECONDARY_INFORMATION];
        $units[] = ['unit' => 'senderRecipientInformations', 'label' => _DEST_INFORMATION];
        $units[] = ['unit' => 'diffusionList',               'label' => _DIFFUSION_LIST];
        $units[] = ['unit' => 'visaWorkflow',                'label' => _VISA_WORKFLOW];
        $units[] = ['unit' => 'opinionWorkflow',             'label' => _AVIS_WORKFLOW];
        $units[] = ['unit' => 'notes',                       'label' => _NOTES_COMMENT];
        
        $tmpIds = [$args['resId']];
        $data   = [];
        foreach ($units as $unit) {
            if ($unit['unit'] == 'opinionWorkflow') {
                $data['listInstancesOpinion'] = ListInstanceModel::get([
                    'select'    => ['item_id', 'process_date', 'res_id'],
                    'where'     => ['difflist_type = ?', 'res_id in (?)'],
                    'data'      => ['AVIS_CIRCUIT', $tmpIds],
                    'orderBy'   => ['listinstance_id']
                ]);
            } elseif ($unit['unit'] == 'visaWorkflow') {
                $data['listInstancesVisa'] = ListInstanceModel::get([
                    'select'    => ['item_id', 'requested_signature', 'process_date', 'res_id'],
                    'where'     => ['difflist_type = ?', 'res_id in (?)'],
                    'data'      => ['VISA_CIRCUIT', $tmpIds],
                    'orderBy'   => ['listinstance_id']
                ]);
            } elseif ($unit['unit'] == 'diffusionList') {
                $data['listInstances'] = ListInstanceModel::get([
                    'select'  => ['item_id', 'item_type', 'item_mode', 'res_id'],
                    'where'   => ['difflist_type = ?', 'res_id in (?)'],
                    'data'    => ['entity_id', $tmpIds],
                    'orderBy' => ['listinstance_id']
                ]);
            }
        }

        $mainResource = ResModel::getOnView([
            'select' => ['process_limit_date', 'status', 'alt_identifier', 'subject', 'priority', 'res_id', 'admission_date', 'creation_date', 'doc_date', 'initiator', 'typist', 'type_label', 'destination', 'filename'],
            'where'  => ['res_id = ?'],
            'data'   => [$args['resId']]
        ]);

        $pdf = new Fpdi('P', 'pt');
        $pdf->setPrintHeader(false);
        SummarySheetController::createSummarySheet($pdf, ['resource' => $mainResource[0], 'units' => $units, 'login' => $GLOBALS['login'], 'data' => $data]);

        $tmpPath = CoreConfigModel::getTmpPath();
        $summarySheetFilePath = $tmpPath . "summarySheet_".$args['resId'] . "_" . $aArgs['userId'] . "_" . rand() . ".pdf";
        $pdf->Output($summarySheetFilePath, 'F');

        return ['filePath' => $summarySheetFilePath];
    }

    public static function generateSEDAPackage(array $args)
    {
        $encodedFile = '';
        
        return ['encodedFile' => $encodedFile];
    }

    public static function checkAcknowledgmentRecordManagement(array $args)
    {
        ValidatorModel::notEmpty($args, ['resId']);
        ValidatorModel::intVal($args, ['resId']);

        $acknowledgement = AttachmentModel::get([
            'select' => ['res_id_master', 'path', 'filename', 'docserver_id', 'fingerprint'],
            'where'  => ['res_id_master = ?', 'attachment_type = ?', 'status = ?'],
            'data'   => [$args['resId'], 'acknowledgement_record_management', 'TRA']
        ])[0];
        if (empty($acknowledgement)) {
            return ['errors' => ['No acknowledgement found']];
        }

        $docserver = DocserverModel::getByDocserverId(['docserverId' => $acknowledgement['docserver_id'], 'select' => ['path_template', 'docserver_type_id']]);
        if (empty($docserver['path_template']) || !file_exists($docserver['path_template'])) {
            return ['errors' => ['Docserver does not exists']];
        }

        $pathToDocument = $docserver['path_template'] . str_replace('#', DIRECTORY_SEPARATOR, $acknowledgement['path']) . $acknowledgement['filename'];
        if (!file_exists($pathToDocument)) {
            return ['errors' => ['File does not exists']];
        }

        $docserverType = DocserverTypeModel::getById(['id' => $docserver['docserver_type_id'], 'select' => ['fingerprint_mode']]);
        $fingerprint = StoreController::getFingerPrint(['filePath' => $pathToDocument, 'mode' => $docserverType['fingerprint_mode']]);
        if (!empty($acknowledgement['fingerprint']) && $acknowledgement['fingerprint'] != $fingerprint) {
            return ['errors' => ['Fingerprint does not match']];
        }
        
        $acknowledgementXml = @simplexml_load_file($pathToDocument);
        if (empty($acknowledgementXml)) {
            return ['errors' => ['Acknowledgement is not readable']];
        }

        $messageExchange = MessageExchangeModel::getMessageByReference(['select' => ['message_id'], 'reference' => (string)$acknowledgementXml->MessageReceivedIdentifier]);
        if (empty($messageExchange)) {
            return ['errors' => ['No acknowledgement found with this reference']];
        }

        $unitIdentifier = MessageExchangeModel::getUnitIdentifierByResId(['select' => ['message_id'], 'resId' => $args['resId']]);
        if ($unitIdentifier['message_id'] != $messageExchange['message_id']) {
            return ['errors' => ['Wrong acknowledgement']];
        }

        return true;
    }

    public static function checkReplyRecordManagement(array $args)
    {
        ValidatorModel::notEmpty($args, ['resId']);
        ValidatorModel::intVal($args, ['resId']);

        $reply = AttachmentModel::get([
            'select' => ['res_id_master', 'path', 'filename', 'docserver_id', 'fingerprint'],
            'where'  => ['res_id_master = ?', 'attachment_type = ?', 'status = ?'],
            'data'   => [$args['resId'], 'reply_record_management', 'TRA']
        ])[0];
        if (empty($reply)) {
            return ['errors' => ['No reply found']];
        }

        $docserver = DocserverModel::getByDocserverId(['docserverId' => $reply['docserver_id'], 'select' => ['path_template', 'docserver_type_id']]);
        if (empty($docserver['path_template']) || !file_exists($docserver['path_template'])) {
            return ['errors' => ['Docserver does not exists']];
        }

        $pathToDocument = $docserver['path_template'] . str_replace('#', DIRECTORY_SEPARATOR, $reply['path']) . $reply['filename'];
        if (!file_exists($pathToDocument)) {
            return ['errors' => ['File does not exists']];
        }

        $docserverType = DocserverTypeModel::getById(['id' => $docserver['docserver_type_id'], 'select' => ['fingerprint_mode']]);
        $fingerprint = StoreController::getFingerPrint(['filePath' => $pathToDocument, 'mode' => $docserverType['fingerprint_mode']]);
        if (!empty($reply['fingerprint']) && $reply['fingerprint'] != $fingerprint) {
            return ['errors' => ['Fingerprint does not match']];
        }
        
        $replyXml = @simplexml_load_file($pathToDocument);
        if (empty($replyXml)) {
            return ['errors' => ['Reply is not readable']];
        }

        $messageExchange = MessageExchangeModel::getMessageByReference(['select' => ['message_id'], 'reference' => (string)$replyXml->MessageReceivedIdentifier]);
        if (empty($messageExchange)) {
            return ['errors' => ['No reply found with this reference']];
        }

        $unitIdentifier = MessageExchangeModel::getUnitIdentifierByResId(['select' => ['message_id'], 'resId' => $args['resId']]);
        if ($unitIdentifier['message_id'] != $messageExchange['message_id']) {
            return ['errors' => ['Wrong reply']];
        }

        return true;
    }
}
