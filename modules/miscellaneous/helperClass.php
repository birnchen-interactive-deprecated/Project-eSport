<?php

namespace app\modules\miscellaneous;

use Yii;

/**
 * Class HelperClass
 * @package app\modules\core\miscellaneous
 */
class helperClass
{
    /**
     * HelperClass constructor.
     */
    public function __construct()
    {

    }

    /**
     * @param $imagePath
     * @return string
     */
    public function checkImage($imagePath, $id)
    {
        $imagePath = Yii::getAlias("@web") . $imagePath;

        if (!is_file($_SERVER['DOCUMENT_ROOT'] . $imagePath . $id . '.webp')) {
            if (!is_file($_SERVER['DOCUMENT_ROOT'] . $imagePath . $id .'.png')) {
                return $imagePath . 'default';
            }
        }

        return $imagePath . $id;
    }
}