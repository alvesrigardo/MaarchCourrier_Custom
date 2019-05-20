<?php

/**
 * Copyright Maarch since 2008 under licence GPLv3.
 * See LICENCE.txt file at the root folder for more details.
 * This file is part of Maarch software.
 *
 */

/**
 * @brief Full Text Script
 * @author dev@maarch.org
 */

namespace Convert\scripts;

require 'vendor/autoload.php';

use Attachment\models\AttachmentModel;
use Convert\controllers\FullTextController;
use Resource\models\ResModel;
use SrcCore\controllers\LogsController;
use SrcCore\models\DatabasePDO;
use User\models\UserModel;

// SAMPLE COMMANDS :
// Launch index fulltext for specific document(for res_letterbox) : php FullTextScript.php --customId yourcustom --collId letterbox_coll --userId 10
// Launch reindex failed fulltext (for res_letterbox) : php FullTextScript.php --customId yourcustom --collId letterbox_coll --mode reindex

// ARGS
// --customId    : instance id;
// --collId      : letterbox_coll / attachments_coll / attachments_version_col;
// --userId      : technical identifer user (for saving log);
// --mode        : 'reindex' => usefull to re analyse failed fulltext result;


FullTextScript::initalize($argv);

class FullTextScript
{
    public static function initalize($args)
    {
        $customId = '';
        $resId    = '';
        $userId   = '';
        $collId   = '';
        $mode     = '';

        if (array_search('--customId', $args) > 0) {
            $cmd = array_search('--limit', $args);
            $customId = $args[$cmd+1];
        }
        
        if (array_search('--resId', $args) > 0) {
            $cmd = array_search('--resId', $args);
            $resId = $args[$cmd+1];
        }
        
        if (array_search('--collId', $args) > 0) {
            $cmd = array_search('--collId', $args);
            $collId = $args[$cmd+1];
        }
        
        if (array_search('--userId', $args) > 0) {
            $cmd = array_search('--userId', $args);
            $userId = $args[$cmd+1];
        } else {
            $userId = 'superadmin';
        }
        
        if (array_search('--mode', $args) > 0) {
            $cmd = array_search('--mode', $args);
            $mode = $args[$cmd+1];
        }

        if (empty($mode)) {
            FullTextScript::index(['customId' => $customId, 'resId' => $resId, 'collId' => $collId, 'userId' => $userId]);
        } else {
            FullTextScript::reindex(['customId' => $customId, 'collId' => $collId, 'userId' => $userId]);
        }
    }

    public static function index(array $args)
    {
        DatabasePDO::reset();
        new DatabasePDO(['customId' => $args['customId']]);

        $currentUser = UserModel::getById(['id' => $args['userId'], 'select' => ['user_id']]);
        $GLOBALS['userId'] = $currentUser['user_id'];

        $isIndexed = FullTextController::indexDocument(['resId' => $args['resId'], 'collId' => $args['collId']]);

        if (!empty($isIndexed['success'])) {
            if ($args['collId'] == 'letterbox_coll') {
                ResModel::update(['set' => ['fulltext_result' => 'SUCCESS'], 'where' => ['res_id = ?'], 'data' => [$args['resId']]]);
            } else {
                AttachmentModel::update([
                    'set'       => ['fulltext_result' => 'SUCCESS'],
                    'where'     => ['res_id = ?'],
                    'data'      => [$args['resId']],
                    'isVersion' => $args['collId'] == 'attachments_version_coll'
                ]);
            }
        } else {
            if ($args['collId'] == 'letterbox_coll') {
                ResModel::update(['set' => ['fulltext_result' => 'ERROR'], 'where' => ['res_id = ?'], 'data' => [$args['resId']]]);
            } else {
                AttachmentModel::update([
                    'set'       => ['fulltext_result' => 'ERROR'],
                    'where'     => ['res_id = ?'],
                    'data'      => [$args['resId']],
                    'isVersion' => $args['collId'] == 'attachments_version_coll'
                ]);
            }
            LogsController::add([
                'isTech'    => true,
                'moduleId'  => 'fullText',
                'level'     => 'ERROR',
                'tableName' => $args['collId'],
                'recordId'  => $args['resId'],
                'eventType' => "Full Text failed : {$isIndexed['errors']}",
                'eventId'   => "resId : {$args['resId']} || collId : {$args['collId']}"
            ]);
        }

        return $isIndexed;
    }

    public static function reindex(array $args)
    {
        DatabasePDO::reset();
        new DatabasePDO(['customId' => $args['customId']]);

        $currentUser = UserModel::getByLogin(['login' => $args['userId'], 'select' => ['id']]);

        $GLOBALS['userId'] = $args['userId'];

        $resIdsToReindex = FullTextController::getFailedIndexes(['collId' => $args['collId']]);
       
        if (count($resIdsToReindex) == 0) {
            echo "No result to process.\n";
        } else {
            foreach ($resIdsToReindex as $resId) {
                echo "Re index for res_id : {$resId['res_id']} in progress...\n";
                FullTextScript::index(['customId' => $args['customId'], 'resId' => $resId['res_id'], 'collId' => $args['collId'], 'userId' => $currentUser['id']]);
                echo "Done !\n\n";
            }
        }
    }
}
