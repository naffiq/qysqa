<?php
/**
 * Created by PhpStorm.
 * User: naffiq
 * Date: 10/18/2016
 * Time: 8:56 PM
 */

namespace App\Http\Controllers;


use App\ShortUrl;
use Illuminate\Http\Request;

class UrlShortenController extends Controller
{
    /**
     * Shortens given URLs
     *
     * @param Request $request
     *
     * @return mixed JSON string with request result
     */
    public function shorten(Request $request)
    {
        $url = $request->get('url');
        $shortUrl = ShortUrl::shortened($url);

        return response()->json(['result' => $shortUrl]);
    }

    /**
     * Redirects user to
     *
     * @param Request $request
     * @param $code
     * @return \Illuminate\Http\RedirectResponse|\Laravel\Lumen\Http\Redirector
     */
    public function unshorten(Request $request, $code)
    {
        $originalUrl = ShortUrl::getOriginalUrl($code);

        if ($originalUrl !== false) {
            return redirect($originalUrl);
        }

        return redirect('/');
    }
}