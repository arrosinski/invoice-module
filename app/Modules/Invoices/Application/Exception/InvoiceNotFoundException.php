<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Exception;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class InvoiceNotFoundException extends NotFoundHttpException
{
}
