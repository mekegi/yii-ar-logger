<?php
/**
 * @property LogSession $fkLogSession
 * @property User $user
 *
 * @method LogChanges find($condition='',$params=[])
 * @method LogChanges[] findAll($condition='',$params=[])
 * @method LogChanges findByPk($pk,$condition='',$params=[])
 * @method LogChanges[] findAllByPk($pk,$condition='',$params=[])
 * @method LogChanges findByAttributes($attributes,$condition='',$params=[])
 * @method LogChanges[] findAllByAttributes($attributes,$condition='',$params=[])
 * @method LogChanges findBySql($sql,$params=[])
 * @method LogChanges[] findAllBySql($sql,$params=[])
 * @method LogChanges with($relations)
 */

class LogChanges extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LogChanges the static model class
	 */
	public static function model($className=__CLASS__)
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
			'fkLogSession' => [self::BELONGS_TO, 'LogSession', 'fk_log_session'],
            'user' => [self::BELONGS_TO, 'User', 'fk_user'],
		);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'log_changes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fk_log_session, generic_id', 'numerical', 'integerOnly'=>true),
			array('generic_type, variable, old, new, title', 'length', 'max'=>255),
			array('created_at', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_log_changes, created_at, fk_user, fk_log_session, generic_type, generic_id, variable, old, new, title, add_info', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_log_changes' => 'Id Log Changes',
			'created_at' => 'Created At',
			'fk_log_session' => 'Fk Log Session',
			'generic_type' => 'Generic Type',
			'generic_id' => 'Generic',
			'variable' => 'Variable',
			'old' => 'Old',
			'new' => 'New',
			'title' => 'title',
			'add_info' => 'add_info',
		);
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

		$criteria->compare('id_log_changes',$this->id_log_changes);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('fk_log_session',$this->fk_log_session);
		$criteria->compare('fk_user',$this->fk_user);
        $criteria->compare('generic_type',$this->generic_type,true);
		$criteria->compare('generic_id',$this->generic_id);
		$criteria->compare('variable',$this->variable,true);
		$criteria->compare('old',$this->old,true);
		$criteria->compare('new',$this->new,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('add_info',$this->add_info,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


    /**
     * @since 23.07.13 16:09
     * @author Arsen Abdusalamov
     * @param CActiveRecord $generic
     */
    public function setGeneric(CActiveRecord $generic)
    {
        $this->generic_type = get_class($generic);
        $this->generic_id = $generic->getPrimaryKey();
    }

    /**
     * @since 23.07.13 16:09
     * @author Arsen Abdusalamov
     * @param CActiveRecord $generic
     */
    public function setUser()
    {
        $this->fk_user = (isset(Yii::app()->user) && Yii::app()->user->id) ? Yii::app()->user->id : null;
    }

/**
     * @since 23.07.13 16:11
     * @author Arsen Abdusalamov
     * @return null|CActiveRecord
     */
    public function getGeneric()
    {
        if($this->generic_id && class_exists($this->generic_type)) {
            $model = call_user_func([$this->generic_type, 'model']);
            return $model->findByPk($this->generic_id);
        }
        return null;
    }
}