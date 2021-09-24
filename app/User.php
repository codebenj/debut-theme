<?php

namespace App;

use Carbon\Carbon;
use Laravel\Cashier\Billable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Osiset\ShopifyApp\Contracts\ShopModel as IShopModel;
use Osiset\ShopifyApp\Traits\ShopModel;
use App\SubscriptionPaypal;
use App\SubscriptionStripe;
use App\MainSubscription;

class User extends Authenticatable implements IShopModel
{
    use Billable;
    use Notifiable;
    use ShopModel;
    use SoftDeletes;

    const PLAN_CANCELLED = 'cancelled';
    const PLAN_FROZEN = 'frozen';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','affiliate_id', 'referred_by', 'test'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'shop_api',
        'modified_all_addons',
        'modified_all_addons_plan',
        'first_name',
        'last_name',
        'paypal_email',
        'installed_at',
        'all_invoices',
        'total_spent',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $attributes = [
        'commission_count' => 0,
    ];

    /**
     * @return int
     */

    public function addons()
    {
        return $this->hasMany('App\AddOns');
    }

    public function storeThemes()
    {
        return $this->hasMany('App\StoreThemes');
    }

    public function childstores()
    {
        return $this->hasMany('App\ChildStore');
    }

    public function mentoringcalls()
    {
        return $this->hasMany('App\MentoringCall');
    }

    public function getFirstNameAttribute()
    {
        return getName($this->shop_api['shop_owner'] ?? '', 'first');
    }

    public function getLastNameAttribute()
    {
        return getName($this->shop_api['shop_owner'] ?? '', 'last');
    }

    public function getPaypalEmailAttribute()
    {
        return $this->paypalSubscription()->active()->first() ? $this->paypalSubscription()->active()->first()->paypal_email : '';
    }

    public function getShopApiAttribute()
    {
        return $this->api()->request(
            'GET',
            "/admin/api/shop.json",
            []
        )['body']['shop'] ?? false;
    }

    public function getInstalledAtAttribute()
    {
        return $this->password ? $this->created_at : null;
    }

    public function getAllInvoicesAttribute()
    {
        $mainSubscription = $this->mainSubscription;
        $prevSubscriptionsInvoice = null;

        if (isset($mainSubscription)) {
            $paymentPlatform = $mainSubscription->payment_platform;

            try {
                \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

                if ($paymentPlatform == MainSubscription::PAYMENT_PLATFORM_STRIPE) {
                    $prevSubscriptionsInvoice = \Stripe\Invoice::all(["customer" => $this->stripe_id]);
                }

                if ($paymentPlatform == MainSubscription::PAYMENT_PLATFORM_PAYPAL) {
                    $subscriptions = SubscriptionPaypal::where('user_id', $this->id)
                                ->orderBy('id', 'desc')->select('id', 'paypal_id', 'paypal_status', 'created_at')
                                ->get();
                    $fromDate = Carbon::now()->subMonth(6)->format('Y-m-d');
                    $toDate = Carbon::now()->addDay()->format('Y-m-d');
                    $prevSubscriptionsInvoice = [];
                    $subscriptions->each(function($subscription) use (&$prevSubscriptionsInvoice, $fromDate, $toDate) {
                        $subId = $subscription->paypal_id;
                        $prevSubscriptionsInvoiceResult = getPaypalHttpClient()->get(getPaypalUrl("v1/billing/subscriptions/${subId}/transactions?start_time=${fromDate}T00:00:00.940Z&end_time=${toDate}T00:00:00.940Z"))->json();

                        if (count($prevSubscriptionsInvoiceResult)) {
                            array_push($prevSubscriptionsInvoice, $prevSubscriptionsInvoiceResult);
                        }
                    });
                }
            } catch (\Exception $e) {
                logger("Error getting invoice. Message: " . $e->getMessage());
            }
        }

        return $prevSubscriptionsInvoice;
    }

    public function getTotalSpentAttribute()
    {
        $spent = 0;
        $mainSubscription = $this->mainSubscription;

        if (isset($mainSubscription)) {
            $paymentPlatform = $mainSubscription->payment_platform;

            if ($paymentPlatform == MainSubscription::PAYMENT_PLATFORM_STRIPE) {
                if (isset($this->all_invoices) && isset($this->all_invoices->data)) {
                    $spent = collect($this->all_invoices->data)->map(function($invoice) {
                        return $invoice->amount_paid;
                    })->sum() / 100;
                }
            }

            if ($paymentPlatform == MainSubscription::PAYMENT_PLATFORM_PAYPAL) {
                $spent = collect($this->all_invoices)->map(function($invoice) {
                    if (isset($invoice['transactions'])) {
                        return collect($invoice['transactions'])->map(function($transaction) {
                           return $transaction['amount_with_breakdown']['gross_amount']['value'];
                        })->sum();
                    }
                })->sum();
            }
        }

        return $spent;
    }

    public function getModifiedAllAddOnsAttribute()
    {
        $trial_days = $this->trial_days;

        if ( ! $trial_days ) { // if trial is over
            $modified_all_addons = $this->all_addons;
        } else { // else fake hustler subscription for trial
            $modified_all_addons = 1;
        }

        return $modified_all_addons;
    }

    public function getModifiedAllAddOnsPlanAttribute()
    {
        $trial_plan = 'Master';
        $trial_days = $this->trial_days;

        if ( ! $trial_days ) {
            $modified_all_addons_plan = $this->alladdons_plan;
        } else {
            $modified_all_addons_plan = $trial_plan;
        }

        return $modified_all_addons_plan;
    }

    public function scopeHasPlan($query, $plan) {
        if ( isset($plan) && ! empty($plan) ) {
            $query->where('alladdons_plan', $plan);
        }
        return $query;
    }
    // public function referrer()
    // {
    //     return $this->hasOne('App\User', 'id', 'referred_by');
    // }

    // public function referrals()
    // {
    //     return $this->hasMany('App\User', 'referred_by', 'id');
    // }

    public function mainSubscription()
    {
        return $this->hasOne(MainSubscription::class, 'user_id');
    }

    public function stripeSubscription()
    {
        return $this->hasOne(SubscriptionStripe::class,'user_id')
                    ->orderBy('id', 'DESC');
    }

    public function paypalSubscription()
    {
        return $this->hasOne(SubscriptionPaypal::class,'user_id')
                    ->orderBy('id', 'DESC');
    }

    public function extendTrialRequests()
    {
        return $this->hasMany(SubscriptionPaypal::class,'user_id');
    }

    public function allPaypalSubscriptions()
    {
        return $this->hasMany(SubscriptionPaypal::class,'user_id')
                    ->orderBy('id', 'DESC');
    }
}
