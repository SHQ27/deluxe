<?php

class pmWidgetCampanaUsuarios extends sfWidgetForm
{
  public function __construct($options = array(), $attributes = array())
  {
	parent::__construct($options, $attributes);
  }

  protected function configure($options = array(), $attributes = array())
  {  	
    parent::configure($options,$attributes);
  }

  public function render($name, $value = null, $attributes = array(), $errors = array())
  {  		
  		// Definicion de los campos que componen al widget
		
		$email = new sfWidgetFormInput();
		$emailHidden = new sfWidgetFormInputHidden();
		
		// Definicion del template
		$template  = '';
		
		$template .= $email->render($name.'[email][]');
		
		$template .= '<table id="' . $this->generateId($name) . '_table">';
		
		$c = 0;
		if (isset($value['email']))
		{
			$c = count($value['email']);
			$c = ($c > 0)? $c : 0;
		}
	
		$template .= '<tr>';
		$template .= '	<td class="center">Email</td>';
		$template .= '	<td class="center">Usuario</td>';
		$template .= '	<td class="center" colspan="2" width="100">Acciones</td>';
		$template .= '</tr>';
				
		for($i=0;$i<$c;$i++)
		{
			$valueEmail = isset($value['email'][$i]) ? $value['email'][$i] : '';
			$valueUsuario = isset($value['usuario'][$i]) ? $value['usuario'][$i] : '';			
			
			$template .= '<tr rel="' . $valueEmail . '">';
			$template .= '	<td>' . $emailHidden->render($name.'[email][]', $valueEmail) . $valueEmail . '</td>';
			$template .= '	<td>' . $valueUsuario . '</td>';
			
			if ($valueEmail)
			{
				$template .= '	<td class="remove"><a></a></td>';
				$template .= '	<td class="resend"><a title="Renviar Datos de Acceso"></a></td>';
			}			
			$template .= '</tr>';
		}
		
		$template .= '</table>';
		
		$template .= '<a id="' . $this->generateId($name) . '_addItem">Agregar item</a>';
		
		
		return $template;
  	
  }
}
?>