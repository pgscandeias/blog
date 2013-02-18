<?php
set_exception_handler('App::exception'); // bootstrap

class App {
  protected $_server = array();

  public function __construct() {
    // skipped mocking here
    $this->_server = $_SERVER;
  }

  public function get($pattern, $callback) {
    $this->_route('GET', $pattern, $callback);
  }

  public function delete($pattern, $callback) {
    $this->_route('DELETE', $pattern, $callback);
  }

  public function post($pattern, $callback) {
    $this->_route('POST', $pattern, $callback);
  }


  protected function _route($method, $pattern, $callback) {
    if ($this->_server['REQUEST_METHOD']!=$method) return;

    // convert URL parameter (e.g. ":id", "*") to regular expression
    $regex = preg_replace('#:([\w]+)#', '(?<\\1>[^/]+)', 
        str_replace(array('*', ')'), array('[^/]+', ')?'), $pattern)
    );
    if (substr($pattern,-1)==='/') $regex .= '?';

    // extract parameter values from URL if route matches the current request
    if (!preg_match('#^'.$regex.'$#', $this->_server['REQUEST_URI'], $values)) {
      return;
    }
    // extract parameter names from URL
    preg_match_all('#:([\w]+)#', $pattern, $params, PREG_PATTERN_ORDER);
    $args = array();
    foreach ($params[1] as $param) {
      if (isset($values[$param])) $args[] = urldecode($values[$param]);
    }
    $this->_exec($callback, $args);
  }

  protected function _exec(&$callback, &$args) {
    foreach ((array)$callback as $cb) call_user_func_array($cb, $args);
    throw new Halt(); // Exception instead of exit;
  }

  // Stop execution on exception and log as E_USER_WARNING
  public static function exception($e) {
    if ($e instanceof Halt) return;
    trigger_error($e->getMessage()."\n".$e->getTraceAsString(), E_USER_WARNING);
    $app = new App();
    $app->display('exception.php', 500);
  }

  public function quote($str) {
    return htmlspecialchars($str, ENT_QUOTES);
  }
}

class AppJson extends App {
  protected function _exec(&$callback, &$args) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(call_user_func_array($callback, $args));
    throw new Halt(); // Exception instead of exit;
  }
}

// use Halt-Exception instead of exit;
class Halt extends Exception {}

