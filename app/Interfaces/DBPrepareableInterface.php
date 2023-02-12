<?php

namespace App\Interfaces;

interface DBPrepareableInterface{
    
    public function prepareForDB(array $data): array;

}
?>