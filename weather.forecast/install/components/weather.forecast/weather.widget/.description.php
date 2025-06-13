<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

$arComponentDescription = [
    "NAME" => Loc::getMessage('WEATHER_WIDGET_NAME'),
    "SORT" => 100,
    "CACHE_PATH" => "Y",
    "PATH" => [
        "ID" => "weather_forecast_widget",
        "NAME" => Loc::getMessage("WEATHER_FORECAST_FOLDER_NAME"),
    ],
];
