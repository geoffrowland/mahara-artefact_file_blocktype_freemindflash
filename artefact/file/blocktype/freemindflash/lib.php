<?php
/**
 * Mahara: Electronic portfolio, weblog, resume builder and social networking
 * Copyright (C) 2006-2009 Catalyst IT Ltd and others; see:
 *                         http://wiki.mahara.org/Contributors
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package mahara
 * @subpackage blocktype-freemindflash
 * @author James Kerrigan
 * @author Geoffrey Rowland
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL
 * @copyright (C) 2011 James Kerrigan and Geoffrey Rowland geoff.rowland@yeovil.ac.uk
 */

defined('INTERNAL') || die();

class PluginBlocktypeFreeMindFlash extends PluginBlocktype {

    public static function get_title() {
        return get_string('title', 'blocktype.file/freemindflash');
    }

    public static function get_description() {
        return get_string('description', 'blocktype.file/freemindflash');
    }

    public static function get_categories() {
        return array('fileimagevideo');
    }

    public static function render_instance(BlockInstance $instance, $editing=false) {

        $configdata = $instance->get('configdata'); // this will make sure to unserialize it for us
        $configdata['viewid'] = $instance->get('view');
              
        if (empty($configdata['artefactid'])) {
            return '';
        }
 
        $result = '';
            $artefact = $instance->get_artefact_instance($configdata['artefactid']);
            static $count = 0;
            $count++;
            $id = time().$count;
            $url = get_config('wwwroot') . 'artefact/file/download.php?file='. $artefact->get('id') . '&view=' . $instance->get('view').'&e=.mm';
            $base = get_config('wwwroot') . 'artefact/file/download.php?file='. $artefact->get('id') . '&view=' . $instance->get('view').'/';
            $width  = (!empty($configdata['width'])) ? hsc($configdata['width']) : '450';
            $height  = (!empty($configdata['height'])) ? hsc($configdata['height']) : '300';
            $node  = (!empty($configdata['node'])) ? hsc($configdata['node']) : '-1';
            $result .= '<script type="text/javascript" src="'.get_config('wwwroot').'artefact/file/blocktype/freemindflash/flash/flashobject.js"></script>'; 
            $result .= '<div class="freemindflash-container center">';
  	         $result .= '<a href="' . $url . '">' . hsc($artefact->get('title')) . '</a><br>';
  	         $result .= '<div id="flashcontent'.$id.'">';
  	         $result .= 'No Flash';
  	         $result .= '</div>';
  	         $result .= '<script type="text/javascript">';
	      	$result .= 'var fo = new FlashObject("'.get_config('wwwroot').'artefact/file/blocktype/freemindflash/flash/visorFreeplane.swf", "visorFreeplane", "'.$width.'", "'.$height.'", 8);';
            // All these variables can be added in the script.
            // None of them are needed, they all have default values.
	         $result .= 'fo.addParam("quality", "high");';
	         // If we want to initiate the mindmap with all the nodes collapsed from this level
	         // default = "-1" that means, do nothing
	      	$result .= 'fo.addVariable("startCollapsedToLevel","'.$node.'");';
            // Map background color
            // default=last chosen by user or white	         
	         $result .= 'fo.addVariable("bgcolor", 0xffffff);';
            // Initial mindmap to load
      		$result .= 'fo.addVariable("initLoadFile", "'.$url.'");';
            // Where to open a link: 
            // default="_self"
	      	$result .= 'fo.addVariable("openUrl", "_blank");';
	      	$result .= 'fo.write("flashcontent'.$id.'");';
            $result .= '</script>';
  	         $result .= '</div>';	        
        return $result;
    }
    
    public static function has_instance_config() {
        return true;
    }

    public static function instance_config_form($instance) {
        $configdata = $instance->get('configdata');
        safe_require('artefact', 'file');
        $instance->set('artefactplugin', 'file');
        return array(
            'artefactid' => self::filebrowser_element($instance, (isset($configdata['artefactid'])) ? array($configdata['artefactid']) : null),
            'width' => array(
                'type' => 'text',
                'title' => get_string('width', 'blocktype.file/freemindflash'),
                'size' => 4,
                'description' => get_string('widthdescription', 'blocktype.file/freemindflash'),
                'defaultvalue' => (isset($configdata['width'])) ? $configdata['width'] : '',
            ),
           'height' => array(
                'type' => 'text',
                'title' => get_string('height', 'blocktype.file/freemindflash'),
                'size' => 4,
                'description' => get_string('heightdescription', 'blocktype.file/freemindflash'),
                'defaultvalue' => (isset($configdata['height'])) ? $configdata['height'] : '',
            ),
           'node' => array(
                'type' => 'text',
                'title' => get_string('node', 'blocktype.file/freemindflash'),
                'size' => 2,
                'description' => get_string('nodedescription', 'blocktype.file/freemindflash'),
                'defaultvalue' => (isset($configdata['node'])) ? $configdata['node'] : '',
            ),            
        );
    }

    private static function get_allowed_mimetypes() {
        static $mimetypes = array();
        if (!$mimetypes) {
            $mimetypes = get_column('artefact_file_mime_types', 'mimetype', 'description', 'mm');
        }
        return $mimetypes;
    }

    public static function filebrowser_element(&$instance, $default=array()) {
        $element = ArtefactTypeFileBase::blockconfig_filebrowser_element($instance, $default);
        $element['title'] = get_string('file', 'artefact.file');
        $element['name'] = 'artefactid';
        $element['config']['selectone'] = true;
        $element['filters'] = array(
            'artefacttype'    => array('file'),
            'filetype'        => self::get_allowed_mimetypes(),
        );
        return $element;
    }

    public static function artefactchooser_element($default=null) {
        return array(
            'name'  => 'artefactid',
            'type'  => 'artefactchooser',
            'title' => get_string('file', 'artefact.file'),
            'defaultvalue' => $default,
            'blocktype' => 'freemindflash',
            'limit' => 10,
            'artefacttypes' => array('file'),
            'template' => 'artefact:file:artefactchooser-element.tpl',
        );
    }

    public static function default_copy_type() {
        return 'full';
    }
    
 }

?>