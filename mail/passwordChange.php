<?php
/**
 * Created by PhpStorm.
 * User: Isabella Neufeld
 * Date: 25.05.2018
 * Time: 12:48
 */

use app\modules\core\models\User;
use yii\helpers\Html;

/**
 * @var User $user
 * @var $password
 */
?>
<main>
    <table cellspacing="0" cellpadding="0" style="font-family: Calibri; font-size: 12pt;">
        <tr>
            <td>Sehr geehrte(r) Herr / Frau <?= $user->getLastName() ?>,<br><br><br></td>
        </tr>
        <tr>
            <td>Ihr Passwort wurde geändert. Mit dem Klick auf
                den nachstehenden Link werden Sie auf eine Seite geführt, auf der Sie Ihr Passwort eingeben können.<br><br>
            </td>
        </tr>
        <tr>
            <td>
                <a href= <?= Yii::$app->urlManager->createAbsoluteUrl(['site/login']); ?>>Link</a><br><br>
            </td>
        </tr>
        <tr>
            <td><?= Yii::t('app', 'Username') . ': ' . $user->getUsername(); ?><br></td>
        </tr>
        <tr>
            <td><?= Yii::t('app', 'Password') . ': ' . $password ?><br><br></td>
        </tr>
    </table>
</main>