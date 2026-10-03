<?php

declare(strict_types=1);

namespace Drupal\openy_home_branch\Attribute;

use Drupal\Component\Plugin\Attribute\Plugin;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Defines a home branch library attribute object.
 *
 * @see \Drupal\openy_home_branch\Annotation\HomeBranchLibrary
 * @see \Drupal\openy_home_branch\HomeBranchLibraryManager
 * @see \Drupal\openy_home_branch\HomeBranchLibraryInterface
 * @see plugin_api
 */
#[\Attribute(\Attribute::TARGET_CLASS)]
class HomeBranchLibrary extends Plugin {

  /**
   * Constructs a HomeBranchLibrary attribute.
   *
   * @param string $id
   *   The home_branch_library plugin ID.
   * @param \Drupal\Core\StringTranslation\TranslatableMarkup $title
   *   The human-readable name of the home_branch_library plugin.
   * @param string $entity
   *   The home_branch_library plugin entity. For this entity will be
   *   attached library that referenced in plugin.
   */
  public function __construct(
    public readonly string $id,
    public readonly TranslatableMarkup $title,
    public readonly string $entity,
  ) {}

}
