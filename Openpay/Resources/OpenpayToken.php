<?php

namespace Openpay\Resources;

use Openpay\Data\OpenpayApiResourceBase;

class OpenpayToken extends OpenpayApiResourceBase
{
    protected $card;

    public function get($param) {
        return $this->_getAttributes($param);
    }
}

?>
