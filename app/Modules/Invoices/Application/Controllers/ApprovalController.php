<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Controllers;

use App\Infrastructure\Controller;
use App\Modules\Invoices\Application\Exceptions\InvoiceNotFoundException;
use App\Modules\Invoices\Application\Services\ApprovalService;
use DomainException;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Throwable;

class ApprovalController extends Controller
{
    public function __construct(
        private readonly ApprovalService $approvalService,
    ) {
    }

    /**
     * @throws Throwable
     */
    public function approveAction(UuidInterface $uuid): Response
    {
        try {
            $this->approvalService->approve($uuid);
        } catch (InvoiceNotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage(), $e);
        } catch (DomainException $e) {
            throw new UnprocessableEntityHttpException($e->getMessage(), $e);
        }

        return response(status: Response::HTTP_OK);
    }

    /**
     * @throws Throwable
     */
    public function rejectAction(UuidInterface $uuid): Response
    {
        try {
            $this->approvalService->reject($uuid);
        } catch (InvoiceNotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage(), $e);
        } catch (DomainException $e) {
            throw new UnprocessableEntityHttpException($e->getMessage(), $e);
        }

        return response(status: Response::HTTP_OK);
    }
}
