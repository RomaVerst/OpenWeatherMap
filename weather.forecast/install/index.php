<?php

use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Config as Conf;
use \Bitrix\Main\Config\Option;
use \Bitrix\Main\Loader;
use \Bitrix\Main\Entity\Base;
use \Bitrix\Main\Application;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\EventManager;
use Bitrix\Main\IO\Directory;


use \Bitrix\Main\Data;
use \Bitrix\Main\Diag;
use \Bitrix\Main\IO;

Loc::loadMessages(__FILE__);

class weather_forecast extends CModule
{
    var $MODULE_ID = "weather.forecast";
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $PARTNER_NAME;
    var $PARTNER_URI;


    public function __construct()
    {

        $arModuleVersion = array();
        include(__DIR__ . '/version.php');
        $this->MODULE_VERSION = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];

        $this->MODULE_NAME = Loc::getMessage("WEATHER_FORECAST_NAME");
        $this->MODULE_DESCRIPTION = Loc::getMessage("WEATHER_FORECAST_DESCRIPTION");
        $this->PARTNER_NAME = Loc::getMessage("WEATHER_FORECAST_PARTNER_NAME");
        $this->PARTNER_URI = Loc::getMessage("WEATHER_FORECAST_PARTNER_URI");
    }


    public function DoInstall()
    {

        global $APPLICATION;

        if (CheckVersion(ModuleManager::getVersion("main"), "14.00.00")) {
            $this->InstallDB();
            ModuleManager::registerModule($this->MODULE_ID);
            $this->InstallFiles();
            $this->InstallEvents();
        } else {
            $APPLICATION->ThrowException(
                Loc::getMessage("WEATHER_FORECAST_INSTALL_ERROR_VERSION")
            );
        }

        return true;
    }


    public function DoUninstall()
    {
        $this->UnInstallEvents();
        $this->unInstallFiles();
        ModuleManager::unRegisterModule($this->MODULE_ID);
        $this->UnInstallDB();
    }


    public function InstallFiles()
    {
        CopyDirFiles(
            $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . $this->MODULE_ID . '/install/components',
            $_SERVER['DOCUMENT_ROOT'] . '/bitrix/components',
            true,
            true
        );
        CopyDirFiles(
            $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . $this->MODULE_ID . '/install/themes',
            $_SERVER['DOCUMENT_ROOT'] . '/bitrix/themes',
            true,
            true
        );
        CopyDirFiles(
            $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . $this->MODULE_ID . '/install/admin',
            getenv('DOCUMENT_ROOT') . '/bitrix/admin',
            true,
            true
        );

        return true;
    }

    public function InstallDB()
    {
        return true;
    }

    public function InstallEvents()
    {
        return true;
    }


    public function UnInstallFiles()
    {
        DeleteDirFilesEx( '/bitrix/components/weather.forecast/weather.widget' );
        DeleteDirFiles(
            getenv('DOCUMENT_ROOT') . '/bitrix/modules/' . $this->MODULE_ID . '/install/themes',
            getenv('DOCUMENT_ROOT') . '/bitrix/themes'
        );
        DeleteDirFiles(
            getenv('DOCUMENT_ROOT') . '/bitrix/modules/' . $this->MODULE_ID . '/install/admin',
            getenv('DOCUMENT_ROOT') . '/bitrix/admin'
        );
        return true;
    }

    public function UnInstallDB()
    {
        return true;
    }

    public function UnInstallEvents()
    {
        return true;
    }
}


