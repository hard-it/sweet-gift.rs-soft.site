<?php

namespace common\models\traits;

trait Images
{
    /**
     * @param bool $insert
     *
     * @return bool
     */
    public function beforeSave($insert)
    {
        $images    = $this->Images ?? [];
        $tmpImages = [];
        foreach ($images as $key => $image) {
            $tmpImages[$image['order'] ?? $key] = $image;
        }
        $this->Images = $tmpImages;

        return parent::beforeSave($insert);
    }
}