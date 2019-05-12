<?php

namespace app\modules\user\models;

use yii\db\ActiveRecord;

/**
 * Class Language_i18n
 * @package app\modules\user\models
 *
 * @property int $id
 * @property int $language_id
 * @property string $name
 */
class Gender extends ActiveRecord
{
	/**
	 * @return int id
	 */
	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * @return int language_id
	 */
	public function getLanguageId()
	{
		return $this->language_id;
	}

	/**
	 * @return string name
	 */
	public function getName()
	{
		return $this->name;
	}
}