<?php


namespace App\Http\Controllers;

use App\Models\AppDetail;
use Request;

class AjaxController extends Controller
{

    public function spamCard(Request $request)
    {
        if (Request::ajax()) {

            // seri-pin generate
            if (Request::get('tel') == 1) {
                if (Request::get('tel') < 50000) {
                    $seri = mt_rand(10000000000000, 99999999999999);
                    $pin = mt_rand(100000000000000, 999999999999999);
                } else {
                    $seri = mt_rand(10000000000, 99999999999);
                    $pin = mt_rand(1000000000000, 9999999999999);
                }
            } else if (Request::get('tel') == 2) {
                $seri = mt_rand(100000000000000, 999999999999999);
                $pin = mt_rand(100000000000, 999999999999);
            } else {
                $seri = mt_rand(10000000000000, 99999999999999);
                $pin = mt_rand(10000000000000, 99999999999999);
            }

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL            => "https://shopgarena.info/Content/ajax/site/napcham3.php",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING       => "",
                CURLOPT_MAXREDIRS      => 10,
                CURLOPT_TIMEOUT        => 50,
                CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST  => "POST",
                CURLOPT_POSTFIELDS     => 'card_type_id=' . Request::get('tel') . '&amount=' . Request::get('amount') . '&seri=' . $seri . '&pin=' . $pin,
                CURLOPT_HTTPHEADER     => array(
//                    "accept: application/json, text/javascript, */*; q=0.01",
//                    "accept-encoding: gzip, deflate, br",
//                    "accept-language: en-US,en;q=0.9,vi;q=0.8",
//                    "cache-control: no-cache",
//                    "content-length: 67",
//                    "origin: https://shopgarena.info",
//                    "referer: https://shopgarena.info/nap-tien.html",
//                    "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36",
//                    "x-requested-with: XMLHttpRequest"
                ),
                CURLOPT_COOKIE         => Request::get('cookie')
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                return "cURL Error #:" . $err;
            } else {
                return $response;
            }
        }
    }

    private function random_seri_pin($length)
    {
        return substr(bin2hex(random_bytes($length)),
            0, $length);
    }


}
