<?php

namespace Weather\Forecast;

use \Bitrix\Main\Config\Option,
    \Bitrix\Main\Web\HttpClient,
    \Bitrix\Main\Localization\Loc;

abstract class WeatherBaseProvider
{
    protected string $apiKey;
    protected object $httpClient;

    public function __construct()
    {
        try {
            $this->apiKey = Option::get('weather.forecast', 'api_key', '');
            if (empty($this->apiKey)) {
                throw new \Exception(Loc::getMessage('WEATHER_FORECAST_BASE_PROVIDER_EMPTY_API_KEY'));
            }
            $this->httpClient = new HttpClient();
        } catch (\Throwable $e) {
            die($e->getMessage());
        }
    }

    abstract public function getCurrentWeather();
}
