<?php
/**
 * @var $field \GDForm\Models\Fields\Address
 */
$setting_html = '<div class="setting-row">';
$setting_html .= '<label for="switch-country-'.$field->getId().'"><span class="checkbox-label">Country</span><input type="checkbox" id="switch-country-'.$field->getId().'" class="switch-checkbox" '.checked('1',$field->getShowCountry(),false).' name="show_country-'.$field->getId().'"><span class="switch"></span></label>';
$setting_html .= '<label for="switch-state-'.$field->getId().'"><span class="checkbox-label">State</span><input type="checkbox" id="switch-state-'.$field->getId().'" class="switch-checkbox" '.checked('1',$field->getShowState(),false).' name="show_state-'.$field->getId().'"><span class="switch"></span></label>';
$setting_html .= '<label for="switch-city-'.$field->getId().'"><span class="checkbox-label">City</span><input type="checkbox" id="switch-city-'.$field->getId().'" class="switch-checkbox" '.checked('1',$field->getShowCity(),false).' name="show_city-'.$field->getId().'"><span class="switch"></span></label>';
$setting_html .= '<label for="switch-zip-'.$field->getId().'"><span class="checkbox-label">Zip</span><input type="checkbox" id="switch-zip-'.$field->getId().'" class="switch-checkbox" '.checked('1',$field->getShowZip(),false).' name="show_zip-'.$field->getId().'"><span class="switch"></span></label>';
$setting_html .= '<label for="switch-address-'.$field->getId().'"><span class="checkbox-label">Address Lines</span><input type="checkbox" id="switch-address-'.$field->getId().'" class="switch-checkbox" '.checked('1',$field->getShowAddress(),false).' name="show_address-'.$field->getId().'"><span class="switch"></span></label>';
$setting_html .= '</div>';
echo  $setting_html;