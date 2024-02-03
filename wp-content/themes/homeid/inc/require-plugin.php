<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}

function homeid_require_plugin() {
    include_once get_parent_theme_file_path('inc/libs/class-tgm-plugin-activation.php');
    /*
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(
	    array(
		    'name'               => esc_html__('Essential Real Estate','homeid'), // The plugin name
		    'slug'               => 'essential-real-estate', // The plugin slug (typically the folder name)
		    'required'           => true, // If false, the plugin is only 'recommended' instead of required
	    ),
        array(
            'name'               => esc_html__('G5 Core','homeid') , // The plugin name
            'slug'               => 'g5-core', // The plugin slug (typically the folder name)
            'source'             => get_template_directory() . '/inc/plugins/g5-core-v1.8.1.zip', // The plugin source
            'required'           => true, // If false, the plugin is only 'recommended' instead of required
            'version'            => '1.8.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'       => '', // If set, overrides default API URL and points to an external URL
        ),
	    array(
		    'name'               => esc_html__('G5 ERE','homeid') , // The plugin name
		    'slug'               => 'g5-ere', // The plugin slug (typically the folder name)
		    'source'             => get_template_directory() . '/inc/plugins/g5-ere-v1.6.5.zip', // The plugin source
		    'required'           => true, // If false, the plugin is only 'recommended' instead of required
		    'version'            => '1.6.5', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
		    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
		    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
		    'external_url'       => '', // If set, overrides default API URL and points to an external URL
	    ),
	    array(
		    'name'               => esc_html__('HomeId Addons','homeid') , // The plugin name
		    'slug'               => 'homeid-addons', // The plugin slug (typically the folder name)
		    'source'             => get_template_directory() . '/inc/plugins/homeid-addons-v1.1.3.zip', // The plugin source
		    'required'           => true, // If false, the plugin is only 'recommended' instead of required
		    'version'            => '1.1.3', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
		    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
		    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
		    'external_url'       => '', // If set, overrides default API URL and points to an external URL
	    ),
        array(
            'name'               => esc_html__('G5 Blog','homeid') , // The plugin name
            'slug'               => 'g5-blog', // The plugin slug (typically the folder name)
            'source'             => get_template_directory() . '/inc/plugins/g5-blog-v1.1.8.zip', // The plugin source
            'required'           => false, // If false, the plugin is only 'recommended' instead of required
            'version'            => '1.1.8', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'       => '', // If set, overrides default API URL and points to an external URL
        ),
        array(
            'name'               => esc_html__('G5 Element','homeid') , // The plugin name
            'slug'               => 'g5-element', // The plugin slug (typically the folder name)
            'source'             => get_template_directory() . '/inc/plugins/g5-element-v1.2.7.zip', // The plugin source
            'required'           => false, // If false, the plugin is only 'recommended' instead of required
            'version'            => '1.2.7', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'       => '', // If set, overrides default API URL and points to an external URL
        ),
	    array(
		    'name'               => esc_html__('G5 Install Demo','homeid'), // The plugin name
		    'slug'               => 'g5-install-demo', // The plugin slug (typically the folder name)
		    'source'             => get_template_directory() . '/inc/plugins/g5-install-demo-v1.1.3.zip', // The plugin source
		    'required'           => true, // If false, the plugin is only 'recommended' instead of required
		    'version'            => '1.1.3', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
		    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
		    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
		    'external_url'       => '', // If set, overrides default API URL and points to an external URL
	    ),
        array(
            'name'               => esc_html__('Visual Composer','homeid') , // The plugin name
            'slug'               => 'js_composer', // The plugin slug (typically the folder name)
            'source'             => get_template_directory() . '/inc/plugins/js_composer_7.3.zip', // The plugin source
            'required'           => true, // If false, the plugin is only 'recommended' instead of required
            'version'            => '7.3', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'       => '', // If set, overrides default API URL and points to an external URL
        ),

	    array(
		    'name' => 'Elementor', // The plugin name
		    'slug' => 'elementor', // The plugin slug (typically the folder name)
		    'required' => true, // If false, the plugin is only 'recommended' instead of required
	    ),
	    array(
		    'name'               => 'Elementor Pro', // The plugin name
		    'slug'               => 'elementor-pro', // The plugin slug (typically the folder name)
		    'source'             => get_template_directory() . '/inc/plugins/elementor-pro-3.18.2.zip', // The plugin source
		    'required'           => true, // If false, the plugin is only 'recommended' instead of required
		    'version'            => '3.18.2', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
		    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
		    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
		    'external_url'       => '', // If set, overrides default API URL and points to an external URL
	    ),
	    array(
		    'name'               => 'Ultimate Bootstrap Elements for Elementor', // The plugin name
		    'slug'               => 'ultimate-bootstrap-elements-for-elementor', // The plugin slug (typically the folder name)
		    'required'           => true, // If false, the plugin is only 'recommended' instead of required
	    ),

        array(
            'name'               => esc_html__('Envato Market','homeid') , // The plugin name
            'slug'               => 'envato-market', // The plugin slug (typically the folder name)
            'source'             => get_template_directory() . '/inc/plugins/envato-market.zip', // The plugin source
            'required'           => false, // If false, the plugin is only 'recommended' instead of required
            'version'            => '2.0.11', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'       => '', // If set, overrides default API URL and points to an external URL
        ),
        array(
            'name'     => esc_html__('Contact Form 7','homeid') , // The plugin name
            'slug'     => 'contact-form-7', // The plugin slug (typically the folder name)
            'required' => false, // If false, the plugin is only 'recommended' instead of required
        ),
        array(
            'name'     => esc_html__('WP Mail SMTP','homeid') , // The plugin name
            'slug'     => 'wp-mail-smtp', // The plugin slug (typically the folder name)
            'required' => false, // If false, the plugin is only 'recommended' instead of required
        ),
        array(
            'name'     => esc_html__('MailChimp for WordPress','homeid') , // The plugin name
            'slug'     => 'mailchimp-for-wp', // The plugin slug (typically the folder name)
            'required' => false, // If false, the plugin is only 'recommended' instead of required
        ),
	    array(
	    	'name' => esc_html__('Post Views Counter','homeid'),
		    'slug' => 'post-views-counter',
		    'required' => false
	    )
    );

    /*
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */

    // Change this to your theme text domain, used for internationalising strings
    $config = array(
        'domain'       => 'homeid',
        'id'           => 'homeid',// Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'menu'         => 'install-required-plugins', // Menu slug.
        'parent_slug'  => 'themes.php',            // Parent menu slug.
        'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
        'strings'      => array(
            'page_title'                      => esc_html__('Install Required Plugins', 'homeid'),
            'menu_title'                      => esc_html__('Install Plugins', 'homeid'),
            'installing'                      => esc_html__('Installing Plugin: %s', 'homeid'), // %s = plugin name.
            'oops'                            => esc_html__('Something went wrong with the plugin API.', 'homeid'),
            'notice_can_install_required'     => _n_noop('This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'homeid'), // %1$s = plugin name(s).
            'notice_can_install_recommended'  => _n_noop('This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'homeid'), // %1$s = plugin name(s).
            'notice_cannot_install'           => _n_noop('Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'homeid'), // %1$s = plugin name(s).
            'notice_can_activate_required'    => _n_noop('The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'homeid'), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => _n_noop('The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'homeid'), // %1$s = plugin name(s).
            'notice_cannot_activate'          => _n_noop('Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'homeid'), // %1$s = plugin name(s).
            'notice_ask_to_update'            => _n_noop('The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'homeid'), // %1$s = plugin name(s).
            'notice_cannot_update'            => _n_noop('Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'homeid'), // %1$s = plugin name(s).
            'install_link'                    => _n_noop('Begin installing plugin', 'Begin installing plugins', 'homeid'),
            'activate_link'                   => _n_noop('Begin activating plugin', 'Begin activating plugins', 'homeid'),
            'return'                          => esc_html__('Return to Required Plugins Installer', 'homeid'),
            'plugin_activated'                => esc_html__('Plugin activated successfully.', 'homeid'),
            'complete'                        => esc_html__('All plugins installed and activated successfully. %s', 'homeid'), // %s = dashboard link.
            'nag_type'                        => 'updated', // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
    );
    tgmpa($plugins, $config);
}
homeid_require_plugin();
