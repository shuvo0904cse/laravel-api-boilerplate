<?php
namespace App\Helpers;


class Utils
{
    /**
     * get Paginate
    */
    public static function getPaginate($list){
        return [
            "total"             => $list->total(),
            "per_page"          => $list->perPage(),
            "current_page"      => $list->currentPage(),
            "last_page"         => $list->lastPage(),
            "first_page_url"    => $list->url(1),
            "last_page_url"     => $list->url($list->lastPage()),
            "next_page_url"     => $list->nextPageUrl(),
            "prev_page_url"     => $list->previousPageUrl()
        ];
    }
}
