<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Jobs\ActiveCampaignJobV3;
use App\Constants\ActiveCampaignConstants as AC;
use App\Contact;
use App\AffiliateImpact;

class ImpactPartnerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // 10 attempt when job fails
    public $tries = 10;

    // 180 sec max timeout time
    public $timeout = 180;

    // retry 10 sec after jobs fails
    public $retryAfter = 10;

    public $contact;
    public $impactID;
    public $status;
    public $uri;
    public $companyName;
    /**
     * The webhook data
     *
     * @var object
     */
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($contact, $impactID, $status, $uri, $name)
    {
        $this->contact = $contact;
        $this->impactID = $impactID;
        $this->status = $status;
        $this->uri = $uri;
        $this->companyName = $name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $tag = null;
            $updateListStatus = null;
            $activeCampaign = new ActiveCampaignJobV3();
            $find = count($activeCampaign->findContactViaEmail($this->contact->EmailAddress));
            $contact = $activeCampaign->sync([
              'email' => $this->contact->EmailAddress,
              'firstName' => $this->contact->FirstName,
              'lastName' => $this->contact->LastName,
              'fieldValues' => [
                ['field' => AC::FIELD_IMPACT_AFFILIATE_ID, 'value' =>  $this->impactID],
                ['field' => AC::FIELD_IMPACT_AFFILIATE_STATUS, 'value' =>  $this->status],
                ['field' => AC::FIELD_IMPACT_URI,'value' => $this->uri],
                ['field' => AC::FIELD_IMPACT_COMPANY_NAME, 'value' => $this->companyName],
              ]
            ]);
            if($contact) {
            $contactTag = AC::TAG_EVENT_AFFILIATE_IMPACT;
            $tag = $activeCampaign->tag($contact['id'], $contactTag);
              if($find < 1) {
                  logger('New Subscriber from impact');
                  $updateListStatus = $activeCampaign->updateListStatus([
                    'list' => AC::LIST_MASTERLIST,
                    'contact' => $contact['id'],
                    'status' => AC::LIST_SUBSCRIBE
                  ]);
              }
            }
            $impactTable = new AffiliateImpact;
            $impactTable->updateOrCreate(
                ['email' => $this->contact->EmailAddress],
                [
                    'first_name' => $this->contact->FirstName,
                    'last_name' => $this->contact->LastName,
                    'status' => $this->status,
                    'impact_id' => $this->impactID,
                    'email' => $this->contact->EmailAddress
                ]);
            logger('Impact Job Done');
        } catch(\Exception $e) {
            logger('Released back into the job queue');
            // release back to job queue with 10 seconds delay
            $this->release(10);
        }
    }
}
