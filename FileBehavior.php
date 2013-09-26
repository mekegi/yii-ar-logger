<?php

namespace mekegi\ArLogger;

use \Yii;
use \CLogger;

class FileBehavior extends Behavior
{

    public $filePath = null;

    /**
     * @since 23.07.13 15:33
     * @author Arsen Abdusalamov
     * @param string $title
     * @param array $diff
     */
    protected function logChanges($title, array $diff)
    {
        if (!is_writable($this->filePath)) {
            Yii::log("{$this->filePath} is not writable!!", CLogger::LEVEL_ERROR);
            return;
        }

        $modelName = get_class($this->owner);
        $body = "\n==================\n"
        . "== $title ==\n"
        . date('r') . "\nModel: $modelName\n";
        $user = (isset(Yii::app()->user) && Yii::app()->user->id) ? Yii::app()->user->id : null;
        if ($this->bactrace) {
            $body .= 'bactrace: ' . implode("\n\t", $this->getBackTrace()) . PHP_EOL;
        }
        $body .= "user: $user\n\t ---\n";
        foreach ($diff as $key => $newVal) {
            $oldVal = empty($this->_oldAttributes[$key]) ? null : $this->_oldAttributes[$key];
            $body .= "\t$key: [$oldVal -> $newVal]\n";
        }
        $f = fopen($this->filePath, 'a+');
        fwrite($f, $body);
        fclose($f);
    }

}