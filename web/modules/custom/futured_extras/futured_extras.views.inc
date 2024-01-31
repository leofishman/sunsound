<?php

/**
 * Implements hook_views_data_alter().
 */
function futured_extras_views_data_alter(array &$data) {


// $data['group_field_data']['nodes_titles'] = [
//   'title' => t('Nodes title'),
//   'help' => t('Nodes title'),
//   'group' => t('group'),
//   'filter' => [
//     'id' => 'string',
//     'field' => 'title',
//     'table' => 'group_field_data',
//     'operator' => 'CONTAINS',
//   ],
// ];



// $data['taxonomy_term_field_data']['field_teacher_name_for_filter'] = [
//     'title' => t('Teacher name for filter'),
//     'help' => t('Teacher name for filter'),
//     'field' => [
//       'id' => 'field_teacher_name_for_filter',
//     ],
//     'filter' => [
//       'id' => 'taxonomy_index_tid',
//       'field_name' => 'field_teacher_name_for_filter',
//     ],
//     'argument' => [
//       'id' => 'taxonomy_index_tid',
//       'field_name' => 'field_teacher_name_for_filter',
//     ],
//   ];
//   $data['taxonomy_term_field_data']['field_institution_name_for_filte'] = [
//     'title' => t('Institution name for filter'),
//     'help' => t('Institution name for filter'),
//     'field' => [
//       'id' => 'field_institution_name_for_filte',
//     ],
//     'filter' => [
//       'id' => 'taxonomy_index_tid',
//       'field_name' => 'field_institution_name_for_filte',
//     ],
//     'argument' => [
//       'id' => 'taxonomy_index_tid',
//       'field_name' => 'field_institution_name_for_filte',
//     ],
//   ];
  $data['group__field_institution']['institutions_titles'] = [
    'title' => t('Institution'),
    'help' => t('Institution title'),
    'group' => t('group'),
    'filter' => [
      'id' => 'futured_extras_institutions',
      'field' => 'field_institution_target_id',
      'table' => 'group__field_institution',
      'operator' => 'CONTAINS',
    ],
  ];

  $data['group__field_teacher']['teachers_titles'] = [
    'title' => t('Teacher'),
    'help' => t('Teacher title'),
    'group' => t('group'),
    'filter' => [
      'id' => 'futured_extras_teachers',
      'field' => 'field_teacher_target_id',
      'table' => 'group__field_teacher',
      'operator' => 'CONTAINS',
    ],
  ];

}
