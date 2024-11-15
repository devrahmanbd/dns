<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $settings = new \stdClass;
        $settings->name = 'Global DNS';
        $settings->version = '2.5';
        $settings->license_key = '';
        $settings->ads = [
            'one' => '',
            'two' => '',
            'three' => '',
            'four' => '',
            'five' => '',
            'six' => '',
        ];
        $settings->socials = [];
        $settings->colors = [
            'primary' => '#0155b5',
            'secondary' => '#2fc10a',
            'tertiary' => '#d2ab3e'
        ];
        $settings->global = [
            'css' => '',
            'js' => '',
            'header' => '',
            'footer' => ''
        ];
        $settings->cookie = [
            'enable' => true,
            'text' => '<p>By using this website you agree to our <a href="#" target="_blank">Cookie Policy</a></p>'
        ];
        $settings->font_family = 'Poppins';
        $settings->text = [
            'above_map' => '',
            'below_map' => '',
            'footer' => '<p class="ql-align-center">Copyright 2024 - CloudMan DNS</p>'
        ];
        $settings->find_btn = [
            'text' => 'Find',
            'color' => '#F3DF00',
            'text_color' => '#000000'
        ];
        $settings->whois_btn = [
            'text' => 'Lookup',
            'color' => '#5CC9FF',
            'text_color' => '#000000'
        ];
        $settings->ip_btn = [
            'text' => 'Lookup',
            'color' => '#5CC9FF',
            'text_color' => '#000000'
        ];
        $settings->blacklist_btn = [
            'text' => 'Check',
            'color' => '#5CC9FF',
            'text_color' => '#000000'
        ];
        $settings->dmarc_btn = [
            'text' => 'Check',
            'color' => '#5CC9FF',
            'text_color' => '#000000'
        ];
        $settings->default_dns = 'A';
        $settings->enable_logs = false;
        $settings->show_dark_mode = true;
        $settings->recaptcha = [
            'enabled' => false,
            'site_key' => '',
            'secret_key' => ''
        ];
        $settings->enable_ad_block_detector = false;
        $settings->ad_block_detector_filename = null;
        $settings->map_fail_reloader = false;
        $settings->api_keys = [];
        $settings->timeout = 5;
        $settings->blacklist = [
            'servers' => ["dyna.spamrats.com", "all.s5h.net", "b.barracudacentral.org", "spam.spamrats.com", "zen.spamhaus.org", "dnsbl.dronebl.org", "spam.rbl.blockedservers.com", "rbl.interserver.net", "spamsources.fabel.dk", "bl.scientificspam.net", "dnsbl.zapbl.net", "bl.rbl.scrolloutf1.com", "dnsbl.kempt.net", "mail-abuse.com", "bl.score.senderscore.com", "exploit.mail.abusix.zone", "new.spam.dnsbl.sorbs.net", "block.dnsbl.sorbs.net", "bl.spamcop.net", "black.mail.abusix.zone", "multi.surbl.org", "escalations.dnsbl.sorbs.net", "zombie.dnsbl.sorbs.net", "dnsbl.tornevall.org", "bl.nordspam.com", "fnrbl.fast.net", "talosintelligence.com", "truncate.gbudb.net", "0spam.fusionzero.com", "bl.nosolicitado.org"],
        ];

        foreach ($settings as $key => $value) {
            if (!Setting::where('key', $key)->exists()) {
                Setting::create([
                    'key' => $key,
                    'value' => serialize($value)
                ]);
            }
        }
    }
}
