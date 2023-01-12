<?php declare(strict_types=1);

namespace Myposter\Api;

use Myposter\Bootstrap;

final class CustomerDataApiMock
{
	/**
	 * API Mock to simulate an api request to an external service.
	 * The api response is a json string of all customer data.
	 */
	public function getData(): string
	{
		return \file_get_contents(Bootstrap::getRootDirectoryPath() . 'resources/files/customer_data.json');
	}
}
