<?php

/**
 * @copyright Copyright (C) 2015-2021 AIZAWA Hina
 * @license https://github.com/fetus-hina/stat.ink/blob/master/LICENSE MIT
 * @author AIZAWA Hina <hina@fetus.jp>
 */

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "gear_configuration_secondary".
 *
 * @property int $id
 * @property int $config_id
 * @property int|null $ability_id
 *
 * @property Ability|null $ability
 * @property GearConfiguration $config
 */
final class GearConfigurationSecondary extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gear_configuration_secondary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['config_id'], 'required'],
            [['config_id', 'ability_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'config_id' => 'Config ID',
            'ability_id' => 'Ability ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAbility()
    {
        return $this->hasOne(Ability::class, ['id' => 'ability_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConfig()
    {
        return $this->hasOne(GearConfiguration::class, ['id' => 'config_id']);
    }

    public function toJsonArray()
    {
        return $this->ability ? $this->ability->toJsonArray() : null;
    }
}
