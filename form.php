<?php

/**
 * Class Form
 * -----------
 * Generates html code for forms
 * 
 * @author Javier Monzón jfmonzon1@hotmail.com
 * @author Danilo Lizama dlizama@cisal.cl
 * 
 * 2011 / 11 /18
 * 
 * usage
 * -------------------
   Description of form
        $form = new Form;
         $js = new Javascript;
 
 
        $questions = array( 
            array(
                'name'  => 'hola',
                'type'  => 'textarea',
                'id'    => 'mi_text',
                'value' => 'mi texto',
                'cols'  => 40,
                'rows'  => 10,
                'onblur' => $js->update_generate( array('target_id' => 'hola', 'url' => '#')),
            ), 
        );
        $options = array( 'action' => "#" , 'questions' => $questions);

        $html .= $form->form_generate($options);


 */
class Form {
    
    public $html = NULL;
    
    protected $atributtes_common = array(
        'id',
        'class',
        'name',
        'title',
        'tabindex',
        'accesskey',
        'disabled',
        'readonly',
        'onclick',
        'onchange',
        'onblur',
        'ondblclick',
        'onfocus',
        'onmousedown',
        'onmousemove',
        'onmouseout',
        'onmouseover',
        'onmouseup',
        'onkeydown',
        'onkeypress',
        'onkeyup',
        'onselect',
    );
    
    
    function __construct(){

    }
    
    /* question_generate method
     * ========================
     * devuelve el código html con el contenido y opciones de un formulario
     * 
     * $options = array() : array que contiene las opciones
     * ----------------------------------------------------
     * options: values:
     * ---------------
     * 
     * 
     */
    public function form_generate( $options = array() ){
        
        $element    = array();
        $questions  = NULL;
        
        // set required values
        $required   = array(
            'action',
        );
        
        // set default values
        $default    = array(
            'method' => 'POST', 
        ); 
                             
        $attributes = array(
            'action',
            'method',
            'enctype',
            'onsubmit',
            'onreset',
        );
        
        $attributes = $this->_default($this->atributtes_common, $attributes);
        
        if( !$this->_required($required, $options) ) return false; // verify required values
        
        $options = $this->_default($default, $options); // merge default values
        
        //atributtes
        for ( $i = 0 ; $i < count($attributes); $i++)   $element[] = $this->_attribute ($options, $attributes[$i]);
        
        if (isset($options['questions']) && is_array($options['questions']))
        {
            foreach ($options['questions'] as $question) $questions .= $this->question_generate ($question);
        }
        
        
        $html  = '<form ' . implode(" ", $element) . '>' . $questions . '</form>';              
        
        $this->html = $html;
        
        return $html;
    }
    
    /* question_generate method
     * ========================
     * devuelve el código html con el contenido y opciones de un objeto del formulario
     * 
     * $options = array() : array que contiene las opciones
     * ----------------------------------------------------
     * options: values:
     * ---------------
     * type: textarea, text, num, boolean, radio, select, file
     * 
     */
    public function question_generate( $options = array() ) {
        
        $html = NULL;
        
        $required = array(
            'type',
            'name',
        );
        
        if( !$this->_required($required, $options) ) return false; // verify required values
        
        if      ( isset($options['label']) )        $html .= $this->_label($options);
        
        if      ( $options['type'] == 'textarea')   $html .= $this->_textarea_generate($options);
        elseif  ( $options['type'] == 'select')     $html .= $this->_select_generate($options);
        else                                        $html .= $this->_input_generate ($options);   
        
        $this->html = $html;
        
        return $html;
    }    
    
    
    /* _input_generate method
     * ========================
     * devuelve el código html con el contenido y opciones de un objeto input del formulario
     * 
     * $options = array() : array que contiene las opciones
     * 
     * @return $html string contaning html code for an input element
     * 
     */
    private function _input_generate( $options = array() ) {
        
        $element = array();
        
        // set default values
        $default    = array(); 
                             
        $attributes = array(
            'type',
            'checked',
            'maxlenght',
            'size',
            'src',
            'value',
        );  
        
        $attributes = $this->_default($this->atributtes_common, $attributes);
        
        // merge default values
        $options = $this->_default($default, $options); 
        
        //atributtes
        for ( $i = 0 ; $i < count($attributes); $i++)   $element[] = $this->_attribute ($options, $attributes[$i]);
        
        $html = '<input ' . implode(" ", $element) . '/>';
        
        if (isset($options['text'])) $html .= $options['text'];
                       
        return $html;        
          
    }
    
    /* _textarea_generate method
     * ========================
     * devuelve el código html con el contenido y opciones de un objeto textarea del formulario
     * 
     * $options = array() : array que contiene las opciones
     * 
     * @return $html string contaning html code for an textarea element
     * 
     */
    private function _textarea_generate( $options = array() ) {
        
        $element = array();
        
        $required = array(
            'cols',
            'rows',
        );
        
        if( !$this->_required($required, $options) ) return false; // verify required values               
        
        // set default values
        $default    = array();         
                             
        $attributes = array(
            'cols',
            'rows'
        );       

        $attributes = $this->_default($this->atributtes_common, $attributes);
        
        // merge default values
        $options = $this->_default($default, $options);         
        
        //atributtes
        for ( $i = 0 ; $i < count($attributes); $i++)   $element[] = $this->_attribute ($options, $attributes[$i]);
        
        $html  = '<textarea ' . implode(" ", $element) . '>';
        
        if (isset($options['value'])) $html .= $options['value'];
        
        $html .= '</textarea>';
                       
        return $html;        
          
    }    
    
    
    /* _select_generate method
     * ========================
     * devuelve el código html con el contenido y opciones de un objeto select del formulario
     * 
     * $options = array() : array que contiene las opciones
     * 
     * @return $html string contaning html code for an select element and its options
     * 
     */
    private function _select_generate( $options = array() ) {
        
        $element = array();
        
        // set default values
        $default    = array(); 
                             
        $attributes = array(
            'size',
            'multiple',
        );       
        
        $attributes = $this->_default($this->atributtes_common, $attributes);
        
        // merge default values
        $options = $this->_default($default, $options);         
        
        //atributtes
        for ( $i = 0 ; $i < count($attributes); $i++)   $element[] = $this->_attribute ($options, $attributes[$i]);
        
        $html  = '<select ' . implode(" ", $element) . '>';
        
        if (isset($options['options'])) $html .= $this->_options_generate($options['options']);
        
        $html .= '</select>';
                       
        return $html;        
          
    }      
    
    /* _options_generate method
     * ========================
     * devuelve el código html con el contenido y opciones de un objeto select del formulario
     * 
     * $options = array() : array que contiene las opciones
     * 
     * @return $html string contaning html code for an select element and its options
     * 
     */
    private function _options_generate( $options = array() ) {
        
        if ( !is_array($options) ) return FALSE;
        
        $attributes = array(
            'value',
            'selected',
        );   
        
        $attributes = $this->_default($this->atributtes_common, $attributes);
        
        $html  = NULL;
        
        foreach ($options as $option)
        {
            //atributtes
            $element = array();
            for ( $i = 0 ; $i < count($attributes); $i++)   $element[] = $this->_attribute ($option, $attributes[$i]);

            $html  .= '<option ' . implode(" ", $element) . '>';

            if (isset($option['text'])) $html .= $option['text'];

            $html .= '</option>';

        }
                              
        return $html;        
          
    }          
    
    /* _required method
     * ===============
     * te dice si el array de opciones trae los índices necesarios
     * 
     * @return: boolean
     */
    protected function _required($required, $data)
    {
        foreach ($required as $field)
            if(!isset($data[$field])) return false;
        return true;
    }
    
    
    /* _default method
     * ===============
     * agrega opciones por defecto
     * 
     * @return: boolean
     */     
    protected function _default($defaults, $options)
    {
        return array_merge($defaults, $options);
    }    
    
   
    /* _attributte method
     * ===============
     * escribe los atributos dentro del tag
     * 
     * @return: string
     */
    private function _attribute($options = array(), $attribute = NULL )
    {
        if ( !isset($options[$attribute]) ) return FALSE;
                        
        $element =  is_array($options[$attribute]) ? $attribute . '="' . $this->_js_escape( implode(" ", $options[$attribute]) ) . '"' : $attribute .'="' . $this->_js_escape( $options[$attribute] ) . '"';
        return $element;
    }
    
    /* _label method
     * ===============
     * escribe la etiqueta de la pregunta
     * 
     * @return: html containing label
     */
    private function _label($options = array())
    {
   
        $html = '<label for="' . $options['name'] . '">' . $options['label'] . '</label>';
        
        return $html;
    }          
    

    /* _js_escape method
     * =================
     * eliminates double quotes from any string
     * 
     * @param: string, string to be escaped
     * @return: string, escaped string
     */
    protected function _js_escape($string = NULL){
        
        $search = array('"', "'");
        $new = "'";
        
        return str_replace( $search, $new, $string );
        
    }    
    
    
}