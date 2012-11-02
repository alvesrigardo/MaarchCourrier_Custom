<?php

class Message
{
    const INFO      = 0;
    const WARNING   = 1;
    const ERROR     = 2;
    const FATAL     = 3;
   
    public $code;
    public $message;
    public $level;
    
    public function Message($code, $message, $level)
    {
        $this->code = $code;
        $this->message = trim($message);
        $this->level = $level;
    }
    
    public function send($receiver=false)
    {
        if(!$receiver) $receiver = $_SESSION;
        if(is_object($receiver)) {
            $receiver->messages[] = $this;
        } elseif(is_array($receiver)) {
            $receiver['messages'][] = $this;
        }
    }
    
}