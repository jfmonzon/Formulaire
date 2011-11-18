<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of javascript
 *
 * @author Gaming
 */
class Javascript extends Form {
    
    function __construct() {
    }
    
        
    /* update_generate method
     * ======================
     * returns an string containing javascript function that can be used to update any div with an AJAX response
     * 
     * @param options: array()
     * -----------------------
     * $options: target_id  : id of the object that will be updated
     * $options: url        : AJAX href
     * $options: method     : AJAX method
     * $options: parameters : array with all other parameteres    
     * 
     * @return $js : string containg javascript function
     * 
     */
    public function update_generate( $options = array() ) {
        
        $jsobject = array();
        
        $required = array(
            'target_id',
            'url',
        );
        
        // verifies required value
        if( !$this->_required($required, $options) ) return NULL;
        
        // set default values
        $default    = array(
            'parameters'        => array(
                'task'          => '"updater_' . $options['target_id'] . '"',
                'value'         => '$F(this)',
                'current_id'    => 'this.id'
            ),
        );    
        
        // merge default values
        $options = $this->_default($default, $options);   
        
        if ( isset($options['parameters']) && count($options['parameters']))    $jsobject[] = $this->_parameters_generate ($options);
        
        if ( isset($options['method']) )                                        $jsobject[] = $this->_method_generate ($options);
        
        $js  = "new Ajax.Updater('" . $this->_js_escape($options['target_id']) . "', '" . $this->_js_escape($options['url']) . "', {";
        
        $js .= implode(", ", $jsobject); 
        
        $js .= "});";
        
        return $js;
        
    }
        

    /* _parameteres_generate method
     * ============================
     * returns an string with parameters for this AJAX call
     * 
     * @param: options, array with all options
     * @return: string, string with parameters
     */    
    private function _parameters_generate ($options = array()) {
        
        $string = NULL;
        
        foreach( $options['parameters'] as $key => $value)      $string .= $key . ' : ' . $this->_js_escape ($value) . ',';
        
        $string = substr($string, 0, -1);
        
        return 'parameters: {' . $string . '}';
    }
    
    /* _method_generate method
     * =======================
     * returns an string with method for this AJAX call
     * 
     * @param: options, array with all options
     * @return: string, string with method section
     */    
    private function _method_generate ($options = array()) {
        
        $string = NULL;
        
        foreach( $options['parameters'] as $key => $value)      $string .= $key . ' : ' . $this->_js_escape ($value) . ',';
        
        return "method: '" . $this->_js_escape ($options['method']) . "'";
    }      
    
}

