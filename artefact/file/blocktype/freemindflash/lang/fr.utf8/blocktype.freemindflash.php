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
 * @package    mahara
 * @subpackage blocktype-freemindflash
 * @author     James Kerrigan
 * @author     Geoffrey Rowland 
 * @author     Dominique-Alain JAN <djan@mac.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL
 * @copyright  (C) 2011 James Kerrigan and Geoffrey Rowland geoff.rowland@yeovil.ac.uk
 *
 * Includes code from the FreeMind Flash Browser visorFreemind.swf 1.0b
 * http://freemind.sourceforge.net/wiki/index.php/Flash_browser (GNU GPL licence)
 *
 * and expressInstall.swf and swfobject.js from SWFObject 2.2
 * http://code.google.com/p/swfobject/ (MIT licence)
 *
 */

defined('INTERNAL') || die();

$string['title'] = 'FreeMind Flash';
$string['description'] = 'Un fichier FreeMind (mm) de votre zone de dépôt.';
$string['showdescription'] = 'Afficher la description ?';
$string['width'] = 'Largeur';
$string['height'] = 'Hauteur';
$string['widthdescription'] = 'Spécifiez la largeur de la zone pour afficher votre carte (en pixels). Laissez la rubrique vide pour utiliser la valeur par défaut de 450 px.';
$string['heightdescription'] = 'Spécifiez la hauteur de la zone pour afficher votre carte (en pixels). Laissez la rubrique vide pour utiliser la valeur par défaut de 300 px.';