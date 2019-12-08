<?php
namespace CustomApp\Customer\Model;

use CustomApp\Database\MysqlPDO;

class CustomerRepository
{
    /** @var MysqlPDO */
    private $mysqlPDO;

    public function __construct(MysqlPDO $mysqlPDO)
    {

        $this->mysqlPDO = $mysqlPDO;
    }

    public function getCustomers(int $offset = 0, int $limit = 20): array
    {
        $query = 'SELECT * FROM customers ORDER BY id_customer ASC LIMIT %d,%d';

        $query = sprintf($query, $offset, $limit);

        $statement = $this->mysqlPDO->getConnection()->prepare($query);
        $statement->execute();

        return $this->buildArray($statement->fetchAll());

    }

    function getByUuid(string $uuid): Customer
    {
        $queryPattern = 'SELECT * FROM customers WHERE uuid = :uuid';

        $statement = $this->mysqlPDO->getConnection()->prepare($queryPattern);
        $statement->execute([':uuid' => $uuid]);

        $record = $statement->fetch();

        if (false === $record) {
            throw new \Exception(
                sprintf(
                    'Customer with UUID %s not found',
                    $uuid
                )
            );
        }

        return new Customer(
            $record['id_customer'],
            $record['uuid'],
            $record['name'],
            $record['email'],
            $record['phone']
        );
    }

    public function add(Customer $customer)
    {
        $query =
            'INSERT INTO customers (uuid, name, email, phone)
              VALUES (:uuid, :name, :email, :phone)';

        $statement = $this->mysqlPDO->getConnection()->prepare($query);
        $success = $statement->execute(
            [
                ':uuid' => $customer->getUuid(),
                ':name' => $customer->getName(),
                ':email' => $customer->getEmail(),
                ':phone' => $customer->getPhone(),
            ]
        );

        if (false === $success) {
            throw new \Exception(
                sprintf(
                    'Failed to add customer %s to the repository',
                    $customer->getUuid()
                )
            );
        }
    }

    public function update(Customer $customer)
    {
        $query =
            'UPDATE customers SET 
                name = :name,
                email = :email,
                phone = :phone
              WHERE id_customer = :id_customer';

        $statement = $this->mysqlPDO->getConnection()->prepare($query);

        $success = $statement->execute(
            [
                ':id_customer' => $product->getCustomerId(),
                ':name' => $product->getName(),
                ':email' => $product->getEmail(),
                ':phone' => $product->getPhone()
            ]
        );



        if (false === $success) {
            throw new \Exception(
                sprintf(
                    'Failed to update customer %s in the repository. Error info: \'%s\'',
                    $customer->getUuid(),
                    $statement->errorInfo()
                )
            );
        }
    }

    public function deleteByUuid(string $uuid)
    {
        $query = 'DELETE FROM customers WHERE uuid = :uuid';

        $statement = $this->mysqlPDO->getConnection()->prepare($query);
        $success = $statement->execute(
            [
                ':uuid' => $uuid,
            ]
        );

        if (false === $success) {
            throw new \Exception(
                sprintf(
                    'Failed to delete customer %s from the repository',
                    $uuid
                )
            );
        }
    }

    private function buildArray(array $statementResults)
    {
        $objects = [];

        foreach ($statementResults as $result) {
            $objects[] = new Customer(
                $result['id_customer'],
                $result['uuid'],
                $result['name'],
                $result['email'],
                $result['phone']
            );
        }

        return $objects;
    }
}
