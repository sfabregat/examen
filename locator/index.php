<?php


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
//autoload
require 'vendor/autoload.php';
//fichero con la configuracion de la base de datos
require 'config.slim.php';
//generamos un nuevo slimApp con los datos de configuracion de la db
$app = new \Slim\App(['settings'=>$config]);
//creamos un contenedor  de la aplicacion
$container = $app->getContainer();
//dentro del contenedor db creamos la conexion a la DB
$container['db']=function($c)
{
    $db=$c['settings']['db'];
    $pdo=new PDO('mysql:host='.$db['host'].';dbname='.$db['dbname'],$db['user'],$db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
    return $pdo;

};

/**
 *
 * 
 * Mostrar el listado de usuarios 
 * Ruta: /search
 * 
 */

    
$app->get('/search', function(Request $req, Response $res){
    //Generamos una consulta simple
    $stmt=$this->db->prepare("SELECT * FROM empleats");
    //la ejecutamos
    $stmt->execute();
    //recojemos los resultado
    $result=$stmt->fetchAll();
    //los devolvemos en formato json
    return $this->response->withJson($result);
});

/**
 * 
 * Mostrar un usuario en concreto (donde pone id ponemos el numero identificativo del empleado)
 * Ruta: /search/id
 * 
 */

$app->get('/search/{id}',function(Request $req, Response $res, $args)
{
    //recogemos el argumento id
    $id=(int)$args['id'];
    //Generamos una consulta simple, filtrando por id en empleados
    $stmt=$this->db->prepare("SELECT * FROM empleats WHERE id=:id");
    //enlazamos el id
    $stmt->bindParam(':id',$id);
    //ejecutamos
    $stmt->execute();
    //recojemos el resultado
    $result=$stmt->fetchAll();
    //los devolvemos en formato json
    return $this->response->withJson($result);
});

$app->run();    
