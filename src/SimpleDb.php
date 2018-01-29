<?php

namespace Luanpcweb\SimpleDb;

use Luanpcweb\SimpleDb\Adapter\AdapterInterface;


class SimpleDb
{
    /** @var AdapterInterface */
    private $adapter;


    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    public function findAll()
    {
        $data = $this->adapter->read();

        if (isset($data['data'])) {
            return $data['data'];
        }

        return [];

    }
}
