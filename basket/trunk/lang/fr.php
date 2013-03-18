<?php
/*
 *
 *    Copyright 2008,2009 Maarch
 *
 *  This file is part of Maarch Framework.
 *
 *   Maarch Framework is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   Maarch Framework is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *    along with Maarch Framework.  If not, see <http://www.gnu.org/licenses/>.
 */

/*********************** SERVICES ***********************************/
if (!defined('_ADMIN_BASKETS'))
    define('_ADMIN_BASKETS', 'Corbeilles');
if (!defined('_ADMIN_BASKETS_DESC'))
    define('_ADMIN_BASKETS_DESC', 'D&eacute;finir le contenu des corbeilles et les affecter &agrave; des groupes d&rsquo;utilisateurs. Enum&eacute;rer les redirections possibles lors de l&rsquo;utilisation de la corbeille par un groupe donn&eacute;. Attribuer un format d&rsquo;affichage de la corbeille par ce groupe.');
if (!defined('_USE_BASKETS'))
    define('_USE_BASKETS', 'Utiliser les corbeilles');
if (!defined('_DIFFUSION_LIST'))
    define('_DIFFUSION_LIST', 'Liste de diffusion');

//class basket
if (!defined('_BASKET'))
    define('_BASKET', 'Corbeille');
if (!defined('_BASKETS_COMMENT'))
    define('_BASKETS_COMMENT', 'Corbeilles');
if (!defined('_THE_BASKET'))
    define('_THE_BASKET', 'La corbeille ');
if (!defined('_THE_ID'))
    define('_THE_ID', 'L&rsquo;identifiant ');
if (!defined('_THE_DESC'))
    define('_THE_DESC', 'La description ');
if (!defined('_BELONGS_TO_NO_GROUP'))
    define('_BELONGS_TO_NO_GROUP', 'n&rsquo;appartient &agrave; aucun groupe');
if (!defined('_SYSTEM_BASKET_MESSAGE'))
    define('_SYSTEM_BASKET_MESSAGE', 'Cette corbeille est une corbeille syst&egrave;me, vous ne pouvez pas modifier la table et la where clause. Elles sont affich&eacute;es &agrave; titre indicatif');
if (!defined('_BASKET_MISSING'))
    define('_BASKET_MISSING', 'La Corbeille n&rsquo;existe pas');
if (!defined('_BASKET_UPDATED'))
    define('_BASKET_UPDATED', 'Corbeille modifi&eacute;e');
if (!defined('_BASKET_UPDATE'))
    define('_BASKET_UPDATE', 'Modification de la corbeille');
if (!defined('_BASKET_ADDED'))
    define('_BASKET_ADDED', 'Nouvelle corbeille ajout&eacute;e');
if (!defined('_DELETED_BASKET'))
    define('_DELETED_BASKET', 'Corbeille supprim&eacute;e');
if (!defined('_BASKET_DELETION'))
    define('_BASKET_DELETION', 'Suppression de la corbeille');
if (!defined('_BASKET_AUTORIZATION'))
    define('_BASKET_AUTORIZATION', 'Autorisation de la corbeille');
if (!defined('_BASKET_SUSPENSION'))
    define('_BASKET_SUSPENSION', 'Suspension de la corbeille');
if (!defined('_AUTORIZED_BASKET'))
    define('_AUTORIZED_BASKET', 'Corbeille autoris&eacute;e');
if (!defined('_SUSPENDED_BASKET'))
    define('_SUSPENDED_BASKET', 'Corbeille suspendue');
if (!defined('_NO_BASKET_DEFINED_FOR_YOU'))
    define('_NO_BASKET_DEFINED_FOR_YOU', 'Aucune corbeille d&eacute;finie pour cet utilisateur');
if (!defined('_BASKET_VISIBLE'))
    define('_BASKET_VISIBLE', 'Corbeille visible');
if (!defined('_BASKETS_LIST'))
    define('_BASKETS_LIST', 'Liste des corbeilles');

/////// frame corbeilles
if (!defined('_BASKETS'))
    define('_BASKETS', 'Corbeilles');
if (!defined('_CHOOSE_BASKET'))
    define('_CHOOSE_BASKET', 'Choisissez une corbeille');
if (!defined('_PROCESS_BASKET'))
    define('_PROCESS_BASKET', 'Votre courrier &agrave; traiter');
if (!defined('_VALIDATION_BASKET'))
    define('_VALIDATION_BASKET', 'Votre courrier &agrave; valider');
if (!defined('_MANAGE_BASKETS'))
    define('_MANAGE_BASKETS', 'G&eacute;rer les corbeilles');
if (!defined('_MANAGE_BASKETS_APP'))
    define('_MANAGE_BASKETS_APP', 'G&eacute;rer les corbeilles de l&rsquo;application');

/************** Corbeille : Liste + Formulaire**************/
if (!defined('_ALL_BASKETS'))
    define('_ALL_BASKETS', 'Toutes les corbeilles');
if (!defined('_BASKET_LIST'))
    define('_BASKET_LIST', 'Liste des corbeilles');
if (!defined('_ADD_BASKET'))
    define('_ADD_BASKET', 'Ajouter une corbeille');
if (!defined('_BASKET_ADDITION'))
    define('_BASKET_ADDITION', 'Ajout d&rsquo;une corbeille');
if (!defined('_BASKET_MODIFICATION'))
    define('_BASKET_MODIFICATION', 'Modification d&rsquo;une corbeille');
if (!defined('_BASKET_VIEW'))
    define('_BASKET_VIEW', 'Vue sur la table');
if (!defined('_MODIFY_BASKET'))
    define('_MODIFY_BASKET', 'Modifier la corbeille');
if (!defined('_ADD_A_NEW_BASKET'))
    define('_ADD_A_NEW_BASKET', 'Cr&eacute;er une nouvelle corbeille');
if (!defined('_ADD_A_GROUP_TO_BASKET'))
    define('_ADD_A_GROUP_TO_BASKET', 'Associer un nouveau groupe &agrave; la corbeille');
if (!defined('_DEL_GROUPS'))
    define('_DEL_GROUPS', 'Supprimer groupe(s)');
if (!defined('_BASKET_NOT_USABLE'))
    define('_BASKET_NOT_USABLE', 'Aucun groupe associ&eacute; (la corbeille est inutilisable pour l&rsquo;instant)');
if (!defined('_ASSOCIATED_GROUP'))
    define('_ASSOCIATED_GROUP', 'Liste des groupes associ&eacute;s &agrave; la corbeille');
if (!defined('_TITLE_GROUP_BASKET'))
    define('_TITLE_GROUP_BASKET', 'Associer la corbeille &agrave; un groupe');
if (!defined('_ADD_TO_BASKET'))
    define('_ADD_TO_BASKET', 'Associer la corbeille');
if (!defined('_TO_THE_GROUP'))
    define('_TO_THE_GROUP', '&agrave; un groupe');
if (!defined('_ALLOWED_ACTIONS'))
    define('_ALLOWED_ACTIONS', 'Actions autoris&eacute;es');
if (!defined('_SERVICES_BASKETS'))
    define('_SERVICES_BASKETS', 'Corbeilles de services');
if (!defined('_USERGROUPS_BASKETS'))
    define('_USERGROUPS_BASKETS', 'Corbeilles des groupes d&rsquo;utilisateurs');
if (!defined('_BASKET_RESULT_PAGE'))
    define('_BASKET_RESULT_PAGE', 'Liste de r&eacute;sultats');
if (!defined('_ADD_THIS_GROUP'))
    define('_ADD_THIS_GROUP', 'Ajouter le groupe');
if (!defined('_MODIFY_THIS_GROUP'))
    define('_MODIFY_THIS_GROUP', 'Modifier le groupe');
if (!defined('_DEFAULT_ACTION_LIST'))
    define('_DEFAULT_ACTION_LIST', 'Action par d&eacute;faut sur la liste<br/><i>(Cliquez sur la ligne)');
if (!defined('_NO_ACTION_DEFINED'))
    define('_NO_ACTION_DEFINED', 'Aucune action d&eacute;finie');
//BASKETS
if (!defined('_PROCESS_FOLDER_LIST'))
    define('_PROCESS_FOLDER_LIST', 'Liste des dossiers trait&eacute;s');
if (!defined('_INCOMPLETE_FOLDERS_LIST'))
    define('_INCOMPLETE_FOLDERS_LIST', 'Liste des dossiers incomplets');
if (!defined('_WAITING_VAL_LIST'))
    define('_WAITING_VAL_LIST', 'Liste des pi&egrave;ces en attente de validation');
if (!defined('_WAITING_QUAL_LIST'))
    define('_WAITING_QUAL_LIST', 'Liste des pi&egrave;ces en attente de qualification');
if (!defined('_WAITING_DISTRIB_LIST'))
    define('_WAITING_DISTRIB_LIST', 'Liste des courriers en attente de distribution');
if (!defined('_NO_REDIRECT_RIGHT'))
    define('_NO_REDIRECT_RIGHT', 'Vous n&rsquo;avez pas le droit de redirection dans cette corbeille');
if (!defined('_CLICK_LINE_BASKET1'))
    define('_CLICK_LINE_BASKET1', 'Cliquez sur une ligne pour qualifier un document');

//DIFFUSION LIST
if (!defined('_CHOOSE_DEPARTMENT_FIRST'))
    define('_CHOOSE_DEPARTMENT_FIRST', 'Vous devez d&rsquo;abord choisir un service avant de pouvoir acc&eacute;der &agrave; la liste diffusion');
if (!defined('_NO_LIST_DEFINED__FOR_THIS_MAIL'))
    define('_NO_LIST_DEFINED__FOR_THIS_MAIL', 'Aucune liste n&rsquo;est d&eacute;finie pour ce courrier');
if (!defined('_NO_LIST_DEFINED__FOR_THIS_DEPARTMENT'))
    define('_NO_LIST_DEFINED__FOR_THIS_DEPARTMENT', 'Aucune liste n&rsquo;est d&eacute;finie pour ce service');
if (!defined('_NO_LIST_DEFINED'))
    define('_NO_LIST_DEFINED', 'Pas de liste d&eacute;finie');
if (!defined('_REDIRECT_MAIL'))
    define('_REDIRECT_MAIL', 'Redirection du document');
if (!defined('_DISTRIBUTE_MAIL'))
    define('_DISTRIBUTE_MAIL', 'Ventilation du document');
if (!defined('_REDIRECT_TO_OTHER_DEP'))
    define('_REDIRECT_TO_OTHER_DEP', 'Rediriger vers un autre service');
if (!defined('_REDIRECT_TO_USER'))
    define('_REDIRECT_TO_USER', 'Rediriger vers un utilisateur');
if (!defined('_LETTER_SERVICE_REDIRECT'))
    define('_LETTER_SERVICE_REDIRECT','Rediriger vers le service &eacute;metteur');
if (!defined('_LETTER_SERVICE_REDIRECT_VALIDATION'))
    define('_LETTER_SERVICE_REDIRECT_VALIDATION','Souhaitez-vous vraiment rediriger vers le service &eacute;metteur');
if (!defined('_DOC_REDIRECT_TO_SENDER_ENTITY'))
    define('_DOC_REDIRECT_TO_SENDER_ENTITY', 'Document redirig&eacute; vers service &eacute;metteur');
if (!defined('_DOC_REDIRECT_TO_ENTITY'))
    define('_DOC_REDIRECT_TO_ENTITY', 'Document redirig&eacute; vers service');
if (!defined('_DOC_REDIRECT_TO_USER'))
    define('_DOC_REDIRECT_TO_USER', 'Document redirig&eacute; vers utilisateur');
if (!defined('_WELCOME_DIFF_LIST'))
    define('_WELCOME_DIFF_LIST', 'Bienvenue dans l&rsquo;outil de diffusion de courrier');
if (!defined('_START_DIFF_EXPLANATION'))
    define('_START_DIFF_EXPLANATION', 'Pour demarrer la diffusion, utilisez la navigation par service ou par utilisateur ci-dessus');
if (!defined('_CLICK_ON'))
    define('_CLICK_ON', 'cliquez sur');
if (!defined('_ADD_USER_TO_LIST_EXPLANATION'))
    define('_ADD_USER_TO_LIST_EXPLANATION', 'Pour ajouter un utilisateur &agrave; la liste de diffusion');
if (!defined('_REMOVE_USER_FROM_LIST_EXPLANATION'))
    define('_REMOVE_USER_FROM_LIST_EXPLANATION', 'Pour retirer l&rsquo;utilisateur &agrave; cette liste de diffusion');
if (!defined('_TO_MODIFY_LIST_ORDER_EXPLANATION'))
    define('_TO_MODIFY_LIST_ORDER_EXPLANATION', 'Pour modifier l&rsquo;ordre d&rsquo;attribution d&rsquo;un courrier aux utilisateurs, utilisez les ic&ocirc;nes');
if (!defined('_AND'))
    define('_AND', ' et ' );
if (!defined('_LINKED_DIFF_LIST'))
    define('_LINKED_DIFF_LIST', 'Liste de diffusion associ&eacute;e');
if (!defined('_NO_LINKED_DIFF_LIST'))
    define('_NO_LINKED_DIFF_LIST', 'Pas de liste associ&eacute;e');
if (!defined('_CREATE_LIST'))
    define('_CREATE_LIST', 'Cr&eacute;er une liste de diffusion');
if (!defined('_MODIFY_LIST'))
    define('_MODIFY_LIST', 'Modifier la liste');
if (!defined('_THE_ENTITY_DO_NOT_CONTAIN_DIFF_LIST'))
    define('_THE_ENTITY_DO_NOT_CONTAIN_DIFF_LIST', 'Le service s&eacute;lectionn&eacute; n&rsquo;a pas de mod&egrave;le de liste de diffusion associ&eacute;e');

//LIST MODEL
if (!defined('_MANAGE_MODEL_LIST_TITLE'))
    define('_MANAGE_MODEL_LIST_TITLE', 'Cr&eacute;ation / Modification Mod&egrave;le de liste de diffusion');
if (!defined('_SORT_BY'))
    define('_SORT_BY', 'Trier par');
if (!defined('_WELCOME_MODEL_LIST_TITLE'))
    define('_WELCOME_MODEL_LIST_TITLE', 'Bienvenue dans l&rsquo;outil de cr&eacute;tion de mod&egrave;le de liste de diffusion');
if (!defined('_MODEL_LIST_EXPLANATION1'))
    define('_MODEL_LIST_EXPLANATION1', 'Pour d&eacute;marrer la cr&eacute;tion, utilisez la navigation par service ou par utilisateur cidessus');
if (!defined('_VALID_LIST'))
    define('_VALID_LIST', 'Valider la liste');

//LIST
if (!defined('_COPY_LIST'))
    define('_COPY_LIST', 'Liste des documents en copie');
if (!defined('_PROCESS_LIST'))
    define('_PROCESS_LIST', 'Liste des documents &agrave; traiter');
if (!defined('_CLICK_LINE_TO_VIEW'))
    define('_CLICK_LINE_TO_VIEW', 'Cliquez sur une ligne pour visualiser');
if (!defined('_CLICK_LINE_TO_PROCESS'))
    define('_CLICK_LINE_TO_PROCESS', 'Cliquez sur une ligne pour traiter');
if (!defined('_REDIRECT_TO_SENDER_ENTITY'))
    define('_REDIRECT_TO_SENDER_ENTITY', 'Redirection vers le service &eacute;metteur');
if (!defined('_CHOOSE_DEPARTMENT'))
    define('_CHOOSE_DEPARTMENT', 'Choisissez un service');
if (!defined('_ENTITY_UPDATE'))
    define('_ENTITY_UPDATE', 'Service mis &agrave; jour');

// USER ABS
if (!defined('_MY_ABS'))
    define('_MY_ABS', 'G&eacute;rer mes absences');
if (!defined('_MY_ABS_TXT'))
    define('_MY_ABS_TXT', 'Permet de rediriger vos corbeilles en cas de d&eacute;part en cong&eacute;.');
if (!defined('_MY_ABS_REDIRECT'))
    define('_MY_ABS_REDIRECT', 'Vos courriers sont actuellement redirig&eacute;s vers');
if (!defined('_MY_ABS_DEL'))
    define('_MY_ABS_DEL', 'Pour supprimer la redirection, cliquez ici pour stopper');
if (!defined('_ADMIN_ABS'))
    define('_ADMIN_ABS', 'G&eacute;rer les absences.');
if (!defined('_ADMIN_ABS_TXT'))
    define('_ADMIN_ABS_TXT', 'Permet de rediriger le courrier de l&rsquo;utilisateur en attente en cas de d&eacute;part en cong&eacute;.');
if (!defined('_ADMIN_ABS_REDIRECT'))
    define('_ADMIN_ABS_REDIRECT', 'Redirection d&rsquo;absence en cours.');
if (!defined('_ADMIN_ABS_FIRST_PART'))
    define('_ADMIN_ABS_FIRST_PART', 'Les courrier de');
if (!defined('_ADMIN_ABS_SECOND_PART'))
    define('_ADMIN_ABS_SECOND_PART', 'sont actuellement redirig&eacute;s vers ');
if (!defined('_ADMIN_ABS_THIRD_PART'))
    define('_ADMIN_ABS_THIRD_PART', '. Cliquez ici pour supprimer la redirection.');
if (!defined('_ACTIONS_DONE'))
    define('_ACTIONS_DONE', 'Actions effectu&eacute;es le');
if (!defined('_PROCESSED_MAIL'))
    define('_PROCESSED_MAIL', 'Courriers trait&eacute;s');
if (!defined('_INDEXED_MAIL'))
    define('_INDEXED_MAIL', 'Courriers index&eacute;s');
if (!defined('_REDIRECTED_MAIL'))
    define('_REDIRECTED_MAIL', 'Courriers redirig&eacute;s');
if (!defined('_PROCESS_MAIL_OF'))
    define('_PROCESS_MAIL_OF', 'Courrier &agrave; traiter de');
if (!defined('_MISSING'))
    define('_MISSING', 'Absent');
if (!defined('_BACK_FROM_VACATION'))
    define('_BACK_FROM_VACATION', 'de retour de son absence');
if (!defined('_MISSING_ADVERT_TITLE'))
    define('_MISSING_ADVERT_TITLE','Gestion des absences');
if (!defined('_MISSING_ADVERT_01'))
    define('_MISSING_ADVERT_01','Ce compte est actuellement d&eacute;finit en mode &rsquo;absent&rsquo; et les courriers sont redirig&eacute;s vers un autre utilisateur.');
if (!defined('_MISSING_ADVERT_02'))
    define('_MISSING_ADVERT_02','Si vous desirez vous connecter avec ce compte, le mode &rsquo;absent&rsquo; sera alors supprim&eacute;.<br/> La redirection des courriers arrivera &agrave; son terme et l&rsquo;application sera r&eacute;activ&eacute;e');
if (!defined('_MISSING_CHOOSE'))
    define('_MISSING_CHOOSE','Souhaitez-vous continuer?');
if (!defined('_CHOOSE_PERSON_TO_REDIRECT'))
    define('_CHOOSE_PERSON_TO_REDIRECT', 'Choisissez la personne vers qui vous souhaitez rediriger ce courrier dans la liste ci-dessus');
if (!defined('_CLICK_ON_THE_LINE_OR_ICON'))
    define('_CLICK_ON_THE_LINE_OR_ICON', 'Il vous suffit de cliquer sur la ligne ou sur l&rsquo;ic&ocirc;ne');
if (!defined('_TO_SELECT_USER'))
    define('_TO_SELECT_USER', 'pour s&eacute;lectionner un utilisateur');
if (!defined('_DIFFUSION_DISTRIBUTION'))
    define('_DIFFUSION_DISTRIBUTION', 'Diffusion et distribution du courrier');
if (!defined('_VALIDATED_ANSWERS'))
    define('_VALIDATED_ANSWERS', 'DGS R&eacute;ponses valid&eacute;es');
if (!defined('_REJECTED_ANSWERS'))
    define('_REJECTED_ANSWERS', 'DGS R&eacute;ponses rejet&eacute;es');
if (!defined('_MUST_HAVE_DIFF_LIST'))
    define('_MUST_HAVE_DIFF_LIST', 'Vous devez d&eacute;finir une liste de diffusion');
if (!defined('_ASSOCIATED_STATUS'))
    define('_ASSOCIATED_STATUS', 'Statut associ&eacute;');
if (!defined('_SYSTEM_ACTION'))
    define('_SYSTEM_ACTION', 'Action syst&egrave;me');
if (!defined('_CANNOT_MODIFY_STATUS'))
    define('_CANNOT_MODIFY_STATUS', 'Vous ne pouvez pas modifier le statut');
if (!defined('_ASSOCIATED_ACTIONS'))
    define('_ASSOCIATED_ACTIONS', 'Actions possibles sur la page de r&eacute;sultat');
if (!defined('_NO_ACTIONS_DEFINED'))
    define('_NO_ACTIONS_DEFINED', 'Aucune action d&eacute;finie');
if (!defined('_CONFIG'))
    define('_CONFIG', '(param&egrave;trer)');
if (!defined('_CONFIG_ACTION'))
    define('_CONFIG_ACTION', 'Param&egrave;trage de l&rsquo;action');
if (!defined('_WHERE_CLAUSE_ACTION_TEXT'))
    define('_WHERE_CLAUSE_ACTION_TEXT', 'D&eacute;finissez une condition d&rsquo;apparition de l&rsquo;action dans la page par une clause Where (Facultatif) : ');
if (!defined('_IN_ACTION'))
    define('_IN_ACTION', ' dans l&rsquo;action');
if (!defined('_TO_ENTITIES'))
    define('_TO_ENTITIES', 'Vers des services');
if (!defined('_TO_USERGROUPS'))
    define('_TO_USERGROUPS', 'Vers des groupes d&rsquo;utilisateur');
if (!defined('_USE_IN_MASS'))
    define('_USE_IN_MASS', 'Action disponible dans la liste');
if (!defined('_USE_ONE'))
    define('_USE_ONE', 'Action disponible dans la page d&rsquo;action');
if (!defined('_MUST_CHOOSE_WHERE_USE_ACTION'))
    define('_MUST_CHOOSE_WHERE_USE_ACTION','Vous devez d&eacute;finir o&ugrave; vous souhaitez utiliser l&rsquo;action ');
if (!defined('_MUST_CHOOSE_DEP'))
    define('_MUST_CHOOSE_DEP', 'Vous devez s&eacute;lectionner un service!');
if (!defined('_MUST_CHOOSE_USER'))
    define('_MUST_CHOOSE_USER', 'Vous devez s&eacute;lectionner un utilisateur!');
if (!defined('_REDIRECT_TO_DEP_OK'))
    define('_REDIRECT_TO_DEP_OK', 'Redirection vers un service effectu&eacute;e');
if (!defined('_REDIRECT_TO_USER_OK'))
    define('_REDIRECT_TO_USER_OK', 'Redirection vers un utilisateur effectu&eacute;e');
if (!defined('_SAVE_CHANGES'))
    define('_SAVE_CHANGES', 'Enregistrer les modifications');
if (!defined('_VIEW_BASKETS'))
    define('_VIEW_BASKETS', 'Mes corbeilles');
if (!defined('_VIEW_BASKETS_DESC'))
    define('_VIEW_BASKETS_DESC', 'Mes corbeilles');
if (!defined('_VIEW_BASKETS_TITLE'))
    define('_VIEW_BASKETS_TITLE', 'Mes corbeilles');
if (!defined('_INVOICE_LIST_TO_VAL'))
    define('_INVOICE_LIST_TO_VAL', 'Factures &agrave; valider');
if (!defined('_POSTINDEXING_LIST'))
    define('_POSTINDEXING_LIST', 'Documents &agrave; vid&eacute;ocoder');
if (!defined('_MY_BASKETS'))
    define('_MY_BASKETS', 'Mes corbeilles');
if (!defined('_REDIRECT_MY_BASKETS'))
    define('_REDIRECT_MY_BASKETS', 'Rediriger les corbeilles');
if (!defined('_NAME'))
    define('_NAME', 'Nom');
if (!defined('_CHOOSE_USER_TO_REDIRECT'))
    define('_CHOOSE_USER_TO_REDIRECT', 'Vous devez rediriger au moins une des corbeilles vers un utilisateur.');
if (!defined('_FORMAT_ERROR_ON_USER_FIELD'))
    define('_FORMAT_ERROR_ON_USER_FIELD', 'Un champ n&rsquo;est pas dans le bon format : Nom, Pr&eacute;nom (Identifiant)');
if (!defined('_BASKETS_OWNER_MISSING'))
    define('_BASKETS_OWNER_MISSING', 'Le propri&eacute;taire des corbeilles n&rsquo;est pas d&eacute;fini.');
if (!defined('_FORM_ERROR'))
    define('_FORM_ERROR', 'Erreur dans la transmission du formulaire...');
if (!defined('_USER_ABS'))
    define('_USER_ABS', 'Utilisateur absent : redirection d&eacute;j&agrave; param&eacute;tr&eacute;e.');
if (!defined('_ABS_LOG_OUT'))
    define('_ABS_LOG_OUT', 'si vous vous reconnectez, le mode absent sera annul&eacute;.');
if (!defined('_ABS_USER'))
    define('_ABS_USER', 'Utilisateur absent');
if (!defined('_ABSENCE'))
    define('_ABSENCE', 'Absence');
if (!defined('_BASK_BACK'))
    define('_BASK_BACK', 'Retour');
if (!defined('_CANCEL_ABS'))
    define('_CANCEL_ABS', 'Annulation d&rsquo;absence');
if (!defined('_REALLY_CANCEL_ABS'))
    define('_REALLY_CANCEL_ABS', 'Voulez-vous vraiment annuler l&rsquo;absence ?');
if (!defined('_ABS_MODE'))
    define('_ABS_MODE', 'Gestion des absences');
if (!defined('_REALLY_ABS_MODE'))
    define('_REALLY_ABS_MODE', 'Voulez-vous vraiment passer en mode absent ?');
if (!defined('_DOCUMENTS_LIST_WITH_FILTERS'))
    define('_DOCUMENTS_LIST_WITH_FILTERS', 'Liste avec filtres');
if (!defined('_AUTHORISED_ENTITIES'))
    define('_AUTHORISED_ENTITIES', 'Liste services autoris&eacute;s');
if (!defined('_ARCHIVE_LIST'))
    define('_ARCHIVE_LIST', 'Liste d&rsquo;unit&eacute;s d&rsquo;archive');
if (!defined('_COUNT_LIST'))
    define('_COUNT_LIST', 'Liste des copies');
if (!defined('_FILTER_BY_ENTITY'))
    define('_FILTER_BY_ENTITY', 'Filtrer par service');
if (!defined('_FILTER_BY'))
    define('_FILTER_BY', 'Filtrer par');
if (!defined('_OTHER_BASKETS'))
    define('_OTHER_BASKETS', 'Autres corbeilles');
if (!defined('_SPREAD_SEARCH_TO_BASKETS'))
    define('_SPREAD_SEARCH_TO_BASKETS', 'Etendre la recherche aux corbeilles');
if (!defined('_BASKET_WELCOME_TXT1'))
    define('_BASKET_WELCOME_TXT1', 'Durant votre navigation dans les corbeilles,');
if (!defined('_BASKET_WELCOME_TXT2'))
    define('_BASKET_WELCOME_TXT2', 'cliquez, &agrave; tout moment, dans la liste ci-dessus <br/>pour changer de corbeille');
if (!defined('_VIEWED'))
    define('_VIEWED', 'Vu?');
if (!defined('_SEE_BASKETS_RELATED'))
    define('_SEE_BASKETS_RELATED', 'Voir les corbeilles associ&eacute;es');
if (!defined('_GO_MANAGE_BASKET'))
    define('_GO_MANAGE_BASKET', 'Modifier');

//NEW WF
if (!defined('_WF'))
    define('_WF', 'Workflow');
if (!defined('_POSITION'))
    define('_POSITION', 'Position');
if (!defined('_ADVANCE_TO'))
    define('_ADVANCE_TO', 'Avancer vers');
if (!defined('_VALID_STEP'))
    define('_VALID_STEP', 'Valider l&rsquo;&eacute;tape');
if (!defined('_BACK_TO'))
    define('_BACK_TO', 'Retourner vers');
if (!defined('_FORWARD_IN_THE_WF'))
    define('_FORWARD_IN_THE_WF', 'Avance dans le workflow');
if (!defined('_BACK_IN_THE_WF'))
    define('_BACK_IN_THE_WF', 'Recule dans le workflow');
if (!defined('_ITS_NOT_MY_TURN_IN_THE_WF'))
    define('_ITS_NOT_MY_TURN_IN_THE_WF', 'Ce n&rsquo;est pas mon tour de traiter dans le workflow');
if (!defined('_COMBINATED_ACTION'))
    define('_COMBINATED_ACTION', 'Action combin&eacute;e');
