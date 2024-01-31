<?php

namespace Drupal\futured_extras;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Cache\CacheBackendInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class EntitiesQueryService {

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
   * entitiesQueryService constructor.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   The cache backend.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }
  
  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager'),
      );
  }
  /**
 * Runs the custom query and returns the result.
 *
 * @return array
 *   The query result.
 */

public function runCustomQuery($term) {
 
 // TODO Add caching.
  // $cache_key = 'custom_query_result';

  // if ($cache = $this->cacheBackend->get($cache_key)) {
  //   return $cache->data;
  // }
  // Build the query using the EntityQuery API.
  $query = $this->entityTypeManager->getStorage('node')->getQuery();
  $query->condition('status', 1)
    ->condition('type', 'entity_')
    ->condition('langcode', \Drupal::languageManager()->getCurrentLanguage()->getId())
    ->condition('field_entity_type', $term) 
    ->sort('title', 'ASC');
  $nids = $query->execute();

  $result = [];
  foreach ($nids as $nid) {
    $node = $this->entityTypeManager->getStorage('node')->load($nid);

    if ($node->hasTranslation(\Drupal::languageManager()->getCurrentLanguage()->getId())) {
      $translated_entity = $node->getTranslation(\Drupal::languageManager()->getCurrentLanguage()->getId());
      $result[$nid] = $translated_entity->getTitle();
    } else {
     $result[$nid] = $node->getTitle();
    }

  }
  // Cache the result for the maximum time (e.g., 1 hour).
 // $this->cacheBackend->set($cache_key, $result, CacheBackendInterface::CACHE_PERMANENT, ['futured']);
  return $result;
}
  
}
