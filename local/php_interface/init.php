<?php
//AddMessage2Log();
define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"]."/log.txt");

// подключаем модуль phpdev.cprop
if (CModule::IncludeModule("phpdev.cprop"))
{
    //Вешаем обработчик на событие создания списка пользовательских свойств OnUserTypeBuildList
    AddEventHandler('main', 'OnUserTypeBuildList',
        array('IBlockPropertyPhpDev', 'GetUserTypeDescription'), 5000);
}

