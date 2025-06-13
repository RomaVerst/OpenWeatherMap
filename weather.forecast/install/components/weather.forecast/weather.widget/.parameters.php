<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use \Bitrix\Main\Localization\Loc,
    \Bitrix\Main\Loader;

$arComponentParameters = [
    "PARAMETERS" => [
        "API_KEY" => [
            "PARENT" => "BASE",
            "NAME" => Loc::getMessage("WEATHER_WIDGET_PARAMETERS_API_KEY"),
            "TYPE" => "STRING",
            "DEFAULT" => "",
        ],
        "CITY" => [
            "PARENT" => "BASE",
            "NAME" => Loc::getMessage("WEATHER_WIDGET_PARAMETERS_CITY"),
            "TYPE" => "STRING",
            "DEFAULT" => "Moscow",
        ],
        "UNITS" => [
            "PARENT" => "BASE",
            "NAME" => Loc::getMessage("WEATHER_WIDGET_PARAMETERS_UNITS"),
            "TYPE" => "LIST",
            "VALUES" => [
                'metric' => 'ºС',
                'imperial' => 'ºF',
            ],
            "DEFAULT" => 'metric',
        ],
        "CACHE_TIME" => ["DEFAULT" => 1800],
    ],
];