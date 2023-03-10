<?php


class OpenpayQr extends OpenpayApiResourceBase {

    public $validityDate;
    public $enable;

    public function save() {
        return $this->_update();
    }

    public function delete() {
        $this->_delete();
    }
}

class OpenpayQrList extends OpenpayApiDerivedResource {

}