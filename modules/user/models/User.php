<?php

namespace app\modules\user\models;

use app\components\AbstractActiveRecord;

use Yii;

use yii\db\ActiveQuery;
use yii\web\IdentityInterface;

use app\modules\platformgames\models\UserGames;
use app\modules\platformgames\models\Platforms;

use app\modules\teams\models\MainTeam;
use app\modules\teams\models\SubTeam;

use app\modules\miscellaneous\HelperClass;

/**
 * Class User
 * @package app\modules\user\models
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $birthday
 * @property int $gender_id
 * @property int $language_id
 * @property int $nationality_id
 * @property string $pre_name
 * @property string $last_name
 * @property string $zip_code
 * @property string $city
 * @property string $street
 * @property string $dt_created
 * @property string $dt_updated
 * @property bool $is_password_change_required
 * @property string $access_token
 * @property string $auth_key
 * @property string $twitter_account
 * @property string $twitter_channel
 * @property string $discord_id
 * @property string $discord_server
 */
class User extends AbstractActiveRecord implements IdentityInterface
{
    /**
     * @return array the attribute labels
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'User id'),
            'username' => Yii::t('modules/user/', 'username'),
        ];
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Finds user by username.
     *
     * @param string $username the username
     * @return static|null the user, if a user with that username exists
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Generates and sets the password hash from the provided password.
     *
     * @param string $password the non-hashed password
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Validates the password password
     *
     * @param string $password password to validate
     * @return boolean true, if the provided password is valid for the current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Finds user by email address.
     *
     * @param string $email the email address
     * @return static|null the user, if a user with that email exists
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    /**
     * @return string
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @return int
     */
    public function getGenderId()
    {
        return $this->gender_id;
    }

    /**
     * @return ActiveQuery
     */
    public function getGender()
    {
        return $this->hasOne(Gender::className(), ['id' => 'gender_id']);
    }

    /**
     * @return int
     */
    public function getLanguageId()
    {
        return $this->language_id;
    }

    /**
     * @return ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }

    /**
     * @return int
     */
    public function getNationalityId()
    {
        return $this->nationality_id;
    }

    /**
     * @return ActiveQuery
     */
    public function getNationality()
    {
        return $this->hasOne(Nationality::className(), ['id' => 'nationality_id']);
    }

    /**
     * @return string
     */
    public function getPreName()
    {
        return $this->pre_name;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @return string
     */
    public function getZipCode()
    {
        return $this->zip_code;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @return string
     */
    public function getTwitterAccount()
    {
        return $this->twitter_account;
    }

    /**
     * @return string
     */
    public function getTwitterChannels()
    {
        return $this->twitter_channel;
    }

    /**
     * @return string
     */
    public function getDiscordName()
    {
        return $this->discord_id;
    }

    /**
     * @return string
     */
    public function getDiscordServer()
    {
        return $this->discord_server;
    }

    /**
     * @return string
     */
    public function getDtCreated()
    {
        return $this->dt_created;
    }

    /**
     * @return string
     */
    public function getDtUpdated()
    {
        return $this->dt_updated;
    }

    /**
     * @return bool
     */
    public function isPasswordChangeRequired()
    {
        return $this->is_password_change_required;
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->access_token;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled. The returned key will be stored on the
     * client side as a cookie and will be used to authenticate user even if PHP session has been expired.
     *
     * Make sure to invalidate earlier issued authKeys when you implement force user logout, password change and
     * other scenarios, that require forceful access revocation for old sessions.
     *
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /** Get User Games Platforms and Id's */
    /**
     * @return ActiveQuery
     */
    public function getGames()
    {
        return $this->hasMany(UserGames::className(), ['user_id' => 'id']);
    }

    /** Get User Teams */
    /**
     * @return ActiveQuery
     */
    public function getMainTeams()
    {
         $mainTeamsOwnership = $this->hasMany(MainTeam::className(), ['owner_id' => 'id'])->all();
         $mainTeamsMembership = $this->hasMany(MainTeam::className(), ['id' => 'main_team_id'])
            ->viaTable('main_team_member', ['user_id' => 'id'])->all();
         

        $mainTeams = [];
        foreach ($mainTeamsOwnership as $mainTeam) {
            $mainTeams[] = [
                'owner' => true,
                'team' => $mainTeam
            ];
        }

        foreach ($mainTeamsMembership as $memberTeam) {
            $mainTeams[] = [
                'owner' => false,
                'team' => $memberTeam
            ];
        }

        return $mainTeams;
    }

    /**
     * @return ActiveQuery
     */
    public function getMainTeamsOwnership()
    {
        return $this->hasMany(MainTeam::className(), ['owner_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getSubTeamsOwnership()
    {
        return $this->hasMany(SubTeam::className(), ['captain_id' => 'id'])->all();
    }

    /**
     * @return ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getSubTeamsMembership()
    {
        return $this->hasMany(SubTeam::className(), ['id' => 'sub_team_id'])
            ->viaTable('sub_team_member', ['user_id' => 'id']);
    }

    /**
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function getAllSubTeamsWithMembers()
    {
        $retArr = array();
        /** @var SubTeam[] $subTeams */
        $subTeams = $this->getSubTeamsMembership()->all();
        foreach ($subTeams as $subTeam) {
            $retArr[] = array(
                'owner' => ($subTeam->getTeamCaptainId() == $this->getId()),
                //TODO: isUserSubstitute testen
                'isSub' => $subTeam->isUserSubstitute($this->getId()),
                'team' => $subTeam,
                'subTeamId' => $subTeam->getId(),
            );
        }

        $captainTeams = $this->getMainTeamsOwnership()->all();
        /** @var SubTeam $captainTeam */
        foreach ($captainTeams as $key => $captainTeam) {
            if (array_search($captainTeam->getId(), array_column($retArr, 'subTeamId'))) {
                $retArr[] = array(
                    'owner' => true,
                    'isSub' => false,
                    'team' => $captainTeam,
                    'subTeamId' => $captainTeam->getId(),
                );
            }
        }

        return $retArr;
    }

    /** Static functions to get Identity and reset Passwords */

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     *
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Finds out if the password reset token is valid.
     * A token has a limited lifetime, that is determined by the timestamp prefix. That timestamp
     * will be validated.
     *
     * @param string $token password reset token
     * @return boolean true, if the password reset token has not expired yet
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * Finds user by password reset token.
     * If the password reset token is not valid, this method returns null.
     *
     * @param string $token password reset token
     * @return static|null the user, if a user with that password reset token exists
     */
    public static function findByPasswordResetToken($token)
    {
        // validate the password reset token
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'is_active' => true,
        ]);
    }
}