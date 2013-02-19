<?php
$mongo = new MongoClient();
$db = $mongo->selectDB('blog');


class Model
{
    public static $db;
    public static $_collection = '';
    public static $_fields = array();
    protected $writeConcerns = array('w' => 1);

    public $_id;


    public function __construct(array $data = array())
    {
        foreach ($data as $var=>$value) {
            $this->{$var} = $value;
        }
    }

    public function save()
    {
        $doc = array();
        if (!empty($this->_id)) { $doc['_id'] = $this->_id; }

        $values = array();
        foreach (static::$_fields as $field) {
            $values[$field] = $this->{$field};
        }
        $doc = array_merge($doc, $values);

        $collection = static::$db->{static::$_collection};
        $collection->save($doc, $this->writeConcerns);
        $this->_id = $doc['_id']->{'$id'};
    }

    public static function findOneBy(array $criteria = array())
    {
        $doc = static::$db->{static::$_collection}->findOne($criteria);
        if ($doc) {
            $model = new static($doc);
            
            return $model;
        }
    }

    public static function all($sort = null)
    {
        $output = array();
        $collection = static::$db->{static::$_collection};
        $docs = $collection->find();

        if ($sort) {
            $docs->sort($sort);
        }

        foreach ($docs as $doc) {
            $output[] = new static($doc);
        }

        return $output;
    }
}


class User extends Model
{
    public static $_collection = 'users';
    public static $_fields = array('name', 'email', 'loginToken', 'authToken');
    
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
        'title', 'slug', 'created', 'updated', 
        'isPublished', 'isPage', 'markdown', 'html'
    );

    public $created;
    public $updated;
    public $isPublished;
    public $isPage;
    public $title;
    public $slug;
    public $markdown;
    public $html;

    public function __construct(array $data = array())
    {
        parent::__construct($data);
        $this->created = new DateTime();
        $this->updated = new DateTime();
    }

    public function save()
    {
        require_once PWD . '/../vendor/markdown.php';
        $this->html = Markdown($this->markdown);
        return parent::save();
    }
}


Model::$db = $db;
