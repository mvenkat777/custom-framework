<?php
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$controller = $container->get('apiCustomerController');
$routes = new RouteCollection();

$customers_route = new Route(
      '/customers?page={page}',
      array('_controller' => $controller->getList()),
      array('page' => '[0-9]+')
    );
$routes->add('customers-all', $customers_route);

$customer_post = new Route(
      '/customer/create',
      array('_controller' => $controller->post()),
      [],
      [],
      [],
      ['POST']
    );
$routes->add('customers-post', $customers_post);

$customer_update = new Route(
      '/customer/{id}/update',
      array('_controller' => $controller->put()),
      ['id' => '[0-9]+'],
      [],
      [],
      ['PUT']
    );
$routes->add('customers-put', $customers_update);

$customer_delete = new Route(
      '/customer/{uuid}/delete',
      array('_controller' => $controller->delete()),
      [],
      [],
      [],
      ['DELETE']
    );
$routes->add('customer-delete', $customer_delete);


$routes->add('hello', new Route('/hello/{name}', [
	'name' => 'venkat',
	'_controller' => function(){
			return new Response("Test jdnfjds");
		}
	]
));

return $routes;