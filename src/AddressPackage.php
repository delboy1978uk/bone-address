<?php

declare(strict_types=1);

namespace Bone\Address;

use Barnacle\Container;
use Barnacle\EntityRegistrationInterface;
use Barnacle\RegistrationInterface;
use Bone\Address\Controller\AddressApiController;
use Bone\Address\Controller\AddressController;
use Bone\Address\Service\AddressService;
use Bone\Controller\Init;
use Bone\Http\Middleware\HalCollection;
use Bone\Http\Middleware\HalEntity;
use Bone\Router\Router;
use Bone\Router\RouterConfigInterface;
use Bone\User\Http\Middleware\SessionAuth;
use Bone\View\ViewRegistrationInterface;
use Doctrine\ORM\EntityManager;
use Laminas\Diactoros\ResponseFactory;
use League\Route\RouteGroup;
use League\Route\Strategy\JsonStrategy;

class AddressPackage implements RegistrationInterface, RouterConfigInterface, EntityRegistrationInterface, ViewRegistrationInterface
{
    /**
     * @param Container $c
     */
    public function addToContainer(Container $c)
    {
        $c[AddressService::class] = $c->factory(function (Container $c) {
            $em =  $c->get(EntityManager::class);

            return new AddressService($em);
        });

        $c[AddressController::class] = $c->factory(function (Container $c) {
            $service = $c->get(AddressService::class);

            return Init::controller(new AddressController($service), $c);
        });

        $c[AddressApiController::class] = $c->factory(function (Container $c) {
            $service = $c->get(AddressService::class);

            return new AddressApiController($service);
        });
    }

    /**
     * @return array
     */
    public function addViews(): array
    {
        return ['address' => __DIR__ . '/View/Address'];
    }

    /**
     * @param Container $c
     * @return array
     */
    public function addViewExtensions(Container $c): array
    {
        return [];
    }

    /**
     * @return string
     */
    public function getEntityPath(): string
    {
        return __DIR__ . '/Entity';
    }

    /**
     * @param Container $c
     * @param Router $router
     * @return Router
     */
    public function addRoutes(Container $c, Router $router): Router
    {
        $auth = $c->get(SessionAuth::class);
        $router->group('/admin/address', function (RouteGroup $route) {
            $route->map('GET', '/', [AddressController::class, 'index']);
            $route->map('GET', '/{id:number}', [AddressController::class, 'view']);
            $route->map('GET', '/create', [AddressController::class, 'create']);
            $route->map('GET', '/edit/{id:number}', [AddressController::class, 'edit']);
            $route->map('GET', '/delete/{id:number}', [AddressController::class, 'delete']);

            $route->map('POST', '/create', [AddressController::class, 'create']);
            $route->map('POST', '/edit/{id:number}', [AddressController::class, 'edit']);
            $route->map('POST', '/delete/{id:number}', [AddressController::class, 'delete']);
        })->middlewares([$auth]);

        $factory = new ResponseFactory();
        $strategy = new JsonStrategy($factory);
        $strategy->setContainer($c);

        $router->group('/api/address', function (RouteGroup $route) {
            $route->map('GET', '/', [AddressApiController::class, 'index'])->prependMiddleware(new HalCollection(5));
            $route->map('POST', '/', [AddressApiController::class, 'create']);
            $route->map('GET', '/{id:number}', [AddressApiController::class, 'view'])->prependMiddleware(new HalEntity());
            $route->map('PUT', '/{id:number}', [AddressApiController::class, 'update']);
            $route->map('DELETE', '/{id:number}', [AddressApiController::class, 'delete']);
        })
        ->setStrategy($strategy);

        return $router;
    }
}
