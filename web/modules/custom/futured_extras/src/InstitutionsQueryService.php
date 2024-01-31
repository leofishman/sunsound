<?php

namespace Drupal\futured_extras;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Cache\CacheBackendInterface;

class institutionsQueryService {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The cache backend.
   *
   * @var \Drupal\Core\Cache\CacheBackendInterface
   */
  protected $cacheBackend;

  /**
   * institutionsQueryService constructor.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   The cache backend.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager, CacheBackendInterface $cache_backend) {
    $this->entityTypeManager = $entity_type_manager;
    $this->cacheBackend = $cache_backend;
  }

  private function create()

  /**
 * Runs the custom query and returns the result.
 *
 * @return array
 *   The query result.
 */
public function runCustomQuery() {
  $cache_key = 'custom_query_result';

  if ($cache = $this->cacheBackend->get($cache_key)) {
    return $cache->data;
  }

  // Build the query using the EntityQuery API.
  $query = $this->entityTypeManager->getStorage('node')->getQuery();
  $query->distinct(TRUE)
    ->condition('status', 1)
    ->condition('type', 'entity_')
    ->condition('langcode', 'es')
    ->condition('field_institution', 6) // Replace with the actual term ID
    ->sort('sticky', 'DESC')
    ->sort('promote', 'DESC')
    ->sort('changed', 'DESC')
    ->sort('created', 'DESC');

  $nids = $query->execute();

  // Load the nodes.
  $nodes = $this->entityTypeManager->getStorage('node')->loadMultiple($nids);

  $result = [];
  foreach ($nodes as $node) {
    // Replace 'field_institution' with the actual field name.
    $institution_values = $node->get('field_institution')->getValue();
    foreach ($institution_values as $value) {
      $result[] = [
        'nid' => $node->id(),
        'title' => $node->getTitle(),
      ];
    }
  }

  // Cache the result for the maximum time (e.g., 1 hour).
  $this->cacheBackend->set($cache_key, $result, CacheBackendInterface::CACHE_PERMANENT, ['futured']);

  return $result;
}
  
}
