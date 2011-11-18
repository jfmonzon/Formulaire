<?php
//example

require_once ('form.php');
require_once  ('javascrip.php');

$form   = new Form;
$js     = new Javascript;

$questions = array( 
    array(
        'name'  => 'hola',
        'label' => 'ingresa tu comentario',
        'type'  => 'textarea',
        'cols'  => 10,
        'rows'  => 10,
        'id'    => 'mi_text',
        'value' => 'mi texto',
        'onblur' => $js->update_generate( array('target_id' => 'hola', 'url' => '#')),
    ), 
    array(
        'name'  => 'hola2',
        'label' => 'ingresa tu comentario',
        'type'  => 'text',
        'class' => 'required',
        'id'    => 'mi_text2',
        'value' => 'mi texto',
    ),  
    
    array(
        'name'  => 'hola',
        'label' => 'ingresa tu comentario',
        'type'  => 'checkbox',
        'id'    => 'mi_text3',
        'value' => 'mi texto',
        'onclick' => 'alert("salut")',
    ),  
    
    array(
        'name'  => 'mi_select',
        'label' => 'elige',
        'type'  => 'select',
        'id'    => 'mino',
        'options' => array( 
            array(
                'value' => 1,
                'text'  => 'volvo',
                'id'    => 'mi_option',
            ),
            array(
                'value' => 2,
                'text'  => 'toyota',
                'class' => 'red'
            ),
        ),
        'onchange' => $js->update_generate( array('target_id' => 'hola', 'url' => '#')),
    ), 
    
);

$form_options = array( 
    'action'    => "#" ,
    'id'        => 'id_form',
    'class'     => 'myclass',
    'questions' => $questions,
    );

echo( $form->form_generate($form_options) );


?>