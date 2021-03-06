<?php

abstract class Model
{
    public static $db;
    public static $_collection = '';
    public static $_fields = array();
    protected $writeConcerns = array('w' => 1);

    public $_id;


    public function __construct(array $data = array())
    {
        foreach ($data as $field=>$value) {
            if (
                isset(static::$_fields[$field])
                && static::$_fields[$field] == 'datetime'
                && is_a($value, 'MongoDate')
            ) {
                $this->{$field} = static::mongo2date($value);

            } else { $this->{$field} = $value; }
        }
    }

    public function save()
    {
        $doc = array();
        if (!empty($this->_id)) { $doc['_id'] = $this->_id; }

        $values = array();
        foreach (static::$_fields as $field => $type) {
            $value = null;
            switch ($type) {
                case 'string':
                    $value = (string) $this->{$field};
                    break;

                case 'int':
                    $value = (int) $this->{$field};
                    break;

                case 'datetime':
                    $value = static::date2mongo($this->{$field});
                    break;

                case 'bool':
                    $value = (bool) $this->{$field};
                    break;
            }
            $doc[$field] = $value;
        }

        $collection = static::$db->{static::$_collection};
        $collection->save($doc, $this->writeConcerns);
        $this->_id = $doc['_id'];
    }

    public function delete()
    {
        static::$db->{static::$_collection}->remove(array(
            '_id' => $this->_id
        ));
    }

    public static function findOneBy(array $criteria = array())
    {
        $doc = static::$db->{static::$_collection}->findOne($criteria);
        if ($doc) {
            $model = new static($doc);
            
            return $model;
        }
    }

    public static function find($_id)
    {
        $doc = static::$db->{static::$_collection}->findOne(array('_id' => new MongoId($_id)));
        return $doc ? new static($doc) : null;
    }

    public static function all($criteria = array(), $sort = null)
    {
        $output = array();
        $collection = static::$db->{static::$_collection};
        $docs = $collection->find($criteria);

        if ($sort) {
            $docs->sort($sort);
        }

        foreach ($docs as $doc) {
            $output[] = new static($doc);
        }

        return $output;
    }

    public static function date2mongo($date)
    {
        return is_a($date, 'DateTime') ?
                    new MongoDate(strtotime($date->format('Y-m-d H:i:s')))
                        : new MongoDate((string) $date);
    }

    public static function mongo2date(MongoDate $mongoDate)
    {
        return new DateTime(date('Y-m-d H:i:s', $mongoDate->sec));
    }
}


class User extends Model
{
    public static $_collection = 'users';
    public static $_fields = array(
        'name' => 'string',
        'email' => 'string',
        'loginToken' => 'string',
        'authToken' => 'string',
    );
    
    public $name;
    public $email;
    public $loginToken;
    public $authToken;


    public static function generateLoginToken($email)
    {
        // Yeah this is wrong. Just experimenting.
        return sha1(mt_rand());
    }

    public function renewAuthCookie(Cookie $cookie)
    {
        $this->authToken = sha1(mt_rand()); // rong, rong, rong

        $tokenCookie = $cookie::generate();
        $tokenCookie
            ->setName('auth_token')
            ->setValue($this->authToken)
            ->setExpire(time() + 3600 * 24 * 30)
            ->setPath('/')
            ->send()
        ;

        return $this;
    }

    public static function getByAuthCookie(Cookie $cookie)
    {
        return static::findOneBy(array('authToken' => $cookie->get('auth_token')));
    }
}


class Post extends Model{
    public static $_collection = 'posts';
    public static $_fields = array(
        'created' => 'datetime', 
        'updated' => 'datetime', 
        'isPublished' => 'bool', 
        'isPrivate' => 'bool',
        'isPage' => 'bool', 
        'title' => 'string', 
        'slug' => 'string', 
        'markdown' => 'string', 
        'html' => 'string'
    );

    public $created;
    public $updated;
    public $isPublished;
    public $isPrivate;
    public $isPage;
    public $title;
    public $slug;
    public $markdown;
    public $html;

    public function __construct(array $data = array())
    {
        parent::__construct($data);
        $this->created = $this->created ?: new DateTime();
        $this->updated = $this->updated ?: new DateTime();
    }

    public static function md2html($string)
    {
        require_once APP_ROOT . '/vendor/markdown.php';
        return Markdown($string);
    }

    public static function findPages()
    {
        return Post::all(
            array(
                'isPublished' => true,
                'isPrivate' => false,
                'isPage' => true,
            ),
            array('created' => -1)
        );
    }

    public static function findPosts()
    {
        return Post::all(
            array(
                'isPublished' => true,
                'isPrivate' => false,
                'isPage' => false,
            ),
            array('created' => -1)
        );
    }

    public function save()
    {
        $this->invalidateCache();

        return parent::save();
    }

    public function url()
    {
        return '/' . $this->slug;
    }

    public function adminUrl()
    {
        return '/admin/posts/' . $this->_id;
    }


    private function invalidateCache()
    {
        // Post page cache
        $cachePath = APP_ROOT . '/cache/' . md5($this->url());
        @unlink($cachePath);

        // Posts index cache
        $cachePath = APP_ROOT . '/cache/' . md5('/');
        @unlink($cachePath);
    }
}
