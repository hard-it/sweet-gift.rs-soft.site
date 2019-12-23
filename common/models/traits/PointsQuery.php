<?php

namespace common\models\traits;

trait PointsQuery
{
    public function getLatLng(string $fieldName)
    {
        $fieldName = $fieldName ?? $this->geoPointName;
        $this->addSelect(new Expression("ST_X([[{$fieldName}]]) as geoLat"));
        $this->addSelect(new Expression("ST_Y([[{$fieldName}]]) as geoLng"));

        return $this;
    }
}
