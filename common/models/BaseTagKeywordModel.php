<?php

namespace common\models;

use yii\db\ActiveRecord;

class BaseTagKeywordModel extends ActiveRecord
{

    /**
     * @return bool
     */
    public function saveTags()
    {
        $tags = $this->Tags ?? null;

        if (isset($tags) && is_array($tags)) {
            foreach ($tags as $tag) {
                $model = Tag::find()->having(['Name' => $tag])->one();
                if (!$model) {
                    $model       = new Tag();
                    $model->Name = $tag;
                    if (!$model->save()) {
                        return false;
                    }
                }
            }
        }

        return true;
    }

    /**
     * @return bool
     */
    public function saveKeywords()
    {
        $keywords = $this->Keywords ?? null;

        if (isset($keywords) && is_array($keywords)) {
            foreach ($keywords as $keyword) {
                $model = Keyword::find()->having(['Name' => $keyword])->one();
                if (!$model) {
                    $model       = new Keyword();
                    $model->Name = $keyword;
                    if (!$model->save()) {
                        return false;
                    }
                }
            }
        }

        return true;
    }

    /**
     * @param bool $runValidation
     * @param null $attributeNames
     *
     * @return bool
     * @throws \yii\db\Exception
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        try {

            $transaction = static::getDb()->beginTransaction();

            $affected = parent::save($runValidation, $attributeNames);

            if (!$affected) {
                $transaction->rollBack();

                return false;
            }

            if (!$this->saveKeywords()) {
                $transaction->rollBack();

                return false;
            }

            if (!$this->saveTags()) {
                $transaction->rollBack();

                return false;
            }

            $transaction->commit();

        } catch (Exception $e) {
            throw $e;
        } catch (Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }

        return true;
    }

}
