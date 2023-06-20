<?php
interface IParamHandler {
    public function addParam($key, $value);

    public function getAllParams();

    static public function getInstance($filename);

    public function read();

    public function write();
}

abstract class CParamHandler implements IParamHandler {
    protected $source;
    protected $params = array();

    public function __construct($source) {
        $this->source = $source;
    }

    public function addParam($key, $value) {
        $this->params[$key] = $value;
    }

    public function getAllParams() {
        return $this->params;
    }

    static public function getInstance($filename) {
        $path = pathinfo($filename);

        if (!isset($path['extension'])) {
            throw new Exception('Unknown format.');
        }
    
        $classname = 'C' . ucfirst(strtolower($path['extension']))
                         . 'ParamHandler';
  #      $path = dirname(__FILE__) . '/' . $classname . '.php';
    
    #    if (!is_readable($path)) {
   #         throw new Exception('File not found.');
   #     }
  #      include_once $path;
    
        if (!class_exists($classname)) {
            throw new Exception('Class is not declared.');
        }
        $obj = new $classname($filename);
    
        if (!is_subclass_of($obj, 'IParamHandler')) {
            throw new Exception(
                      'Class does not implement interface "IParamHandler"');
        }
    
        return $obj;
    }
}

class CTextParamHandler extends CParamHandler {
    public function read() {
      # Чтение из текстового файла
      # и запись значений в массив $this->params
    }
  
    public function write() {
      # Запись в текстовый файл массива параметров $this->params
    }
  }

  function db_hendler($value, $tag, $flags) {
    var_dump(func_get_args()); // отладка
  }

  
  class CYamlParamHandler extends CParamHandler {
    public function read() {
        // var_dump($this->source);
        // $ndocs = null;
        $data = yaml_parse_file($this->source, -1 );
        return $data[0]; 

      # Чтение в формате yaml
      # и запись значений в массив $this->params

    }
    public function db_hendler($value, $tag, $flags) {
        var_dump(func_get_args()); // отладка
    }
  
    public function write() {
      # Запись в формате yaml массива параметров $this->params
    }
  }


 # print_r( $filename);


