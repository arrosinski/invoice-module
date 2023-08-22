<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Invoices\Application\Mapper;

use App\Modules\Invoices\Api\Dto\CompanyDto;
use App\Modules\Invoices\Application\Mapper\CompanyMapper;
use App\Modules\Invoices\Domain\Entity\Company;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class CompanyMapperTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testFromRawToEntity(): void
    {
        $companyId = Uuid::uuid1();
        $name = uniqid('name-');
        $street = uniqid('street-');
        $city = uniqid('city-');
        $zip = uniqid('zip-');
        $phone = uniqid('phone-');
        $email = uniqid('email-');

        $raw = new \stdClass();
        $raw->id = $companyId->toString();
        $raw->name = $name;
        $raw->street = $street;
        $raw->city = $city;
        $raw->zip = $zip;
        $raw->phone = $phone;
        $raw->email = $email;

        $expected = new Company(
            $companyId,
            $name,
            $street,
            $city,
            $zip,
            $phone,
            $email,
        );

        $this->assertEquals($expected, CompanyMapper::fromRawToEntity($raw));
    }

    /**
     * @throws \Exception
     */
    public function testFromRawToEntityWithTimestamps(): void
    {
        $companyId = Uuid::uuid1();
        $name = uniqid('name-');
        $street = uniqid('street-');
        $city = uniqid('city-');
        $zip = uniqid('zip-');
        $phone = uniqid('phone-');
        $email = uniqid('email-');
        $createdAt = '2023-05-27 00:00:00';
        $updatedAt = '2023-05-27 00:52:00';

        $raw = new \stdClass();
        $raw->id = $companyId->toString();
        $raw->name = $name;
        $raw->street = $street;
        $raw->city = $city;
        $raw->zip = $zip;
        $raw->phone = $phone;
        $raw->email = $email;
        $raw->createdAt = $createdAt;
        $raw->updatedAt = $updatedAt;

        $expected = new Company(
            $companyId,
            $name,
            $street,
            $city,
            $zip,
            $phone,
            $email,
            new \DateTimeImmutable($createdAt),
            new \DateTimeImmutable($updatedAt),
        );

        $this->assertEquals($expected, CompanyMapper::fromRawToEntity($raw));
    }

    public function testFromEntityToDto(): void
    {
        $companyId = Uuid::uuid1();
        $name = uniqid('name-');
        $street = uniqid('street-');
        $city = uniqid('city-');
        $zip = uniqid('zip-');
        $phone = uniqid('phone-');
        $email = uniqid('email-');

        $company = new Company(
            $companyId,
            $name,
            $street,
            $city,
            $zip,
            $phone,
            $email,
        );

        $expected = new CompanyDto(
            $companyId,
            $name,
            $street,
            $city,
            $zip,
            $phone,
            $email,
        );

        $this->assertEquals($expected, CompanyMapper::fromEntityToDto($company));
    }

    public function testFromDtoToArrayWithoutTimestamps(): void
    {
        $companyId = Uuid::uuid1();
        $name = uniqid('name-');
        $street = uniqid('street-');
        $city = uniqid('city-');
        $zip = uniqid('zip-');
        $phone = uniqid('phone-');
        $email = uniqid('email-');

        $companyDto = new CompanyDto(
            $companyId,
            $name,
            $street,
            $city,
            $zip,
            $phone,
            $email,
        );

        $expected = [
            'name' => $name,
            'street' => $street,
            'city' => $city,
            'zip' => $zip,
            'phone' => $phone,
        ];

        $this->assertEquals($expected, CompanyMapper::fromDtoToArray($companyDto));
    }

    public function testFromDtoToArray(): void
    {
        $companyId = Uuid::uuid1();
        $name = uniqid('name-');
        $street = uniqid('street-');
        $city = uniqid('city-');
        $zip = uniqid('zip-');
        $phone = uniqid('phone-');
        $email = uniqid('email-');

        $companyDto = new CompanyDto(
            $companyId,
            $name,
            $street,
            $city,
            $zip,
            $phone,
            $email,
        );

        $expected = [
            'name' => $name,
            'street' => $street,
            'city' => $city,
            'zip' => $zip,
            'phone' => $phone,
            'createdAt' => null,
            'updatedAt' => null,
        ];

        $this->assertEquals($expected, CompanyMapper::fromDtoToArray(dto: $companyDto, timestamps: true));
    }
}
