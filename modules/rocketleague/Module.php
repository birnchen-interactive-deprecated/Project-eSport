<?php

namespace app\modules\rocketleague;

use Yii;

/**
 * Class Module
 * @package app\modules\rocketleague
 */
 class Module extends \yii\base\Module
 {
 	public function init()
 	{
 		parent::init();

 		$this->registerTranslations();
 	}

 	/**
 	 * Register the module translation
 	 */
 	public function registerTranslations()
 	{
 		Yii::$app->i18n->translations['modules/rocketleague/*'] = [
 			'class' => 'yii\i18n\PhpMessageSource',
 			'sourceLanguage' => 'de',
 			'basePath' => '@app/modules/rocketleague/messages',
 			'fileMap' => [
 				'modules/rocketleague/overview' => 'overview.php',
 				//'modules/user/login' => 'login.php',
 				//'modules/user/register' => 'register.php',
 				//'modules/user/account' => 'account.php',
 				//'modules/user/userDetails' => 'userDetails.php',
 			],
 		];

 		Yii::$app->i18n->translations['modules/rocketleague/*'] = [
 			'class' => 'yii\i18n\PhpMessageSource',
 			'sourceLanguage' => 'en',
 			'basePath' => '@app/modules/rocketleague/messages',
 			'fileMap' => [
 				'modules/rocketleague/overview' => 'overview.php',
 				//'modules/user/login' => 'login.php',
 				//'modules/user/register' => 'register.php',
 				//'modules/user/account' => 'account.php',
 				//'modules/user/userDetails' => 'userDetails.php',
 			],
 		];
 	}

 	/**
     * @inheritdoc
     */
 	public static function t($category, $message, $language = null, $params = [])
 	{
 		return Yii::t('modules/rocketleague/' . $category, $message, $params, $language);
 	}
 }