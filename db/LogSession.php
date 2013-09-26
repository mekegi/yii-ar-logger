<?php
/**
 * This docblock is auto-generated! Do not touch! 
 *
 * @property LogChanges[] $logChanges
 * @property User $user
 *
 * @method LogSession find($condition='',$params=[])
 * @method LogSession[] findAll($condition='',$params=[])
 * @method LogSession findByPk($pk,$condition='',$params=[])
 * @method LogSession[] findAllByPk($pk,$condition='',$params=[])
 * @method LogSession findByAttributes($attributes,$condition='',$params=[])
 * @method LogSession[] findAllByAttributes($attributes,$condition='',$params=[])
 * @method LogSession findBySql($sql,$params=[])
 * @method LogSession[] findAllBySql($sql,$params=[])
 * @method LogSession with($relations)
 */

class LogSession extends CActiveRecord
{

    /**
     * @var array Lazy cache
     */
    protected static $_lazyStatic = [];

    const TABLE_NAME = 'log_session';
    const ID_LOG_SESSION = 'id_log_session';
    const CREATED_AT = 'created_at';
    const FK_USER = 'fk_user';
    const ACTION = 'action';
    const CONTROLLER = 'controller';
    const URL = 'url';

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return LogSession the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'logChanges' => array(self::HAS_MANY, 'LogChanges', 'fk_log_session'),
            'user' => array(self::BELONGS_TO, 'User', 'fk_user'),
        );
    }

    protected function afterConstruct()
    {
        parent::afterConstruct();
        $app = Yii::app();
        $this->url = $app instanceof CWebApplication && $app->getRequest() ? $app->getRequest()->getUrl() : null;
        $this->fk_user = (isset(Yii::app()->user) && Yii::app()->user->id) ? Yii::app()->user->id : null;
        $this->controller = $app->getController() ? get_class($app->getController()) : null;
        $this->action = $app->getController() && $app->getController()->action
            ? $app->getController()->action->id
            : null;
    }

    public function __toString()
    {
        return __CLASS__.'#'.$this->getPrimaryKey().':['.$this->url.']';
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return self::TABLE_NAME;
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            ['fk_user', 'numerical', 'integerOnly' => true],
            ['action, controller, url', 'length', 'max' => 255],
            ['created_at', 'safe'],
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            ['id_log_session, created_at, fk_user, action, controller, url', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        if (!empty(static::$_lazyStatic[__METHOD__])) {
            return static::$_lazyStatic[__METHOD__];
        }

        return static::$_lazyStatic[__METHOD__] = [
            self::ID_LOG_SESSION => Yii::t('base', 'Id Log Session'),
            self::CREATED_AT => Yii::t('base', 'Created At'),
            self::FK_USER => Yii::t('base', 'Fk User'),
            self::ACTION => Yii::t('base', 'Action'),
            self::CONTROLLER => Yii::t('base', 'Controller'),
            self::URL => Yii::t('base', 'Url'),
        ];
    }

    /**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

        $criteria->compare(self::ID_LOG_SESSION, $this->id_log_session, false);
        $criteria->compare(self::CREATED_AT, $this->created_at, true);
        $criteria->compare(self::FK_USER, $this->fk_user, false);
        $criteria->compare(self::ACTION, $this->action, true);
        $criteria->compare(self::CONTROLLER, $this->controller, true);
        $criteria->compare(self::URL, $this->url, true);

		return new CActiveDataProvider('LogSession', [
			'criteria' => $criteria,
		]);
	}

}