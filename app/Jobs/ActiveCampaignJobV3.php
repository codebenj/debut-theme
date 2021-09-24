<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mediatoolkit\ActiveCampaign\Client as ActiveCampaignClient;
use Mediatoolkit\ActiveCampaign\Contacts\Contacts;
use Illuminate\Support\Arr;

class ActiveCampaignJobV3 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $contacts;
    public $activeCampaign;

    public function __construct()
    {
        $this->activeCampaign = new ActiveCampaignClient(config('services.activecampaign.api_url'), config('services.activecampaign.api_key'));
    }

    public function contacts()
    {
        return new Contacts($this->activeCampaign);
    }

    public function create($contact)
    {
        try {
            logger("Initializing ActiveCampaign Create");
            $req = $this->contacts()->create($contact);

            return json_decode($req, true)['contact'];
        } catch(\Exception $e) {
            logger($e->getMessage());
        }
    }

    public function sync($contact)
    {
        try {
            logger("Initializing ActiveCampaign Sync");
            $req = $this->contacts()->sync($contact);

            return json_decode($req, true)['contact'];
        } catch(\Exception $e) {
            logger($e->getMessage());
        }
    }

    public function get($id)
    {
        if (!isset($id)) {
            return false;
        }

        try {
            logger("Initializing ActiveCampaign Get");
            $req = $this->contacts()->get($id);

            return json_decode($req, true)['contact'];
        } catch(\Exception $e) {
            logger($e->getMessage());
        }
    }

    public function updateListStatus($contact_list)
    {
        try {
            logger("Initializing ActiveCampaign UpdateListStatus");
            $req = $this->contacts()->updateListStatus($contact_list);
    
            return json_decode($req, true)['contactList'];
        } catch(\Exception $e) {
            logger($e->getMessage());
        }
    }

    public function update($id, $contact)
    {
        if (!isset($id)) {
            return false;
        }

        try {
            logger("Initializing ActiveCampaign Update");
            $req = $this->contacts()->update($id, $contact);
    
            return json_decode($req, true)['contact'];
        } catch(\Exception $e) {
            logger($e->getMessage());
        }
    }

    public function tag($id, $tag_id)
    {
        if (!isset($id)) {
            return false;
        }

        try {
            logger("Initializing ActiveCampaign Tag");
            $req = $this->contacts()->tag($id, $tag_id);

            return json_decode($req, true)['contactTag'];
        } catch(\Exception $e) {
            logger($e->getMessage());
        }
    }

    public function untag($contact_tag_id)
    {
        if (!isset($contact_tag_id)) {
            return false;
        }

        try {
            logger("Initializing ActiveCampaign Untag");
            $req = $this->contacts()->untag($contact_tag_id);
    
            return json_decode($req, true);
        } catch(\Exception $e) {
            logger($e->getMessage());
        }
    }

    public function getContactTag($contact_id, $tag_id)
    {
        if (!isset($contact_id)) {
            return false;
        }

        try {
            logger("Initializing ActiveCampaign GetContactTag");
            $req = $this->activeCampaign
                ->getClient()
                ->get('/api/3/contacts/' . $contact_id . '/contactTags');
            $contactTags = json_decode($req->getBody()->getContents(), true)['contactTags'];
    
            return Arr::first($contactTags, function ($value, $key) use ($tag_id) {
                return $value['tag'] == $tag_id;
            });
        } catch(\Exception $e) {
            logger($e->getMessage());
        }
    }

    public function customSync($contact)
    {
        try {
            logger("Initializing ActiveCampaign Sync");
            $req = $this->contacts()->sync($contact);
    
            return json_decode($req, true);
        } catch(\Exception $e) {
            logger($e->getMessage());
        }
    }

    public function create_tag($tag_name, $tag_description){
        try {
            $client =  new ActiveCampaignClient(config('services.activecampaign.api_url'), config('services.activecampaign.api_key'));
                $tag_id = 0;
                $get_tag = $client->getClient()->get('/api/3/tags?search='.$tag_name);
                $tag_data = json_decode($get_tag->getBody()->getContents());
                if(isset($tag_data->meta->total) && $tag_data->meta->total > 0 ) {
                    if(isset($tag_data->tags) && !empty($tag_data->tags)){
                        if(isset($tag_data->tags[0]) && !empty($tag_data->tags[0])) {
                            $tag_id =  $tag_data->tags[0]->id;
                        }
                    }
                } else {
                    $create_tag = $client->getClient()->post('/api/3/tags', [
                        'json' => [
                            'tag' => ['tag' => $tag_name, 'tagType' => 'contact', 'description' => $tag_description]
                        ]
                    ]);
                    $create_tag = json_decode($create_tag->getBody()->getContents());
                    if(isset($create_tag->tag->id) && !empty($create_tag->tag->id) ) {
                        $tag_id =  $create_tag->tag->id;
                    }
                }
            return $tag_id;
        } catch(\Exception $e) {
            logger($e->getMessage());
        }
    }

    public function findContactViaEmail($email) {
        try {
            $req = $this->activeCampaign
            ->getClient()
            ->get("/api/3/contacts?filters[email]=$email");
        return json_decode($req->getBody()->getContents(), true)['contacts'];
        } catch(\Exception $e) {
            logger($e->getMessage());
        }
    }

    public function createCustomFieldValue($contact_id, $field_id, $field_value) {
        if (!isset($contact_id)) {
            return false;
        }

        try {
            $req = $this->contacts()->createCustomFieldValue($contact_id, $field_id, $field_value);
            return json_decode($req, true)['fieldValue'];
        } catch(\Exception $e) {
            logger($e->getMessage());
        }
    }
}
