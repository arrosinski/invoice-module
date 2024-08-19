<?php

namespace App\Modules\Invoices\Exceptions;

use Exception;

class InvoiceNotFoundException extends Exception
{
    public function __construct($message = "Invoice not found", $code = 404, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
