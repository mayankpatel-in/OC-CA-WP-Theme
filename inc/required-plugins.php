<?php
/**
 * OC CA Theme — Plugin Registry
 *
 * Add, remove or change 'required' here to control which plugins
 * appear on Appearance → Required Plugins and which trigger notices.
 *
 * Fields:
 *   name        (string)  Display name
 *   slug        (string)  WordPress.org slug  →  used for one-click Install
 *   file        (string)  folder/main-file.php  →  used for status detection
 *   description (string)  Short purpose description shown in the admin table
 *   required    (bool)    true = red error notice; false/absent = yellow warning
 *
 * @package OC_CA_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

OC_CA_Plugin_Manager::register( [

    // ── Required ──────────────────────────────────────────────

    [
        'name'        => 'Contact Form 7',
        'slug'        => 'contact-form-7',
        'file'        => 'contact-form-7/wp-contact-form-7.php',
        'description' => 'Powers the Get a Quote modal and all contact forms.',
        'required'    => true,
    ],

    // ── Recommended ───────────────────────────────────────────

    [
        'name'        => 'Yoast SEO',
        'slug'        => 'wordpress-seo',
        'file'        => 'wordpress-seo/wp-seo.php',
        'description' => 'On-page SEO, XML sitemaps, and breadcrumb schema markup.',
        'required'    => false,
    ],
    [
        'name'        => 'WP Super Cache',
        'slug'        => 'wp-super-cache',
        'file'        => 'wp-super-cache/wp-cache.php',
        'description' => 'Full-page caching for faster load times.',
        'required'    => false,
    ],
    [
        'name'        => 'Akismet Anti-Spam',
        'slug'        => 'akismet',
        'file'        => 'akismet/akismet.php',
        'description' => 'Spam filtering for comments and contact-form submissions.',
        'required'    => false,
    ],
    [
        'name'        => 'UpdraftPlus Backup/Restore',
        'slug'        => 'updraftplus',
        'file'        => 'updraftplus/updraftplus.php',
        'description' => 'Scheduled backups to cloud storage (Google Drive, Dropbox, etc.).',
        'required'    => false,
    ],
    [
        'name'        => 'Wordfence Security',
        'slug'        => 'wordfence',
        'file'        => 'wordfence/wordfence.php',
        'description' => 'Web application firewall, malware scanner, and login protection.',
        'required'    => false,
    ],

] );
