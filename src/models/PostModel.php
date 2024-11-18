<?php
ContentCreator::loadContent();


class Posts{
    protected $id;

    public function __construct($id)
    {
        $data = [
            'id' => $id
        ];
        $this->load($data);
    }

    protected function load($data)
    {
        foreach($data as $key => $value)
        {
            $this->{$key} = $value;
        }
    }
    public function __get($key)
    {
        return $this->{$key};
    }
}

class ContentCreator{
    public static function loadContent($id = null)
    {
        $postModel = new Posts();
        echo $postModel->id;
    }
}