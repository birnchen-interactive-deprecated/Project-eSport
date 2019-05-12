<?php

namespace app\modules\user\models;

use yii\db\ActiveRecord;

/**
 * Class Gender
 * @package app\modules\user\models
 *
 * @property int $id
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
	 * @return string name
	 */
	public function getName()
	{
		return $this->name;
	}
}