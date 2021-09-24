<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ShareasaleCommission implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $data)
    {
        $this->user = $user;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = $this->data;
        if (isset($data['date']))
        {
            $data['date'] = Carbon::parse($data['date'])->format('m/d/Y');
            $date = Carbon::parse($data['date']);
        }
        else
        {
            $date = now();
        }
        $merchantId = config('services.shareasale.merchant_id');
        $token = config('services.shareasale.token');
        $secret = config('services.shareasale.secret');
        $version = config('services.shareasale.version');
        $timestamp = $date->format(DATE_RFC1123);
        $action = $data['action'];
        $sig = $token . ':' . $timestamp . ':' . $action . ':' . $secret;
        $hash = hash("sha256", $sig);

        $response = Http::withHeaders([
            'x-ShareASale-Date' => $timestamp,
            'x-ShareASale-Authentication' => $hash
        ])->get('https://api.shareasale.com/w.cfm',
            array_merge([
                'merchantId' => $merchantId,
                'token' => $token,
                'version' => $version,
                'transtype' => 'sale',
            ], $data)
        );

        if (stripos($response->body(), "Error Code"))
        {
            $this->fail(new \Exception($response->body()));
        }
        else
        {
            $user = $this->user;
            $user->increment('commission_count', $this->getMonthlyCount($this->getPlanCycle()));
        }
    }

    private function getPlanCycle()
    {
        $mainSubscription = $this->user->mainSubscription;

        if ($mainSubscription && $mainSubscription->payment_platform == $mainSubscription::PAYMENT_PLATFORM_STRIPE)
        {
            return optional(optional($this->user->stripeSubscription)->plan)->cycle;
        }
        elseif ($mainSubscription && $mainSubscription->payment_platform == $mainSubscription::PAYMENT_PLATFORM_PAYPAL)
        {
            return optional(optional($this->user->paypalSubscription)->plan)->cycle;
        }
        return null;
    }

    private function getMonthlyCount($cycle)
    {
        switch ($cycle)
        {
            case 'Monthly':
                return 1;
            case 'Quarterly':
                return 3;
            case 'Yearly':
                return 12;
            case 'Annually':
                return 12;
            default:
                return 1; #increase 1 default for plan doesn't exists, such as testing paypal daily plan
        }
    }
}
