<?php

namespace Openpay\Resources;

use Openpay\Data\OpenpayApiDerivedResource;

class OpenpayTransferList extends OpenpayApiDerivedResource
{
    public function create($params)
    {
        return $this->add($params);
    }
}
