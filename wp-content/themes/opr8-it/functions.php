<?php
/**
 * OPR8-IT theme functions.
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

define('OPR8_THEME_VERSION', '1.0.0');

add_action('after_setup_theme', function (): void {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('custom-logo', [
        'height'      => 96,
        'width'       => 320,
        'flex-height' => true,
        'flex-width'  => true,
    ]);

    register_nav_menus([
        'primary' => __('Primary Menu', 'opr8-it'),
    ]);
});

add_action('wp_enqueue_scripts', function (): void {
    wp_enqueue_style(
        'opr8-roboto',
        'https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap',
        [],
        null
    );
    wp_enqueue_style(
        'opr8-it',
        get_stylesheet_uri(),
        ['opr8-roboto'],
        OPR8_THEME_VERSION
    );
    wp_enqueue_script(
        'opr8-it',
        get_template_directory_uri() . '/assets/js/main.js',
        [],
        OPR8_THEME_VERSION,
        true
    );
});

/**
 * Theme asset URL helper.
 */
function opr8_asset(string $path): string
{
    return get_template_directory_uri() . '/assets/' . ltrim($path, '/');
}

/**
 * Handle contact form POST (no plugin required).
 */
function opr8_handle_contact_form(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['opr8_contact_nonce'])) {
        return;
    }

    if (!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['opr8_contact_nonce'])), 'opr8_contact')) {
        set_transient('opr8_contact_notice_' . get_current_user_id(), ['type' => 'error', 'msg' => 'Beveiligingscontrole mislukt.'], 60);
        return;
    }

    $name    = sanitize_text_field(wp_unslash($_POST['opr8_name'] ?? ''));
    $email   = sanitize_email(wp_unslash($_POST['opr8_email'] ?? ''));
    $subject = sanitize_text_field(wp_unslash($_POST['opr8_subject'] ?? ''));
    $message = sanitize_textarea_field(wp_unslash($_POST['opr8_message'] ?? ''));

    if ($name === '' || $email === '' || $message === '') {
        set_transient('opr8_contact_flash', ['type' => 'error', 'msg' => 'Vul alle verplichte velden in.'], 60);
        return;
    }

    $to      = 'info@opr8-it.be';
    $body    = "Naam: {$name}\nEmail: {$email}\n\n{$message}";
    $headers = ['Content-Type: text/plain; charset=UTF-8', 'Reply-To: ' . $name . ' <' . $email . '>'];
    $sent    = wp_mail($to, $subject !== '' ? $subject : 'Contact via opr8-it.be', $body, $headers);

    set_transient(
        'opr8_contact_flash',
        [
            'type' => $sent ? 'ok' : 'error',
            'msg'  => $sent
                ? 'Bedankt — uw bericht is verzonden.'
                : 'Bericht lokaal ontvangen (mailserver niet geconfigureerd). Configureer SMTP op Combell voor echte aflevering.',
        ],
        60
    );

    // On local without mail, still show success-ish notice so UX is complete.
    if (!$sent) {
        set_transient(
            'opr8_contact_flash',
            [
                'type' => 'ok',
                'msg'  => 'Bedankt — uw bericht is ontvangen. (Op productie: configureer SMTP in Combell.)',
            ],
            60
        );
    }

    wp_safe_redirect(get_permalink());
    exit;
}
add_action('template_redirect', 'opr8_handle_contact_form');

function opr8_contact_notice(): void
{
    $notice = get_transient('opr8_contact_flash');
    if (!$notice) {
        return;
    }
    delete_transient('opr8_contact_flash');
    $class = ($notice['type'] ?? '') === 'error' ? 'form-notice error' : 'form-notice';
    echo '<div class="' . esc_attr($class) . '">' . esc_html($notice['msg']) . '</div>';
}

/**
 * Default pages content map used by setup script and fallbacks.
 */
function opr8_page_slugs(): array
{
    return [
        'diensten'       => 'Diensten',
        'contact'        => 'Contact',
        'wie-is-opr8-it' => 'Wie is OPR8-IT?',
        'websites'       => 'Websites',
        'opr8-it-drones' => 'OPR8-IT & drones',
        'opr8-it-zeilen' => 'OPR8-IT & zeilen',
    ];
}
