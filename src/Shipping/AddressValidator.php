<?php declare(strict_types=1);

namespace Myposter\Shipping;

use Myposter\Api\CustomerApi;
use Myposter\Api\CustomerDataApiMock;
use Myposter\Api\Entity\Customer;
use Myposter\Shipping\Entity\Street;
use Myposter\Shipping\Exception\AddressSplitException;

final class AddressValidator
{
    /**
     * @return Customer[]
     * @throws \JsonException
     */
	public function getAllCustomers(): array
	{
        $customerApi = new CustomerApi(new CustomerDataApiMock);

		return $customerApi->getAllCustomers();
	}

    /**
     * Split a given street string from a customer into
     * street name and house number.
     *
     * @param Customer $customer
     * @return Street
     * @throws AddressSplitException
     */
	public function splitStreet(Customer $customer): Street
	{
        if (!preg_match('/(?<street>\D+?)\s*(?<houseNumber>\d.*)?+$/isu', $customer->getStreet(), $splitResults)) {
            throw new AddressSplitException('Cannot determine street or house number.');
        }

		return new Street($splitResults['street'], $splitResults['houseNumber'] ?? '');
    }
}
