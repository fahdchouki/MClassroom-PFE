<?php
class MsgModel extends Model{
    public function __construct()
    {
        $this->table = 'message';
        $this->con = (new Model)->con;
    }
}