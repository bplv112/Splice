<?php
/**
 * The sidebar containing the main widget area
 *
 * @package CustomPortfolio
 */

if (!is_active_sidebar('sidebar-1')) {
    return;
}
?>

<aside id="secondary" class="widget-area">
    <?php dynamic_sidebar('sidebar-1'); ?>
    
    <!-- Custom Project Categories -->
    <section class="widget widget-project-categories">
        <h3 class="widget-title"><?php _e('Project Categories', 'custom-portfolio'); ?></h3>
        <ul>
            <?php
            $project_categories = get_terms(array(
                'taxonomy' => 'project_category',
                'hide_empty' => true,
            ));
            
            if ($project_categories && !is_wp_error($project_categories)) {
                foreach ($project_categories as $category) {
                    echo '<li><a href="' . esc_url(get_term_link($category)) . '">' . esc_html($category->name) . '</a></li>';
                }
            } else {
                echo '<li>' . __('No categories found', 'custom-portfolio') . '</li>';
            }
            ?>
        </ul>
    </section>
    
    <!-- Recent Projects -->
    <section class="widget widget-recent-projects">
        <h3 class="widget-title"><?php _e('Recent Projects', 'custom-portfolio'); ?></h3>
        <ul>
            <?php
            $recent_projects = new WP_Query(array(
                'post_type' => 'project',
                'posts_per_page' => 5,
                'post_status' => 'publish'
            ));
            
            if ($recent_projects->have_posts()) {
                while ($recent_projects->have_posts()) {
                    $recent_projects->the_post();
                    echo '<li>';
                    echo '<a href="' . esc_url(get_permalink()) . '">' . esc_html(get_the_title()) . '</a>';
                    echo '<span class="post-date">' . get_the_date() . '</span>';
                    echo '</li>';
                }
                wp_reset_postdata();
            } else {
                echo '<li>' . __('No projects found', 'custom-portfolio') . '</li>';
            }
            ?>
        </ul>
    </section>
    
    <!-- Search Form -->
    <section class="widget widget_search">
        <h3 class="widget-title"><?php _e('Search', 'custom-portfolio'); ?></h3>
        <?php get_search_form(); ?>
    </section>
</aside><!-- #secondary -->

