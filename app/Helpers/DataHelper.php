<?php
if(!function_exists('dataFiltering')){
    function dataFiltering(array $filterData): array{
        $defaultArgs = [
            'perPage'   => 10,
            'search'    => '',
            'orderBy'   => 'id',
            'order'     => 'desc'  
        ];
    
        return array_merge($defaultArgs, $filterData);
    }
}

?>