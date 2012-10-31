<?php

require_once(
    'core/tests/class/MessageController.php'
);

class ViewController
    extends DOMXPath
{
    //*************************************************************************
    // Constructor
    //*************************************************************************
    function ViewController()
    {
        
    }
    
    function loadHTMLFile($viewFile)
    {     
        $customFilePath = 
            $_SESSION['config']['corepath'] . DIRECTORY_SEPARATOR 
            . 'custom' . DIRECTORY_SEPARATOR 
            . $_SESSION['custom_override_id'] . DIRECTORY_SEPARATOR
            . $viewFile;
            
        $relativeFilePath = 
            $_SESSION['config']['corepath'] . DIRECTORY_SEPARATOR 
            . $viewFile;
        
        if(is_file($customFilePath)) {
            $loadFile = $customFilePath;
        } elseif(is_file($relativeFilePath)) {
            $loadFile = $relativeFilePath;
        } elseif(is_file($viewFile)) {
            $loadFile = $viewFile;
        } else {
            throw new maarch\Exception("Failed to load view file $viewFile");
        }

        $view = new View();
        $view->loadHTMLFile($loadFile);
        if(!$view->encoding) $view->encoding = 'UTF-8';
        
        parent::__construct($view);
        $this->view = $this->document;
        return $this->view;
    }
    
    function loadHTML($viewString)
    {
        $view = new View();
        $view->loadHTML($viewString);
        if(!$view->encoding) $view->encoding = 'UTF-8';
        
        parent::__construct($view);
        $this->view = $this->document;
        return $this->view;
    }

    function showView()
    {
        print $this->document->saveHTML();
    }  
    
    function createView()
    {
        $view = new View();
        $view->encoding = 'UTF-8';
        parent::__construct($view);
        $this->view = $this->document;
        return $this->view;
    }
        
    //*************************************************************************
    // Get tags
    //*************************************************************************
    function getElementById($id, $contextNode=false)
    {
        if(!$contextNode) $contextNode = $this->view->documentElement;
        $elements = $this->query("//*[@id='$id']", $contextNode);
        if($elements->length == 0) return false;
        return $elements->item(0);
    }
    
    function getIds()
    {
        $ids = $this->query("//@id");
        return $ids;
    }
    
    function getLabelFor($for)
    {     
        $labels = $this->query("//label[@for='$for']");
        if($labels->length == 0) return false;
        return $labels->item(0);
    }
    
    function getLabels()
    {
        $labels = $this->query("//label");
        return $labels;
    }
    
    function getImgs()
    {
        $imgs = $this->query("//img | //IMG");
        return $imgs;
    }
    
    function getScripts()
    {
        $scripts = $this->query("//script | //SCRIPT");
        return $scripts;
    }
    
    function getTableHeaderCols()
    {
        $th = $this->query("//th[@axis]");
        if($th->length == 0) return false;
        return $th;
    }
    
    function getDataTranslate()
    {
        $dataTranslate = $this->query("//*[@data-translate]");
        if($dataTranslate->length == 0) return false;
        return $dataTranslate;
    }
    
    //*************************************************************************
    // Update tags
    //*************************************************************************
    function setLabelFor($for, $text)
    {
        $label = $this->getlabelFor($for);
        if($label) $label->nodeValue = htmlentities($text, 0, $this->document->encoding);
    }
    
    function setUniqueIds(
        $RefData = false
    ) {
        if($RefData && method_exists($RefData, 'getNodePath')) {
            $uniqueId = $RefData->getNodePath();
            if(substr($uniqueId, -3) == '[1]') {
                $uniqueId = substr($uniqueId, 0, -3);
                echo $uniqueId;
            }
        } else {
            $uniqueId = uniqid();
        }
        
        // Add uniqueId prefix to ids
        $ids = $this->getIds();
        for ($i=0; $i<$ids->length; $i++) {
            $id = $ids->item($i);
            $localId = $id->nodeValue;
            
            if(strpos($localId, $uniqueId) === 0) continue; 
            
            /*$prefix = '';
            if($localId && $RefData->hasAttribute($localId)) {
                $prefix = '@';
            }*/
            $newId = $uniqueId;
            if($localId) {
                $newId .= '/' . $prefix . $localId;
            }
            $id->nodeValue = $newId;
        }
        
        // Add uniqueId to label fors
        $labels = $this->getLabels();
        for ($i=0; $i<$labels->length; $i++) {
            $label = $labels->item($i);
            $localLabelFor = $label->getAttribute('for');
            if(strpos($localLabelFor, $uniqueId) === 0) continue; 
            
            /*$prefix = '';
            if($localLabelFor && $RefData->hasAttribute($localLabelFor)) {
                $prefix = '@';
            }*/
            $newLabelFor = $uniqueId;
            if($localLabelFor) {
                $newLabelFor .= '/' . $localLabelFor;
            }
            $label->setAttribute(
                'for',
                $newLabelFor
            );
        }
    }
    
    function setSrcBaseUrl($tagName, $baseUrl)
    {
        $tags = $this->view->getElementsByTagName($tagName);
        $tagsLength = $tags->length;
        for ($i=0; $i<$tagsLength; $i++) {
            $tag = $tags->item($i);
            $tag->setAttribute(
                'src',
                $baseUrl . $tag->getAttribute('src')
            );
        }  
    }
    
    function setHRefBaseUrl($tagName, $baseUrl)
    {
        $tags = $this->view->getElementsByTagName($tagName);
        $tagsLength = $tags->length;
        for ($i=0; $i<$tagsLength; $i++) {
            $tag = $tags->item($i);
            $tag->setAttribute(
                'href',
                $baseUrl . $tag->getAttribute('href')
            );
        }  
    }
    
    function loadDataObject(
        $XMLElement,
        $create=false
    ) {
        /***************************************************************************
        **  Attributes
        ***************************************************************************/
        foreach($XMLElement->attributes as $attribute) {
            if($input = 
                $this->getElementById(
                    $attribute->nodeName
                )
            ) {
                $input->setValue($attribute->nodeValue);
            }
        }
           
        /***************************************************************************
        **  Elements
        ***************************************************************************/
        $childElements = $XMLElement->childNodes;
        $childCount = $childElements->length;
        for($i=0; $i<$childCount; $i++) {
            $childElement = $childElements->item($i);
            if($childElement->nodeType === 1 
                && $childElement->nodeValue != '' 
                && $input = $this->getElementById(
                        $childElement->tagName
                    )
            ) {
                $input->setValue($childElement->nodeValue);
            }
        }
    
    }
    
    function translate($MessageController)
    {
      
        $labels = $this->getLabels();
        for ($i=0; $i<$labels->length; $i++) {
            $label = $labels->item($i);
            $labelFor = $label->getAttribute('for');
            $labelText = $MessageController->getMessageText(
                $labelFor
            );
            if($labelText == $labelFor) continue;
            $label->nodeValue = $labelText;
        }
        
        $buttons = $this->query('//input[@type="button"]');
        for($i=0; $i<$buttons->length; $i++) {
            $button = $buttons->item($i);
            if($button->hasAttribute('value')) {
                $button->setValue(
                    $MessageController->getMessageText(
                        $button->getAttribute('value')
                    )
                );
            }
        }
        
        $titles = $this->query('//@title');
        for($i=0; $i<$titles->length; $i++) {
            $title = $titles->item($i);
            $title->nodeValue = 
                $MessageController->getMessageText(
                    $title->nodeValue
                );
        }
        
        $translates = $this->query('//*[@data-translate != ""]');
        for($i=0; $i<$translates->length; $i++) {
            $translate = $translates->item($i);
            $message = $translate->getAttribute('data-translate');
            $translation = 
                $MessageController->getMessageText(
                    $message
                );
            if($translate->hasAttribute('value')) {
                $translate->setAttribute(
                    'value', 
                    $translation
                );
            } else {
                $translate->nodeValue = $translation;
            }
        }
    
    }
    
    
}

//*****************************************************************************
// HTML PAGE / FRAGMENT
//*****************************************************************************
class View
    extends DOMDocument
{
    
    //*************************************************************************
    // Constructor
    //*************************************************************************
    function View() 
    {
        parent::__construct();
        $this->registerNodeClass('DOMElement', 'ViewElement');
        $this->registerNodeClass('DOMAttr', 'ViewAttribute');
        $this->registerNodeClass('DOMText', 'ViewText');
        $this->validateOnParse = true;
    }
    
    //*************************************************************************
    // DOM
    //*************************************************************************
    function createElement($tagName, $nodeValue=false)
    {
        $element = parent::createElement($tagName, $nodeValue);
        if(!$this->documentElement) {
            $this->appendChild($element);
        }
        return $element;
    }
    
    //*************************************************************************
    // Create tags
    //*************************************************************************
    function createSelect()
    {
        $select = $this->createElement('select');
        $this->appendChild($select);
        return $select;
    }
    
    function createOption($value, $label)
    {
        $option = $this->createElement('option', $label);
        $option->setAttribute('value', $value);
        return $option;
    }
    
    function createOptionGroup($label)
    {
        $optionGroup = $this->createElement('optgroup');
        $optionGroup->setAttribute('label', $label);
        return $optionGroup;
    }
        
    function replaceViewNode($ViewNode, $replaceNode) 
    {
        $replaceNode->parentNode->replaceChild(
            $this->importNode($ViewNode, true),
            $replaceNode
        );
    }
    
    function createList($tag='ul') 
    {
        $list = $this->createElement($tag);
        return $list;
    }
    
    function createTable(
        $rows=0, 
        $columns=0, 
        $header=false
    ) {
        $table = $this->createElement('table');
        // Create header
        if($header) {
            $thead = $this->createElement('thead');
            $table->appendChild($thead);
            $headerRow = 
                $this->createRow($columns, $header=true);
            
        }
        // Create body
        $tbody = $this->createElement('tbody');
        $table->appendChild($tbody);
        for($i=0; $i<$rows; $i++) {
            $row = $this->createRow($columns, $header=false);
            $tbody->appendChild($row);
        }
        return $table;
    }
    
    function createRow(
        $columns=0,
        $header=false
    ) {
        $row = $this->createElement('tr');
        for($i=0; $i<$columns; $i++) {
            $column = $this->createColumn($header);
            $row->appendChild($column);
        }
        return $row;
    }
    
    function createColumn(
       $header=false
    ) {
        if($header) $tag = 'th';
        else $tag = 'td';
        $column = $this->createElement($tag);
        return $column;
    }
       
    //*************************************************************************
    // Outputs
    //*************************************************************************
    public function show()
    {
        echo $this->saveHTML();
    }
    
    public function getHTML()
    {
        return $this->saveHTML();
    }
    
    
}


//*****************************************************************************
// HTML TAGS
//*****************************************************************************
class ViewElement   
    extends DOMElement
{
    
    //*************************************************************************
    // Retrieve / display
    //*************************************************************************
    function getSource()
    {
        return $this->C14N();
    }
    
    function show() 
    { 
        echo $this->getSource();
    }
    
    //*************************************************************************
    // Structure
    //*************************************************************************
    function appendViewNode($ViewNode)
    {
        $this->appendChild($this->ownerDocument->importNode($ViewNode, true));
    }
    
    //*************************************************************************
    // Search
    //*************************************************************************
    function getAncestorsByTagName($tagName)
    {
        $xpath = new DOMXPath($this->ownerDocument);
        $ancestors = 
            $xpath->query(
                "./ancestor::*[name()='".$tagName."']", 
                $this
            );
        return $ancestors;
    }
    
    //*************************************************************************
    // Standard attributes
    //*************************************************************************
    function setId($id) 
    {
        $this->setAttribute('id', $id);
    }
    
    function setName($name) 
    {
        $this->setAttribute('name', $name);
    }
    
    function setValue($value)
    {
        $this->setAttribute('value', $value);
    }
    
    //*************************************************************************
    // Custom HTML5 attributes
    //*************************************************************************
    function setDataAttribute($name, $value)
    {
        //$this->setAttribute('data-' . $name, htmlentities($value, 0, $this->encoding));
        $this->setAttribute('data-' . $name, $value);
    }
    
    //*************************************************************************
    // Lists
    //*************************************************************************
    function addList($type) 
    {
        $list = $this->ownerDocument->createList($type);
        $this->appendChild($list);
        return $list;
    }
    
    function addListItem($value, $definition=false) {
        switch($this->tagName) {
        case 'ul':
        case 'ol':
            $item = $this->ownerDocument->createElement('li', $value);
            $this->appendChild($item);
            return $item;
            break;
        
        case 'dl':
            $dt = $this->ownerDocument->createElement('dt', $value);
            $this->appendChild($dt);
            $dd = $this->ownerDocument->createElement('dd', $definition);
            $this->appendChild($dd);
            return $this->childNodes;
            break;
        }
 
    }
    
    //*************************************************************************
    // Table
    //*************************************************************************
    function addTable(
        $rows=0, 
        $columns=0, 
        $header=false
    ) {
        $table = 
            $this->ownerDocument->createTable(
                $rows, 
                $columns, 
                $header
            );
        $this->appendChild($table);
        return $table;
    }
    
    function addRow(
        $columns=0,
        $header=false
    ) {
        $row = 
            $this->ownerDocument->createRow(
                $columns, 
                $header
            );
        $this->appendChild($row);
        return $row;
    }
    
    function addColumn(
        $header=false
    ) {
        $column = 
            $this->ownerDocument->createColumn(
                $header
            );
        $this->appendChild($column);
        return $column;
    }
    
    //*************************************************************************
    // Inputs
    //*************************************************************************
    function addOption($value, $label)
    {
        $option = $this->ownerDocument->createOption($value, $label);
        $this->appendChild($option);
        return $option;
    }
    
    function addOptionGroup($label)
    {
        $optionGroup = $this->ownerDocument->createOptionGroup($label);
        $this->appendChild($optionGroup);
        return $optionGroup;
    }
            
    function disable()
    {
        $this->setAttribute('disabled', 'disabled');
    }
    
    function enable() 
    {
        $this->removeAttribute('disabled');
    }
    
    function select()
    {
        $this->setAttribute('selected', 'selected');
    }
    
    function unselect()
    {
        $this->removeAttribute('selected');
    }
    
    function check()
    {
        $this->setAttribute('checked', 'checked');
    }
    
    function uncheck() 
    {
        $this->removeAttribute('checked');
    }
    
    
    //*************************************************************************
    // Style
    //*************************************************************************       
    function setStyle($name, $value) {
        //echo "<br/>Set style $name = $value";
        if($this->hasAttribute('style')) {
            //echo "<br/>Has attribute 'style'";
            $style = $this->getAttribute('style');
            if(preg_match("/".$name.":[\.|\s]*[^;]*/i", $style)) {
                $style = preg_replace(
                    "/".$name.":[\.|\s]*[^;]*/i", 
                    $name.": " . $value,
                    $style
                );
            } else {
                $style .= $name . ": " . $value . ";";
            }
        } else {
            //echo "<br/>no attribute 'style'";
            $style = $name . ": " . $value . ";";
        }
        $this->setAttribute('style', $style);
    }

    
}

//*****************************************************************************
// ATTRIBUTES
//*****************************************************************************
class ViewAttribute
    extends DOMAttr
{

}

//*****************************************************************************
// TEXT
//*****************************************************************************
class ViewText
    extends DOMText
{

}
