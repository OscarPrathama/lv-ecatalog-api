<?php


/**
 * Default data filtering
 *
 * @param array $filterData(int perPage, string search, string orderBy, string desc)
 * @return array
 */
function dataFiltering(array $filterData): array{
    $defaultArgs = [
        'perPage'   => 20,
        'search'    => '',
        'orderBy'   => 'id',
        'order'     => 'desc'  
    ];

    return array_merge($defaultArgs, $filterData);
}

?>