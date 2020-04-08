<?php

/**
 * Copyright Maarch since 2008 under licence GPLv3.
 * See LICENCE.txt file at the root folder for more details.
 * This file is part of Maarch software.
 *
 */

/**
 * @brief Datasource Controller
 * @author dev@maarch.org
 */

namespace Template\controllers;

use Basket\models\BasketModel;
use Contact\controllers\ContactController;
use Contact\models\ContactModel;
use Entity\models\EntityModel;
use Resource\models\ResourceContactModel;
use SrcCore\models\DatabaseModel;
use User\models\UserBasketPreferenceModel;
use Note\models\NoteModel;
use Resource\models\ResModel;
use SrcCore\models\TextFormatModel;
use User\models\UserModel;

class DatasourceController
{
    public static function notifEvents(array $aArgs)
    {
        $datasources['notification'][0] = $aArgs['params']['notification'];
        $datasources['recipient'][0]    = $aArgs['params']['recipient'];
        $datasources['events']          = [];
   
        foreach ($aArgs['params']['events'] as $event) {
            $datasources['events'][] = $event;
        }
        
        return $datasources;
    }

    public static function letterboxEvents(array $aArgs)
    {
        $datasources['recipient'][0]  = $aArgs['params']['recipient'];
        $datasources['res_letterbox'] = [];
        $datasources['contact']       = [];
        
        $urlToApp = trim($aArgs['params']['maarchUrl'], '/').'/apps/maarch_entreprise/index.php?';
        
        $basket = BasketModel::getByBasketId(['select' => ['id'], 'basketId' => 'MyBasket']);
        $preferenceBasket = UserBasketPreferenceModel::get([
            'select'  => ['group_serial_id'],
            'where'   => ['user_serial_id = ?', 'basket_id = ?'],
            'data'    => [$aArgs['params']['recipient']['id'], 'MyBasket']
        ]);
        
        foreach ($aArgs['params']['events'] as $event) {
            $table    = [$aArgs['params']['res_view'] . ' lb'];
            $leftJoin = [];
            $where    = [];
            $arrayPDO = [];
        
            switch ($event['table_name']) {
                case 'notes':
                    $table[]    = 'notes';
                    $leftJoin[] = 'notes.identifier = lb.res_id';
                    $where[]    = 'notes.id = ?';
                    $arrayPDO[] = $event['record_id'];
                    break;
        
                case 'listinstance':
                    $table[]    = 'listinstance li';
                    $leftJoin[] = 'lb.res_id = li.res_id';
                    $where[]    = 'listinstance_id = ?';
                    $arrayPDO[] = $event['record_id'];
                    break;
        
                case 'res_letterbox':
                case 'res_view_letterbox':
                default:
                    $where[]    = 'lb.res_id = ?';
                    $arrayPDO[] = $event['record_id'];
            }
        
            // Main document resource from view
            $res = DatabaseModel::select([
                'select'    => ['lb.*'],
                'table'     => $table,
                'left_join' => $leftJoin,
                'where'     => $where,
                'data'      => $arrayPDO,
            ])[0];
        
            // Lien vers la page detail
            $res['linktodoc']     = $urlToApp . 'linkToDoc='.$res['res_id'];
            $res['linktodetail']  = $urlToApp . 'linkToDetail='.$res['res_id'];
            if (!empty($res['res_id']) && !empty($preferenceBasket[0]['group_serial_id']) && !empty($basket['id']) && !empty($aArgs['params']['recipient']['user_id'])) {
                $res['linktoprocess'] = $urlToApp . 'linkToProcess='.$res['res_id'].'&groupId='.$preferenceBasket[0]['group_serial_id'].'&basketId='.$basket['id'].'&userId='.$aArgs['params']['recipient']['user_id'];
            }
        
            if (!empty($res['initiator'])) {
                $entityInfo = EntityModel::getByEntityId(['select' => ['*'], 'entityId' => $res['initiator']]);
                foreach ($entityInfo as $key => $value) {
                    $res['initiator_'.$key] = $value;
                }
            }
        
            $datasources['res_letterbox'][] = $res;
        
            $resourceContacts = ResourceContactModel::get([
                'where' => ['res_id = ?', "mode='sender'", "type='contact'"],
                'data'  => [$res['res_id']],
                'limit' => 1
            ]);
            $resourceContacts = $resourceContacts[0];
        
            if (!empty($resourceContacts)) {
                $contact = ContactModel::getById(['id' => $resourceContacts['item_id'], 'select' => ['*']]);
        
                $postalAddress = ContactController::getContactAfnor($contact);
                unset($postalAddress[0]);
                $contact['postal_address'] = implode("\n", $postalAddress);
        
                $datasources['sender'][] = $contact;
            }
        }

        return $datasources;
    }

    public static function noteEvents(array $aArgs)
    {
        $datasources['recipient'][0] = $aArgs['params']['recipient'];
        $datasources['notes']        = array();
        
        // Link to detail page
        $urlToApp = trim($aArgs['params']['maarchUrl'], '/').'/apps/maarch_entreprise/index.php?';
        
        $basket = BasketModel::getByBasketId(['select' => ['id'], 'basketId' => 'MyBasket']);
        $preferenceBasket = UserBasketPreferenceModel::get([
            'select'  => ['group_serial_id'],
            'where'   => ['user_serial_id = ?', 'basket_id = ?'],
            'data'    => [$aArgs['params']['recipient']['user_id'], 'MyBasket']
        ]);
        
        foreach ($aArgs['params']['events'] as $event) {
            $note = [];
            
            if ($event['table_name'] != 'notes') {
                $note = DatabaseModel::select([
                    'select'    => ['mlb.*', 'notes.*', 'users.*'],
                    'table'     => ['listinstance', $aArgs['params']['res_view'] . ' mlb', 'notes', 'users'],
                    'left_join' => ['mlb.res_id = li.res_id', 'notes.identifier = li.res_id', 'users.id = notes.user_id'],
                    'where'     => ['li.item_id = ?', 'li.item_mode = \'dest\'', 'li.item_type = \'user_id\'', 'li.res_id = ?'],
                    'data'      => [$aArgs['params']['recipient']['user_id'], $event['record_id']],
                ])[0];
                $resId = $note['identifier'];
            } else {
                $note         = NoteModel::getById(['id' => $event['record_id']]);
                $resId        = $note['identifier'];
                $resLetterbox = ResModel::getById(['select' => ['*'], 'resId'  => $resId]);
                $datasources['res_letterbox'][] = $resLetterbox;
            }
        
            $note['linktodoc']     = $urlToApp . 'linkToDoc='.$resId;
            $note['linktodetail']  = $urlToApp . 'linkToDetail='.$resId;
        
            if (!empty($resId) && !empty($preferenceBasket[0]['group_serial_id']) && !empty($basket['id']) && !empty($aArgs['params']['recipient']['user_id'])) {
                $note['linktoprocess'] = $urlToApp . 'linkToProcess='.$resId.'&groupId='.$preferenceBasket[0]['group_serial_id'].'&basketId='.$basket['id'].'&userId='.$aArgs['params']['recipient']['user_id'];
            }
        
            $resourceContacts = ResourceContactModel::get([
                'where' => ['res_id = ?', "type = 'contact'", "mode = 'sender'"],
                'data'  => [$resId],
                'limit' => 1
            ]);
            $resourceContacts = $resourceContacts[0];
        
            if ($event['table_name'] == 'notes') {
                $datasources['res_letterbox'][0]['linktodoc']     = $note['linktodoc'];
                $datasources['res_letterbox'][0]['linktodetail']  = $note['linktodetail'];
                $datasources['res_letterbox'][0]['linktoprocess'] = $note['linktodoc'];
        
                $labelledUser = UserModel::getLabelledUserById(['id' => $note['user_id']]);
                $creationDate = TextFormatModel::formatDate($note['creation_date'], 'd/m/Y');
                $note = "{$labelledUser}  {$creationDate} : {$note['note_text']}\n";
            }
        
            if (!empty($resourceContacts)) {
                $contact = ContactModel::getById(['id' => $resourceContacts['item_id'], 'select' => ['*']]);
                $datasources['sender'][] = $contact;
            }
            
            $datasources['notes'] = $note;
        }

        return $datasources;
    }
}
