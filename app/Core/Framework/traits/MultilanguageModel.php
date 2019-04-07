<?php

namespace App\Core\Framework\Traits;

trait MultilanguageModel {

//    protected $multilanguageModels = [];

//    protected $translatable = [];

//    public function getOriginalTable()
//    {
//        return parent::getTable();
//    }
//
//    public function getTable()
//    {
//        return 'en_'. $this->getTable();
//    }

    public function __get($key)
    {
        return $this->getMultilangAttribute($key);
    }

    public function getMultilangAttribute($key)
    {


        if (! $key) {
            return;
        }

        // If the attribute exists in the attribute array or has a "get" mutator we will
        // get the attribute's value. Otherwise, we will proceed as if the developers
        // are asking for a relationship's value. This covers both types of values.
        if (array_key_exists($key, $this->attributes) ||
            $this->hasGetMutator($key)) {
            return $this->getAttributeValue($key);
        }

        // Here we will determine if the model base class itself contains this given key
        // since we do not want to treat any of those methods are relationships since
        // they are all intended as helper methods and none of these are relations.
        if (method_exists(self::class, $key)) {
            return;
        }

        return $this->getRelationValue($key);
    }
}