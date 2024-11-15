<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $pages = [
            [
                'title' => 'WHOIS Lookup',
                'slug' => 'whois',
                'content' => '<h1>WHOIS Lookup</h1><p>Whois domain lookup allows you to trace the ownership and tenure of a domain name. Similar to how all houses are registered with governing authority, all domain name registries maintain a record of information about every domain name purchased through them, along with who owns it, and the date till which it has been purchased.</p><p>[split]</p><p>You can search for an unlimited number of domains!</p>',
                'meta' => null,
                'header' => null
            ],
            [
                'title' => 'IP Lookup',
                'slug' => 'ip',
                'content' => '<h1>IP Lookup</h1><p>Discover comprehensive information about any IP address with our powerful IP lookup tool. Whether you\'re a developer, a curious individual, or seeking to enhance your online security, our website offers a user-friendly interface to access a wealth of data related to IP addresses. Simply enter the IP address you\'re interested in, and let us provide you with valuable insights.</p>',
                'meta' => null,
                'header' => null
            ],
            [
                'title' => 'Blacklist',
                'slug' => 'blacklist',
                'content' => '<h1>Blacklist Checker</h1><p>The blacklist check is a tool that assesses a mail server\'s IP address by cross-referencing it with more than 100 DNS-based email blacklists, often referred to as Realtime blacklists, DNSBLs, or RBLs. When a mail server\'s IP address is blacklisted, there is a risk that some of the emails sent from that server may not reach their intended recipients. These email blacklists serve as a widely used method for minimizing the impact of spam emails.</p>',
                'meta' => null,
                'header' => null
            ],
            [
                'title' => 'DMARC Checker',
                'slug' => 'dmarc',
                'content' => '<h1>DMARC Checker</h1><p>A DMARC (Domain-based Message Authentication, Reporting, and Conformance) record is crucial for email security. It enhances your organization\'s email authentication by preventing phishing and spoofing attacks. By specifying email authentication policies, DMARC ensures that only legitimate emails from your domain are delivered, safeguarding your brand reputation and user trust. Checking the DMARC record with a dedicated tool is vital to ensure its proper configuration, providing insights into potential vulnerabilities and ensuring effective email protection. Regular monitoring of DMARC records helps organizations maintain a secure email ecosystem, reducing the risk of malicious activities and fortifying their email communication integrity.</p>',
                'meta' => null,
                'header' => null
            ],
        ];
        foreach ($pages as $page) {
            if (!Page::where('slug', $page['slug'])->exists()) {
                Page::create([
                    'title' => $page['title'],
                    'slug' => $page['slug'],
                    'content' => $page['content'],
                    'meta' => $page['meta'],
                    'header' => $page['header'],
                ]);
            }
        }
    }
}
