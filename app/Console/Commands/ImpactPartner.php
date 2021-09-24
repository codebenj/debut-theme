<?php

namespace App\Console\Commands;
use App\Jobs\ImpactPartnerJob;
use Illuminate\Console\Command;

class ImpactPartner extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'impactPartner:update';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'sync impact to active campaign';

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
   * @return int
   */
  public function handle()
  {
    \Log::info("=== Start Impact's Partner Job ===");

    $hasNextpage = true;
    $page = 1;
    $mediaData = array();
    $pagesize = 250;

    while ($hasNextpage) {
      $curl = curl_init();
      $generateBase64 = base64_encode(config('env-variables.IMPACT_USERNAME').':'.config('env-variables.IMPACT_PASSWORD'));
      curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.impact.com/Advertisers/IR4tZu7VkvDr2559139NXkEsVhZJYravM1/MediaPartners?page=$page&PageSize=$pagesize",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 500,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
          'Content-type: application/json',
          'Accept: application/json',
          'Authorization: Basic '.$generateBase64
        ),
      ));

      $data = curl_exec($curl);

      curl_close($curl);

      $json = json_decode($data);

      if (isset($json->MediaPartners)) {
        # get the affiliates data
        $mediaPartners = $json->MediaPartners;

        # Merge the current fetched data and the stored data
        $mediaData = array_merge($mediaData, $mediaPartners);

        # Check if the current data is equal to the current page size
        if (count($mediaPartners) == $pagesize)
        {
          $hasNextpage = true;
          $page++;
        } else
        {
          $hasNextpage = false;
        }
      }
      else 
      {
        $hasNextpage = false;
      }
    }

    foreach ($mediaData as $mediaPartnerData) 
    {
      if ($mediaPartnerData->Contact->EmailAddress) 
      {
        $contact = $mediaPartnerData->Contact;
        $impactID = $mediaPartnerData->Id;
        $status = $mediaPartnerData->State;
        $uri = $mediaPartnerData->Uri;
        $name = $mediaPartnerData->Name;
        dispatch(new ImpactPartnerJob($contact, $impactID, $status, $uri, $name));
        logger('Impact Command successfully dispatched');
      } else {
        logger('No Email Address');
      }
    }
    \Log::info("=== End Impact's Partner Job ===");
  }
}
