<?php

class InvitacionListadoEmailsForm extends sfForm
{
    public function configure()
    {
        $contacts = $this->getDefaults();        
        $emailWidgets = array();
        $emailValidators = array();
        $labels = array();
        foreach ($contacts as $contact) {
            $labels[] = "{$contact['name']} <em>({$contact['email']})</em>";
            $emailWidgets[] = new sfWidgetFormInputCheckbox(array(
            	'value_attribute_value' => $contact['email'],				       
            ));
            $emailValidators[] = new sfValidatorEmail(array('required' => false));
        }
        $schema = new sfWidgetFormSchema($emailWidgets);
        $schema->setLabels($labels);
        $schema->setFormFormatterName('list');
        $this->setWidget('emails', $schema);
        $this->setValidator('emails', new sfValidatorSchema($emailValidators));
        $this->getWidgetSchema()->setNameFormat('invitacion_listado[%s]');
    }
 }