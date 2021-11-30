<?php

namespace Openpay\Resources;

use Openpay\Data\OpenpayApiDerivedResource;

class OpenpaySubscriptionList extends OpenpayApiDerivedResource
{
    public function create($params)
    {
        return $this->add($params);
    }
}
