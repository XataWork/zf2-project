<?php
/**
 * Created by PhpStorm.
 * User: boozz
 * Date: 15.06.14
 * Time: 18:29
 */
namespace Album\Model;

class Album
{
    public $id;
    public $artist;
    public $title;

    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->artist = (isset($data['artist'])) ? $data['artist'] : null;
        $this->title  = (isset($data['title'])) ? $data['title'] : null;
    }

    public function  getArrayCopy(){
        return get_object_vars($this);
    }
}