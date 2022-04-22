<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use DG\BypassFinals;

class Unit extends \Codeception\Module
{

    /**
     * @return void
     */
    public function _initialize(): void
    {
        BypassFinals::enable();
    }
}
