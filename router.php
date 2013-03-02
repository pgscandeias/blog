<?php
/**
 * Router
 */
class Router
{
    public function route() {}

    /**
     * Checks if a url matches a given pattern.
     * If it does, returns a list of arguments.
     */
    public function matchPattern($pattern, $url) {
        if ($url == $pattern) {
            return true;
        }

        // convert URL parameter (e.g. ":id", "*") to regular expression
        $regex = preg_replace('#:([\w]+)#', '(?<\\1>[^/]+)', 
            str_replace(array('*', ')'), array('[^/]+', ')?'), $pattern)
        );
        if (substr($pattern,-1)==='/') $regex .= '?';

        // extract parameter values from URL if route matches the current request
        if (!preg_match('#^'.$regex.'$#', $url, $values)) {
          return;
        }
        // extract parameter names from URL
        preg_match_all('#:([\w]+)#', $pattern, $params, PREG_PATTERN_ORDER);
        $args = array();
        foreach ($params[1] as $param) {
          if (isset($values[$param])) $args[$param] = urldecode($values[$param]);
        }

        return $args;
    }

    public function extractArguments($pattern, $values) {
        // extract parameter names from URL
        preg_match_all('#:([\w]+)#', $pattern, $params, PREG_PATTERN_ORDER);

        $args = array();
        foreach ($params[1] as $param) {
            if (isset($values[$param])) $args[$param] = urldecode($values[$param]);
        }

        return $args;
    }
}