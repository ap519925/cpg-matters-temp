<?php

/**
 * @file
 * Theme settings form for CPG Matters theme.
 *
 * Adds custom admin settings to Appearance → CPG Matters Theme → Settings
 * that allow site admins to control brand colors and key design tokens
 * without touching code.
 */

/**
 * Implements hook_form_system_theme_settings_alter().
 */
function cpg_theme_form_system_theme_settings_alter(&$form, \Drupal\Core\Form\FormStateInterface $form_state) {

  $form['cpg_design'] = [
    '#type' => 'details',
    '#title' => t('CPG Design Settings'),
    '#open' => TRUE,
    '#weight' => -10,
  ];

  // ── Brand Colors ──
  $form['cpg_design']['cpg_brand_color'] = [
    '#type' => 'textfield',
    '#title' => t('Primary Brand Color (hex)'),
    '#description' => t('Main accent color used for headers, buttons, links, and CTA elements. Default: #C41E3A'),
    '#default_value' => theme_get_setting('cpg_brand_color') ?? '#C41E3A',
    '#size' => 10,
    '#maxlength' => 7,
    '#attributes' => ['pattern' => '#[0-9a-fA-F]{6}'],
  ];

  $form['cpg_design']['cpg_brand_color_dark'] = [
    '#type' => 'textfield',
    '#title' => t('Brand Color Dark (hex)'),
    '#description' => t('Darker shade of the brand color, used for hover states. Default: #9B1730'),
    '#default_value' => theme_get_setting('cpg_brand_color_dark') ?? '#9B1730',
    '#size' => 10,
    '#maxlength' => 7,
  ];

  $form['cpg_design']['cpg_text_color'] = [
    '#type' => 'textfield',
    '#title' => t('Primary Text Color (hex)'),
    '#description' => t('Main body text color. Default: #1A1A1A'),
    '#default_value' => theme_get_setting('cpg_text_color') ?? '#1A1A1A',
    '#size' => 10,
    '#maxlength' => 7,
  ];

  $form['cpg_design']['cpg_footer_bg'] = [
    '#type' => 'textfield',
    '#title' => t('Footer Background Color (hex)'),
    '#description' => t('Background color of the footer. Default: #1A1A1A'),
    '#default_value' => theme_get_setting('cpg_footer_bg') ?? '#1A1A1A',
    '#size' => 10,
    '#maxlength' => 7,
  ];

  $form['cpg_design']['cpg_header_border_width'] = [
    '#type' => 'number',
    '#title' => t('Header Border Width (px)'),
    '#description' => t('Width of the red accent line under the header. Default: 4'),
    '#default_value' => theme_get_setting('cpg_header_border_width') ?? 4,
    '#min' => 0,
    '#max' => 10,
  ];

  // ── Card Settings ──
  $form['cpg_cards'] = [
    '#type' => 'details',
    '#title' => t('Card & Directory Styling'),
    '#open' => FALSE,
    '#weight' => -5,
  ];

  $form['cpg_cards']['cpg_directory_card_bg'] = [
    '#type' => 'textfield',
    '#title' => t('Directory Card Background (hex)'),
    '#description' => t('Background color of directory listing cards. Default: #E8F1FC (light blue)'),
    '#default_value' => theme_get_setting('cpg_directory_card_bg') ?? '#E8F1FC',
    '#size' => 10,
    '#maxlength' => 7,
  ];

  $form['cpg_cards']['cpg_whitepapers_card_bg'] = [
    '#type' => 'textfield',
    '#title' => t('White Papers Card Background (hex)'),
    '#description' => t('Background color of white paper cards. Default: #FFFFFF'),
    '#default_value' => theme_get_setting('cpg_whitepapers_card_bg') ?? '#FFFFFF',
    '#size' => 10,
    '#maxlength' => 7,
  ];

  // ── Social / Contact Links ──
  $form['cpg_social'] = [
    '#type' => 'details',
    '#title' => t('Social Media & Contact'),
    '#open' => FALSE,
    '#weight' => 0,
  ];
  
  // ── Social Share Toggles ──
  $form['cpg_social']['cpg_share_heading'] = [
    '#markup' => '<h3>' . t('Social Share Icons on Article Teasers') . '</h3><p>' . t('Toggle which share icons appear on article teaser cards.') . '</p>',
  ];
  $form['cpg_social']['cpg_share_twitter'] = [
    '#type' => 'checkbox',
    '#title' => t('Show X (Twitter) share icon'),
    '#default_value' => theme_get_setting('cpg_share_twitter') ?? TRUE,
  ];
  $form['cpg_social']['cpg_share_facebook'] = [
    '#type' => 'checkbox',
    '#title' => t('Show Facebook share icon'),
    '#default_value' => theme_get_setting('cpg_share_facebook') ?? TRUE,
  ];
  $form['cpg_social']['cpg_share_linkedin'] = [
    '#type' => 'checkbox',
    '#title' => t('Show LinkedIn share icon'),
    '#default_value' => theme_get_setting('cpg_share_linkedin') ?? TRUE,
  ];
  $form['cpg_social']['cpg_share_email'] = [
    '#type' => 'checkbox',
    '#title' => t('Show Email share icon'),
    '#default_value' => theme_get_setting('cpg_share_email') ?? TRUE,
  ];


  $form['cpg_social']['cpg_phone_number'] = [
    '#type' => 'textfield',
    '#title' => t('Phone Number'),
    '#description' => t('Displayed in the header and mobile drawer. Leave empty to hide.'),
    '#default_value' => theme_get_setting('cpg_phone_number') ?? '',
    '#size' => 20,
  ];

  $form['cpg_social']['cpg_twitter_url'] = [
    '#type' => 'url',
    '#title' => t('Twitter / X URL'),
    '#default_value' => theme_get_setting('cpg_twitter_url') ?? '',
  ];

  $form['cpg_social']['cpg_facebook_url'] = [
    '#type' => 'url',
    '#title' => t('Facebook URL'),
    '#default_value' => theme_get_setting('cpg_facebook_url') ?? '',
  ];

  $form['cpg_social']['cpg_linkedin_url'] = [
    '#type' => 'url',
    '#title' => t('LinkedIn URL'),
    '#default_value' => theme_get_setting('cpg_linkedin_url') ?? '',
  ];
}
