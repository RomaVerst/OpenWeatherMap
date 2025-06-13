<?php

namespace Weather\Forecast;

use Weather\Forecast\WeatherBaseProvider,
    \Bitrix\Main\Localization\Loc;

class OpenWeatherMap extends WeatherBaseProvider
{
    const
        GET_WEATHER_URL = 'https://api.openweathermap.org/data/2.5/weather?q=#CITY_NAME#&appid=#API_KEY#';

    /**
     * Текущая погода в выбранном городе
     * @param string $city
     * @param array $options опции exclude, units
     * @return array
     */
    public function getCurrentWeather(string $city = 'Moscow', array $options = []): array
    {
        $url = str_replace(
            ['#CITY_NAME#', '#API_KEY#'],
            [$city, $this->apiKey],
            self::GET_WEATHER_URL
        );

        if (!empty($options)) {
            foreach ($options as $param => $value) {
                $url .= "&$param=$value";
            }
        }

        return json_decode($this->httpClient->get($url), true);
    }
}