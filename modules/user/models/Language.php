<?php

namespace app\modules\user\models;

use yii\db\ActiveRecord;

/**
 * Class Language
 * @package app\modules\user\models
 *
 * @property int $id
 * @property string $name
 * @property string $locale
 */
class Language extends ActiveRecord
{
	/**
	 * @return int id
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return string name
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @return string name
	 */
	public function getLocale()
	{
		return $this->locale;
	}

	/**
     * Finds Language by localee.
     *
     * @param string $Selectedlocale the locale
     * @return static|null the language, if a language with that Selectedlocale exists
     */
    public static function findByLocale($Selectedlocale)
    {
        return static::findOne(['locale' => $Selectedlocale]);
    }
}