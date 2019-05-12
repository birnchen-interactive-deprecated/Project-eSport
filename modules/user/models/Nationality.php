<?php

namespace app\modules\user\models;

use yii\db\ActiveRecord;

/**
 * Class Nationality
 * @package app\modules\user\models
 *
 * @property int $id
 * @property string $name
 * @property string $synonym_m
 * @property string $synonym_w
 * @property string $synonym_d
 */
class Nationality extends ActiveRecord
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
	 * @return string synonym_m
	 */
	public function getSynonymeM()
	{
		return $this->synonym_m;
	}

	/**
	 * @return string synonym_w
	 */
	public function getSynonymeW()
	{
		return $this->synonym_w;
	}

	/**
	 * @return string synonym_d
	 */
	public function getSynonymeD()
	{
		return $this->synonym_d;
	}
}