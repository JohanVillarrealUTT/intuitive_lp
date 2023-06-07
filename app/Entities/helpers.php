<?php

use Illuminate\Support\Facades\Input;

function sortSubscribersBy($column)
{
    $direction = (Input::get('direction') == 'desc') ? 'asc' : 'desc';
    
    $rows_by_page = Input::get('rowsByPage');
    if(!isset($rows_by_page))
		$rows_by_page = 15;

    $type = Input::get('type');
    if(!isset($type))
		$type = 'all';

    return route('admin.index', [
        'sortBy' => $column,
        'direction' => $direction,
        'rowsByPage' => $rows_by_page,
        'type' => $type
    ]);
}
