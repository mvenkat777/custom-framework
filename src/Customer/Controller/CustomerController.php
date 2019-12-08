<?php
namespace CustomApp\Customer\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use CustomApp\Customer\Model\Customer;
use CustomApp\Customer\Model\CustomerRepository;
use Ramsey\Uuid\Uuid;

class CustomerController
{
	const PAGE_SIZE = 10;
    const CUSTOMER_ID_PARAM = 'id_customer';

    /** @var CustomerRepository */
    private $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function getList(Request $request, Response $response): Response
    {
        $serializable = [];

        $page = $request->query->get('page') ?? 1;
        $page = 1;

        foreach ($this->customerRepository->getCustomers(
            ($page - 1) * static::PAGE_SIZE,
            static::PAGE_SIZE
        ) as $customer) {
            $serializable[] = $this->toJsonSerializable($customer);
        }

        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(json_encode($serializable));

        return $response;
    }

    public function post(Request $request, Response $response): Response
    {
        $requestJson = json_decode($request->getBody()->getContents(), true);

        $uuid = Uuid::uuid1(1)->toString();

        $customer = new Customer(
            $uuid,
            $requestJson['name'],
            $requestJson['email'],
            $requestJson['phone']
        );

        $this->customerRepository->add($customer);

        $savedProduct = $this->customerRepository->getByUuid($uuid);

        $serializable = $this->toJsonSerializable($savedProduct);

        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(json_encode($serializable));

        return $response;
    }

    public function put(Request $request, Response $response): Response
    {
        
        $uuid = $request->getQueryParams()[self::CUSTOMER_ID_PARAM] ?? null;
        $original = $this->customerRepository->getByUuid($uuid);

        $requestJson = json_decode($request->getBody()->getContents(), true);

        $modified = new Customer(
            $original->getUuid(),
            $requestJson['name'],
            $requestJson['email'],
            $requestJson['phone']
        );

        $this->customerRepository->update($modified);

        $updated = $this->customerRepository->getByUuid($uuid);

        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(json_encode($this->toJsonSerializable($updated)));

        return $response;
    }

    public function delete(Request $request, Response $response): Response
    {
        $uuid = $request->getQueryParams()[self::PRODUCT_ID_PARAM] ?? null;
        $this->customerRepository->deleteByUuid($uuid);
        return $response;
    }

    private function toJsonSerializable(Customer $customer): array
    {
        return [
            'uuid' => $customer->getUuid(),
            'name' => $customer->getName(),
            'email' => $customer->getEmail(),
            'phone' => $customer->getPhone()
        ];
    }

    public function list(): Response
    {
        return new Response(
            sprintf("<br> Loading customer controller <br> ")
        );
        //echo '<br> Loading customer controller <br>';
    }
}