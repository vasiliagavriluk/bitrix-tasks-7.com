# Материалы и задание на 7 неделю

Написать свой модуль на основе "phpdevorg.cprop"  

Модуль должен добавлять для элементов инфоблока комплексное свойство

![img.png](img.png)

Одним из типов комплексного свойства должен быть HTML редактор, как в модуле d2mg.ufhtml  

        showHTMLEdit($code, $title, $arValue, $strHTMLControlName)


(Дополнительно, сложно) Добавить комплексное свойство для пользовательских полей  

        init.php - проверка и обработчик на событие OnUserTypeBuildList

        IBlockPropertyPhpDev::GetUserTypeDescription - добавлены доп свойства (USER_TYPE_ID, CLASS_NAME, BASE_TYPE), а так же функция GetDBColumnType()

![Alt text](img_1.png)