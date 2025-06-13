<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/** @var array $arParams */
/** @var array $arResult */

use Bitrix\Main\Localization\Loc;

$this->setFrameMode(true);

$tempUnits = '';
switch ($arParams['UNITS']) {
    case 'imperial':
        $tempUnits = 'ºF';
        break;
    case 'metric':
        $tempUnits = 'ºС';
        break;
}

if (!empty($arResult)): ?>
    <div class="card">
        <div class="card__characteristic">
            <span>🌡 <?= Loc::getMessage('WEATHER_WIDGET_TEMPLATE_DEF_TEMP') ?></span>
            <span><?= ($arResult['TEMP'] > 0 ? '+' : '') . $arResult['TEMP'] . $tempUnits ?></span>
        </div>
        <div class="card__characteristic">
            <span>💧 <?= Loc::getMessage('WEATHER_WIDGET_TEMPLATE_DEF_HUMIDITY') ?></span>
            <span><?= $arResult['HUMIDITY'] . '%' ?></span>
        </div>
        <div class="card__characteristic">
            <span>🌀 <?= Loc::getMessage('WEATHER_WIDGET_TEMPLATE_DEF_PRESSURE') ?></span>
            <span><?= $arResult['PRESSURE']
                . ' ' . Loc::getMessage('WEATHER_WIDGET_TEMPLATE_DEF_PRESSURE_UNITS') ?></span>
        </div>
    </div>
<?php
endif;
