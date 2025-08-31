<?php
/**
 * Custom Portfolio Theme Functions
 * 
 * @package CustomPortfolio
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme Setup
 */
function custom_portfolio_setup() {
    // Add theme support for various features
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    add_theme_support('custom-logo');
    add_theme_support('menus');
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'custom-portfolio'),
        'footer' => __('Footer Menu', 'custom-portfolio'),
    ));
    
    // Add image sizes
    add_image_size('project-thumbnail', 400, 300, true);
    add_image_size('project-large', 800, 600, true);
}
add_action('after_setup_theme', 'custom_portfolio_setup');

/**
 * Enqueue scripts and styles
 */
function custom_portfolio_scripts() {
    // Enqueue main stylesheet
    wp_enqueue_style('custom-portfolio-style', get_stylesheet_uri(), array(), '1.0.0');
    
    // Enqueue custom JavaScript
    wp_enqueue_script('custom-portfolio-script', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0.0', true);
    
    // Localize script for AJAX
    wp_localize_script('custom-portfolio-script', 'custom_portfolio_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('custom_portfolio_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'custom_portfolio_scripts');

/**
 * Register Custom Post Type: Projects
 */
function custom_portfolio_register_post_types() {
    $labels = array(
        'name' => _x('Projects', 'post type general name', 'custom-portfolio'),
        'singular_name' => _x('Project', 'post type singular name', 'custom-portfolio'),
        'menu_name' => _x('Projects', 'admin menu', 'custom-portfolio'),
        'name_admin_bar' => _x('Project', 'add new on admin bar', 'custom-portfolio'),
        'add_new' => _x('Add New', 'project', 'custom-portfolio'),
        'add_new_item' => __('Add New Project', 'custom-portfolio'),
        'new_item' => __('New Project', 'custom-portfolio'),
        'edit_item' => __('Edit Project', 'custom-portfolio'),
        'view_item' => __('View Project', 'custom-portfolio'),
        'all_items' => __('All Projects', 'custom-portfolio'),
        'search_items' => __('Search Projects', 'custom-portfolio'),
        'parent_item_colon' => __('Parent Projects:', 'custom-portfolio'),
        'not_found' => __('No projects found.', 'custom-portfolio'),
        'not_found_in_trash' => __('No projects found in Trash.', 'custom-portfolio')
    );

    $args = array(
        'labels' => $labels,
        'description' => __('Project post type for portfolio.', 'custom-portfolio'),
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'projects'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-portfolio',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'show_in_rest' => true,
    );

    register_post_type('project', $args);
}
add_action('init', 'custom_portfolio_register_post_types');

/**
 * Add Custom Meta Boxes for Projects
 */
function custom_portfolio_add_meta_boxes() {
    add_meta_box(
        'project_details',
        __('Project Details', 'custom-portfolio'),
        'custom_portfolio_project_meta_box_callback',
        'project',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'custom_portfolio_add_meta_boxes');

/**
 * Meta box callback function
 */
function custom_portfolio_project_meta_box_callback($post) {
    // Add nonce for security
    wp_nonce_field('custom_portfolio_save_meta_box_data', 'custom_portfolio_meta_box_nonce');

    // Get existing values
    $project_name = get_post_meta($post->ID, '_project_name', true);
    $project_description = get_post_meta($post->ID, '_project_description', true);
    $project_start_date = get_post_meta($post->ID, '_project_start_date', true);
    $project_end_date = get_post_meta($post->ID, '_project_end_date', true);
    $project_url = get_post_meta($post->ID, '_project_url', true);

    ?>
    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="project_name"><?php _e('Project Name', 'custom-portfolio'); ?></label>
            </th>
            <td>
                <input type="text" id="project_name" name="project_name" value="<?php echo esc_attr($project_name); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="project_description"><?php _e('Project Description', 'custom-portfolio'); ?></label>
            </th>
            <td>
                <textarea id="project_description" name="project_description" rows="4" class="large-text"><?php echo esc_textarea($project_description); ?></textarea>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="project_start_date"><?php _e('Project Start Date', 'custom-portfolio'); ?></label>
            </th>
            <td>
                <input type="date" id="project_start_date" name="project_start_date" value="<?php echo esc_attr($project_start_date); ?>" />
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="project_end_date"><?php _e('Project End Date', 'custom-portfolio'); ?></label>
            </th>
            <td>
                <input type="date" id="project_end_date" name="project_end_date" value="<?php echo esc_attr($project_end_date); ?>" />
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="project_url"><?php _e('Project URL', 'custom-portfolio'); ?></label>
            </th>
            <td>
                <input type="url" id="project_url" name="project_url" value="<?php echo esc_url($project_url); ?>" class="regular-text" />
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Save meta box data
 */
function custom_portfolio_save_meta_box_data($post_id) {
    // Check if nonce is valid
    if (!isset($_POST['custom_portfolio_meta_box_nonce']) || 
        !wp_verify_nonce($_POST['custom_portfolio_meta_box_nonce'], 'custom_portfolio_save_meta_box_data')) {
        return;
    }

    // Check if user has permissions to save data
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Check if not an autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Sanitize and save data
    if (isset($_POST['project_name'])) {
        update_post_meta($post_id, '_project_name', sanitize_text_field($_POST['project_name']));
    }
    
    if (isset($_POST['project_description'])) {
        update_post_meta($post_id, '_project_description', sanitize_textarea_field($_POST['project_description']));
    }
    
    if (isset($_POST['project_start_date'])) {
        update_post_meta($post_id, '_project_start_date', sanitize_text_field($_POST['project_start_date']));
    }
    
    if (isset($_POST['project_end_date'])) {
        update_post_meta($post_id, '_project_end_date', sanitize_text_field($_POST['project_end_date']));
    }
    
    if (isset($_POST['project_url'])) {
        update_post_meta($post_id, '_project_url', esc_url_raw($_POST['project_url']));
    }
}
add_action('save_post', 'custom_portfolio_save_meta_box_data');

/**
 * Custom REST API Endpoint for Projects
 */
function custom_portfolio_register_rest_routes() {
    register_rest_route('custom-portfolio/v1', '/projects', array(
        'methods' => 'GET',
        'callback' => 'custom_portfolio_get_projects_api',
        'permission_callback' => '__return_true',
    ));
}
add_action('rest_api_init', 'custom_portfolio_register_rest_routes');

/**
 * REST API callback function
 */
function custom_portfolio_get_projects_api($request) {
    // Sanitize parameters
    $start_date = sanitize_text_field($request->get_param('start_date'));
    $end_date = sanitize_text_field($request->get_param('end_date'));
    
    $args = array(
        'post_type' => 'project',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'DESC',
    );
    
    // Add date filters if provided
    if (!empty($start_date) || !empty($end_date)) {
        $args['meta_query'] = array();
        
        if (!empty($start_date)) {
            $args['meta_query'][] = array(
                'key' => '_project_start_date',
                'value' => $start_date,
                'compare' => '>=',
                'type' => 'DATE'
            );
        }
        
        if (!empty($end_date)) {
            $args['meta_query'][] = array(
                'key' => '_project_end_date',
                'value' => $end_date,
                'compare' => '<=',
                'type' => 'DATE'
            );
        }
    }
    
    $projects = get_posts($args);
    $data = array();
    
    foreach ($projects as $project) {
        $project_data = array(
            'id' => $project->ID,
            'title' => get_the_title($project->ID),
            'content' => wp_kses_post($project->post_content),
            'excerpt' => wp_kses_post($project->post_excerpt),
            'date' => get_the_date('Y-m-d', $project->ID),
            'modified' => get_the_modified_date('Y-m-d', $project->ID),
            'link' => get_permalink($project->ID),
            'project_name' => get_post_meta($project->ID, '_project_name', true),
            'project_description' => get_post_meta($project->ID, '_project_description', true),
            'project_start_date' => get_post_meta($project->ID, '_project_start_date', true),
            'project_end_date' => get_post_meta($project->ID, '_project_end_date', true),
            'project_url' => get_post_meta($project->ID, '_project_url', true),
            'featured_image' => get_the_post_thumbnail_url($project->ID, 'medium'),
        );
        
        $data[] = $project_data;
    }
    
    return new WP_REST_Response($data, 200);
}

/**
 * AJAX handler for project filtering
 */
function custom_portfolio_filter_projects() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'custom_portfolio_nonce')) {
        wp_die('Security check failed');
    }
    
    // Sanitize inputs
    $start_date = sanitize_text_field($_POST['start_date']);
    $end_date = sanitize_text_field($_POST['end_date']);
    
    $args = array(
        'post_type' => 'project',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'DESC',
    );
    
    // Add date filters if provided
    if (!empty($start_date) || !empty($end_date)) {
        $args['meta_query'] = array();
        
        if (!empty($start_date)) {
            $args['meta_query'][] = array(
                'key' => '_project_start_date',
                'value' => $start_date,
                'compare' => '>=',
                'type' => 'DATE'
            );
        }
        
        if (!empty($end_date)) {
            $args['meta_query'][] = array(
                'key' => '_project_end_date',
                'value' => $end_date,
                'compare' => '<=',
                'type' => 'DATE'
            );
        }
    }
    
    $projects = get_posts($args);
    $output = '';
    
    if ($projects) {
        foreach ($projects as $project) {
            $project_name = get_post_meta($project->ID, '_project_name', true);
            $project_description = get_post_meta($project->ID, '_project_description', true);
            $project_start_date = get_post_meta($project->ID, '_project_start_date', true);
            $project_end_date = get_post_meta($project->ID, '_project_end_date', true);
            $project_url = get_permalink($project->ID);
            
            $output .= '<div class="project-card">';
            $output .= '<div class="project-image">';
            if (has_post_thumbnail($project->ID)) {
                $output .= get_the_post_thumbnail($project->ID, 'project-thumbnail');
            } else {
                $output .= '<span>No Image</span>';
            }
            $output .= '</div>';
            $output .= '<div class="project-content">';
            $output .= '<h3 class="project-title"><a href="' . esc_url(get_permalink($project->ID)) . '">' . esc_html($project_name ?: get_the_title($project->ID)) . '</a></h3>';
            $output .= '<p class="project-description">' . esc_html($project_description ?: wp_trim_words($project->post_content, 20)) . '</p>';
            $output .= '<div class="project-meta">';
            if ($project_start_date) {
                $output .= '<span>Start: ' . esc_html($project_start_date) . '</span>';
            }
            if ($project_end_date) {
                $output .= '<span>End: ' . esc_html($project_end_date) . '</span>';
            }
            $output .= '</div>';
            if ($project_url) {
                $output .= '<a href="' . esc_url($project_url) . '" class="btn" target="_blank">View Project</a>';
            }
            $output .= '</div>';
            $output .= '</div>';
        }
    } else {
        $output = '<p>No projects found matching your criteria.</p>';
    }
    
    wp_send_json_success($output);
}
add_action('wp_ajax_custom_portfolio_filter_projects', 'custom_portfolio_filter_projects');
add_action('wp_ajax_nopriv_custom_portfolio_filter_projects', 'custom_portfolio_filter_projects');

/**
 * Helper function to get project meta
 */
function custom_portfolio_get_project_meta($post_id, $key) {
    return get_post_meta($post_id, '_' . $key, true);
}

/**
 * Add custom columns to projects admin
 */
function custom_portfolio_add_project_columns($columns) {
    $new_columns = array();
    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;
        if ($key === 'title') {
            $new_columns['project_name'] = __('Project Name', 'custom-portfolio');
            $new_columns['project_dates'] = __('Project Dates', 'custom-portfolio');
            $new_columns['project_url'] = __('Project URL', 'custom-portfolio');
        }
    }
    return $new_columns;
}
add_filter('manage_project_posts_columns', 'custom_portfolio_add_project_columns');

/**
 * Populate custom columns
 */
function custom_portfolio_populate_project_columns($column, $post_id) {
    switch ($column) {
        case 'project_name':
            $project_name = custom_portfolio_get_project_meta($post_id, 'project_name');
            echo esc_html($project_name);
            break;
        case 'project_dates':
            $start_date = custom_portfolio_get_project_meta($post_id, 'project_start_date');
            $end_date = custom_portfolio_get_project_meta($post_id, 'project_end_date');
            if ($start_date) {
                echo esc_html($start_date);
            }
            if ($start_date && $end_date) {
                echo ' - ';
            }
            if ($end_date) {
                echo esc_html($end_date);
            }
            break;
        case 'project_url':
            $project_url = custom_portfolio_get_project_meta($post_id, 'project_url');
            if ($project_url) {
                echo '<a href="' . esc_url($project_url) . '" target="_blank">' . esc_html($project_url) . '</a>';
            }
            break;
    }
}
add_action('manage_project_posts_custom_column', 'custom_portfolio_populate_project_columns', 10, 2);

/**
 * Make custom columns sortable
 */
function custom_portfolio_make_project_columns_sortable($columns) {
    $columns['project_name'] = 'project_name';
    $columns['project_dates'] = 'project_dates';
    return $columns;
}
add_filter('manage_edit-project_sortable_columns', 'custom_portfolio_make_project_columns_sortable');

/**
 * Custom query for sorting
 */
function custom_portfolio_project_custom_orderby($query) {
    if (!is_admin()) {
        return;
    }
    
    $orderby = $query->get('orderby');
    
    if ('project_name' === $orderby) {
        $query->set('meta_key', '_project_name');
        $query->set('orderby', 'meta_value');
    }
    
    if ('project_dates' === $orderby) {
        $query->set('meta_key', '_project_start_date');
        $query->set('orderby', 'meta_value');
    }
}
add_action('pre_get_posts', 'custom_portfolio_project_custom_orderby');

/**
 * Register widget areas
 */
function custom_portfolio_widgets_init() {
    register_sidebar(array(
        'name'          => __('Sidebar', 'custom-portfolio'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here.', 'custom-portfolio'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'custom_portfolio_widgets_init');

/**
 * Custom Navigation Walker for dropdown menus
 */
class Custom_Portfolio_Walker_Nav_Menu extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $submenu = ($depth > 0) ? ' sub-menu' : '';
        $output .= "\n$indent<ul class=\"dropdown-menu$submenu\">\n";
    }
    
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        
        $li_attributes = '';
        $class_names = $value = '';
        
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        
        // Add dropdown class for items with children
        if ($args->walker->has_children) {
            $classes[] = 'dropdown';
            $classes[] = 'has-children';
        }
        
        // Add depth-specific classes
        if ($depth > 0) {
            $classes[] = 'sub-menu-item';
        }
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = ' class="' . esc_attr($class_names) . '"';
        
        $id = apply_filters('nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args);
        $id = strlen($id) ? ' id="' . esc_attr($id) . '"' : '';
        
        $output .= $indent . '<li' . $id . $value . $class_names . $li_attributes . '>';
        
        $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
        
        if ($args->walker->has_children) {
            $attributes .= ' class="dropdown-toggle"';
        }
        
        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        if ($args->walker->has_children) {
            $item_output .= ' <span class="caret"></span>';
        }
        $item_output .= '</a>';
        $item_output .= $args->after;
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}

/**
 * Fallback menu function
 */
function custom_portfolio_fallback_menu() {
    echo '<ul id="primary-menu" class="nav-menu">';
    echo '<li><a href="' . esc_url(home_url('/')) . '">' . __('Home', 'custom-portfolio') . '</a></li>';
    echo '<li><a href="' . esc_url(get_post_type_archive_link('project')) . '">' . __('Projects', 'custom-portfolio') . '</a></li>';
    echo '<li><a href="' . esc_url(get_permalink(get_option('page_for_posts'))) . '">' . __('Blog', 'custom-portfolio') . '</a></li>';
    echo '</ul>';
}
