<?php

namespace Drupal\cpg_register\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Controller for the Dictionary page.
 */
class DictionaryController extends ControllerBase {

  /**
   * Returns the dictionary page content.
   */
  public function content() {
    // Load all dictionary_term nodes, sorted by title
    $query = \Drupal::entityTypeManager()->getStorage('node')->getQuery()
      ->condition('type', 'dictionary_term')
      ->condition('status', 1)
      ->sort('title', 'ASC')
      ->accessCheck(TRUE);
    $nids = $query->execute();
    $nodes = \Drupal::entityTypeManager()->getStorage('node')->loadMultiple($nids);

    // Group terms by first letter
    $grouped_terms = [];
    foreach ($nodes as $node) {
      $title = $node->getTitle();
      $letter = strtoupper(substr($title, 0, 1));
      // Handle non-alpha chars
      if (!ctype_alpha($letter)) {
        $letter = '#';
      }

      $category = '';
      $category_class = '';
      if ($node->hasField('field_dict_category') && !$node->get('field_dict_category')->isEmpty()) {
        $term = $node->get('field_dict_category')->entity;
        if ($term) {
          $category = $term->getName();
          $category_class = strtolower(str_replace(' ', '-', $category));
        }
      }

      $grouped_terms[$letter][] = [
        'title' => $title,
        'full_name' => $node->hasField('field_dict_full_name') ? $node->get('field_dict_full_name')->value : '',
        'body' => $node->hasField('body') ? $node->get('body')->value : '',
        'example' => $node->hasField('field_dict_example') ? $node->get('field_dict_example')->value : '',
        'also_known' => $node->hasField('field_dict_also_known') ? $node->get('field_dict_also_known')->value : '',
        'related_link_url' => $node->hasField('field_dict_related_link') && !$node->get('field_dict_related_link')->isEmpty() ? $node->get('field_dict_related_link')->first()->getUrl()->toString() : '',
        'related_link_title' => $node->hasField('field_dict_related_link') && !$node->get('field_dict_related_link')->isEmpty() ? $node->get('field_dict_related_link')->first()->title : '',
        'category' => $category,
        'category_class' => $category_class,
        'nid' => $node->id(),
      ];
    }

    // Sort by letter key
    ksort($grouped_terms);

    // Get all available letters
    $available_letters = array_keys($grouped_terms);

    // Load all categories
    $cat_terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadByProperties([
      'vid' => 'dictionary_category',
    ]);
    $categories = [];
    foreach ($cat_terms as $term) {
      $categories[] = $term->getName();
    }
    sort($categories);

    $config = \Drupal::config('cpg_register.settings');
    $title = $config->get('dict_title') ?? 'CPG Industry Dictionary';
    $subtitle = $config->get('dict_subtitle') ?? 'Your comprehensive guide to consumer packaged goods terminology. From basic concepts to advanced industry jargon, we\'ve got you covered.';

    $build = [
      '#theme' => 'cpg_dictionary_page',
      '#grouped_terms' => $grouped_terms,
      '#available_letters' => $available_letters,
      '#categories' => $categories,
      '#total_count' => count($nids),
      '#title' => $title,
      '#subtitle' => $subtitle,
      '#attached' => [
        'library' => ['cpg_theme/global-styling'],
      ],
      '#cache' => ['max-age' => 0],
    ];

    return $build;
  }

}
