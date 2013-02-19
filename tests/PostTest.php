<?php
require_once APP_ROOT . '/models.php';


class PostTest extends PHPUnit_Framework_TestCase
{
    private $dummyData = array();

    public function setUp()
    {
        parent::setUp();
        Post::$db->posts->drop();

        $this->dummyData = array(
            'created' => new DateTime('2009-11-12 10:11:12'),
            'updated' => new DateTime('2010-01-05 18:19:20'),
            'isPublished' => true,
            'isPage' => true,
            'title' => 'Lorem ipsum',
            'slug' => 'lorem-ipsum',
            'markdown' => 'Something',
            'html' => 'or other',
        );
    }

    public function tearDown()
    {
        parent::tearDown();
        Post::$db->posts->drop();
    }

    public function testInsert()
    {
        $p = new Post($this->dummyData);
        $p->save();

        foreach ($this->dummyData as $field => $value) {
            $this->assertEquals($value, $p->{$field});
        }
    }

    public function testFind()
    {
        $p = new Post($this->dummyData);
        $p->save();

        $dbP = Post::find($p->_id);

        $this->assertInstanceOf('Post', $dbP);
        foreach (Post::$_fields as $field => $type) {
            $this->assertEquals($this->dummyData[$field], $dbP->{$field});
        }
    }
}
