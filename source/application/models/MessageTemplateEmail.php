<?php
class MessageTemplateEmail
{
    /**
     * @var string
     */
    private $content;

    //private $file;
    /**
     * @var string[] varname => string value
     */
    private $vars;

    public function __construct($content, array $vars = array())
    {
        $this->content = (string)$content;
        $this->setVars($vars);
    }

    public function setVars(array $vars)
    {
        $this->vars = $vars;
    }

    public function getTemplateText()
    {
        //return file_get_contents($this->file);
        return $this->content;
    }

    public function __toString()
    {
        return strtr($this->getTemplateText(), $this->getReplacementPairs());
    }

    private function getReplacementPairs()
    {
        $pairs = array();
        foreach ($this->vars as $name => $value)
        {
            $key = sprintf('{{%s}}', strtoupper($name));
            $pairs[$key] = (string)$value;
        }
        return $pairs;
    }
}

//$username = 'test';
//$message = 'test';
//$vars = compact('username', 'message');
//$message = new MessageTemplateEmail($content, $vars);