<?php
/**
 * @var $field \GDForm\Models\Fields\Address
 */
?>
<div class="setting-row"><label>Countries List</label>
<select class="select2" multiple="multiple" name="countries-<?php echo $field->getId();?>">

<?php
foreach (\GDForm\Helpers\Countries::get_countries() as $country_name=>$country_key){
    $selected = in_array( $country_name, $field->getCountries()) ? 'selected="selected"' : '';
    echo '<option '.$selected.'>'.$country_name.'</option>';
}
?>
</select>
</div>

