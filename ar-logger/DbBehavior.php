<?php

namespace mekegi\ArLogger;

/**
 * @since 24.07.13 11:01
 * @author Arsen Abdusalamov
 */
class DbBehavior extends Behavior
{

    public $logChangesClass = '\LogChanges';
    public $logSessionClass = '\LogSession';
    public $title = 'title';
    public $add_info = 'add_info';
    public $variable = 'variable';
    public $old = 'old';
    public $new = 'new';
    public $fk_user = 'fk_user';
    public $fk_log_session = 'fk_log_session';

    /**
     * @var LogSession
     */
    protected static $_logSession;

    /**
     * 
     * @param type $title
     * @param array $diff
     */
    protected function logChanges($title, array $diff)
    {
        foreach ($diff as $key => $new) {
            $oldVal = empty($this->_oldAttributes[$key]) ? null : $this->_oldAttributes[$key];
            $this->logChange($title, $key, $oldVal, $new);
        }
    }

    /**
     *
     * @param string $title
     * @param string $variable
     * @param string $old
     * @param string $new
     */
    protected function logChange($title, $variable, $old, $new)
    {
        if ($old == $new) {
            return;
        }
        $logChange = new $this->logChangesClass;

        if ($this->title) {
            $logChange->{$this->title} = $title;
        }

        if ($this->add_info) {
            $logChange->{$this->add_info} = implode("\n", $this->getBackTrace());
        }

        if ($this->variable) {
            $logChange->{$this->variable} = $variable;
        }

        if ($this->old) {
            $logChange->{$this->old} = (string) $old;
        }

        $logChange->setUser();

        if ($this->new) {
            $logChange->{$this->new} = (string) $new;
        }

        $logChange->setGeneric($this->owner);

        if ($this->fk_log_session) {
            $logChange->{$this->fk_log_session} = $this->getLogSession()->getPrimaryKey();
        }

        $logChange->save();
    }

    /**
     * @since 26.09.13 16:47
     * @author Arsen Abdusalamov
     * @return LogSession
     */
    protected function getLogSession()
    {
        if (empty(self::$_logSession)) {
            self::$_logSession = new $this->logSessionClass;
            self::$_logSession->save(0);
        }
        return self::$_logSession;
    }

}