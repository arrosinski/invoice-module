<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Invoices\Application\Mapper;

use App\Domain\Enums\StatusEnum;
use App\Modules\Invoices\Api\Dto\CompanyDto;
use App\Modules\Invoices\Api\Dto\InvoiceDto;
use App\Modules\Invoices\Api\Dto\ProductDto;
use App\Modules\Invoices\Application\Mapper\CompanyMapper;
use App\Modules\Invoices\Application\Mapper\InvoiceMapper;
use App\Modules\Invoices\Domain\Entity\Company;
use App\Modules\Invoices\Domain\Entity\Invoice;
use EduardoMarques\TypedCollections\TypedCollectionImmutable;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Tests\CreatesApplication;

final class InvoiceMapperTest extends TestCase
{
    use CreatesApplication;

    /**
     * @throws \Exception
     */
    public function testFromRawToEntity(): void
    {
        $id = Uuid::uuid1();
        $number = Uuid::uuid1();
        $date = new \DateTimeImmutable('2023-05-28');
        $dueDate = new \DateTimeImmutable('2023-05-30');
        $status = StatusEnum::DRAFT;

        $raw = new \stdClass();
        $raw->id = $id->toString();
        $raw->number = $number->toString();
        $raw->date = $date->format('Y-m-d');
        $raw->dueDate = $dueDate->format('Y-m-d');
        $raw->status = $status->value;

        $expected = new Invoice(
            $id,
            $number,
            $date,
            $dueDate,
            $status,
        );

        $this->assertEquals($expected, InvoiceMapper::fromRawToEntity($raw));
    }

    /**
     * @throws \Exception
     */
    public function testFromRawToEntityWithTimestamps(): void
    {
        $id = Uuid::uuid1();
        $number = Uuid::uuid1();
        $date = new \DateTimeImmutable('2023-05-28');
        $dueDate = new \DateTimeImmutable('2023-05-30');
        $status = StatusEnum::DRAFT;
        $createdAt = new \DateTimeImmutable('2023-04-28 00:05:00');
        $updatedAt = new \DateTimeImmutable('2023-05-02 10:34:54');

        $raw = new \stdClass();
        $raw->id = $id->toString();
        $raw->number = $number->toString();
        $raw->date = $date->format('Y-m-d');
        $raw->dueDate = $dueDate->format('Y-m-d');
        $raw->status = $status->value;
        $raw->createdAt = $createdAt->format('Y-m-d H:i:s');
        $raw->updatedAt = $updatedAt->format('Y-m-d H:i:s');

        $expected = new Invoice(
            $id,
            $number,
            $date,
            $dueDate,
            $status,
            $createdAt,
            $updatedAt,
        );

        $this->assertEquals($expected, InvoiceMapper::fromRawToEntity($raw));
    }

    /**
     * @throws \Exception
     */
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

        $id = Uuid::uuid1();
        $number = Uuid::uuid1();
        $date = new \DateTimeImmutable();
        $dueDate = new \DateTimeImmutable();
        $status = StatusEnum::DRAFT;

        $invoice = new Invoice(
            $id,
            $number,
            $date,
            $dueDate,
            $status,
        );

        $invoice->setCompany($company);

        $companyDto = CompanyMapper::fromEntityToDto($company);
        $productsDto = TypedCollectionImmutable::create(ProductDto::class);

        $expected = new InvoiceDto(
            $id,
            $number,
            $date,
            $dueDate,
            $companyDto,
            $status,
            $productsDto,
            0,
            'USD 0.00',
        );

        $this->assertEquals($expected, InvoiceMapper::fromEntityToDto($invoice));
    }

    public function testFromDtoToArrayWithFormattingAndTimestamps(): void
    {
        $productsDto = TypedCollectionImmutable::create(ProductDto::class);

        $companyId = Uuid::uuid1();
        $name = uniqid('name-');
        $street = uniqid('street-');
        $city = uniqid('city-');
        $zip = uniqid('zip-');
        $phone = uniqid('phone-');
        $email = uniqid('email-');
        $companyCreatedAt = new \DateTimeImmutable('2023-01-28 00:05:00');
        $companyUpdatedAt = new \DateTimeImmutable('2023-02-02 10:34:54');

        $companyDto = new CompanyDto(
            $companyId,
            $name,
            $street,
            $city,
            $zip,
            $phone,
            $email,
            $companyCreatedAt,
            $companyUpdatedAt,
        );

        $id = Uuid::uuid1();
        $number = Uuid::uuid1();
        $date = new \DateTimeImmutable();
        $dueDate = new \DateTimeImmutable();
        $status = StatusEnum::DRAFT;
        $invoiceCreatedAt = new \DateTimeImmutable('2023-04-28 00:05:00');
        $invoiceUpdatedAt = new \DateTimeImmutable('2023-05-02 10:34:54');

        $dto = new InvoiceDto(
            $id,
            $number,
            $date,
            $dueDate,
            $companyDto,
            $status,
            $productsDto,
            0,
            'USD 0.00',
            $invoiceCreatedAt,
            $invoiceUpdatedAt,
        );

        $expected = [
            'number' => $number->toString(),
            'date' => $date->format('c'),
            'dueDate' => $dueDate->format('c'),
            'company' => [
                'name' => $name,
                'street' => $street,
                'city' => $city,
                'zip' => $zip,
                'phone' => $phone,
                'createdAt' => $companyCreatedAt->format('c'),
                'updatedAt' => $companyUpdatedAt->format('c'),
            ],
            'products' => [],
            'total' => 'USD 0.00',
            'createdAt' => $invoiceCreatedAt->format('c'),
            'updatedAt' => $invoiceUpdatedAt->format('c'),
        ];

        $this->assertSame($expected, InvoiceMapper::fromDtoToArray($dto, true, true));
    }

    public function testFromDtoToArrayWithoutFormattingAndTimestamps(): void
    {
        $productsDto = TypedCollectionImmutable::create(ProductDto::class);

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

        $id = Uuid::uuid1();
        $number = Uuid::uuid1();
        $date = new \DateTimeImmutable();
        $dueDate = new \DateTimeImmutable();
        $status = StatusEnum::DRAFT;

        $dto = new InvoiceDto(
            $id,
            $number,
            $date,
            $dueDate,
            $companyDto,
            $status,
            $productsDto,
            0,
            'USD 0.00',
        );

        $expected = [
            'number' => $number->toString(),
            'date' => $date->format('c'),
            'dueDate' => $dueDate->format('c'),
            'company' => [
                'name' => $name,
                'street' => $street,
                'city' => $city,
                'zip' => $zip,
                'phone' => $phone,
            ],
            'products' => [],
            'total' => 0,
        ];

        $this->assertSame($expected, InvoiceMapper::fromDtoToArray($dto, false));
    }

    public function testFromEntityToPersistenceArray(): void
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

        $id = Uuid::uuid1();
        $number = Uuid::uuid1();
        $date = new \DateTimeImmutable();
        $dueDate = new \DateTimeImmutable();
        $status = StatusEnum::DRAFT;

        $invoice = new Invoice(
            $id,
            $number,
            $date,
            $dueDate,
            $status,
        );

        $invoice->setCompany($company);

        $expected = [
            'number' => $number->toString(),
            'date' => $date->format('Y-m-d'),
            'due_date' => $dueDate->format('Y-m-d'),
            'company_id' => $companyId->toString(),
            'status' => $status->value,
        ];

        $this->assertSame($expected, InvoiceMapper::fromEntityToPersistenceArray($invoice));
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->createApplication();
    }
}
