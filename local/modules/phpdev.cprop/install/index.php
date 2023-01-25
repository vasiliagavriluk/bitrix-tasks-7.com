<?php
use \Bitrix\Main\Localization\Loc,
    \Bitrix\Main\EventManager,
    \Bitrix\Main\ModuleManager;

Loc::loadMessages(__FILE__);

Class phpdev_cprop extends CModule
{
    var $MODULE_ID = "phpdev.cprop";
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;

    function __construct()
    {
        $arModuleVersion = array();
        include __DIR__ . '/version.php';

        $this->MODULE_VERSION = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];

        $this->MODULE_NAME = Loc::getMessage('CPROP_MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('CPROP_MODULE_DESC');

        $this->PARTNER_NAME = Loc::getMessage('CPROP_PARTNER_NAME');
        $this->PARTNER_URI = Loc::getMessage('CPROP_PARTNER_URL');

    }

    function isVersionD7()
    {
        return true;
    }

    function DoInstall()
    {
        global $APPLICATION;
        if($this->isVersionD7())
        {
            $this->InstallDB();
            $this->InstallEvents();
            $this->InstallFiles();

            ModuleManager::registerModule($this->MODULE_ID);

            $APPLICATION->ThrowException("Инсталляция модуля '".$this->MODULE_NAME."' прошла успешно");
        }
        else
        {
            $APPLICATION->ThrowException(Loc::getMessage('CPROP_INSTALL_ERROR_VERSION'));
        }
    }

    function DoUninstall()
    {
        global $APPLICATION;

        ModuleManager::unRegisterModule($this->MODULE_ID);

        $this->UnInstallFiles();
        $this->UnInstallEvents();
        $this->UnInstallDB();

        $APPLICATION->ThrowException("Деинсталляция модуля '".$this->MODULE_NAME."' прошла успешно");
    }

    function InstallDB()
    {
        return true;
    }

    function UnInstallDB()
    {
        return true;
    }

    function installFiles()
    {
        return true;
    }

    function uninstallFiles()
    {
        return true;
    }

    function getEvents()
    {
        return [
            ['FROM_MODULE' => 'iblock', 'EVENT' => 'OnIBlockPropertyBuildList', 'TO_METHOD' => 'GetUserTypeDescription'],
        ];
    }

    /**
     * Регистрируем ИнфоБлок->Свойства->Тип
     * свой Тип - "Комплексное свойство"
     * @return bool
     */
    function InstallEvents()
    {
        $classHandler = 'IBlockPropertyPhpDev'; //подключаем наш созданный класс
        $eventManager = EventManager::getInstance();

        $arEvents = $this->getEvents();
        foreach($arEvents as $arEvent){
            $eventManager->registerEventHandler(
                $arEvent['FROM_MODULE'],
                $arEvent['EVENT'],
                $this->MODULE_ID,
                $classHandler,
                $arEvent['TO_METHOD']
            );
        }

        return true;
    }

    function UnInstallEvents()
    {
        $classHandler = 'IBlockPropertyPhpDev';
        $eventManager = EventManager::getInstance();

        $arEvents = $this->getEvents();
        foreach($arEvents as $arEvent){
            $eventManager->unregisterEventHandler(
                $arEvent['FROM_MODULE'],
                $arEvent['EVENT'],
                $this->MODULE_ID,
                $classHandler,
                $arEvent['TO_METHOD']
            );
        }

        return true;
    }
}