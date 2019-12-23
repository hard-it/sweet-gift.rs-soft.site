<?php

namespace common\models\traits;

trait Points
{
    protected $geoPointName  = '';
    private   $strCoordinate = '';
    private   $geoLat        = 0.00;
    private   $geoLng        = 0.00;

    /**
     * @param $insert
     *
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $geoPointName         = $this->geoPointName;
            $this->strCoordinates = $this->$geoPointName;
            [$latitude, $longitude] = explode(',', $this->$geoPointName);
            $this->$geoPointName = new Expression("POINT({$latitude},{$longitude})");

            return true;
        } else {
            return false;
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $geoPointName        = $this->geoPointName;
        $this->$geoPointName = $this->strCoordinates;
    }

    public function afterFind()
    {
        parent::afterFind();
        $geoPointName        = $this->geoPointName;
        $this->$geoPointName = implode(',', [$this->geoLat, $this->geoLng]);
    }
}
