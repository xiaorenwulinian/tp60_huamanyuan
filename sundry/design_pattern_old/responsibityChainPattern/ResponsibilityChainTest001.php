<?php

abstract class  AbstractLogger
{
    const INFO   = 1;
    const DEBUG  = 2;
    const ERROR  = 3;
    protected $level ;
    protected $nextLogger = null ;

    public  function setNextLogger($nextLogger)
    {
        $this->nextLogger  = $nextLogger;
    }

    public function logMessage($level, $message)
    {
        if ($this->level <= $level ) {
            $this->write($message);
        }
        if ($this->nextLogger != null) {
            $this->nextLogger->logMessage($this->level, $message);
        }
    }

    public abstract function write($message);

}

class InfoLogger extends AbstractLogger
{
    public function __construct($level)
    {
        $this->level = $level;
    }

    public function write($message)
    {
        // TODO: Implement write() method.
        echo ' ==standard_Info_logger: ' . $message . '<br/>';

    }
}

class ErrorLogger extends AbstractLogger
{
    public function __construct($level)
    {
        $this->level = $level;
    }

    public function write($message)
    {
        // TODO: Implement write() method.
        echo ' ==error_logger: ' . $message . '<br/>';
    }
}

class DebugLogger extends AbstractLogger
{
    public function __construct($level)
    {
        $this->level = $level;
    }

    public function write($message)
    {
        // TODO: Implement write() method.
        echo ' ==Debug_logger: ' . $message . '<br/>';
    }
}
demo();
function demo()
{
    $loggerChain  = getChain();
    $loggerChain->logMessage(AbstractLogger::INFO,"this_conosole_info");
    $loggerChain->logMessage(AbstractLogger::DEBUG,"this_debug_info");
    $loggerChain->logMessage(AbstractLogger::ERROR,"this_error_info");
}
function getChain()
{
    $errorLogger = new ErrorLogger(AbstractLogger::ERROR);
    $debugLogger = new DebugLogger(AbstractLogger::DEBUG);
    $infoLogger = new InfoLogger(AbstractLogger::INFO);

    //开启职责链
    $errorLogger->setNextLogger($debugLogger);
    $debugLogger->setNextLogger($infoLogger);
    return $errorLogger;
}