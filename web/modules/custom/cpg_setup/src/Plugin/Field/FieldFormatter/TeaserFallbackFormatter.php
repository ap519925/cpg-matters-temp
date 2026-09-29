<?php

namespace Drupal\cpg_setup\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Component\Utility\Html;

/**
 * Plugin implementation of the 'teaser_fallback' formatter.
 *
 * @FieldFormatter(
 *   id = "teaser_fallback",
 *   label = @Translation("Teaser Text (with 25-word Body Fallback)"),
 *   field_types = {
 *     "string",
 *     "string_long",
 *     "text",
 *     "text_long",
 *     "text_with_summary"
 *   }
 * )
 */
class TeaserFallbackFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];
    $has_value = FALSE;

    // Check if the current field (e.g. field_teaser) has a value.
    foreach ($items as $delta => $item) {
      if (!empty($item->value)) {
        $text = $item->value;
        // If it's a formatted text field, render it normally.
        if (isset($item->format)) {
          $elements[$delta] = [
            '#type' => 'processed_text',
            '#text' => $text,
            '#format' => $item->format,
            '#langcode' => $item->getLangcode(),
          ];
        } else {
          $elements[$delta] = [
            '#markup' => nl2br(Html::escape($text)),
          ];
        }
        $has_value = TRUE;
      }
    }

    // If there's no teaser entered, fallback to the article body.
    if (!$has_value) {
      $entity = $items->getEntity();
      if ($entity->hasField('body') && !$entity->get('body')->isEmpty()) {
        $body_text = $entity->get('body')->value;
        
        // Strip tags correctly and securely (prevent word merging).
        $text = str_replace('<', ' <', $body_text);
        $text = strip_tags($text);
        $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
        $text = trim(preg_replace('/\s+/', ' ', $text));
        
        // Trim to 25 words
        $words = explode(' ', $text);
        if (count($words) > 25) {
          $text = implode(' ', array_slice($words, 0, 25)) . '...';
        } else {
          $text = implode(' ', $words);
        }

        $elements[0] = [
          '#markup' => '<p>' . Html::escape($text) . '</p>',
        ];
      }
    }

    return $elements;
  }

}
