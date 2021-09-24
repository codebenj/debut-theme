<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\AffiliateLinkmink;
use Illuminate\Support\Facades\Http;

class LinkminkJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $data;
    protected $type;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $data, $type)
    {
        $this->user = $user;
        $this->data = $data;
        $this->type = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $data = $this->data;
            if ($this->type == 'renewal') {
                $affiliate = AffiliateLinkmink::where('user_id', $this->user->id)->where('paypal_id', $data['paypalid'])->first();

                if ($affiliate) {
                    $this->linkminkCommission($affiliate->conversion_id, $data);
                }
            } else {
                $this->linkminkConversion($data);
            }

        } catch (\Exception $exception) {
            logger("Linkmink conversion Error Message " . $exception->getMessage());
        }
    }

    public function linkminkConversion($data) 
    {
        try {
            logger('Linkmink conversion starts');
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('env-variables.LINKMINK_API'),
            ])->post('https://app.linkmink.com/api/v0.1.0/conversions', [
                'email'     => $data['email'],
                'type'      => $data['planname'] . ' - ' . $data['email'],
                'status'    => 'active',
                'livemode'  => true,
                'lm_data'   => $data['lmdata'],
            ]);

            if ($response->successful()) {
                $result = $response->json();
                logger('Conversion: ' . json_encode($result));

                $this->linkminkCommission($result['conversion_id'], $data);
            }
        } catch (\Exception $exception) {
            logger("Linkmink conversion Error Message " . $exception->getMessage());
        }
    }    
    
    public function linkminkCommission($conversion, $data) 
    {
        try {
            logger('Linkmink commission starts');
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('env-variables.LINKMINK_API'),
            ])->post('https://app.linkmink.com/api/v0.1.0/value-events', [
                'livemode'      => true,
                'conversion_id' => $conversion,
                'status'        => 'pending',
                'currency'      => 'usd',
                'amount'        => floor($data['amount']) * 100, // We multiple it by 100 because Linkmink converts amount and commission to cents.
            ]);

            if ($response->successful()) {
                $result = $response->json();
                logger('Commission: ' . json_encode($result));

                AffiliateLinkmink::create([
                    'user_id' => $this->user->id,
                    'conversion_id' => $conversion,
                    'paypal_id' => $data['paypalid'],
                    'paypal_plan' => $data['paypalplan'],
                    'paypal_email' => $data['email'],
                    'type' => $this->type,
                    'response' => json_encode($result)
                ]);
            }
        } catch (\Exception $exception) {
            logger("Linkmink commission Error Message " . $exception->getMessage());
        }
    }
}
