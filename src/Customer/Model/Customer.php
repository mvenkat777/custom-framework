<?php
namespace CustomApp\Customer\Model;

class Customer
{
    /** @var int */
    private $customerId;

    /** @var string */
    private $uuid;

    /** @var string */
    private $name;

    /** @var string */
    private $email;

    /** @var string */
    private $phone;

    public function __construct(
        int $customerId,
        string $uuid,
        string $name,
        string $email,
        string $phone
    ) {
        $this->customerId = $customerId;
        $this->uuid = $uuid;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
    }

    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }
}
