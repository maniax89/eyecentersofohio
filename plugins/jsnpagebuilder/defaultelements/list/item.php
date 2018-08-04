<?php
/**
 * @version    $Id$
 * @package    JSN_PageBuilder
 * @author     JoomlaShine Team <support@joomlashine.com>
 * @copyright  Copyright (C) 2012 JoomlaShine.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.joomlashine.com
 * Technical Support:  Feedback - http://www.joomlashine.com/contact-us/get-support.html
 */

// No direct access to this file.
defined('_JEXEC') || die('Restricted access');

/**
 * List Item shortcode element
 *
 * @package  JSN_PageBuilder
 * @since    1.0.0
 */
class JSNPBShortcodeListItem extends IG_Pb_Child {

	/**
	 * Constructor
	 *
	 * @return type
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Include admin scripts
	 * 
	 * @return type
	 */
	public function backend_element_assets() {
		JSNPagebuilderHelpersFunctions::print_asset_tag( JSNPB_ADMIN_URL . '/assets/joomlashine/js/jsn-iconselector.js', 'js' );
		JSNPagebuilderHelpersFunctions::print_asset_tag( JSNPB_FRAMEWORK_ASSETS . '/joomlashine/css/jsn-general.css', 'css' );
		JSNPagebuilderHelpersFunctions::print_asset_tag( JSNPB_FRAMEWORK_ASSETS . '/joomlashine/css/jsn-fonticomoon.css', 'css' );
        JSNPagebuilderHelpersFunctions::print_asset_tag(JSNPB_PLG_SYSTEM_ASSETS_URL . '3rd-party/font-awesome/css/font-awesome.min.css', 'css');
	}
	
	/**
	 * DEFINE configuration information of shortcode
	 * 
	 * @return type
	 */
	public function element_config() {
		$this->config['shortcode'] = 'pb_list_item';
		$this->config['exception'] = array(
			'data-modal-title' => JText::_( 'JSN_PAGEBUILDER_ELEMENT_MODAL_TITLE_PB_LIST_ITEM' )
		);
	}

    /**
     * DEFINE setting options of shortcode in backend
     */
    public function backend_element_items()
    {
        $this->frontend_element_items();
    }

    /**
     * DEFINE setting options of shortcode in frontend
     */
    public function frontend_element_items()
    {
		$this->items = array(
			'Notab' => array(
				array(
					'name'    => JText::_( 'JSN_PAGEBUILDER_DEFAULT_ELEMENT_HEADING' ),
					'id'      => 'heading',
					'type'    => 'text_field',
					'class'   => 'jsn-input-xxlarge-fluid',
					'role'    => 'title',
					'std'     => JText::_( 'JSN_PAGEBUILDER_ELEMENT_LIST_ITEM_HEADING_STD' ),
					'tooltip' => JText::_( 'JSN_PAGEBUILDER_DEFAULT_ELEMENT_HEADING_DES' )
				),
				array(
					'name'    => JText::_( 'JSN_PAGEBUILDER_DEFAULT_ELEMENT_BODY' ),
					'id'      => 'body',
					'role'    => 'content',
					'type'    => 'tiny_mce',
					'std'     => JSNPagebuilderHelpersType::loremText(),
					'tooltip' => JText::_( 'JSN_PAGEBUILDER_DEFAULT_ELEMENT_BODY_DES' )
				),
				array(
					'name'      => JText::_( 'JSN_PAGEBUILDER_DEFAULT_ELEMENT_ICON' ),
					'id'        => 'icon',
					'type'      => 'icons',
					'std'       => '',
					'role'      => 'title_prepend',
					'role_type' => 'icon',
					'tooltip'   => JText::_( 'JSN_PAGEBUILDER_DEFAULT_ELEMENT_ICON_DES' )
				),
			)
		);
	}

	/**
	 * DEFINE shortcode content
	 *
	 * @param type $atts
	 * @param type $content
	 * 
	 * @return string
	 */
	public function element_shortcode( $atts = null, $content = null ) {
		extract( JSNPagebuilderHelpersShortcode::shortcodeAtts( $this->config['params'], $atts ) );
		$content = JSNPagebuilderHelpersFunctions::add_absolute_path_to_image_url($content);
		return "
		<li>
			[icon]<div class='pb-sub-icons' style='pb-styles'>
				<i class='$icon'></i>
			</div>[/icon]
			<div class='pb-list-content-wrap'>
				[heading]<h4 style='pb-list-title'>$heading</h4>[/heading]
				<div class='pb-list-content'>
					$content
				</div>
			</div>
		</li><!--seperate-->";
	}

}
