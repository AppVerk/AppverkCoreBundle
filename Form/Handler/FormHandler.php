<?php

namespace Cube\CoreBundle\Form\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

abstract class FormHandler
{
    /** @var Request */
    protected $request;

    /** @var Form */
    protected $form;

    public function setRequest(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
        return $this;
    }

    public function getForm()
    {
        return $this->form;
    }

    public function setForm(Form $form)
    {
        $this->form = $form;

        return $this;
    }

    public function getFormView()
    {
        return $this->form->createView();
    }

    public function getFormErrors()
    {
        return $this->processFormErrors($this->form);
    }

    protected function processFormErrors(Form $form)
    {
        $errors = [];
        /** @var Form $f */
        foreach ($form->getIterator() as $f) {
            if ($f instanceof Form) {
                $childErrors = $this->processFormErrors($f);
                if ($childErrors) {
                    $errors[$f->getName()] = $childErrors;
                }
            }
        }
        $selfErrors = [];
        foreach ($form->getErrors() as $e) {
            $selfErrors[] = $e->getMessage();
        }
        if ($selfErrors) {
            $errors['message'] = implode($selfErrors, '\n');
        }

        return $errors;
    }

    public function process($data = null)
    {
        if ($data) {
            $this->form->setData($data);
        }

        if ('GET' !== $this->request->getMethod()) {
            $this->form->submit($this->request);

            if ($this->form->isValid()) {
                return $this->doProcessForm();
            }
        }

        return false;
    }

    /**
     * @return boolean Has form processed successfully
     */
    abstract protected function doProcessForm();
}
