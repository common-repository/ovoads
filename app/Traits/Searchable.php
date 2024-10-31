<?php

namespace Ovoads\Traits;

trait Searchable
{

    public function scopeSearchable($query,$param,$like = true){
        $search = ovoads_request()->search;
        if (!$search) {
            return $query;
        }
        $search = $like ? "%$search%" : $search;
        return $query->where($param,"LIKE",$search);
    }

    public function scopeFilter($query,$params){
        foreach ($params as $param) {
            $relationData = explode(':', $param);
            $filters = array_keys(ovoads_request()->all());
            $column = $param;
            if (@$relationData[1]) {
                $this->relationFilter($query,$relationData[0],$relationData[1],$filters);
            }else{
                if (in_array($column, $filters) && ovoads_request()->$column != null) {
                    if(gettype(ovoads_request()->$column) =='array'){
                        $query->whereIn($column, ovoads_request()->$column);
                    }else{
                        $query->where($column, ovoads_request()->$column);
                    }
                }
            }
        }
    }


    private function relationFilter($query,$relation,$columns,$filters){
        foreach (explode(',', $columns) as $column) {
            if (in_array($relation, $filters) && ovoads_request()->$relation != null) {
                $query->whereHas([$relation=>function($q) use ($column,$relation){
                    return $q->where($column,ovoads_request()->$relation);
                }]);
            }
        }
    }
}