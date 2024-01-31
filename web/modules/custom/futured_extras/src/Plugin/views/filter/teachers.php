<?php

namespace Drupal\futured_extras\Plugin\views\filter;

use Drupal\views\Plugin\views\display\DisplayPluginBase;
use Drupal\views\Plugin\views\filter\InOperator;
use Drupal\views\ViewExecutable;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Filters by given list of teachers.
 *
 * @ingroup views_filter_handlers
 *
 * @ViewsFilter("futured_extras_teachers")
 */
class Teachers extends InOperator {

 /**
  * entitiesQueryService
  */
  protected $entitiesQueryService;

  /**
   * {@inheritdoc}
   */  
  public function __construct(array $configuration, $plugin_id, $plugin_definition, \Drupal\futured_extras\EntitiesQueryService $entitiesQueryService) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entitiesQueryService = $entitiesQueryService;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('futured_extras.entitiesQueryService')
      );
  }

 /**
   * {@inheritdoc}
   */
  public function init(ViewExecutable $view, DisplayPluginBase $display, array &$options = NULL) {
    parent::init($view, $display, $options);
    $this->valueTitle = t('Instructor');
    $this->definition['options callback'] = array($this, 'generateTeachersOptions');

  }

  /**
   * Override the query so that no filtering takes place if the user doesn't
   * select any options.
   */
  public function query() {
    if (!empty($this->value)) {
      parent::query();
    }
  }

  /**
   * Skip validation if no options have been chosen so we can use it as a
   * non-filter.
   */
  public function validate() {
    if (!empty($this->value)) {
      parent::validate();
    }
  }

  /**
   * Helper function that generates the options.
   * @return array
   */
  public function generateTeachersOptions() {
    return $this->entitiesQueryService->runCustomQuery(7);
  }
}
