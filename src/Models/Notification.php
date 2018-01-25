<?php

namespace Bondacom\Antenna\Models;

use Bondacom\Antenna\Drivers\DriverInterface;
use Bondacom\Antenna\Utilities\Model;

class Notification extends Model
{
    /*
     * Attributes when notification is created
        'successful',
        'failed',
        'converted',
        'remaining',
        'queued_at',
        'send_after',
        'url',
        'data',
        'canceled',
        'headings',
        'contents',
     * */

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'included_segments',
        'excluded_segments',
        'filters',
        'include_player_ids',
        'app_id',
        //Content & Language
        'contents',
        'headings',
        'subtitle',
        'template_id',
        'content_available',
        'mutable_content',
        //Attachments
        'data',
        'url',
        'ios_attachments',
        'big_picture',
        'adm_big_picture',
        'chrome_big_picture',
        //Action Buttons
        'buttons',
        'web_buttons',
        'ios_category',
        //Appearance
        'android_channel_id',
        'existing_android_channel_id',
        'android_background_layout',
        'small_icon',
        'large_icon',
        'adm_small_icon',
        'adm_large_icon',
        'chrome_web_icon',
        'chrome_web_image',
        'chrome_icon',
        'ios_sound',
        'android_sound',
        'adm_sound',
        'wp_sound',
        'wp_wns_sound',
        'android_led_color',
        'android_accent_color',
        'android_visibility',
        'ios_badgeType',
        'ios_badgeCount',
        'collapse_id',
        //Delivery
        'send_after',
        'delayed_option',
        'delivery_time_of_day',
        'ttl',
        'priority',
        //Grouping & Collapsing
        'android_group',
        'android_group_message',
        'adm_group',
        'adm_group_message',
        //Platform to Deliver To
        'isIos',
        'isAndroid',
        'isAnyWeb',
        'isChromeWeb',
        'isFirefox',
        'isSafari',
        'isWP',
        'isWP_WNS',
        'isAdm',
        'isChrome',
    ];

    /**
     * @return \Bondacom\Antenna\Drivers\NotificationInterface
     */
    public function newDriverInstance()
    {
        return app(DriverInterface::class)->notification();
    }
}