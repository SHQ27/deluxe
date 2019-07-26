<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version690 extends Doctrine_Migration_Base
{
    public function up()
    {
        $eshop = eshopTable::getInstance()->getById(7);
        $eshop->setFormularioTitulo('Contacto');
        $eshop->setFormularioTexto('Para venta por mayor, por favor completa el siguiente formulario');
        $eshop->setFormularioCampos('[{"label":"Nombre","es_largo":false},{"label":"Apellido","es_largo":false},{"label":"Teléfono","es_largo":false},{"label":"E-mail","es_largo":false},{"label":"Domicilio","es_largo":false},{"label":"Localidad","es_largo":false},{"label":"Provincia","es_largo":false},{"label":"Código Postal","es_largo":false},{"label":"País","es_largo":false},{"label":"Marcas que comercializa","es_largo":false},{"label":"Metros de local","es_largo":false},{"label":"Inauguración","es_largo":false},{"label":"Comentarios","es_largo":true}]');
        $eshop->setFormularioTo('sergio@asterisconet.com.ar');
        $eshop->save();
    }

    public function down()
    {
    }
}