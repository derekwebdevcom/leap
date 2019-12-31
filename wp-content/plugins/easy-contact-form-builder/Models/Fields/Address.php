<?php

namespace GDForm\Models\Fields;

use GDForm\Helpers\Countries;

use GDForm\Helpers\View;

/**
 * Class Address
 * @package GDForm\Models\Fields
 */
class Address extends Field
{
    protected $TypeId = 16;

    /**
     * List of countries
     *
     * @var string
     */
    private $Countries ;

    /**
     * Show/Hide Country Select
     *
     * @var int 0|1
     */
    private $ShowCountry = '1';

    /**
     * Show/Hide City Field
     *
     * @var int 0|1
     */
    private $ShowCity = '1';

    /**
     * Show/Hide State Select
     *
     * @var int 0|1
     */
    private $ShowState = '1';

    /**
     * Show/Hide Zip Field
     *
     * @var int 0|1
     */
    private $ShowZip = '1';

    /**
     * Show/Hide Address/Address Line 2 Fields
     *
     * @var int 0|1
     */
    private $ShowAddress = '1';

    /**
     * Show/Hide Search in countries dropdown
     *
     * @var int 0|1
     */
    private $SearchOn = '1';


    public function __construct( $args = array() )
    {
        if (isset($args['Id'])) {
            $id = absint($args['Id']);
            if ($id !== null && absint($id) == $id) {
                global $wpdb;

                $field = $wpdb->get_row($wpdb->prepare(
                    "SELECT * FROM " . self::getTableName() . " as Fields INNER JOIN " . $wpdb->prefix . "GDFormAddressFieldOptions as addressOptions ON addressOptions.Field=Fields.Id WHERE Fields.Id=%d",
                    $id
                ), ARRAY_A);

                if (!is_null($field)) {

                    $this->Id = $id;

                    foreach ($field as $fieldOptionName => $fieldOptionValue) {

                        $functionName = 'set' . $fieldOptionName;
                        self::$dbFields[] = $fieldOptionName;
                        if (method_exists($this, $functionName)) {
                            call_user_func(array($this, $functionName), $fieldOptionValue);
                        }

                    }

                }
            }
        }

    }


    /**
     * @return int
     */
    public function getShowCountry()
    {
        return $this->ShowCountry;
    }

    /**
     * @param int $show
     *
     * @return Address
     */
    public function setShowCountry($show)
    {

        if (in_array($show, array(0, 1, 'on'))) {

            if ($show == 'on') $show = 1;
            $this->ShowCountry = intval($show);

        }

        return $this;
    }

    /**
     * @return int
     */
    public function getShowState()
    {
        return $this->ShowState;
    }

    /**
     * @param int $show
     *
     * @return Address
     */
    public function setShowState($show)
    {

        if (in_array($show, array(0, 1, 'on'))) {

            if ($show == 'on') $show = 1;
            $this->ShowState = intval($show);

        }

        return $this;
    }

    /**
     * @return int
     */
    public function getShowCity()
    {
        return $this->ShowCity;
    }

    /**
     * @param int $show
     *
     * @return Address
     */
    public function setShowCity($show)
    {

        if (in_array($show, array(0, 1, 'on'))) {

            if ($show == 'on') $show = 1;
            $this->ShowCity = intval($show);

        }

        return $this;
    }

    /**
     * @return int
     */
    public function getShowZip()
    {
        return $this->ShowZip;
    }

    /**
     * @param int $show
     *
     * @return Address
     */
    public function SetShowZip($show)
    {

        if (in_array($show, array(0, 1, 'on'))) {

            if ($show == 'on') $show = 1;
            $this->ShowZip = intval($show);

        }

        return $this;
    }

    /**
     * @return int
     */
    public function getShowAddress()
    {
        return $this->ShowAddress;
    }

    /**
     * @param int $show
     *
     * @return Address
     */
    public function setShowAddress($show)
    {

        if (in_array($show, array(0, 1, 'on'))) {

            if ($show == 'on') $show = 1;
            $this->ShowAddress = intval($show);

        }

        return $this;
    }

    /**
     * @return int
     */
    public function getSearchOn()
    {
        return $this->SearchOn;
    }

    /**
     * @param int $show
     *
     * @return Address
     */
    public function setSearchOn($show)
    {

        if (in_array($show, array(0, 1, 'on'))) {

            if ($show == 'on') $show = 1;
            $this->SearchOn = intval($show);

        }

        return $this;
    }

    /**
     * @return array
     */
    public function getCountries()
    {
        $countries_array = explode(',', $this->Countries);
        return $countries_array;
    }

    /**
     * @param string $countries
     *
     * @return Address
     */
    public function setCountries($countries)
    {

        $countries_from_db = sanitize_text_field($countries);
        if ($countries_from_db == '') {
            $this->Countries = Countries::get_countries();
        } else {
            $this->Countries = sanitize_text_field($countries);
        }

        return $this;
    }


    public function save($FieldId = null)
    {
        global $wpdb;

        $fieldData = self::prepareSaveData($FieldId, array(
            'Form' => $this->getForm(),
            'Label' => $this->Label,
            'TypeId' => $this->TypeId,
            'LabelPosition' => $this->LabelPosition,
            'Class' => $this->Class,
            'Ordering' => $this->Ordering,
            'ContainerClass' => $this->ContainerClass,
            'HelperText' => $this->HelperText,
        ));


        $FieldData = is_null($this->Id)
            ? $wpdb->insert(self::getTableName(), $fieldData)
            : $wpdb->update(self::getTableName(), $fieldData, array('Id' => $this->Id));


        if ($FieldData !== false && !isset($this->Id)) {
            $this->Id = $wpdb->insert_id;

            $AddressFieldData = self::prepareSaveData(null, array(
                'Field' => $this->Id,
                'Countries' => Countries::get_countries('string'),
                'ShowCountry' => $this->ShowCountry,
                'ShowCity' => $this->ShowCity,
                'ShowState' => $this->ShowState,
                'ShowAddress' => $this->ShowAddress,
                'ShowZip' => $this->ShowZip,
                'SearchOn' => $this->SearchOn,
            ));

            $wpdb->insert($wpdb->prefix . 'GDFormAddressFieldOptions', $AddressFieldData);

            return $this->Id;

        } elseif ($FieldData !== false && isset($this->Id)) {
            $AddressFieldData = self::prepareSaveData(null, array(
                'Field' => $this->Id,
                'Countries' => $this->Countries,
                'ShowCountry' => $this->ShowCountry,
                'ShowCity' => $this->ShowCity,
                'ShowState' => $this->ShowState,
                'ShowAddress' => $this->ShowAddress,
                'ShowZip' => $this->ShowZip,
                'SearchOn' => $this->SearchOn,
            ));

            $wpdb->update($wpdb->prefix . 'GDFormAddressFieldOptions', $AddressFieldData, array('field' => $this->Id));

            return $this->Id;

        } else {

            return false;

        }
    }


    public function settingsBlock()
    {
        $settings_block_html = '<div class="settings-block pro_option" data-field-id="' . $this->Id . '">';

        $settings_block_html .= View::buffer('admin/FieldSettings/FieldTypeSettingRow.php', array('field' => $this));
        $settings_block_html .= View::buffer('admin/FieldSettings/LabelSettingRow.php', array('field' => $this));
        $settings_block_html .= View::buffer('admin/FieldSettings/LabelPositionSettingRow.php', array('field' => $this));
        $settings_block_html .= View::buffer('admin/FieldSettings/SearchSettingRow.php', array('field' => $this));
        $settings_block_html .= View::buffer('admin/FieldSettings/AddressFieldsSettingRow.php', array('field' => $this));
        $settings_block_html .= View::buffer('admin/FieldSettings/CountriesSettingRow.php', array('field' => $this));
        $settings_block_html .= View::buffer('admin/FieldSettings/ClassSettingRow.php', array('field' => $this));
        $settings_block_html .= View::buffer('admin/FieldSettings/ContainerClassSettingRow.php', array('field' => $this));
        $settings_block_html .= View::buffer('admin/FieldSettings/HelptextSettingRow.php', array('field' => $this));
        $settings_block_html .= View::buffer('admin/FieldSettings/OrderSettingRow.php', array('field' => $this));
	    $settings_block_html .= '<div class="pro_option_notifi">
									<p>Address Field is Unavailable on This Version of Plugin.</br> You Can Unlock It By Upgrading Forms Plugin</p>
									<p class="small_error">(Now the field will not appear on front end)</p>
									<a href="https://grandwp.com/wordpress-contact-form-builder" class="gd-button" target="_blank">Unlock Field</a>
								</div>';
	    $settings_block_html .= '</div>';

        return $settings_block_html;
    }

    public function fieldHtml()
    {
       // View::render('frontend/Fields/Address.php', array('field' => $this));
    }

    public function setProperties($fields_settings, $field_id)
    {
        parent::setProperties($fields_settings, $field_id);

        $this->setShowCountry($fields_settings['show_country-' . $field_id]);
        $this->setShowState($fields_settings['show_state-' . $field_id]);
        $this->setShowCity($fields_settings['show_city-' . $field_id]);
        $this->setShowAddress($fields_settings['show_address-' . $field_id]);
        $this->setShowZip($fields_settings['show_zip-' . $field_id]);
        $this->setSearchOn($fields_settings['searchOn-' . $field_id]);
        $this->setCountries($fields_settings['countries-' . $field_id]);

    }


}