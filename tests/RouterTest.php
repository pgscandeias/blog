<?php
require_once APP_ROOT . '/router.php';


class RouterTest extends PHPUnit_Framework_TestCase
{
    private $callback;

    public function setUp()
    {
        parent::setUp();

        $this->callback = function(array $params = array()) {
            return $params;
        };
    }

    public function testClass()
    {
        $r = new Router;
        $this->assertInstanceOf('Router', $r);
    }

    public function testMatchPattern()
    {
        $r = new Router();

        // Simple urls
        $this->assertNotEmpty($r->matchPattern('/', '/'));
        $this->assertNotEmpty($r->matchPattern('/foo', '/foo'));
        $this->assertEmpty($r->matchPattern('/foo', '/fooo'));
        $this->assertEmpty($r->matchPattern('/foo', '/notfoo'));

        // With named parameters
        $this->assertNotEmpty($r->matchPattern('/foo/:a1', '/foo/bar'));
        $this->assertNotEmpty($r->matchPattern('/foo/:a1/:a2', '/foo/bar/baz'));

        $expectedArguments = array(
            'match' => true,
            'arguments' => array(
                'controller' => 'users',
                'action' => 'login',
                'param' => 'remember',
            )
        );
        $this->assertEquals($expectedArguments,
                            $r->matchPattern(
                                '/:controller/:action/:param',
                                '/users/login/remember'
                            ));
    }
}
