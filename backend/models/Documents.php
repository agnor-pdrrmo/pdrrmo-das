<?php

namespace backend\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use common\Models\User;

/**
 * This is the model class for table "documents".
 *
 * @property int $id
 * @property string $title
 * @property int $type
 * @property string $code
 * @property string $filename
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property TypeOfDocuments $type0
 */
class Documents extends \yii\db\ActiveRecord
{

    /**
     * @var file
     */
    public $file;

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
                ],
             
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'documents';
    }
    

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'type', 'code','filename'], 'required'],
            [['type', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['type', 'created_by', 'updated_by'], 'integer'],
            [['code', 'created_at','filename', 'updated_at'], 'string'],
           // [['title'], 'string', 'max' => 250],
            [['code'], 'unique'],
            [['file',],'required','on'=>['create','updatefile']],
            [['file'], 'file', /*'skipOnEmpty' => false,*/ 'extensions' => 'pdf','maxSize' => 1024 * 1024 * 1024],
            [['type'], 'exist', 'skipOnError' => true, 'targetClass' => TypeOfDocuments::className(), 'targetAttribute' => ['type' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'type' => 'Type of document',
            'code' => 'Code',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'file' => 'Upload documents',
        ];
    }

    
    /**
     * Gets query for [[Type0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getType0()
    {
        return $this->hasOne(TypeOfDocuments::className(), ['id' => 'type']);
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }
}
