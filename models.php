<?php
$mongo = new MongoClient();
$db = $mongo->selectDB('blog');

class Model
{
    public static $db;
    public static $collection = '';
    protected $writeConcerns = array('w' => 1);

    public static function findOneBy(array $criteria = array())
    {
        $doc = static::$db->{static::$_collection}->findOne($criteria);
        if ($doc) {
            $model = new static();
            foreach ($doc as $var=>$value) {
                $model->{$var} = $value;
            }

            return $model;
        }
    }
}

class User extends Model
{
    public static $_collection = 'users';

    public $_id;
    public $name;
    public $email;
    public $loginToken;

    public function __construct(array $data = array())
    {
        foreach ($data as $var=>$value) {
            $this->{$var} = $value;
        }
    }

    public static function generateLoginToken($email)
    {
        // Yeah this is wrong. Just experimenting.
        return sha1(mt_rand());
    }

    public function save()
    {
        $doc = array();
        if (!empty($this->_id)) { $doc['_id'] = $this->_id; }
        $doc = array_merge($doc, array(
            'name' => $this->name,
            'email' => $this->email,
            'loginToken' => $this->loginToken,
        ));

        $collection = static::$db->users;
        $collection->save($doc, $this->writeConcerns);
        $this->_id = $doc['_id']->{'$id'};
    }
}


Model::$db = $db;
