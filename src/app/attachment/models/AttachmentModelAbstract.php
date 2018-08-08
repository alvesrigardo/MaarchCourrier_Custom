<?php

/**
* Copyright Maarch since 2008 under licence GPLv3.
* See LICENCE.txt file at the root folder for more details.
* This file is part of Maarch software.
*
*/

/**
 * @brief Attachment Model Abstract
 * @author dev@maarch.org
 */

namespace Attachment\models;

use SrcCore\models\CoreConfigModel;
use SrcCore\models\DatabaseModel;
use SrcCore\models\ValidatorModel;

abstract class AttachmentModelAbstract
{
    public static function getOnView(array $aArgs)
    {
        ValidatorModel::notEmpty($aArgs, ['select']);
        ValidatorModel::arrayType($aArgs, ['select', 'where', 'data', 'orderBy']);
        ValidatorModel::intType($aArgs, ['limit']);

        $aAttachments = DatabaseModel::select([
            'select'    => $aArgs['select'],
            'table'     => ['res_view_attachments'],
            'where'     => empty($aArgs['where']) ? [] : $aArgs['where'],
            'data'      => empty($aArgs['data']) ? [] : $aArgs['data'],
            'order_by'  => empty($aArgs['orderBy']) ? [] : $aArgs['orderBy'],
            'limit'     => empty($aArgs['limit']) ? 0 : $aArgs['limit']
        ]);

        return $aAttachments;
    }

    public static function getById(array $aArgs)
    {
        ValidatorModel::notEmpty($aArgs, ['id']);
        ValidatorModel::intVal($aArgs, ['id']);
        ValidatorModel::boolType($aArgs, ['isVersion']);

        if (!empty($aArgs['isVersion'])) {
            $table = 'res_version_attachments';
        } else {
            $table = 'res_attachments';
        }

        $aAttachment = DatabaseModel::select([
            'select'    => empty($aArgs['select']) ? ['*'] : $aArgs['select'],
            'table'     => [$table],
            'where'     => ['res_id = ?'],
            'data'      => [$aArgs['id']],
        ]);

        if (empty($aAttachment[0])) {
            return [];
        }

        return $aAttachment[0];
    }

    public static function create(array $aArgs)
    {
        ValidatorModel::notEmpty($aArgs, ['format', 'typist', 'creation_date', 'docserver_id', 'path', 'filename', 'fingerprint', 'filesize', 'status']);
        ValidatorModel::stringType($aArgs, ['format', 'typist', 'creation_date', 'docserver_id', 'path', 'filename', 'fingerprint', 'status']);
        ValidatorModel::intVal($aArgs, ['filesize']);

        $nextSequenceId = DatabaseModel::getNextSequenceValue(['sequenceId' => 'res_attachment_res_id_seq']);
        $aArgs['res_id'] = $nextSequenceId;

        DatabaseModel::insert([
            'table'         => 'res_attachments',
            'columnsValues' => $aArgs
        ]);

        return $nextSequenceId;
    }

    public static function update(array $aArgs)
    {
        ValidatorModel::notEmpty($aArgs, ['set', 'where', 'data']);
        ValidatorModel::arrayType($aArgs, ['set', 'where', 'data']);
        ValidatorModel::boolType($aArgs, ['isVersion']);

        if (!empty($aArgs['isVersion'])) {
            $table = 'res_version_attachments';
        } else {
            $table = 'res_attachments';
        }

        DatabaseModel::update([
            'table' => $table,
            'set'   => $aArgs['set'],
            'where' => $aArgs['where'],
            'data'  => $aArgs['data']
        ]);

        return true;
    }

    public static function getConvertedPdfById(array $aArgs)
    {
        ValidatorModel::notEmpty($aArgs, ['id']);
        ValidatorModel::intVal($aArgs, ['id']);
        ValidatorModel::boolType($aArgs, ['isVersion']);
        ValidatorModel::arrayType($aArgs, ['select']);

        $originalAttachment = AttachmentModel::getById([
            'select'    => ['path', 'filename'],
            'id'        => $aArgs['id'],
            'isVersion' => $aArgs['isVersion']
        ]);

        $PdfFilename = substr($originalAttachment['filename'], 0, strrpos($originalAttachment['filename'], '.')) . '.pdf';

        $attachment = DatabaseModel::select([
            'select'    => empty($aArgs['select']) ? ['*'] : $aArgs['select'],
            'table'     => ['res_attachments'],
            'where'     => ['path = ?', 'filename = ?', 'attachment_type = ?', 'status != ?'],
            'data'      => [$originalAttachment['path'], $PdfFilename, 'converted_pdf', 'DEL'],
        ]);

        if (empty($attachment[0])) {
            return [];
        }

        return $attachment[0];
    }

    public static function getAttachmentsTypesByXML()
    {
        $attachmentTypes = [];

        $loadedXml = CoreConfigModel::getXmlLoaded(['path' => 'apps/maarch_entreprise/xml/entreprise.xml']);
        if ($loadedXml) {
            $attachmentTypesXML = $loadedXml->attachment_types;
            if (count($attachmentTypesXML) > 0) {
                foreach ($attachmentTypesXML->type as $value) {
                    $label = defined((string) $value->label) ? constant((string) $value->label) : (string) $value->label;
                    $attachmentTypes[(string) $value->id] = [
                        'label' => $label,
                        'icon' => (string)$value['icon'],
                        'sign' => (empty($value['sign']) || (string)$value['sign'] == 'true') ? true : false
                    ];
                }
            }
        }

        return $attachmentTypes;
    }

    public static function unsignAttachment(array $aArgs)
    {
        ValidatorModel::notEmpty($aArgs, ['table', 'resId']);
        ValidatorModel::stringType($aArgs, ['table']);
        ValidatorModel::intVal($aArgs, ['resId']);

        DatabaseModel::update([
            'table'     => $aArgs['table'],
            'set'       => ['status' => 'A_TRA', 'signatory_user_serial_id' => null],
            'where'     => ['res_id = ?'],
            'data'      => [$aArgs['resId']]
        ]);

        DatabaseModel::update([
            'table'     => $aArgs['table'],
            'set'       => ['status' => 'DEL'],
            'where'     => ['origin = ?', 'status != ?'],
            'data'      => ["{$aArgs['resId']},{$aArgs['table']}", 'DEL']
        ]);

        return true;
    }

    public static function freezeAttachment(array $aArgs)
    {
        ValidatorModel::notEmpty($aArgs, ['table', 'resId', 'externalId']);
        ValidatorModel::stringType($aArgs, ['table', 'externalId']);
        ValidatorModel::intType($aArgs, ['resId']);

        DatabaseModel::update([
            'table'     => $aArgs['table'],
            'set'       => ['status' => 'FRZ', 'external_id' => $aArgs['externalId']],
            'where'     => ['res_id = ?'],
            'data'      => [$aArgs['resId']]
        ]);

        return true;
    }

    public static function setInSignatureBook(array $aArgs)
    {
        ValidatorModel::notEmpty($aArgs, ['id', 'isVersion']);
        ValidatorModel::intVal($aArgs, ['id']);
        ValidatorModel::stringType($aArgs, ['isVersion']);
        ValidatorModel::boolType($aArgs, ['inSignatureBook']);

        if ($aArgs['isVersion'] == 'true') {
            $table = 'res_version_attachments';
        } else {
            $table = 'res_attachments';
        }
        if ($aArgs['inSignatureBook']) {
            $aArgs['inSignatureBook'] =  'true';
        } else {
            $aArgs['inSignatureBook'] =  'false';
        }

        DatabaseModel::update([
            'table'     => $table,
            'set'       => [
                'in_signature_book'   => $aArgs['inSignatureBook']
            ],
            'where'     => ['res_id = ?'],
            'data'      => [$aArgs['id']],
        ]);

        return true;
    }

    public static function hasAttachmentsSignedForUserById(array $aArgs)
    {
        ValidatorModel::notEmpty($aArgs, ['id', 'user_serial_id', 'isVersion']);
        ValidatorModel::intVal($aArgs, ['id', 'user_serial_id']);
        ValidatorModel::stringType($aArgs, ['isVersion']);

        if ($aArgs['isVersion'] == 'true') {
            $table = 'res_version_attachments';
        } else {
            $table = 'res_attachments';
        }

        $attachment = DatabaseModel::select([
            'select'    => ['res_id_master'],
            'table'     => [$table],
            'where'     => ['res_id = ?'],
            'data'      => [$aArgs['id']],
        ]);

        $attachments = DatabaseModel::select([
            'select'    => ['res_id_master'],
            'table'     => ['res_view_attachments'],
            'where'     => ['res_id_master = ?', 'signatory_user_serial_id = ?'],
            'data'      => [$attachment[0]['res_id_master'], $aArgs['user_serial_id']],
        ]);

        if (empty($attachments)) {
            return false;
        }

        return true;
    }
}
