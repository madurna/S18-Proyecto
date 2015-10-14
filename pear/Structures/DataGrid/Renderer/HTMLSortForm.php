<?php
/**
 * Multiple fields sorting form rendering driver
 * 
 * PHP versions 4 and 5
 *
 * LICENSE:
 * 
 * Copyright (c) 1997-2007, Andrew Nagy <asnagy@webitecture.org>,
 *                          Olivier Guilyardi <olivier@samalyse.com>,
 *                          Mark Wiesemann <wiesemann@php.net>
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *    * Redistributions of source code must retain the above copyright
 *      notice, this list of conditions and the following disclaimer.
 *    * Redistributions in binary form must reproduce the above copyright
 *      notice, this list of conditions and the following disclaimer in the 
 *      documentation and/or other materials provided with the distribution.
 *    * The names of the authors may not be used to endorse or promote products 
 *      derived from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS
 * IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO,
 * THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
 * PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR
 * CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 * EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
 * PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR
 * PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY
 * OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 * NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * CSV file id: $Id: HTMLSortForm.php,v 1.16 2007/12/07 17:22:58 wiesemann Exp $
 *
 * @version  $Revision: 1.16 $
 * @package  Structures_DataGrid_Renderer_HTMLSortForm
 * @category Structures
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 */

require_once 'Structures/DataGrid/Renderer.php';
require_once 'HTML/QuickForm.php';

/**
 * Multiple fields sorting form rendering driver
 *
 * This driver renders a form (using HTML_QuickForm) so that the user can
 * select several fields and directions to sort the datagrid by.
 *
 * SUPPORTED OPTIONS:
 * 
 * - sortFieldsNum:     (int)       How many fields the user will be able to sort by.
 *                                  This has no effect if the backend does not 
 *                                  support sorting by multiple fields.
 * - directionStyle:    (string)    Whether to render the direction form 
 *                                  elements as 'select' or 'radio' elements
 * - textChoose:        (string)    What to display in the select box when no 
 *                                  field is selected (first option)
 * - textAscending:     (string)    Label for the ASC direction
 * - textDescending:    (string)    Label for the DESC direction
 * - textSortBy:        (string)    Label for the first field
 * - textThenBy:        (string)    Label for the second and following fields
 * - textSubmit:        (string)    Label for the submit button
 * - columnAttributes:  (-)         IGNORED
 *
 * SUPPORTED OPERATION MODES:
 *
 * - Container Support: yes
 * - Output Buffering:  yes
 * - Direct Rendering:  no
 * - Streaming:         no
 * - Object Preserving: no
 *
 * @version  $Revision: 1.16 $
 * @example  fill-sortform.php Fill a form with sort fields 
 * @author   Olivier Guilyardi <olivier@samalyse.com>
 * @access   public
 * @package  Structures_DataGrid_Renderer_HTMLSortForm 
 * @category Structures
 */
class Structures_DataGrid_Renderer_HTMLSortForm 
    extends Structures_DataGrid_Renderer
{
    /**
     * Rendering container
     * @var object HTML_QuickForm object
     * @access protected
     */
    var $_form;

    /**
     * Whether the container was provided by the user
     * @var bool
     * @access protected
     */
    var $_isUserContainer;
    
    /**
     * Constructor
     *
     * Build default values
     *
     * @access  public
     */
    function Structures_DataGrid_Renderer_HTMLSortForm()
    {
        parent::Structures_DataGrid_Renderer();
        $this->_addDefaultOptions(
            array(
                'sortFieldsNum'     => 3,
                'directionStyle'    => 'select',
                'textChoose'        => 'Choose...',
                'textAscending'     => 'Ascending',
                'textDescending'    => 'Descending',
                'textSortBy'        => 'Sort by:',
                'textThenBy'        => 'Then by:',
                'textSubmit'        => 'Submit',
            )
        );
        $this->_setFeatures(
            array(
                'outputBuffering' => true,
            )
        );
    }

    /**
     * Attach an already instantiated HTML_QuickForm object
     *
     * @var object HTML_QuickForm object
     * @return mixed  True or PEAR_Error
     * @access public
     */
    function setContainer(&$form)
    {
        $this->_form =& $form;
        return true;
    }
    
    /**
     * Return the currently used HTML_QuickForm object
     *
     * @return object HTML_QuickForm (reference to) or PEAR_Error
     * @access public
     */
    function &getContainer()
    {
        isset($this->_form) or $this->init();
        return $this->_form;
    }
    
    /**
     * Instantiate the HTML_QuickForm container if needed, and set it up
     * 
     * @access protected
     */
    function init()
    {
        if (!isset($this->_form)) {
            // Try to give the form a unique name using $_requestPrefix
            $this->_form =& new HTML_QuickForm(
                    "{$this->_requestPrefix}DataGridSortForm", 'get');
            $this->_isUserContainer = false;
        } else {
            // FIXME: Isn't it a bit risky to set this flag here, because this method could be called more than once?
            $this->_isUserContainer = true;
        }

        if (!$this->_form->getAttribute('onsubmit') && 
                !$this->_form->getAttribute('onSubmit')) {
            $ii = $this->_multiSort ? $this->_options['sortFieldsNum'] : 1;
            $sort = array();
            for ($i = 0; $i < $ii; $i++) {
                $sort[] = "{field: this.elements[" . ($i * 2) . "].value, " . 
                          "direction: this.elements[" . ($i * 2 + 1) . "].value}";
            }
            $sort = '[' . join(',', $sort) . ']';
            if ($handler = $this->_buildOnMoveCall($this->_page, $sort)) {
                $this->_form->setAttribute('onsubmit', "return $handler");
            }
        }

    }

    /**
     * Build form elements
     *
     * @param   array $columns Columns' fields names and labels 
     * @access  protected
     * @return  void
     */
    function buildBody()
    {
        // Build select options from sortable fields information
        $options = array();
        foreach ($this->_columns as $spec) {
            if (in_array ($spec['field'], $this->_sortableFields)) {
                $options[$spec['field']] = $spec['label'];
            }
        }
       
        if ($options) {
            // Make options pretty
            asort($options);
            $options = array_merge(array('' => $this->_options['textChoose']), 
                                   $options);
            
            // Build element groups
            $ii = $this->_multiSort ? $this->_options['sortFieldsNum'] : 1;
            for ($i=0; $i < $ii; $i++) {
                
                // Create the field select element
                $select =& HTML_QuickForm::createElement(
                        'select', "{$this->_requestPrefix}orderBy[$i]");
                $select->loadArray($options);
                
                // Make direction chooser
                $label = ($i == 0) ? $this->_options['textSortBy'] 
                                   : $this->_options['textThenBy'];
                
                if ($this->_options['directionStyle'] == 'radio') {
                    // radio button style
                    $asc =& HTML_QuickForm::createElement(
                            'radio', "{$this->_requestPrefix}direction[$i]", 
                            null, $this->_options['textAscending'], 'ASC');
                    $desc =& HTML_QuickForm::createElement(
                            'radio', "{$this->_requestPrefix}direction[$i]", 
                            null, $this->_options['textDescending'], 'DESC');
                    $this->_form->addGroup(array($select, $asc, $desc), null, $label);
                } else {
                    // select style
                    $dirSelect =& HTML_QuickForm::createElement(
                            'select', "{$this->_requestPrefix}direction[$i]");
                    $dirSelect->loadArray(
                            array('ASC' => $this->_options['textAscending'], 
                                  'DESC' => $this->_options['textDescending']));
                    $this->_form->addGroup(array($select, $dirSelect), null, $label);
                }
            }

            // Set elements values from $_currentSort
            reset ($this->_currentSort);
            $values = array();
            for ($i=0; $i < $this->_options['sortFieldsNum']; $i++) {
                if (list($field, $direction) = each($this->_currentSort)) {
                    $values["{$this->_requestPrefix}orderBy[$i]"] = $field;
                    $values["{$this->_requestPrefix}direction[$i]"] = $direction;
                } else {
                    $values["{$this->_requestPrefix}orderBy[$i]"] = '';
                    $values["{$this->_requestPrefix}direction[$i]"] = 'ASC';
                }
            }
            $this->_form->setConstants($values);

            // Only add a submit button and extraVars if the QF container wasn't
            // provided by the user
            if (!$this->_isUserContainer) {
                $this->_form->addElement('submit', null, $this->_options['textSubmit']);
                foreach($this->_options['extraVars'] as $var => $value) {
                    $this->_form->addElement('hidden', $var, $value);
                }
            }
        }
    }

    /**
     * Retrieve output from the container object 
     *
     * @return mixed Output
     * @access protected
     */
    function flatten()
    {
        return $this->_form->toHTML();
    }

}

/* vim: set expandtab tabstop=4 shiftwidth=4: */
?>
