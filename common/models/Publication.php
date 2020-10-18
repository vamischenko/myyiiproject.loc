<?php

namespace common\models;

use common\helpers\Dictionary;
use Yii;
use yii\behaviors\AttributeTypecastBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/**
 * Class Publication
 *
 * @property int $id
 * @property string $slug
 * @property string $title
 * @property string $annotation
 * @property string $content
 * @property int $created_at
 * @property int $updated_at
 * @property int $status_id
 * @property int $subject_id
 * @property boolean $isActive
 * @property array $route
 * @package common\models
 */
class Publication extends ActiveRecord
{
    const STATUS_PUBLISHED = 1;
    const STATUS_HIDDEN = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%publication}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => TimestampBehavior::class,
            'slug'      => [
                'class'        => SluggableBehavior::class,
                'attribute'    => 'title',
                'value' => function($event){
                    if(!empty($event->sender->slug))
                        return $event->sender->slug;
                    return Inflector::slug($event->sender->title);
                },
                'slugAttribute' => 'slug',
                'ensureUnique' => true,
                'immutable'    => true
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['status_id'], 'integer'],
            ['status_id', 'default', 'value' => self::STATUS_HIDDEN],
            [['title'], 'string', 'max' => 255],
            [['content', 'annotation'], 'string'],
            ['status_id', 'in', 'range' => array_keys(self::status())],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                  => 'ID',
            'title'               => 'Заголовок',
            'annotation'          => 'Аннотация',
            'content'             => 'Контент',
            'created_at'          => 'Дата создания',
            'updated_at'          => 'Дата обновления',
            'status_id'           => 'Статус',
        ];
    }

    /**
     * @return array
     */
    public static function status()
    {
        return [
            self::STATUS_PUBLISHED => 'опубликована',
            self::STATUS_HIDDEN    => 'скрыта'
        ];
    }

    /**
     * @return array|string
     */
    public function getRoute()
    {
        return ['publication/view', 'slug' => $this->slug];
    }

    /**
     * @return bool
     */
    public function getIsActive()
    {
        return $this->status_id == Dictionary::STATUS_ACTIVE;
    }

    public function breadcrumbs()
    {
        return [];
    }
}
