<?php declare(strict_types=1);

namespace Bone\Address\Controller;

use Bone\Address\Collection\AddressCollection;
use Bone\Address\Entity\Address;
use Bone\Address\Form\AddressForm;
use Bone\Address\Service\AddressService;
use Bone\Controller\Controller;
use Bone\Http\Response\LayoutResponse;
use Bone\View\Helper\AlertBox;
use Bone\View\Helper\Paginator;
use Del\Form\Field\Submit;
use Del\Form\Form;
use Del\Icon;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AddressController extends Controller
{
    /** @var int $numPerPage */
    private $numPerPage = 10;

    /** @var Paginator $paginator */
    private $paginator;

    /** @var AddressService $service */
    private $service;

    /** @var string $layout */
    private $layout = 'layouts::admin';

    /**
     * @param AddressService $service
     */
    public function __construct(AddressService $service)
    {
        $this->paginator = new Paginator();
        $this->service = $service;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface $response
     * @throws \Exception
     */
    public function index(ServerRequestInterface $request): ResponseInterface
    {
        $db = $this->service->getRepository();
        $total = $db->getTotalAddressCount();
        $this->paginator->setUrl('address?page=:page');
        $params = $request->getQueryParams();
        $page = array_key_exists('page', $params) ?(int) $params['page'] : 1;
        $this->paginator->setCurrentPage($page);
        $this->paginator->setPageCountByTotalRecords($total, $this->numPerPage);
        $addresss = new AddressCollection($db->findBy([], null, $this->numPerPage, ($page *  $this->numPerPage) - $this->numPerPage));

        $body = $this->view->render('address::index', [
            'addresss' => $addresss,
            'paginator' => $this->paginator->render(),
        ]);

        return new LayoutResponse($body, $this->layout);
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface $response
     * @throws \Exception
     */
    public function view(ServerRequestInterface $request): ResponseInterface
    {
        $db = $this->service->getRepository();
        $id = $request->getAttribute('id');
        $address = $db->find($id);
        $body = $this->view->render('address::view', [
            'address' => $address,
        ]);

        return new LayoutResponse($body, $this->layout);
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface $response
     * @throws \Exception
     */
    public function create(ServerRequestInterface $request): ResponseInterface
    {
        $msg = '';
        $form = new AddressForm('createAddress');

        if ($request->getMethod() === 'POST') {
            $post = $request->getParsedBody();
            $form->populate($post);

            if ($form->isValid()) {
                $data = $form->getValues();
                $address = $this->service->createFromArray($data);
                $this->service->saveAddress($address);
                $msg = $this->alertBox(Icon::CHECK_CIRCLE . ' New address added to database.', 'success');
                $form = new AddressForm('createAddress');
            } else {
                $msg = $this->alertBox(Icon::REMOVE . ' There was a problem with the form.', 'danger');
            }
        }

        $form->getField('submit')->setValue('Create');
        $form = $form->render();
        $body = $this->view->render('address::create', [
            'form' => $form,
            'msg' => $msg,
        ]);

        return new LayoutResponse($body, $this->layout);
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface $response
     * @throws \Exception
     */
    public function edit(ServerRequestInterface $request): ResponseInterface
    {
        $msg = '';
        $form = new AddressForm('editAddress');
        $id = $request->getAttribute('id');
        $db = $this->service->getRepository();
        /** @var Address $address */
        $address = $db->find($id);
        $form->populate($address->toArray());
        $form->getField('submit')->setValue('Update');

        if ($request->getMethod() === 'POST') {
            $post = $request->getParsedBody();
            $form->populate($post);
            if ($form->isValid()) {
                $data = $form->getValues();
                $address = $this->service->updateFromArray($address, $data);
                $this->service->saveAddress($address);
                $msg = $this->alertBox(Icon::CHECK_CIRCLE . ' Address details updated.', 'success');
            } else {
                $msg = $this->alertBox(Icon::REMOVE . ' There was a problem with the form.', 'danger');
            }
        }

        $form = $form->render();
        $body = $this->view->render('address::edit', [
            'form' => $form,
            'msg' => $msg,
        ]);

        return new LayoutResponse($body, $this->layout);
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface $response
     * @throws \Exception
     */
    public function delete(ServerRequestInterface $request): ResponseInterface
    {
        $id = $request->getAttribute('id');
        $db = $this->service->getRepository();
        $form = new Form('deleteAddress');
        $submit = new Submit('submit');
        $submit->setValue('Delete');
        $submit->setClass('btn btn-lg btn-danger');
        $form->addField($submit);
        /** @var Address $address */
        $address = $db->find($id);

        if ($request->getMethod() === 'POST') {
            $this->service->deleteAddress($address);
            $msg = $this->alertBox(Icon::CHECK_CIRCLE . ' Address deleted.', 'warning');
            $form = '<a href="/admin/address" class="btn btn-lg btn-default">Back</a>';
            $text = '<p class="lead">The record has been deleted from the database.</p>';
        } else {
            $form = $form->render();
            $msg = $this->alertBox(Icon::WARNING . ' Warning, please confirm your intention to delete.', 'danger');
            $text = '<p class="lead">Are you sure you want to delete ' . $address->getName() . '?</p>';
        }

        $body = $this->view->render('address::delete', [
            'address' => $address,
            'form' => $form,
            'msg' => $msg,
            'text' => $text,
        ]);

        return new LayoutResponse($body, $this->layout);
    }

    /**
     * @param string $message
     * @param string $class
     * @return string
     */
    private function alertBox(string $message, string $class): string
    {
        $helper = new AlertBox();

        return $helper->alertBox([
            'message' => $message,
            'class' => $class,
        ]);
    }
}
