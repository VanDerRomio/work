<?php
class Router
{
	private $routes;
	function __construct()
	{
		$routesPath = ROOT.'/config/routes.php';
		$this->routes = include($routesPath);
	}
	//return string URI
	private function getUri()
	{
		if(!empty($_SERVER['REQUEST_URI']))
		{
			return trim($_SERVER['REQUEST_URI'], '/');
		}
	}
	public function run()
	{
		//отримуємо стрічку запиту
		$uri = $this->getUri();
		//перевіряємо чи є масив $_GET з елементами
		if(isset($_GET)){
			if(count($_GET) > 0)
			{
				$_SESSION['get'] = $_GET;
				$newUri = explode('?', $uri);
				$uri = $newUri[0];

			}
		}

		//перевірка наявності такого запиту в routes.php
		foreach ($this->routes as $uriPattern => $path)
		{
			//порівнюємо $uriPattern з $uri
			if(preg_match("~$uriPattern~", $uri))
			{
				$internalRoute = preg_replace("~$uriPattern~", $path, $uri);

				//якщо співпадає запит, то визначаємо який контроллер та action обробляє запит
				$segments = explode('/', $internalRoute);

				$controllerName = ucfirst(array_shift($segments) . 'Controller');

				$actionName = 'action' . ucfirst(array_shift($segments));

				$parameters = $segments;

				//підєднуємо файл класу-контроллера
				$controllerFile = ROOT . '/controllers/' . $controllerName . '.php';
				if (file_exists($controllerFile)) {
					include_once($controllerFile);
				}
				else{
					Router::ErrorPage404();
				}

				//створюємо обєкт, викликаємо метод (тобто action)
				$controllerObject = new $controllerName;

				//перевіряємо чи існує така функція в класі, інакше перенаправляємо на сторінку 404
				if(!method_exists($controllerObject, $actionName)){
					Router::ErrorPage404();
				}
				$result = call_user_func_array(array($controllerObject, $actionName), $parameters);
				if ($result != null) {
					break;
				}
			}
		}
	}

	function ErrorPage404()
	{
		$host = HTTP_404;
		header('HTTP/1.1 404 Not Found');
		header("Status: 404 Not Found");
		header('Location: '.$host);
	}
}