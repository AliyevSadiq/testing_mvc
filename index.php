<?php

set_include_path(get_include_path()
					.PATH_SEPARATOR.'app/Controllers'
					.PATH_SEPARATOR.'app/Models'
					.PATH_SEPARATOR.'app/Config'
					.PATH_SEPARATOR.'app/Config/Request'
					.PATH_SEPARATOR.'app/Requests'
					.PATH_SEPARATOR.'app/Repository'
					.PATH_SEPARATOR.'app/Services'
					.PATH_SEPARATOR.'app/Utils'
					.PATH_SEPARATOR.'app/Utils/Mail'
					.PATH_SEPARATOR.'views');

function autoloader($class){
  require_once($class.'.php');
}

spl_autoload_register('autoloader');



$front = BaseController::getInstance();
$front->route();

echo $front->getBody();