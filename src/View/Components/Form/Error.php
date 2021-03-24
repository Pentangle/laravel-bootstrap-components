<?php

namespace Pentangle\BootstrapComponents\View\Components\Form;

use Illuminate\View\Component;

class Error extends Component
{
    /**
     * @var string
     */
    public string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function render()
    {
        return view('bootstrap-components::form.error');
    }
}
