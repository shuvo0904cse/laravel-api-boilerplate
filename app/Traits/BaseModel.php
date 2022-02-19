<?php
namespace App\Traits;

use App\Helpers\Utils;

trait BaseModel
{
    use UsesUuid, CreatedUpdatedBy;

    /**
     * lists
     */
    public function lists($request = [])
    {
        return $this->query()
                    ->ofRelationWith($request)
                    ->ofSearch($request)
                    ->ofOrderBy($request)
                    ->ofList($request);
    }

    /**
     * relation
     */
    public function scopeOfRelationWith($query, $request = [])
    {
          if(isset($request['relation'])) return $query->with($request['relation']);
    }

    /**
     * Search
     */
    public function scopeOfSearch($query, $request = [])
    {
        $fields = isset($request['search']['fields']) ? $request['search']['fields'] : [];
        $search = isset($request['search']['value']) ? $request['search']['value'] : "";

        if (!empty($fields) && !empty($search)) {
            foreach ($fields as $relation => $field) {
                if(is_string($search)) $search = [$search];
                
                if (is_array($field)) {
                    $query->orWhereHas($relation, function ($q) use ($field, $search) {
                        $q->where(function ($q) use ($field, $search) {
                            foreach ($field as $relatedField) {
                                foreach ($search as $term) {
                                    $q->orWhere($relatedField, 'like', "%{$term}%");
                                }
                            }
                        });
                    });
                } else {
                    foreach ($search as $term) {
                        $query->orWhere($field, 'like', "%{$term}%");
                    }
                }
            }
            return $query;
        }
    }

    /**
     * order by
     */
    public function scopeOfOrderBy($query, $request = [])
    {
          $column = isset($request['order_by']['column']) ? $request['order_by']['column'] : "id";
          $pattern = isset($request['order_by']['pattern']) ? $request['order_by']['pattern'] : "ASC";    

          return $query->orderBy($column, $pattern);
    }

     /**
     * List
     */
    public function scopeOfList($query, $request = [])
    {
          if(isset($request['is_paginate']) && $request['is_paginate'] == true){
              return $query->paginate(config("settings.pagination_per_page"));
          } 
          return $query->get();
    }

    /**
     * Pagination
     */
    public function pagination($items, $paginate)
    {
        return [
          "data"      => $items,
          "paginate"  => Utils::getPaginate($paginate)
      ];
    }
}
