<?php
/**
 * Created by PhpStorm.
 * User: naffiq
 * Date: 10/18/2016
 * Time: 9:31 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ShortUrl
 *
 * This model manages stored URLs and generates short codes for them
 *
 * @package app
 *
 * @property $id int
 * @property $original_url string
 * @property $short_url string
 * @property $hits int
 * @property $created_at string
 * @property $updated_at string
 */
class ShortUrl extends Model
{
    protected $fillable = ['original_url', 'short_url', 'hits'];

    /**
     * Creates short url record and returns short URL code,
     * or returns false, if `$url` is not a reachable URL
     *
     * @param $url
     * @return bool|ShortUrl
     */
    public static function shortened($url)
    {
        if (static::checkUrl($url)) {
            $shortUrl = static::where('original_url', $url)->first();

            if (empty($shortUrl)) {
                $shortUrl = static::create([
                    'original_url' => $url,
                    'short_url' => static::generateUniqueCode(),
                    'hits' => 0,
                ]);
            }


            return $shortUrl->short_url;
        }

        return false;
    }

    /**
     * Checks, if `$url` can be reached
     *
     * @param $url
     * @return bool
     */
    private static function checkUrl($url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL) !== false) {
            // TODO: check if URL gives 200 response code
            return true;
        }

        return false;
    }

    /**
     * Returns ShortUrl for $code
     *
     * @param $code
     * @return ShortUrl
     */
    public static function checkCode($code)
    {
        return static::where('short_url', $code)
            ->first();
    }

    /**
     * Returns original URL by code or false, if `$code` is not found
     *
     * @param $code
     * @return bool|string
     */
    public static function getOriginalUrl($code)
    {
        $url = static::checkCode($code);
        if (!empty($url)) {
            $url->hits++;
            $url->save();

            return $url->original_url;
        }

        return false;
    }

    /**
     * Generates unique short code for URLs
     *
     * @return string
     */
    private static function generateUniqueCode()
    {
        do {
            $code = str_random(7);
        } while (static::checkCode($code));

        return $code;
    }
}