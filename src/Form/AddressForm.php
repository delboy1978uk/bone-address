<?php

declare(strict_types=1);

namespace Bone\Address\Form;

use Del\Form\AbstractForm;
use Del\Form\Field\Submit;
use Del\Form\Renderer\HorizontalFormRenderer;

class AddressForm extends AbstractForm
{
    use AddressFormTrait;

    public function init(): void
    {
        $this->addAddressFields($this);
        $submit = new Submit('submit');
        $submit->setClass('btn btn-primary pull-right');
        $this->addField($submit);
        $this->setFormRenderer(new HorizontalFormRenderer());
    }
}
