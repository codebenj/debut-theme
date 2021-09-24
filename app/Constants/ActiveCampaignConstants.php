<?php

namespace App\Constants;

class ActiveCampaignConstants
{
    // ActiveCampaign Tag IDs
    const TAG_SOURCE_NEWSLETTER = 145;
    const TAG_SOURCE_WEBSITE_EXIT_INTENT = 83;
    const TAG_KAMIL_SATTAR_MENTORING = 169;
    const TAG_EVENT_SHOPIFY_STORE_CLOSED = 137;
    const TAG_EVENT_SHOPIFY_STORE_PAUSED = 136;
    const TAG_EVENT_PLAN_UPGRADED = 158;
    const TAG_EVENT_PLAN_DOWNGRADED = 186;
    const TAG_EVENT_PLAN_MONTH_FREE = 114;
    const TAG_EVENT_PLAN_PAUSED = 73;
    const TAG_EVENT_PLAN_CANCELLED = 89;
    const TAG_EVENT_SUCCESSFUL_PAYMENT = 171;
    const TAG_EVENT_FAILED_PAYMENT = 213;
    const TAG_EVENT_LEAD = 321;
    const TAG_EVENT_INITIATE_CHECKOUT = 322;
    const TAG_EVENT_AFFILIATE_IMPACT = 302;

    // ActiveCampaign List IDs
    const LIST_MASTERLIST = 57;

    // ActiveCampaign List Status
    const LIST_SUBSCRIBE = 1;
    const LIST_UNSUBSCRIBE = 2;

    // ActiveCampaign Fields IDs
    const FIELD_SUBSCRIPTION = 1;
    const FIELD_COMPANY = 6;
    const FIELD_APP_STATUS = 7;
    const FIELD_COUNTRY = 9;
    const FIELD_CITY = 10;
    const FIELD_ZIP = 11;
    const FIELD_ADDRESS_LINE_1 = 12;
    const FIELD_ADDRESS_LINE_2 = 13;
    const FIELD_PROVINCE = 14;
    const FIELD_LANGUAGE = 15;
    const FIELD_STORE_NAME = 16;
    const FIELD_IMPACT_AFFILIATE_ID = 64;
    const FIELD_IMPACT_AFFILIATE_STATUS = 65;
    const FIELD_IMPACT_COMPANY_NAME = 66;
    const FIELD_IMPACT_URI = 67;
    const FIELD_ID = 20;
    const FIELD_PAYPAL_EMAIL = 36;
    const FIELD_WEBSITE = 28;
    const FIELD_THEME_BILLING = 63;

    const FIELD_VALUE_APP_STATUS_UNINSTALLED = 'Uninstalled';
    const FIELD_VALUE_APP_STATUS_INSTALLED = 'Installed';

    const FIELD_VALUE_SUBSCRIPTION_FREEMIUM = 'Freemium';
}

