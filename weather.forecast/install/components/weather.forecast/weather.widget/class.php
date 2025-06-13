<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use \Bitrix\Main\Config\Option,
    \Bitrix\Main\SystemException,
    \Bitrix\Main\Localization\Loc,
    \Bitrix\Main\Loader,
    Weather\Forecast\OpenWeatherMap;

class WeatherWidgetClass extends \CBitrixComponent
{
    public function __construct($component = null)
    {
        parent::__construct($component);

        Loc::loadMessages(__FILE__);

        // Подключаем модуль weather.forecast, если он не установлен - выбрасываем ошибку
        try {
            if (!Loader::includeModule('weather.forecast')) {
                throw new SystemException(Loc::getMessage('WEATHER_WIDGET_MODULE_NOT_FOUND'));
            }
        } catch (SystemException $e) {
            ShowError($e->getMessage());
            die();
        }
    }

    /**
     * @return void
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     */
    public function executeComponent()
    {
        if ($this->startResultCache()) {

            // Ключ API решил записывать через Option
            // на случай его переезда в конфиг модуля

            Option::set('weather.forecast', 'api_key', $this->arParams['API_KEY']);

            $weatherProvider = new OpenWeatherMap();

            $currentWeather = $weatherProvider->getCurrentWeather(
                $this->arParams['CITY'],
                ['units' => $this->arParams['UNITS']]
            );
            if (!empty($currentWeather['main'])) {
                $this->arResult = [
                    'TEMP' => round($currentWeather['main']['temp']),
                    'HUMIDITY' => $currentWeather['main']['humidity'],
                    'PRESSURE' => round($currentWeather['main']['pressure'] * 0.75),
                ];
            }
            unset($currentWeather);
            $this->includeComponentTemplate();
        }
    }

    /**
     * Подготовка параметров компонента
     * @param $arParams
     * @return array
     */
    public function onPrepareComponentParams($arParams)
    {
        $arParams['API_KEY'] = isset($arParams['API_KEY'])
            ? htmlspecialchars(trim($arParams['API_KEY']))
            : '';
        $arParams['CITY'] = isset($arParams['CITY'])
            ? htmlspecialchars(trim($arParams['CITY']))
            : 'Moscow';
        $arParams['UNITS'] = $arParams['UNITS'] ?? 'metric';
        return parent::onPrepareComponentParams($arParams);
    }
}