<?php

namespace App\Service;

use App\Entity\Rate;
use App\Repository\RateRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RateService
{
    public const API_KEY = '5488D7AD-5095-4CA5-9971-D2E8F8D56D34';
    public const PERIOD_ID = '1HRS';

    private RateRepository $repository;
    private EntityManagerInterface $em;
    private CurrencyService $currencyService;
    private HttpClientInterface $client;

    public function __construct(
        RateRepository $repository,
        EntityManagerInterface $em,
        CurrencyService $currencyService,
        HttpClientInterface $client
    )
    {
        $this->repository = $repository;
        $this->em = $em;
        $this->currencyService = $currencyService;
        $this->client = $client;
    }

    /**
     * @param string $dateStart
     * @param string $dateEnd
     * @param string $code
     * @return int|mixed[]|string
     */
    public function getCourse(string $dateStart, string $dateEnd, string $code)
    {
        return $this->repository->getCourse(
            $dateStart,
            $dateEnd,
            $code,
        );
    }

    public function sendRequest(): void
    {
        $currencies = $this->currencyService->getAll();
        foreach ($currencies as $currency) {
             $response = ($this->client->request(
                'GET',
                "https://rest.coinapi.io/v1/exchangerate/BTC/{$currency->getCode()}/history",
                [
                    'headers' => [
                        'X-CoinAPI-Key' => self::API_KEY,
                    ],
                    'query' => [
                        'period_id' => self::PERIOD_ID,
                        'time_start' => date('Y-m-d').'T00:00:00',
                        'time_end' => date('Y-m-d', strtotime('-1 day')).'T23:00:00',
                    ]
                ]
            ))->toArray();
            $this->createRate($response, $currency->getCode());
        }
    }

    /**
     * @param array $response
     * @param string $code
     * @throws Exception
     */
    private function createRate(array $response, string $code): void
    {
        $currency = $this->currencyService->getByCode($code);
        foreach ($response as $item) {
            $rate = new Rate;
            $rate->setPrice(round($item['rate_open'], 3))
                ->setDate(new DateTime(substr(str_replace('T', ' ', $item['time_open']), 0, -9)))
                ->setCurrency($currency);
            $this->em->persist($rate);
        }
        $this->em->flush();
    }
}