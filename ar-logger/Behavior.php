<?php

/**
 * @since 23.07.13 15:06
 * @author Arsen Abdusalamov
 */

namespace mekegi\ArLogger;

use \Yii;
use \CLogger;
use \CActiveRecordBehavior;
Use \Exception;

abstract class Behavior extends CActiveRecordBehavior
{
    const EVENT_DELETE = 'delete';
    const EVENT_SAVE = 'save';

    public $bactrace = false;
    public $dontLogFields = [];

    protected $_oldAttributes = [];

    /**
     * @since 23.07.13 15:26
     * @author Arsen Abdusalamov
     * @return []
     */
    protected function getDiffs()
    {
        $new = $this->owner->attributes;
        $old = $this->getOldAttributes();
        $res = array_diff_assoc($new, $old);
        unset($res['updated_at']);
        foreach($this->dontLogFields as $key) {
            unset($res[$key]);
        }
        
        foreach ($res as $key=>$value) {
            if ($this->normalize($value) == $this->normalize($old[$key])) {
                unset($res[$key]);
            }

        }
      
        return $res;
    }

    /**
     * @since 26.09.13 16:48
     * @author Arsen Abdusalamov
     * @return false
     */
    protected function normalize($value)
    {
        $trimVal = preg_replace('/^(.*)\.0+/', '$1', trim($value));
        
        return empty($trimVal) || in_array($trimVal, ['0000-00-00 00:00:00', '0.0'], true)
            ? NULL
            : $trimVal;
    }

    public function afterFind($event)
    {
        $result = parent::afterFind($event);
        $this->setOldAttributes($this->owner->getAttributes());
        return $result;
    }

    protected function getOldAttributes()
    {
        return $this->_oldAttributes;
    }

    protected function setOldAttributes($value)
    {
        $this->_oldAttributes = $value;
    }

    /**
     * @since 22.07.13 16:17
     * @author Arsen Abdusalamov
     * @return array
     */
    protected function getBackTrace($skip = 8, $lineNumber = 2)
    {
        if (!$this->bactrace) {
            return [];
        }
        $result = [];
        $backtrace = debug_backtrace(0);

        for ($i = $skip; ($i - $skip) < $lineNumber; $i++) {
            if (!isset($backtrace[$i])) {
                break;
            }
            $result[] = (empty($backtrace[$i]['file']) ? '(closure)' : $backtrace[$i]['file'])  
                . ':' . (empty($backtrace[$i]['line']) ? '(closure)' : $backtrace[$i]['line']);
        }

        return $result;
    }

    public function afterDelete($event)
    {
        parent::afterDelete($event);
        try {
            if ($diff = $this->getDiffs()) {
                $this->logChanges(self::EVENT_DELETE, $diff);
            }
        }
        catch (Exception $e) {
            Yii::log($e->getMessage(), CLogger::LEVEL_ERROR);
        }
    }

    public function afterSave($event)
    {
        parent::afterSave($event);

        try {
            if ($diff = $this->getDiffs()) {
                $this->logChanges(self::EVENT_SAVE, $diff);
            }
        }
        catch (Exception $e) {
            Yii::log($e->getMessage(), CLogger::LEVEL_ERROR);
        }
    }

    /**
     *
     */
    abstract protected function logChanges($title, array $diff);

}