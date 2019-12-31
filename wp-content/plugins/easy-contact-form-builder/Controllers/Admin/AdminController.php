<?php

namespace GDForm\Controllers\Admin;

use GDForm\Core\Admin\Listener;
use GDForm\Helpers\View;
use GDForm\Models\Fields\Email;
use GDForm\Models\Fields\Address;
use GDForm\Models\Fields\Submit;
use GDForm\Models\Fields\Password;
use GDForm\Helpers\Countries;
use GDForm\Models\Fields\Date;
use GDForm\Models\Fields\Selectbox;
use GDForm\Models\Fields\Text;
use GDForm\Models\Fields\FieldOption;
use GDForm\Models\Fields\Radio;
use GDForm\Models\Fields\Upload;
use GDForm\Models\Fields\Textarea;
use GDForm\Models\Form;
use GDForm\Models\Submission;

class AdminController
{
    use Listener;
    /**
     * Array of pages in admin
     *
     * @var array
     */
    public $Pages;

    public function __construct()
    {
        add_action( 'admin_footer', array( 'GDForm\Controllers\Admin\ShortcodeController', 'showInlinePopup' ) );

        add_action( 'media_buttons_context', array( 'GDForm\Controllers\Admin\ShortcodeController', 'showEditorMediaButton' ) );
        
        add_action( 'admin_menu', array( $this, 'adminMenu' ) , 1);

        add_action( 'admin_init', array( __CLASS__, 'deleteForm' ) , 1);

        add_action( 'admin_init', array( __CLASS__, 'duplicateForm' ) , 1);

        add_action( 'admin_init', array( __CLASS__, 'createForm' ) , 1);

        new ReviewNoticeController();

    }


    /**
     * Add admin menu pages
     */
    public function adminMenu()
    {
        $this->Pages['main_page'] = add_menu_page( __( 'GrandWP Form Builder', GDFRM_TEXT_DOMAIN ), __( 'GrandWP Forms', GDFRM_TEXT_DOMAIN ), 'manage_options', 'gdfrm', array(
            $this,
            'mainPage'
        ),  \GDForm()->pluginUrl() . '/assets/images/forms_logo.png' );

        $this->Pages['forms'] = add_submenu_page( 'gdfrm', __( 'Forms List', GDFRM_TEXT_DOMAIN ), __( 'Forms List', GDFRM_TEXT_DOMAIN ), 'manage_options', 'gdfrm', array(
            $this,
            'mainPage'
        ) );
	    $this->Pages['settings'] = add_submenu_page( 'gdfrm', __( 'Settings', GDFRM_TEXT_DOMAIN ), __( 'Settings', GDFRM_TEXT_DOMAIN ), 'manage_options', 'gdfrm_settings', array(
		    $this,
		    'settingsPage'
	    ) );

        $this->Pages['submissions'] = add_submenu_page( 'gdfrm', __( 'Submissions', GDFRM_TEXT_DOMAIN ), __( 'Submissions', GDFRM_TEXT_DOMAIN ).' <i>(pro)</i>', 'manage_options', 'gdfrm_submissions', array(
            $this,
            'submissionsPage'
        ) );
	    $this->Pages['themes'] = add_submenu_page( 'gdfrm', __( 'Themes', GDFRM_TEXT_DOMAIN ), __( 'Themes', GDFRM_TEXT_DOMAIN ).' <i>(pro)</i>', 'manage_options', 'gdfrm_themes', array(
		    $this,
		    'themesPage'
	    ) );



        $this->Pages['featuredplugins'] = add_submenu_page( 'gdfrm', __( 'Featured Plugins', GDFRM_TEXT_DOMAIN ), __( 'Featured Plugins', GDFRM_TEXT_DOMAIN ), 'manage_options', 'gdfrm_plugins', array(
            $this,
            'featuredPluginsPage'
        ) );


    }

    /**
     * Initialize main page
     */
    public function mainPage()
    {

        View::render('admin/header-banner.php');

        if ( ! isset( $_GET['task'] ) ) {

            View::render( 'admin/forms-list.php' );

        } else {

            $task = $_GET['task'];

            switch ( $task ) {
                case 'edit_form':

                    if ( ! isset( $_GET['id'] ) ) {

                        \GDForm()->Admin->printError( __( 'Missing "id" parameter.', GDFRM_TEXT_DOMAIN ) );

                    }

                    $id = absint( $_GET['id'] );

                    if ( ! $id ) {

                        \GDForm()->Admin->printError( __( '"id" parameter must be not negative integer.', GDFRM_TEXT_DOMAIN ) );

                    }
                    
                    $form = new Form( array('Id'=>$id) );

                    $fields = $form->getFields();

                    View::render( 'admin/edit-form.php', array( 'form' => $form ,'fields' => $fields ) );

                    break;
                case 'choose_form_template':

                    View::render( 'admin/form-templates.php', array( ) );

                    break;
                case 'edit_form_settings':
                    $id = $_GET['id'];

                    if( absint($id)!=$id){

                        \GDForm()->Admin->printError( __( 'Id parameter must be non negative integer.', GDFRM_TEXT_DOMAIN ) );

                    }
                    
                    $form = new Form( array('Id'=>$id) );

                    View::render( 'admin/form-settings.php', array( 'form' => $form ) );

                    break;

            }

        }

    }

   

    public function submissionsPage()
    {
        View::render('admin/submissions.php');
    }
    

    public function settingsPage()
    {

        View::render( 'admin/settings.php' );

    }

    public function featuredPluginsPage()
    {

        View::render( 'admin/featured-plugins.php' );

    }

    public function themesPage()
    {

        View::render( 'admin/themes.php' );

    }


    public function printError( $error_message, $die = true )
    {

        $str = sprintf( '<div class="error"><p>%s&nbsp;<a href="#" onclick="window.history.back()">%s</a></p></div>', $error_message, __( 'Go back', GDFRM_TEXT_DOMAIN ) );

        if ( $die ) {

            wp_die( $str );

        } else {
            echo $str;
        }

    }

    public static function deleteForm()
    {
        if(!self::isRequest('gdfrm','remove_form','GET')){
            return;
        }

        if ( ! isset( $_GET['id'] ) ) {
            wp_die( __( '"id" parameter is required', GDFRM_TEXT_DOMAIN ) );
        }

        $id = $_GET['id'];

        if ( absint( $id ) != $id ) {
            wp_die( __( '"id" parameter must be non negative integer', GDFRM_TEXT_DOMAIN ) );
        }

        if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( $_GET['_wpnonce'], 'gdfrm_remove_form_' . $id ) ) {
            wp_die( __( 'Security check failed', GDFRM_TEXT_DOMAIN ) );
        }

        Form::delete( $id );

        $location = admin_url( 'admin.php?page=gdfrm' );


        header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        header("Location: $location");

        exit;

    }


    public static function DuplicateForm()
    {
        if(!self::isRequest('gdfrm','duplicate_form','GET')){
            return;
        }

        if ( ! isset( $_GET['id'] ) ) {

            \GDForm()->Admin->printError( __( 'Missing "id" parameter.', GDFRM_TEXT_DOMAIN ) );

        }

        $id = absint( $_GET['id'] );

        if ( ! $id ) {

            \GDForm()->Admin->printError( __( '"id" parameter must be not negative integer.', GDFRM_TEXT_DOMAIN ) );

        }

        if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( $_GET['_wpnonce'], 'gdfrm_duplicate_form_'.$id  ) ) {

            \GDForm()->Admin->printError( __( 'Security check failed.', GDFRM_TEXT_DOMAIN ) );

        }

        $form = new Form( array('Id'=>$id) );

        $fields = $form -> getFields();

        $newForm = clone $form;

        $newForm->setName('Copy of '.$form->getName());

        $fields = $form->getFields();

        if( ! empty($fields) ) {
            $newFormFields = array();

            foreach ($fields as $field){
                $newfield = clone $field;

                $newFormFields[] = $newfield;
            }
        }

        $newForm->setFields($newFormFields) ;

        $newFormId = $newForm->save();

        /**
         * after the form is created we need to redirect user to the edit page
         */
        if ( $newFormId && is_int( $newFormId ) ) {
            /* copy form fields to the new form */

            $location = admin_url( 'admin.php?page=gdfrm&task=edit_form&id=' . $newFormId );

            $location = wp_nonce_url( $location, 'gdfrm_edit_form_' . $newFormId );

            $location = html_entity_decode( $location );

            header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
            header("Location: $location");

            exit;

        } else {

            wp_die( __( 'Problems occured while creating new form.', GDFRM_TEXT_DOMAIN ) );

        }

    }

    public static function createForm()
    {
        if(!self::isRequest('gdfrm','create_new_form','GET')){
            return;
        }

        if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( $_GET['_wpnonce'], 'gdfrm_create_new_form'  ) ) {

            \GDForm()->Admin->printError( __( 'Security check failed.', GDFRM_TEXT_DOMAIN ) );

        }

        $form = new Form( );


        $form->setName('New Form');

        if( isset( $_GET['template'])) {
            $templateId = absint($_GET['template']);


            switch($templateId){
                case '1':

                    $form->setFields(array(
                        new Text(array('Label'=>'Name','Placeholder'=>'ex Jane Doe', 'ContainerClass'=>'gdfrm-username','Ordering'=>1)),
                        new Email(array('Label'=>'Email','Placeholder'=>'ex jane@doe.org','Ordering'=>2,'TypeId'=>'2')),
                        new Textarea(array('Label'=>'Message','Placeholder'=>'Type Your Message Here','Height'=>'150','Ordering'=>3,'TypeId'=>'4')),
                        new Submit(array('Label'=>'Send','Ordering'=>4))
                    ));

                    $form->setName('Contact Us');
                   
                    break;
                case '2':
                    $form->setFields(array(
                        new Text(array('Label'=>'Username or Email', 'Placeholder'=>'ex Jane Doe', 'ContainerClass'=>'gdfrm-username')),
                        new Password(array('Label'=>'Password','Placeholder'=>'******')),
                        new Submit(array('Label'=>'Log In'))
                    ));
                    $form->setSaveSubmissions(0)->setActionOnsubmit(2)->setRedirectUrl(home_url())->setName('Log In');

                    break;
                case '3':
                    $form->setFields(array(
                        new Text( array('Label'=>'First Name','Placeholder'=>'ex Jane') ),
                        new Text( array('Label'=>'Last Name','Placeholder'=>'ex Doe') ),
                        new Radio( array('Label'=>'Gender','Options'=>array(
                            new FieldOption(array(
                                'Name'=>'Male',
                                'Value'=>'male'
                            )),
                            new FieldOption(array(
                                'Name'=>'Female',
                                'Value'=>'female'
                            )),
                        ),'TypeId'=>'5')),
                        new Date(array('Label'=>'Birthday','DateFieldType'=>'separate','TypeId'=>'8')),
                        new Text(array('Label'=>'Username','ContainerClass'=>'gdfrm-username','Placeholder'=>'ex janedoe17256','Required'=>1)),
                        new Email(array('Label'=>'Email Address','Placeholder'=>'ex jane@doe.org','Required'=>1,'TypeId'=>'2')),
                        new Password(array('Label'=>'Password','Placeholder'=>'*****','Required'=>1)),
                        new Password(array('Label'=>'Confirm Password','Placeholder'=>'*****','Required'=>1   )),
                        new Submit(array('Label'=>'Register'))
                    ));
                    $form->setName('Sign Up');

                    break;
                case '4':
                    $form->setFields(array(
                        new Text(array('Label'=>'Event Name','Placeholder'=>'ex Jane\'s Birthday')),
                        new Selectbox(array('Label'=>'Event Type', 'Options'=>array(
                            new FieldOption(array(
                                'Name'=>'Birthday',
                                'Value'=>'birthday'
                            )),
                            new FieldOption(array(
                                'Name'=>'Wedding',
                                'Value'=>'wedding'
                            )),
                            new FieldOption(array(
                                'Name'=>'Banquet',
                                'Value'=>'banquet'
                            )),
                            new FieldOption(array(
                                'Name'=>'Anniversary',
                                'Value'=>'anniversary'
                            )),
                        ),'TypeId'=>'7')),
                        new Date(array('Label'=>'Start Date','TypeId'=>'8')),
                        new Address(array('Label'=>'Location','Countries'=>Countries::get_countries('string'))),
                        new Upload(array('Label'=>'Event Image','TypeId'=>'17')),
                        new Textarea(array('Label'=>'Event Description','Placeholder'=>'Write something about your event','Height'=>'150','TypeId'=>'4')),
                        new Submit(array('Label'=>'Add Event'))
                    ));
                    $form->setName('Event Planner');

                    break;
                case '5':
                    $form->setFields(array(
                        new Selectbox(array('Label'=>'Which one do you want?','Options'=>array(
                            new FieldOption(array(
                                'Name'=>'T-shirt1',
                                'Value'=>'tshirt1',
                            )),
                            new FieldOption(array(
                                'Name'=>'T-shirt2',
                                'Value'=>'tshirt2',
                            )),
                        ),'TypeId'=>'7')),
                        new Selectbox(array('Label'=>'Color','Options'=>array(
                            new FieldOption(array(
                                'Name'=>'White',
                                'Value'=>'white',
                            )),
                            new FieldOption(array(
                                'Name'=>'Black',
                                'Value'=>'black',
                            )),
                        ),'TypeId'=>'7')),
                        new Selectbox(array('Label'=>'Size','Options'=>array(
                            new FieldOption(array(
                                'Name'=>'XS',
                                'Value'=>'xs',
                            )),
                            new FieldOption(array(
                                'Name'=>'S',
                                'Value'=>'s',
                            )),
                            new FieldOption(array(
                                'Name'=>'M',
                                'Value'=>'m',
                            )),
                            new FieldOption(array(
                                'Name'=>'L',
                                'Value'=>'l',
                            )),
                        ),'TypeId'=>'7')),
                        new Text(array('Label'=>'Name','Placeholder'=>'ex Jane Doe')),
                        new Email(array('Label'=>'Email','Placeholder'=>'ex jane@doe.org','TypeId'=>'2')),
                        new Address(array('Label'=>'Location','Countries'=>Countries::get_countries('string'),'TypeId'=>'16')),
                        new Submit(array('Label'=>'Order'))
                    ));
                    $form->setName('T-Shirt Order Form');

                    break;
                case '6':
                    $form->setFields(array(
                        new Email(array('Label'=>'Your Email Address','Placeholder'=>'ex jane@doe.org','TypeId'=>'2')),
                        new Submit(array('Label'=>'Subscribe'))
                    ));
                    $form->setName('Subscribe to Our Newsletter');

                    break;
                case '7':
                    $form->setFields(array(
                        new Text(array('Label'=>'Name','Placeholder'=>'Name','LabelPosition'=>'5','ContainerClass'=>'gdfrm-username')),
                        new Email(array('Label'=>'Email','Placeholder'=>'Email','LabelPosition'=>'5','TypeId'=>'2')),
                        new Selectbox(array('Label'=>'Project Type','Placeholder'=>'Project Type','SearchOn'=>0,'LabelPosition'=>'5','Options'=>array(
                            new FieldOption(array(
                                'Name'=>'Testing / Inspection',
                                'Value'=>'testing/inspection',
                            )),
                            new FieldOption(array(
                                'Name'=>'Failure Analysis',
                                'Value'=>'failure analysis',
                            )),
                            new FieldOption(array(
                                'Name'=>'Specimen Machining',
                                'Value'=>'specimen machining',
                            )),
                            new FieldOption(array(
                                'Name'=>'Instrument Calibration',
                                'Value'=>'instrument calibration',
                            )),
                            new FieldOption(array(
                                'Name'=>'Other',
                                'Value'=>'other',
                            )),
                        ),'TypeId'=>'7')),
                        new Selectbox(array('Label'=>'Project Budget','Placeholder'=>'Budget','SearchOn'=>0,'LabelPosition'=>'5','Options'=>array(
                            new FieldOption(array(
                                'Name'=>'Less than $1000',
                                'Value'=>'<$1000',
                            )),
                            new FieldOption(array(
                                'Name'=>'$1000-$5000',
                                'Value'=>'$1000-5000',
                            )),
                            new FieldOption(array(
                                'Name'=>'$5000-$10000',
                                'Value'=>'$5000-10000',
                            )),
                            new FieldOption(array(
                                'Name'=>'More than $10000',
                                'Value'=>'>$10000',
                            )),
                        ),'TypeId'=>'7')),
                        new Textarea(array('Label'=>'Project Details','Placeholder'=>'Project Details','LabelPosition'=>'5','Height'=>'150','TypeId'=>'4')),
                        new Submit(array('Label'=>'Send Request'))
                    ));
                    $form->setName('Request a Quote');

                    break;
                case '8':
                    $form->setFields(array(
                        new Text(array('Label'=>'Name','Required'=>1,'ContainerClass'=>'gdfrm-username')),
                        new Email(array('Label'=>'Email','HelperText'=>'Please enter your email, so that we can follow up with you. ','Required'=>1,'TypeId'=>'2')),
                        new Radio(array('Label'=>'Which department do you have a suggestion for?','Required'=>1,'OptionType'=>'block','Options'=>array(
                            new FieldOption(array(
                                'Name'=>'Sales',
                                'Value'=>'sales',
                            )),
                            new FieldOption(array(
                                'Name'=>'Customer Support',
                                'Value'=>'customer support',
                            )),
                            new FieldOption(array(
                                'Name'=>'Product Development',
                                'Value'=>'product development',
                            )),
                            new FieldOption(array(
                                'Name'=>'Other',
                                'Value'=>'other',
                            )),
                        ),'TypeId'=>'5')),
                        new Text(array('Label'=>'Subject','Required'=>1)),
                        new Textarea(array('Label'=>'Message','Height'=>'150','Required'=>1,'TypeId'=>'4')),
                        new Submit(array('Label'=>'Submit'))
                    ));
                    $form->setName('Suggestion Form');
                    break;
                case '9':
                    $form->setFields(array(
                        new Text(array('Label'=>'Name','Required'=>1,'ContainerClass'=>'gdfrm-username')),
                        new Email(array('Label'=>'Email','Required'=>1,'TypeId'=>'2')),
                        new Radio(array('Label'=>'Overall, how satisfied were you with the product / service?','OptionType'=>'block','Required'=>1,'Options'=>array(
                            new FieldOption(array(
                                'Name'=>'Very Satisfied ',
                                'Value'=>'very satisfied',
                            )),
                            new FieldOption(array(
                                'Name'=>'Satisfied',
                                'Value'=>'satisfied',
                            )),
                            new FieldOption(array(
                                'Name'=>'Neutral',
                                'Value'=>'neutral',
                            )),
                            new FieldOption(array(
                                'Name'=>'Unsatisfied',
                                'Value'=>'unsatisfied',
                            )),
                            new FieldOption(array(
                                'Name'=>'Very Unsatisfied',
                                'Value'=>'very unsatisfied',
                            )),
                        ),'TypeId'=>'5')),
                        new Radio(array('Label'=>'Would you recommend our product / service to colleagues or contacts within your industry?','OptionType'=>'block','Options'=>array(
                            new FieldOption(array(
                                'Name'=>'Definitely',
                                'Value'=>'definitely',
                            )),
                            new FieldOption(array(
                                'Name'=>'Probably',
                                'Value'=>'probably',
                            )),
                            new FieldOption(array(
                                'Name'=>'Not Sure',
                                'Value'=>'not sure',
                            )),
                            new FieldOption(array(
                                'Name'=>'Probably Not',
                                'Value'=>'probably not',
                            )),
                            new FieldOption(array(
                                'Name'=>'Definitely Not',
                                'Value'=>'definitely not',
                            )),
                        ),'TypeId'=>'5')),
                        new Radio(array('Label'=>'Would you use our product / service in the future?','OptionType'=>'block','Options'=>array(
                            new FieldOption(array(
                                'Name'=>'Definitely',
                                'Value'=>'definitely',
                            )),
                            new FieldOption(array(
                                'Name'=>'Probably',
                                'Value'=>'probably',
                            )),
                            new FieldOption(array(
                                'Name'=>'Not Sure',
                                'Value'=>'not sure',
                            )),
                            new FieldOption(array(
                                'Name'=>'Probably Not',
                                'Value'=>'probably not',
                            )),
                            new FieldOption(array(
                                'Name'=>'Definitely Not',
                                'Value'=>'definitely not',
                            )),
                        ),'TypeId'=>'5')),
                        new Radio(array('Label'=>'How long have you used our product / service?','OptionType'=>'block','Options'=>array(
                            new FieldOption(array(
                                'Name'=>'Less than a month',
                                'Value'=>'<1month',
                            )),
                            new FieldOption(array(
                                'Name'=>'1-6 months',
                                'Value'=>'1-6 months',
                            )),
                            new FieldOption(array(
                                'Name'=>'1-3 years',
                                'Value'=>'1-3 years',
                            )),
                            new FieldOption(array(
                                'Name'=>'Over 3 Years',
                                'Value'=>'>3years',
                            )),
                            new FieldOption(array(
                                'Name'=>'Never used',
                                'Value'=>'never used',
                            )),
                        ),'TypeId'=>'5')),
                        new Radio(array('Label'=>'What aspect of the product / service were you most satisfied by?','OptionType'=>'block','Options'=>array(
                            new FieldOption(array(
                                'Name'=>'Quality',
                                'Value'=>'quality',
                            )),
                            new FieldOption(array(
                                'Name'=>'Price',
                                'Value'=>'price',
                            )),
                            new FieldOption(array(
                                'Name'=>'Purchase Experience ',
                                'Value'=>'purchase experience',
                            )),
                            new FieldOption(array(
                                'Name'=>'Usage Experience ',
                                'Value'=>'usage experience',
                            )),
                            new FieldOption(array(
                                'Name'=>'Customer Service',
                                'Value'=>'customer service',
                            )),
                        ),'TypeId'=>'5')),
                        new Radio(array('Label'=>'What aspect of the product / service were you most disappointed by?','OptionType'=>'block','Options'=>array(
                            new FieldOption(array(
                                'Name'=>'Quality',
                                'Value'=>'quality',
                            )),
                            new FieldOption(array(
                                'Name'=>'Price',
                                'Value'=>'price',
                            )),
                            new FieldOption(array(
                                'Name'=>'Purchase Experience ',
                                'Value'=>'purchase experience',
                            )),
                            new FieldOption(array(
                                'Name'=>'Usage Experience ',
                                'Value'=>'usage experience',
                            )),
                            new FieldOption(array(
                                'Name'=>'Customer Service',
                                'Value'=>'customer service',
                            )),
                        ),'TypeId'=>'5')),
                        new Textarea(array('Label'=>'What do you like about the product / service?','Height'=>'150','TypeId'=>'4')),
                        new Textarea(array('Label'=>'What do you dislike about the product / service?','Height'=>'150','TypeId'=>'4')),
                        new Radio(array('Label'=>'Thinking of similar products / services offered by other companies, how would you compare the product / service offered by our company?','OptionType'=>'block','Options'=>array(
                            new FieldOption(array(
                                'Name'=>'Much Better',
                                'Value'=>'much better',
                            )),
                            new FieldOption(array(
                                'Name'=>'Somewhat Better',
                                'Value'=>'somewhat better',
                            )),
                            new FieldOption(array(
                                'Name'=>'About the Same',
                                'Value'=>'about the same',
                            )),
                            new FieldOption(array(
                                'Name'=>'Somewhat Worse',
                                'Value'=>'somewhat worse',
                            )),
                            new FieldOption(array(
                                'Name'=>'Much Worse',
                                'Value'=>'much worse',
                            )),
                            new FieldOption(array(
                                'Name'=>'Don\'t Know',
                                'Value'=>'don\'t know',
                            )),
                        ),'TypeId'=>'5')),
                        new Submit(array('Label'=>'Submit'))
                    ));
                    $form->setName('Customer Satisfaction Survey');
                    break;
            }
        } else {
            $form->setName('Send');
        }


        $form = $form->save();

        /**
         * after the form is created we need to redirect user to the edit page
         */
        if ( $form && is_int( $form ) ) {

            $location = admin_url( 'admin.php?page=gdfrm&task=edit_form&id=' . $form );

            $location = wp_nonce_url( $location, 'gdfrm_edit_form_' . $form );

            $location = html_entity_decode( $location );

            header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
            header("Location: $location");

            exit;

        } else {

            wp_die( __( 'Problems occured while creating new form.', GDFRM_TEXT_DOMAIN ) );

        }

    }


}