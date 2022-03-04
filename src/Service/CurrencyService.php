<?php

namespace App\Service;

use App\Entity\Currency;
use App\Repository\CurrencyRepository;

class CurrencyService
{
    private CurrencyRepository $repository;

    public function __construct(CurrencyRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return Currency[]
     */
    public function getAll(): array
    {
        return $this->repository->findAll();
    }

    /**
     * @param string $code
     * @return Currency|null
     */
    public function getByCode(string $code): ?Currency
    {
        return $this->repository->findOneBy(['code' => $code]);
    }
}