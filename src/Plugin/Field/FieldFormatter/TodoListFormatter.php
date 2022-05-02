<?php

namespace Drupal\systemseed_assessment\Plugin\Field\FieldFormatter;

use Drupal\Component\Serialization\Json;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'ToDo List' formatter.
 *
 * @FieldFormatter(
 *   id = "systemseed_assessment_todo_list",
 *   label = @Translation("ToDo List"),
 *   field_types = {
 *     "entity_reference_revisions"
 *   }
 * )
 */
class TodoListFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $todo_list = [];

    /** @var \Drupal\entity_reference_revisions\Plugin\Field\FieldType\EntityReferenceRevisionsItem $item */
    foreach ($items as $item) {
      /** @var \Drupal\paragraphs\ParagraphInterface $paragraph */
      $paragraph = $item->entity;
      // Ensure the paragraph entity exists and the bundle is the one we
      // expect. Normally the widget should throw warning for other bundles,
      // but for sake of the assessment it can be simplified.
      if (empty($paragraph) || $paragraph->bundle() !== 'to_do_item') {
        continue;
      }

      // Sanity check. Ensure that the paragraph bundle contains the expected
      // fields.
      if (!$paragraph->hasField('field_completed') || !$paragraph->hasField('field_label')) {
        continue;
      }

      /** @var \Drupal\Core\Field\Plugin\Field\FieldType\BooleanItem $completed */
      $completed = $paragraph->get('field_completed')->getString();

      /** @var \Drupal\text\Plugin\Field\FieldType\TextLongItem $label */
      $label = $paragraph->get('field_label')->first()->getValue();

      $todo_list[] = [
        'id' => (int) $paragraph->id(),
        'completed' => (bool) $completed,
        'label' => !empty($label) ? check_markup($label['value'], $label['format']) : '',
      ];
    }

    return [
      '#type' => 'html_tag',
      '#tag' => 'div',
      '#attributes' => [
        'id' => 'todo-list',
        'data-todo-list' => Json::encode($todo_list),
      ],
    ];
  }

}
