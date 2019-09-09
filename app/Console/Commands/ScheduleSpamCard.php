<?php

namespace App\Console\Commands;

use App\CrontabSetting;
use App\Mail\NotifyEmail;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

//use Notify

class ScheduleSpamCard extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spam:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info(Carbon::now());
        $setting = CrontabSetting::first();
        $cardType = config('constants.card_type_id');
        $sleep = $this->sleep($setting['time_request']);
        try {
            for ($i = 0; $i < $setting['card_number']; $i++) {
                if ($i != 0) {
                    sleep($sleep);
                }
                $cardTypeId = $cardType[array_rand($cardType)];
                $card = $this->createCard($cardTypeId);
                $spamCard = $this->spamCard($setting['cookie'], $cardTypeId, $card[0], $card[1], $card[2]);
                if ($spamCard == 'Chưa đăng nhập' || strpos($spamCard, 'cURL Error') !== false) {
                    if ($spamCard == 'Chưa đăng nhập') {
                        $this->pushNotification($setting['email'], $spamCard . ' ( section expired )');
                    } else {
                        $this->pushNotification($setting['email'], $spamCard);
                    }
                    CrontabSetting::where('id', $setting['id'])->limit(1)->update(['status' => 0]);
                    break;
                }
            }
        } catch (\Exception $e) {
            $this->pushNotification($setting['email'], $e->getMessage());
            $this->info(Carbon::now() . "\n");
        }
        $this->info(Carbon::now() . "\n");
    }

    public function sleep($timeRequest)
    {
        $seconds = 0;
        switch ($timeRequest) {
            case 0:
                $seconds = 60;
                break;
            case 1:
                $seconds = 5 * 60;
                break;
            case 2:
                $seconds = 10 * 60;
                break;
            case 3:
                $seconds = 15 * 60;
                break;
            case 4:
                $seconds = 30 * 60;
                break;
            case 5:
                $seconds = 60 * 60;
                break;
            default:
        }
        return $seconds;
    }

    public function createCard($cardType)
    {
        $amounts = config('constants.amount');
        $amount = $amounts[array_rand($amounts)];
        if ($cardType == 1) {
            if ($amount < 50000) {
                $seri = mt_rand(10000000000000, 99999999999999);
                $pin = mt_rand(100000000000000, 999999999999999);
            } else {
                $seri = mt_rand(10000000000, 99999999999);
                $pin = mt_rand(1000000000000, 9999999999999);
            }
        }
        if ($cardType == 2) {
            $seri = mt_rand(100000000000000, 999999999999999);
            $pin = mt_rand(100000000000, 999999999999);
        }
        if ($cardType == 4) {
            $seri = mt_rand(10000000000000, 99999999999999);
            $pin = mt_rand(10000000000000, 99999999999999);
        }
        return [$amount, $seri, $pin];

    }

    public function spamCard($cookie, $card_type_id, $amount, $seri, $pin)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL            => "https://shopgarena.info/Content/ajax/site/napcham3.php",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 50,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => 'card_type_id=' . $card_type_id . '&amount=' . $amount . '&seri=' . $seri . '&pin=' . $pin,
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
            CURLOPT_COOKIE         => $cookie
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            $this->info("cURL Error #:" . $err);
            return "cURL Error #:" . $err;
        } else {
            $res = json_decode($response);
            $this->info($res->msg);
            return $res->msg;
        }
    }

    public function pushNotification($email, $msg)
    {
        $obj = new \stdClass();
        $obj->content = $msg;
        $obj->receiver = $email;
        Mail::to($email)->send(new NotifyEmail($obj));
    }
}
