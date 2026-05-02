<?php
namespace Php\Mvc\App\Core;

/**
 * Summary of TemplateEngine
 */
class TemplateEngine
{
    private $template;
    private $viewsPath;
    private $data;
    /**
     * Summary of __construct
     * @param mixed $template
     * @param mixed $viewsPath
     */
    public function __construct($template, $viewsPath = null)
    {
        $this->template = $template;
        $this->viewsPath = $viewsPath;
    }

    /**
     * Summary of set
     * @param mixed $key
     * @param mixed $value
     * @return void
     */

    public function setData($dataArray)
    {
        $this->data = $dataArray;
    }
    public function set($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * Summary of output
     * @return array|bool|string
     */
    public function output()
    {
        if (!file_exists($this->template)) {
            return "Error: Template file not found.";
        }

        $output = file_get_contents($this->template);
        var_dump($output);
        foreach ($this->data as $key => $value) {
            $tagToReplace = "{{" . "$" . $key . "}}";
            if (strpos($output, $tagToReplace) !== false) {
                $output = str_replace($tagToReplace, $value, $output);
            }

        }

        return $output;
    }



}