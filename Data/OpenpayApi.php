<?php

/**
 * Openpay API v1 Client for PHP (version 2.0.0)
 *
 * Copyright © Openpay SAPI de C.V. All rights reserved.
 * http://www.openpay.mx/
 * soporte@openpay.mx
 */

namespace Openpay\Data;

class OpenpayApi extends OpenpayApiResourceBase
{
    protected $derivedResources = [
        'Customer' => [],
        'Card' => [],
        'Charge' => [],
        'Pse' => [],
        'Payout' => [],
        'Fee' => [],
        'Plan' => [],
        'Webhook' => [],
        'Token' => []
    ];

    public static function getInstance($r, $p = null)
    {
        $resourceName = get_class();
        return parent::getInstance($resourceName);
    }

    protected function getResourceUrlName($p = true)
    {
        return '';
    }

    public function getFullURL()
    {
        return $this->getUrl();
    }
}
