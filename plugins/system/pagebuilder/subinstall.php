<?php
/**
 * @version    $Id$
 * @package    JSN_PageBuilder
 * @author     JoomlaShine Team <support@joomlashine.com> giangth
 * @copyright  Copyright (C) 2012 JoomlaShine.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.joomlashine.com
 * Technical Support:  Feedback - http://www.joomlashine.com/contact-us/get-support.html
 */

defined('_JEXEC') or die('Restricted access');

class PlgSystemPagebuilderInstallerScript
{

    /**
     * Enable plugin after installation completed.
     *
     * @param   string $route Route type: install, update or uninstall.
     * @param   object $installer The installer object.
     *
     * @return bool
     * @throws \Exception
     */
    public function postflight($route, $installer)
    {
        $db = JFactory::getDbo();
        try
        {
            $query = $db->getQuery(true);
            $query->update('#__extensions');
            $query->set(array('ordering = 9999'));
            $query->where("element = 'pagebuilder'");
            $query->where("type = 'plugin'", 'AND');
            $query->where("folder = 'system'", 'AND');
            $db->setQuery($query);
            $db->execute();
        }
        catch (Exception $e)
        {
            throw $e;
        }
    }
}