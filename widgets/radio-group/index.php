<?php
/**
 * Elementor Checkbox Widget.
 *
 * @since 1.0.0
 */
class FAEL_Radio_Group extends FAEL_Widget_Base {

    /**
     * Get widget name.
     *
     * Retrieve oEmbed widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'fael_radio_group';
    }

    /**
     * Get widget title.
     *
     * Retrieve oEmbed widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __( 'UF Radio Group', 'fael' );
    }

    /**
     * Get widget icon.
     *
     * Retrieve Checkbox Group widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-radio';
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the oEmbed widget belongs to.
     *
     * @since 1.0.0
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return [ 'fael-category' ];
    }

    /**
     * Register oEmbed widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function _register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'fael' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'form_handle',
            [
                'label' => __( 'Form Handle', 'fael' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'input_type' => 'text',
                'placeholder' => __( 'Form Handle', 'fael' ),
                'description' => __( 'Name of form handle, all fields of same form should have the same form handle', 'fael' ),
                'default' => 'form'
            ]
        );
        $this->add_control(
            'name',
            [
                'label' => __( 'Field Name', 'fael' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'input_type' => 'text',
                'placeholder' => __( 'Field Name', 'fael' ),
                'default' => __( 'radiogroup', 'fael' ),
            ]
        );
        $this->add_control(
            'label',
            [
                'label' => __( 'Label', 'fael' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'input_type' => 'text',
                'placeholder' => __( 'Field Label', 'fael' ),
                'default' => __( 'Radio Group', 'fael' ),
            ]
        );
        //repeater
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'value',
            [
                'label' => __( 'Value', 'fael' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'input_type' => 'text',
                'placeholder' => __( 'Value', 'fael' ),
                'default' => __( 'Default Value', 'fael')
            ]
        );
        $repeater->add_control(
            'label',
            [
                'label' => __( 'Label', 'fael' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'input_type' => 'text',
                'placeholder' => __( 'Label', 'fael' ),
                'default' => __( 'Default Label', 'fael' )
            ]
        );
        $repeater->add_control(
            'is_check',
            [
                'label' => __( 'Checked', 'fael' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Check', 'fael' ),
                'label_off' => __( 'Uncheck', 'fael' ),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        //
        $this->add_control(
            'list',
            [
                'label' => __( 'Add Options', 'plugin-domain' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'value' => __( 'Default Value', 'fael' ),
                        'label' => __( 'Default Label', 'fael' ),
                    ]
                ],
                'title_field' => '{{{ label }}}',
            ]
        );


        $this->add_control(
            'description',
            [
                'label' => __( 'Description', 'fael' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'input_type' => 'textarea',
                'placeholder' => __( 'Description', 'fael' ),
            ]
        );
        $this->add_control(
            'is_required',
            [
                'label' => __( 'Required', 'fael' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Yes', 'fael' ),
                'label_off' => __( 'No', 'fael' ),
                'return_value' => 'yes',
                'default' => '',
            ]
        );
        $this->add_control(
            'element_id',
            [
                'label' => __( 'ID', 'fael' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'description' => __( 'ID for your element, this should be unique', 'fael')
            ]
        );
        $this->add_control(
            'element_class',
            [
                'label' => __( 'Class', 'fael' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'description' => __( 'CSS Class for your element', 'fael')
            ]
        );
        $this->end_controls_section();
        do_action( 'fael_widget_controls_sections_end', $this );

    }

    /**
     * Render oEmbed widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render() {
        global $has_fael_widget, $fael_forms, $fael_post;
        $has_fael_widget = true;
        $s = $this->get_settings_for_display();

        //
        $value = '';
        if( isset( $fael_post->{ $s['name'] } ) ) {
            $value = $fael_post->{ $s['name'] };
        } else {
            foreach ( $s['list'] as $k => $item ) {
                if( $item['is_check'] == 'yes' ) {
                    $value = $item['value'];
                    break;
                }
            }
        }

        FAEL_Form_Elements()->set_form_element( $s['form_handle'], $s['name'], apply_filters( 'fael_form_field', array(
            'rules' => array(
                'is_required' => $s['is_required']
            ),
            'value' => $value,
            'label' => $s['label']
        ), $s) );

        self::$fael_forms = $fael_forms;
        ?>
        <div id="<?php echo $s['element_id']; ?>" class="position-relative form-group <?php echo $s['element_class']; ?>">
            <h5 class="card-title">
                <?php echo $s['label']; ?>
                <?php echo $s['is_required'] == 'yes' ? '<span style="color: red;">&ast;</span>' : ''; ?>
            </h5>
            <?php
            foreach ( $s['list'] as $k => $item ) {
                ?>
                <div class="position-relative form-check">
                    <label class="form-check-label">
                        <input type="radio"
                               class="form-check-input"
                               value="<?php echo $item['value']; ?>"
                               name="<?php echo $s['form_handle']; ?>[<?php echo $s['name']; ?>]"
                            <?php echo $fael_forms[$s['form_handle']][$s['name']]['value'] == $item['value'] ? 'checked' : '' ;?>

                               v-model="fael_forms['<?php echo $s['form_handle']; ?>']['<?php echo $s['name']; ?>'].value"
                        >
                        <?php echo $item['label']; ?>
                    </label>
                </div>
                <?php
            }
            ?>
            <div>
                <?php echo $s['description']; ?>
            </div>
        </div>
<?php
    }
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new FAEL_Radio_Group() );
