<?php
namespace App\Traits;
trait SecureDelete{
    public function secureDelete($relations){
        $ignore_relations = ['BelongsTo'];
        foreach ($relations as $relation_name=>$relation) {
            if(in_array($relation['type'],$ignore_relations)){
                continue;
            }
            if ($this->$relation_name()->count()) {
                return false;
            }
        }


        $this->delete();
        return true;
    }
}
