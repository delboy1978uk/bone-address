<?php

declare(strict_types=1);

namespace Bone\Address\Controller;

use Bone\Address\Collection\AddressCollection;
use Bone\Address\Form\AddressForm;
use Bone\Address\Service\AddressService;
use Laminas\Diactoros\Response\JsonResponse;
use League\Route\Http\Exception\NotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AddressApiController
{
    /** @param AddressService $service */
    private $service;

    /**
     * @param AddressService $service
     */
    public function __construct(AddressService $service)
    {
        $this->service = $service;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws NotFoundException
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function index(ServerRequestInterface $request): ResponseInterface
    {
        $params = $request->getQueryParams();
        $limit = $params['limit'];
        $offset = $params['offset'];
        $db = $this->service->getRepository();
        $addresss = new AddressCollection($db->findBy([], null, $limit, $offset));
        $total = $db->getTotalAddressCount();
        $count = count($addresss);
        if ($count < 1) {
            throw new NotFoundException();
        }

        $payload['_embedded'] = $addresss->toArray();
        $payload['count'] = $count;
        $payload['total'] = $total;

        return new JsonResponse($payload);
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws \Exception
     */
    public function create(ServerRequestInterface $request): ResponseInterface
    {
        $post = json_decode($request->getBody()->getContents(), true) ?: $request->getParsedBody();
        $form = new AddressForm('create');
        $form->populate($post);

        if ($form->isValid()) {
            $data = $form->getValues();
            $address = $this->service->createFromArray($data);
            $this->service->saveAddress($address);

            return new JsonResponse($address->toArray());
        }

        return new JsonResponse([
            'error' => $form->getErrorMessages(),
        ]);
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws \Doctrine\ORM\ORMException
     */
    public function view(ServerRequestInterface $request): ResponseInterface
    {
        $address = $this->service->getRepository()->find($request->getAttribute('id'));

        return new JsonResponse($address->toArray());
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws \Exception
     */
    public function update(ServerRequestInterface $request): ResponseInterface
    {
        $db = $this->service->getRepository();
        $address = $db->find($request->getAttribute('id'));

        $post = json_decode($request->getBody()->getContents(), true) ?: $request->getParsedBody();
        $form = new AddressForm('update');
        $form->populate($post);

        if ($form->isValid()) {
            $data = $form->getValues();
            $address = $this->service->updateFromArray($address, $data);
            $this->service->saveAddress($address);

            return new JsonResponse($address->toArray());
        }

        return new JsonResponse([
            'error' => $form->getErrorMessages(),
        ]);
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws \Exception
     */
    public function delete(ServerRequestInterface $request): ResponseInterface
    {
        $db = $this->service->getRepository();
        $address = $db->find($request->getAttribute('id'));
        $this->service->deleteAddress($address);

        return new JsonResponse(['deleted' => true]);
    }
}
