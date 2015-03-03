<?php
/*
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

/**
* File : create_folder_form.php
*
* Form to create a folder
*
* @package  Folder
* @version 1.0
* @since 06/2007
* @license GPL
* @author  Claire Figueras  <dev@maarch.org>
*/
$core = new core_tools();
$core->load_lang();
$core->test_service('create_folder', 'folder');

 /****************Management of the location bar  ************/
$init = false;
if (isset($_REQUEST['reinit']) && $_REQUEST['reinit'] == "true") {
    $init = true;
}
$level = "";
if (isset($_REQUEST['level']) && ( $_REQUEST['level'] == 2
    || $_REQUEST['level'] == 3 || $_REQUEST['level'] == 4
    || $_REQUEST['level'] == 1)
) {
    $level = $_REQUEST['level'];
}
$pagePath = $_SESSION['config']['businessappurl'].'index.php?page=create_folder_form&module=folder';
$pageLabel = _CREATE_FOLDER;
$pageId = "fold_create_folder_form";
$core->manage_location_bar($pagePath, $pageLabel, $pageId, $init, $level);
/***********************************************************/
$core->load_html();

$db = new dbquery();
$db->connect();
$db->query(
	"select foldertype_id, foldertype_label from "
    . $_SESSION['tablename']['fold_foldertypes'] . " order by foldertype_label"
);

$foldertypes = array();
while ($res = $db->fetch_object()) {
    array_push(
        $foldertypes,
        array(
        	'id' => $res->foldertype_id,
        	'label' => $db->show_string($res->foldertype_label),
        )
    );
}
$init = false;
?>

<h1><i class="fa fa-folder-open fa-2x" title="" /></i> <?php  echo _CREATE_FOLDER;?></h1>
<div id="inner_content">
    <form name="create_folder" id="create_folder" action="<?php
echo $_SESSION['config']['businessappurl'];
?>index.php?display=true&module=folder&page=manage_create_folder" method="post" class="forms">
        <input type="hidden" name="display"  value="true" />
        <input type="hidden" name="module"  value="folder" />
        <input type="hidden" name="page"  value="manage_create_folder" />
        <p>
            <label for="foldertype"><?php echo _FOLDERTYPE;?> :</label>
            <select name="foldertype" id="foldertype" onchange="get_folder_index('<?php
echo $_SESSION['config']['businessappurl'] . 'index.php?display=true'
    . '&module=folder&page=create_folder_get_folder_index';
?>', this.options[this.options.selectedIndex].value, 'folder_indexes');">
                <option value=""><?php  echo _CHOOSE_FOLDERTYPE;?></option>
                <?php
for ($i = 0; $i < count($foldertypes); $i ++) {
    ?><option value="<?php
    echo $foldertypes[$i]['id'];
    ?>" <?php
    if (isset($_SESSION['m_admin']['folder']['foldertype_id'])
        && $_SESSION['m_admin']['folder']['foldertype_id'] == $foldertypes[$i]['id']
    ) {
        echo 'selected="selected"';
    } else if($i == 0) {
        $init = true;
        echo 'selected="selected"';
    }
    ?>><?php
    echo $foldertypes[$i]['label'];
    ?></option>
    <?php
    }
?>
            </select> <span class="red_asterisk">*</span>
        </p>
        <p>
            <label for="folder_id"><?php echo _ID;?></label>
            <input name="folder_id" id="folder_id" value="<?php
if (isset($_SESSION['m_admin']['folder']['folder_id'])) {
    echo $_SESSION['m_admin']['folder']['folder_id'];
}
?>" /> <span class="red_asterisk">*</span>
        </p>
        <p>
            <label for="folder_name"><?php echo _FOLDERNAME;?></label>
            <input name="folder_name" id="folder_name" value="<?php
if (isset($_SESSION['m_admin']['folder']['folder_name'])) {
    echo $_SESSION['m_admin']['folder']['folder_name'];
}
?>" /> <span class="red_asterisk">*</span>
        </p>
        <div id="folder_indexes"></div>
        <p class="buttons">
            <input type="submit" name="validate" id="validate" value="<?php
echo _VALIDATE;
?>" class="button"/>
            <input type="button" name="cancel" id="cancel" value="<?php
echo _CANCEL;
?>" class="button" onclick="window.top.location='<?php
echo $_SESSION['config']['businessappurl'];
?>index.php';" />
        </p>
    </form>
    <?php
if ((isset($_SESSION['m_admin']['folder']['foldertype_id'])
    && ! empty($_SESSION['m_admin']['folder']['foldertype_id'] ))
    || $init
) {
    ?>
    <script type="text/javascript">
    var ft_list = $('foldertype');
    if (ft_list) {
        get_folder_index('<?php
    echo $_SESSION['config']['businessappurl'] . 'index.php?display=true'
        . '&module=folder&page=create_folder_get_folder_index';
    ?>', ft_list.options[ft_list.options.selectedIndex].value, 'folder_indexes');
    }
    </script>
    <?php
}
?>
</div>
