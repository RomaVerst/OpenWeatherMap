<?php

namespace Weather\Forecast;

use Weather\Forecast\WeatherBaseProvider,
    \Bitrix\Main\Localization\Loc,
    \Bitrix\Main\Data\Cache;

class OpenWeatherMap extends WeatherBaseProvider
{
    const
        GET_WEATHER_URL = 'https://api.openweathermap.org/data/2.5/weather?q=#CITY_NAME#&appid=#API_KEY#',
        CACHE_TIME = 1800;

    /**
     * Текущая погода в выбранном городе
     * @param string $city
     * @param array $options опции exclude, units
     * @return array
     */
    public function getCurrentWeather(string $city = 'Moscow', array $options = []): array
    {
        $cache = Cache::createInstance();
        if ($cache->initCache(self::CACHE_TIME, "openWeatherMapCache")) {
            $result = $cache->getVars(); // достаем переменные из кеша
        } elseif ($cache->startDataCache()) { // нет кеша, записываем
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
            $result = json_decode($this->httpClient->get($url), true);
            $cache->endDataCache($result);
        }

        return $result;
    }
}