<?php

class Xhgui_Util
{
    const KEY_DELIMITER = '__';

    /**
     * Creates a simplified URL given a standard URL.
     * Does the following transformations:
     *
     * - Remove numeric values after =.
     *
     * @param string $url
     * @return string
     */
    public static function simpleUrl($url)
    {
        $callable = Xhgui_Config::read('profiler.simple_url');
        if (is_callable($callable)) {
            return call_user_func($callable, $url);
        }
        return preg_replace('/\=\d+/', '', $url);
    }

    public static function replaceDots(array $profile): array
    {
        $result = [];
        foreach ($profile as $key => $value) {
            $key = preg_replace('/\./', static::KEY_DELIMITER, $key);
            $result[$key] = $value;
        }

        return $result;
    }

    /**
     * Returns an new ObjectId-like string, where its first 8
     * characters encode the current unix timestamp and the
     * next 16 are random.
     *
     * @see http://php.net/manual/en/mongodb-bson-objectid.construct.php
     *
     * @return string
     */
    public static function generateId()
    {
        return dechex(time()) . bin2hex(random_bytes(8));
    }

}
