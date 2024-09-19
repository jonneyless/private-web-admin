<?php

namespace App\Models;

class BusinessIntro extends BaseModel
{
    protected $table = "business_intro";

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id', 'id');
    }

    public function getKeywordsAttribute($value)
    {
        return join(",", array_values(json_decode($value, true) ? : []));
    }

    public function setKeywordsAttribute($value)
    {

        if ($value) {
            $value = array_values(explode(",", $value));
        } else {
            $value = [];
        }

        $this->attributes['keywords'] = json_encode($value);
    }

    public function getButtonsAttribute($value)
    {
        return array_values(json_decode($value, true) ? : []);
    }

    public function setButtonsAttribute($value)
    {

        if ($value) {
            $value = array_values($value);
        } else {
            $value = [];
        }

        $this->attributes['buttons'] = json_encode($value);
    }
}