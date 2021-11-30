<?php

namespace Openpay\Resources;

use Openpay\Data\OpenpayApiResourceBase;

class OpenpayWebhook extends OpenpayApiResourceBase
{

    protected $url;
    protected $event_types;

    public function save()
    {
        return $this->_update();
    }

    public function delete()
    {
        $this->_delete();
    }

}

?>
