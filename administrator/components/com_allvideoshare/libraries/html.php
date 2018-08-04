<?php
/*
 * @version		$Id: html.php 3.1 2017-06-30 $
 * @package		All Video Share
 * @copyright   Copyright (C) 2012-2017 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class AllVideoShareHtml {
	
	public static function RadioGroup( $name, $items, $selected = '', $script = '' ) {
	
		$html = '';
		
		foreach( $items as $value => $label ) {
			$checked = ( $value == $selected ) ? ' checked="checked"' : '';
			$html .= sprintf('<label class="radio inline"><input type="radio" name="%s" value="%s"%s%s>%s</label>', $name, $value, $script, $checked, $label );
		}
		
		return $html;
		
	}
	
	public static function RadioGroupPlayer() {
	
		$html = '';

		$html .= sprintf('<label class="radio inline"><input type="radio" name="type" value="allvideoshare" checked="checked">%s</label>', JText::_( 'FLASH' ) );
		$html .= sprintf('<label class="radio inline"><input type="radio" name="type" value="allvideoshare" disabled="disabled">%s <span style="color: red;">(PRO Only)</span></label>', JText::_( 'HTML5' ) );

		return $html;
		
	}
	
	public static function ListItems( $name, $items, $selected = '', $script = '' ) {
	
		$options = array();
		
		foreach( $items as $key => $value ) {
			$options[] = JHTML::_( 'select.option', $key, $value );
		}
		
		return JHTML::_( 'select.genericlist', $options, $name, $script, 'value', 'text', $selected );
				
	}
	
	public static function ListTypes( $name, $items, $selected = '', $script = '' ) {
	
		$options = array();
		
		foreach( $items as $key => $value ) {
			$options[] = JHTML::_( 'select.option', $key, $value );
		}
		
		$options[] = JHTML::_( 'select.optgroup', ' -- PRO Only --' );
		$options[] = JHTML::_( 'select.option', 'pro_only', JText::_( 'YOUTUBE' ) );
		$options[] = JHTML::_( 'select.option', 'pro_only', JText::_( 'VIMEO' ) );
		$options[] = JHTML::_( 'select.option', 'pro_only', JText::_( 'HLS' ) );
		$options[] = JHTML::_( 'select.option', 'pro_only', JText::_( 'THIRD_PARTY_EMBEDCODE' ) );
		
		return JHTML::_( 'select.genericlist', $options, $name, $script, 'value', 'text', $selected );
				
	}
	
	public static function ListBoolean( $name, $selected = 1, $disabled = 0 ) {	
		
		$options[] = JHTML::_( 'select.option', 1, JText::_( 'ALL_VIDEO_SHARE_YES' ) );
		if( ! $disabled ) $options[] = JHTML::_( 'select.option', 0, JText::_('ALL_VIDEO_SHARE_NO' ) );
		
		return JHTML::_( 'select.genericlist', $options, $name, '', 'value', 'text', $selected );		
		
	}
	
	public static function Editor( $name = '', $value = '' ) {
		
		$params = array( 'mode'=> 'advanced' );
		return JFactory::getEditor()->display( $name, $value, '90%', '100%', '20', '20', 1, null, null, null, $params );

	}
	
	public static function ListCategories( $name = 'category', $selected = '', $script = '', $exclude_category = '' ) {

		if( 'parent' == $name ) {		
			$options[] = JHTML::_( 'select.option', 0, '-- '.JText::_( 'ROOT' ).' --' );
			if( '' == $selected ) $selected = 0;
		} else {
			$options[] = JHTML::_( 'select.option', '', '-- '.JText::_( 'SELECT_A_CATEGORY' ).' --' );
		}
		
		if( ! empty( $exclude_category ) ) {
			$items = AllVideoShareUtils::getCategories( $exclude_category );
		} else {
			$items = AllVideoShareUtils::getCategories();
		}
		
		foreach( $items as $item ) {
			$item->treename = JString::str_ireplace( '&#160;', '-', $item->treename );
			$value = ( 'category' == $name || 'filter_category' == $name ) ? $item->name : $item->id;
			
			$options[] = JHTML::_( 'select.option', $value, $item->treename );
		}
		
		return JHTML::_( 'select.genericlist', $options, $name, $script, 'value', 'text', $selected );

	}
	
	public static function ListPlayers( $name = 'playerid', $selected = '', $script = '' ) {
	
		$db = JFactory::getDBO();
		 
        $query = "SELECT id, name FROM #__allvideoshare_players WHERE published=1";
        $db->setQuery( $query );
        $items = $db->loadObjectList();
		 
		$options = array();
		
		foreach( $items as $item ) {
			$options[] = JHTML::_( 'select.option', $item->id, $item->name );
		}
		
		return JHTML::_( 'select.genericlist', $options, $name, $script, 'value', 'text', $selected );
				
	}
	
	public static function ListUsers( $name = 'user', $selected = '', $script = '' ) {
	
		$db = JFactory::getDBO();
		
		$query = 'SELECT id, username FROM #__users';
		$db->setQuery( $query );
		$items = $db->loadObjectList();

		$options = array();
		
		foreach( $items as $item ) {
			$options[] = JHTML::_( 'select.option', $item->username, $item->username );
		}
		
		return JHTML::_( 'select.genericlist', $options, $name, $script, 'value', 'text', $selected );
				
	}
		
}