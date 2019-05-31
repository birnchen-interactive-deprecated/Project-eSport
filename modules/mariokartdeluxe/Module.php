<?php

namespace app\modules\mariokartdelyxe;

use Yii;

/**
 * Class Module
 * @package app\modules\mariokartdelyxe
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
 		Yii::$app->i18n->translations['modules/mariokartdelyxe/*'] = [
 			'class' => 'yii\i18n\PhpMessageSource',
 			'sourceLanguage' => 'de',
 			'basePath' => '@app/modules/mariokartdelyxe/messages',
 			'fileMap' => [
 				'modules/mariokartdelyxe/overview' => 'overview.php',
 				'modules/mariokartdelyxe/details' => 'details.php',
 				//'modules/mariokartdelyxe/register' => 'register.php',
 				//'modules/mariokartdelyxe/account' => 'account.php',
 				//'modules/mariokartdelyxe/userDetails' => 'userDetails.php',
 			],
 		];

 		Yii::$app->i18n->translations['modules/mariokartdelyxe/*'] = [
 			'class' => 'yii\i18n\PhpMessageSource',
 			'sourceLanguage' => 'en',
 			'basePath' => '@app/modules/mariokartdelyxe/messages',
 			'fileMap' => [
 				'modules/mariokartdelyxe/overview' => 'overview.php',
 				'modules/mariokartdelyxe/details' => 'details.php',
 				//'modules/mariokartdelyxe/register' => 'register.php',
 				//'modules/mariokartdelyxe/account' => 'account.php',
 				//'modules/mariokartdelyxe/userDetails' => 'userDetails.php',
 			],
 		];
 	}

 	/**
     * @inheritdoc
     */
 	public static function t($category, $message, $language = null, $params = [])
 	{
 		return Yii::t('modules/mariokartdelyxe/' . $category, $message, $params, $language);
 	}
 }