<?php

/**
* 2010-2023 Webkul.
*
* NOTICE OF LICENSE
*
* All right is reserved,
* Please go through this link for complete license : https://store.webkul.com/license.html
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade this module to newer
* versions in the future. If you wish to customize this module for your
* needs please refer to https://store.webkul.com/customisation-guidelines/ for more information.
*
*  @author    Webkul IN <support@webkul.com>
*  @copyright 2010-2023 Webkul IN
*  @license   https://store.webkul.com/license.html
*/

namespace QloApps\Module\AutoUpgrade;


class Module
{

    private $db;

    private $modulesPath;

    private $upgradeFiles;

    private $name;

    public function __construct($db, $modulesPath)
    {
        $this->modulesPath = $modulesPath;
        $this->db = $db;
    }

    public function runUpgradeModule($name)
    {
        $this->upgradeFiles = array();

        $this->name = $name;
        include_once($this->modulesPath.$this->name.'/'.$this->name.'.php');
        $ret = true;
        if ($moduleInfo = $this->getModuleInstalledInformation($this->name)) {
            if ($module = \Adapter_ServiceLocator::get($this->name)) {
                if (version_compare($module->version, $moduleInfo['version'], '>')) {

                    $this->upgradeFiles = $this->loadUpgradeVersionList($this->name, $module->version, $moduleInfo['version']);
                    if (count($this->upgradeFiles)) {
                        $ret &= $this->upgradeModule($module);
                    }
                    if ($ret) {
                        $ret &= $this->upgradeModuleVersion($module->version);
                    }
                }
            }
        }

        unset($this->name);
        unset($this->upgradeFiles);

        return $ret;
    }

    public function upgradeModule($module)
    {
        $upgradeVersion = 0;
        if (count($this->upgradeFiles)) {
            foreach ($this->upgradeFiles as $num => $file_detail) {
                foreach ($file_detail['upgrade_function'] as $item) {
                    if (function_exists($item)) {
                        $this->upgradeFiles['success'] = false;
                        $this->upgradeFiles['duplicate'] = true;
                        break 2;
                    }
                }

                include($file_detail['file']);

                // Call the upgrade function if defined
                $this->upgradeFiles['success'] = false;
                foreach ($file_detail['upgrade_function'] as $item) {
                    if (function_exists($item)) {
                        $this->upgradeFiles['success'] = $item($module);
                    }
                }

                // Set detail when an upgrade succeed or failed
                if ($this->upgradeFiles['success']) {
                    // $this->upgradeFiles['number_upgraded'] += 1;
                    $upgradeVersion = $file_detail['version'];

                    unset($this->upgradeFiles[$num]);
                } else {
                    $this->upgradeFiles['version_fail'] = $file_detail['version'];

                    // If any errors, the module is disabled
                    $this->disable($module);
                    break;
                }
            }
        }
        if (isset($this->upgradeFiles['version_fail'])) {
            unset($this->upgradeFiles);
            return false;
        }

        unset($this->upgradeFiles);
        return true;
    }

    protected function loadUpgradeVersionList($module_name, $module_version, $registered_version)
    {
        $list = array();

        $upgrade_path = $this->modulesPath.$module_name.'/upgrade/';

        // Check if folder exist and it could be read
        if (file_exists($upgrade_path) && ($files = scandir($upgrade_path))) {
            // Read each file name
            foreach ($files as $file) {
                if (!in_array($file, array('.', '..', '.svn', 'index.php')) && preg_match('/\.php$/', $file)) {
                    $tab = explode('-', $file);

                    if (!isset($tab[1])) {
                        continue;
                    }

                    $file_version = basename($tab[1], '.php');
                    // Compare version, if minor than actual, we need to upgrade the module
                    if (count($tab) == 2 &&
                         (version_compare($file_version, $module_version, '<=') &&
                            version_compare($file_version, $registered_version, '>'))) {
                        $list[] = array(
                            'file' => $upgrade_path.$file,
                            'version' => $file_version,
                            'upgrade_function' => array(
                                'upgrade_module_'.str_replace('.', '_', $file_version),
                                'upgradeModule'.str_replace('.', '', $file_version))
                            );
                    }
                }
            }
        }

        usort($list, 'ps_module_version_sort');

        return $list;
    }

    protected function getModuleInstalledInformation($name)
    {
        return $this->db->getRow('SELECT `id_module`, `version` FROM `' . _DB_PREFIX_ . 'module` WHERE `name` = "'.$name.'"');
    }

    /**
     * Upgrade the registered version to a new one
     *
     * @param $name
     * @param $version
     * @return bool
     */
    protected function upgradeModuleVersion($version)
    {
        return $this->db->execute('
			UPDATE `'._DB_PREFIX_.'module` m
			SET m.version = \''.pSQL($version).'\'
			WHERE m.name = \''.pSQL($this->name).'\'');
    }

    protected function disable($module)
    {
        // Disable module for all shops
        $sql = 'DELETE FROM `'._DB_PREFIX_.'module_shop` WHERE `id_module` = '.(int)$module->id;
        $this->db->execute($sql);
    }

}
