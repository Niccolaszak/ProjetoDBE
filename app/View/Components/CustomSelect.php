<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CustomSelect extends Component
{
    public $name;
    public $options;
    public $label;
    public $placeholder;

    public function __construct($name, $options, $label = null, $placeholder = 'Selecione')
    {
        $this->name = $name;
        $this->options = $options;
        $this->label = $label;
        $this->placeholder = $placeholder;
    }

    public function render()
    {
        return view('components.custom-select');
    }
}