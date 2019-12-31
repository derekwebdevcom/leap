<?php
/**
 * @var $field \GDForm\Models\Fields\Password
 */

echo  '<div class="setting-row"><label for="password_view-'.$field->getId().'">'.__('Password View Toggle',GDFRM_TEXT_DOMAIN).' <input type="checkbox" class="setting-input switch-checkbox" '.checked('1',$field->getPasswordViewToggle(),false).' name="password_view-'.$field->getId().'" id="password_view-'.$field->getId().'"><span class="switch" ></span></label></div>';
