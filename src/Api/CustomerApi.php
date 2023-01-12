<?php declare(strict_types=1);

namespace Myposter\Api;

use Myposter\Api\CustomerDataApiMock as CustomerDataSource;
use Myposter\Api\Entity\Customer;

class CustomerApi
{
    private CustomerDataSource $customerDataSource;

    public function __construct(CustomerDataSource $customerDataSource)
    {
        $this->customerDataSource = $customerDataSource;
    }

    public function getCustomerDataSource(): CustomerDataSource
    {
        return $this->customerDataSource;
    }

    public function setCustomerDataSource(CustomerDataSource $customerDataSource): self
    {
        $this->customerDataSource = $customerDataSource;
        return $this;
    }

    /**
     * @throws \JsonException
     */
    public function getAllCustomers(): array
    {
        $customers = json_decode($this->getCustomerDataSource()->getData(), true, 512, JSON_THROW_ON_ERROR);
        return array_map(function ($customer) {
            return new Customer(...$customer);
        }, $customers );
    }
}