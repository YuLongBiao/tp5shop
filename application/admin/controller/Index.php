<?php
namespace app\admin\controller;

use think\Db;
use think\Request;

class Index extends \think\Controller
{
    public function index(){
        return $this->fetch();
    }
    public function main()
    {
        return $this->fetch();
    }
    public function user()
    {
        return $this->fetch();
    }
    public function banner(){
        return $this->fetch();
    }
    public function opinion(){
        return $this->fetch();
    }
    public function vip(){
        return $this->fetch();
    }
    public function connoisseur(){
        return $this->fetch();
    }
    public function balance(){
        return $this->fetch();
    }
    public function changepwd(){
        return $this->fetch();
    }
}
