<?php

namespace GDForm\Models\Fields;

use GDForm\Controllers\LoginController;
use GDForm\Controllers\SignupController;
use GDForm\Helpers\View;

class Password extends Field
{
    protected $TypeId = 14;

    protected static $dbFields = array(
        'Label',
        'Ordering',
        'LabelPosition',
        'DefaultValue',
        'Class',
        'ContainerClass',
        'Placeholder',
        'HelperText',
        'Required',
        'Disabled',
        'Form',
        'LimitNumber',
        'LimitType',
        'LimitText',
        'PasswordViewToggle',
        'TypeId'
    );

    /**
     * Limit input length
     *
     * @var int
     */
    private $LimitNumber;

    /**
     * Input limit type
     *
     * @var string char
     */
    private $LimitType='char';

    /**
     * Text while typing
     *
     * @var string
     */
    private $LimitText;

    /**
     * Show hide password view toggle
     *
     * @var int 0/1
     */
    private $PasswordViewToggle;


    /**
     * @return int
     */
    public function getLimitNumber()
    {
        return $this->LimitNumber;
    }

    /**
     * @param int $value
     *
     * @return Password
     */
    public function setLimitNumber( $value ) {
        if( absint($value) == $value){

            $this->LimitNumber = intval( $value );
        }

        return $this;
    }

    /**
     * @return string char/word
     */
    public function getLimitType()
    {
        return $this->LimitType;
    }

    /**
     * @param string $value
     *
     * @return Password
     */
    public function setLimitType( $value ) {
        if(in_array($value,array('char','word'))){

            $this->LimitType =  $value ;

        }

        return $this;
    }

    /**
     * @return string
     */
    public function getLimitText()
    {
        return $this->LimitText;
    }

    /**
     * @param string $value
     *
     * @return Password
     */
    public function setLimitText( $value )
    {
        $this->LimitText = sanitize_text_field( $value );

        return $this;
    }

    /**
     * @return int 0/1
     */
    public function getPasswordViewToggle()
    {
        return $this->PasswordViewToggle;
    }

    /**
     * @param string $value
     *
     * @return Password
     */
    public function setPasswordViewToggle( $value ) {
        if(in_array($value,array(0,1,'on'))){

            if($value=='on') $value=1;
            $this->PasswordViewToggle = intval( $value );

        }

        return $this;
    }

    public function settingsBlock()
    {
        $settings_block_html='<div class="settings-block pro_option" data-field-id="'.$this->Id.'">';

        $settings_block_html .= View::buffer('admin/FieldSettings/FieldTypeSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/LabelSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/LabelPositionSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/PlaceholderSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/PasswordViewSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/InputLengthSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/TextLeftSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/ClassSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/ContainerClassSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/HelptextSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/OrderSettingRow.php', array('field'=>$this));
	    $settings_block_html .= '<div class="pro_option_notifi">
									<p>Password Field is Unavailable on This Version of Plugin.</br> You Can Unlock It By Upgrading Forms Plugin</p>
									<p class="small_error">(Now the field will not appear on front end)</p>
									<a href="https://grandwp.com/wordpress-contact-form-builder" class="gd-button" target="_blank">Unlock Field</a>
								</div>';
        $settings_block_html.='</div>';

        return $settings_block_html;


    }

    public function fieldHtml()
    {
       // if( $this->getFormObject()->getThemeId() !==1 ) View::render('frontend/FieldThemes/Password.php', array('field'=>$this));
        //else View::render('frontend/Fields/Password.php',array('field'=>$this));
    }

    public function setProperties($fields_settings, $field_id)
    {
        parent::setProperties($fields_settings, $field_id);

        $this->setLimitNumber($fields_settings['limit-'.$field_id]);
        $this->setLimitText($fields_settings['limitText-'.$field_id]);
        $this->setPasswordViewToggle($fields_settings['password_view-'.$field_id]);

    }


    /**
     * validate text field
     * @param $data
     * @return true/false
     */
    public function validate( $data )
    {
        if(isset($data['field-'.$this->Id]) && $data['field-'.$this->Id]!=''){
            $value = $data['field-'.$this->Id];

            LoginController::setProperty('Password',$value);

            if(SignupController::$Password) {
                if($value != SignupController::$Password){
                    return __( 'Passwords do not match', GDFRM_TEXT_DOMAIN ) ;
                }
            } else {
                SignupController::setProperty('Password',$value);
            }
        }
        return true;
    }
}