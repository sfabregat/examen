<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Api\Lib;
/**
 * Description of db
 *
 * @author linux
 */
class DB {
    public static function start()
    {
        $pdo=new PDO('mysql:host=localhost;dbname=sfabregat_examen','sfabregat_root','linumlinux');
        return $pdo;
    }
}
