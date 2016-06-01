<?php

class Localization
{
    private static $segment; //первый сегмент урла
    private static $locales; //возможные языки
    private static $fallback_locale; //язык по умолчанию
    
    /**
     * Получаем исходные данные, устанавливаем локаль для системы
     */
    public static function init()
    {
        self::$segment = Request::segment(1);
        self::$locales = Config::get('app.locales');
        self::$fallback_locale = Config::get('app.fallback_locale');
        
        //устанавливаем текущую локаль для системы
        App::setLocale(self::getLocale());
    }
    
    /**
     * Проверяет есть ли переданная локаль, если нет возвращает дефолтную
     * @param $locale
     * @return mixed
     */
    public static function checkLocale($locale)
    {
        return array_key_exists($locale, self::$locales) ? $locale : self::$fallback_locale;
    }
    
    /**
     * Возвращает текущий язык
     * @return mixed
     */
    public static function getLocale()
    {
        return self::checkLocale(self::$segment);
    }
    
    /**
     * Возвращает перфикс для языка, если ничего не переданно или не существует вернет язык по умолчанию
     * @return mixed|string
     */
    public static function getUrlPrefix($locale = null)
    {
        if (is_null($locale))
        {
            $locale = self::getLocale();
        }
        $locale = self::checkLocale($locale);
        return ($locale == self::$fallback_locale) ? '' : $locale;
    }
    
    /**
     * Преобразуем урл для нужной локали
     * @param $locale
     * @param string $url
     */
    public static function getUrlFor($locale, $url = '/')
    {
        $url_info = parse_url($url);
        $path = trim($url_info['path'], '/');
        $query = isset($url_info['query']) ? $url_info['query'] : '';
        $segments = explode('/', $path);
        $first_segment = isset($segments[0]) ? $segments[0] : ''; 

        //ищем совпадения первого сегментна в доступных языках, если есть выпиливаем
        foreach (self::$locales as $key => $val)
        {
            if ($key == $first_segment)
            {
                unset($segments[0]);
                break;
            }
        }
    
        $prefix = self::getUrlPrefix($locale);
        
        if ($prefix)
        {
            array_unshift($segments, $prefix);
        }
        
        $new_url = implode('/', $segments);
        
        if ($query)
        {
            $new_url .= '?'.$query;
        }
        
        return URL::to($new_url);
    }
}
