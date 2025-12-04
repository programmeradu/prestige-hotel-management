<?php

/*
 * 2007-2018 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author PrestaShop SA <contact@prestashop.com>
 *  @copyright  2007-2018 PrestaShop SA
 *  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

namespace QloApps\Module\AutoUpgrade\TaskRunner\Upgrade;

use QloApps\Module\AutoUpgrade\UpgradeException;
use QloApps\Module\AutoUpgrade\Parameters\UpgradeFileNames;
use QloApps\Module\AutoUpgrade\TaskRunner\AbstractTask;
use QloApps\Module\AutoUpgrade\UpgradeTools\FilesystemAdapter;
use QloApps\Module\AutoUpgrade\UpgradeContainer;

/**
 * Upgrade all partners modules according to the installed prestashop version.
 */
class UpgradeModules extends AbstractTask
{
    public function run()
    {
        $start_time = time();
        if (!$this->container->getFileConfigurationStorage()->exists(UpgradeFileNames::MODULES_TO_UPGRADE_LIST)) {
            return $this->warmUp();
        }

        $this->next = 'upgradeModules';
        $listModules = $this->container->getFileConfigurationStorage()->load(UpgradeFileNames::MODULES_TO_UPGRADE_LIST);
        if (!is_array($listModules)) {
            $this->next = 'upgradeComplete';
            $this->container->getState()->setWarningExists(true);
            $this->logger->error($this->translator->trans('listModules is not an array. No module has been updated.', array(), 'Modules.Autoupgrade.Admin'));
        }

        $time_elapsed = time() - $start_time;
        // module list
        if (count($listModules) > 0) {
            do {
                $module_info = array_shift($listModules);
                try {
                    $this->logger->debug($this->translator->trans('Upgrading module %module%...', ['%module%' => $module_info['name']], 'Modules.Autoupgrade.Admin'));
                    if ($this->container->getModuleAdapter()->upgradeModule($module_info['id'], $module_info['name'])) {
                        $this->logger->debug($this->translator->trans('The files of module %s have been upgraded.', array($module_info['name']), 'Modules.Autoupgrade.Admin'));
                    } else {
                        $this->logger->error($this->translator->trans('There was an error while upgrading module %s, module has been disabled for now.', array($module_info['name']), 'Modules.Autoupgrade.Admin'));
                    }
                } catch (UpgradeException $e) {
                    $this->handleException($e);
                    if ($e->getSeverity() === UpgradeException::SEVERITY_ERROR) {
                        return false;
                    }
                }
                $time_elapsed = time() - $start_time;
            } while (($time_elapsed < $this->container->getUpgradeConfiguration()->getTimePerCall()) && count($listModules) > 0);

            $modules_left = count($listModules);
            $this->container->getFileConfigurationStorage()->save($listModules, UpgradeFileNames::MODULES_TO_UPGRADE_LIST);
            unset($listModules);

            $this->next = 'upgradeModules';
            if ($modules_left) {
                $this->logger->info($this->translator->trans('%s modules left to upgrade.', array($modules_left), 'Modules.Autoupgrade.Admin'));
            }
            $this->stepDone = false;
        } else {
            if (!$this->container->getFileConfigurationStorage()->exists(UpgradeFileNames::MODULES_TO_INSTALL_LIST)) {
                $modulesToInstall = $this->container->getState()->getModulesToInstall();
                $this->container->getFileConfigurationStorage()->save(
                    $modulesToInstall,
                    UpgradeFileNames::MODULES_TO_INSTALL_LIST
                );
            }

            $modulesToInstall = $this->container->getFileConfigurationStorage()->load(UpgradeFileNames::MODULES_TO_INSTALL_LIST);

            if (count($modulesToInstall) > 0) {
                do {
                    $moduleName = array_shift($modulesToInstall);
                    try {
                        $this->logger->debug($this->translator->trans('Installing module %module%...', ['%module%' => $moduleName], 'Modules.Autoupgrade.Admin'));
                        $this->container->getModuleAdapter()->installModule($moduleName);
                        $this->logger->debug($this->translator->trans('The files of module %s have been insalled.', array($moduleName), 'Modules.Autoupgrade.Admin'));
                    } catch (UpgradeException $e) {
                        $this->handleException($e);
                        if ($e->getSeverity() === UpgradeException::SEVERITY_ERROR) {
                            return false;
                        }
                    }
                    break;
                    $time_elapsed = time() - $start_time;
                } while (($time_elapsed < $this->container->getUpgradeConfiguration()->getTimePerCall()) && count($modulesToInstall) > 0);

                $modules_left = count($modulesToInstall);
                $this->container->getFileConfigurationStorage()->save($modulesToInstall, UpgradeFileNames::MODULES_TO_INSTALL_LIST);
                unset($modulesToInstall);

                $this->next = 'upgradeModules';
                if ($modules_left) {
                    $this->logger->info($this->translator->trans('%s modules left to install.', array($modules_left), 'Modules.Autoupgrade.Admin'));
                }
                $this->stepDone = false;

            } else {
                if (!$this->container->getFileConfigurationStorage()->exists(UpgradeFileNames::MODULES_TO_DISABLE_LIST)) {
                    $modulesToDisable = $this->container->getState()->getModulesToDisable();
                    $this->container->getFileConfigurationStorage()->save(
                        $modulesToDisable,
                        UpgradeFileNames::MODULES_TO_DISABLE_LIST
                    );
                }

                $modulesToDisable = $this->container->getFileConfigurationStorage()->load(UpgradeFileNames::MODULES_TO_DISABLE_LIST);

                $time_elapsed = time() - $start_time;

                if (count($modulesToDisable) > 0) {
                    do {
                        $module = array_shift($modulesToDisable);
                        $this->container->getDb()->execute('DELETE ms.*
                        FROM `' . _DB_PREFIX_ . 'module_shop` ms
                        INNER JOIN `' . _DB_PREFIX_ . 'module` m USING (`id_module`)
                        WHERE m.`name` LIKE \'' . pSQL($module) . '\'');

                        $time_elapsed = time() - $start_time;

                    } while (($time_elapsed < $this->container->getUpgradeConfiguration()->getTimePerCall()) && count($modulesToDisable) > 0);

                    $this->container->getFileConfigurationStorage()->save(
                        $modulesToDisable,
                        UpgradeFileNames::MODULES_TO_DISABLE_LIST
                    );
                    unset($modulesToDisable);

                    $this->next = 'upgradeModules';
                    $this->stepDone = false;
                } else {
                    $this->stepDone = true;
                    $this->status = 'ok';
                    $this->next = 'cleanDatabase';
                    $this->logger->info($this->translator->trans('Addons modules files have been upgraded.', array(), 'Modules.Autoupgrade.Admin'));

                    return true;
                }
            }
        }

        return true;
    }

    public function warmUp()
    {
        try {
            $modulesToUpgrade = $this->container->getModuleAdapter()->listModulesToUpgrade($this->container->getState()->getModules_addons());
            $this->container->getFileConfigurationStorage()->save($modulesToUpgrade, UpgradeFileNames::MODULES_TO_UPGRADE_LIST);
        } catch (UpgradeException $e) {
            $this->handleException($e);

            return false;
        }

        $total_modules_to_upgrade = count($modulesToUpgrade);
        if ($total_modules_to_upgrade) {
            $this->logger->info($this->translator->trans('%s modules will be upgraded.', array($total_modules_to_upgrade), 'Modules.Autoupgrade.Admin'));
        }

        // WamUp core side
        // if (method_exists('\Module', 'getModulesOnDisk')) {
            // \Module::getModulesOnDisk();
        // }

        $this->stepDone = false;
        $this->next = 'upgradeModules';

        return true;
    }

    private function handleException(UpgradeException $e)
    {
        foreach ($e->getQuickInfos() as $log) {
            $this->logger->debug($log);
        }
        if ($e->getSeverity() === UpgradeException::SEVERITY_ERROR) {
            $this->next = 'error';
            $this->error = true;
            $this->logger->error($e->getMessage());
        }
        if ($e->getSeverity() === UpgradeException::SEVERITY_WARNING) {
            $this->logger->warning($e->getMessage());
        }
    }
}
