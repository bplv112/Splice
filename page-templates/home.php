<?php
/**
 * Template Name: Home
 * 
 * @package CustomPortfolio
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="container">
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="hero-content">
                <h1 class="hero-title"><?php echo esc_html(get_bloginfo('name')); ?></h1>
                <p class="hero-description"><?php echo esc_html(get_bloginfo('description')); ?></p>
                <div class="hero-buttons">
                    <a href="<?php echo esc_url(get_post_type_archive_link('project')); ?>" class="btn btn-primary">View Projects</a>
                    <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="btn btn-secondary">Read Blog</a>
                </div>
            </div>
        </section>

        <!-- Featured Projects Section -->
        <section class="featured-projects">
            <h2 class="section-title"><?php _e('Featured Projects', 'custom-portfolio'); ?></h2>
            
            <?php
            $featured_projects = new WP_Query(array(
                'post_type' => 'project',
                'posts_per_page' => 3,
                'meta_query' => array(
                    array(
                        'key' => '_featured_project',
                        'value' => '1',
                        'compare' => '='
                    )
                )
            ));
            
            if ($featured_projects->have_posts()) : ?>
                <div class="projects-grid">
                    <?php while ($featured_projects->have_posts()) : $featured_projects->the_post(); ?>
                        <div class="project-card featured">
                            <div class="project-image">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('project-thumbnail'); ?>
                                <?php else : ?>
                                    <span>No Image</span>
                                <?php endif; ?>
                            </div>
                            <div class="project-content">
                                <h3 class="project-title">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php echo esc_html(custom_portfolio_get_project_meta(get_the_ID(), 'project_name') ?: get_the_title()); ?>
                                    </a>
                                </h3>
                                <p class="project-description">
                                    <?php echo esc_html(custom_portfolio_get_project_meta(get_the_ID(), 'project_description') ?: wp_trim_words(get_the_content(), 20)); ?>
                                </p>
                                <div class="project-meta">
                                    <?php 
                                    $start_date = custom_portfolio_get_project_meta(get_the_ID(), 'project_start_date');
                                    $end_date = custom_portfolio_get_project_meta(get_the_ID(), 'project_end_date');
                                    if ($start_date) : ?>
                                        <span>Start: <?php echo esc_html($start_date); ?></span>
                                    <?php endif; ?>
                                    <?php if ($end_date) : ?>
                                        <span>End: <?php echo esc_html($end_date); ?></span>
                                    <?php endif; ?>
                                </div>
                                <?php 
                                $project_url = get_permalink(get_the_ID());
                                if ($project_url) : ?>
                                    <a href="<?php echo esc_url($project_url); ?>" class="btn" target="_blank">View Project</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else : ?>
                <!-- Fallback to recent projects if no featured projects -->
                <?php
                $recent_projects = new WP_Query(array(
                    'post_type' => 'project',
                    'posts_per_page' => 3
                ));
                
                if ($recent_projects->have_posts()) : ?>
                    <div class="projects-grid">
                        <?php while ($recent_projects->have_posts()) : $recent_projects->the_post(); ?>
                            <div class="project-card">
                                <div class="project-image">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('project-thumbnail'); ?>
                                    <?php else : ?>
                                        <span>No Image</span>
                                    <?php endif; ?>
                                </div>
                                <div class="project-content">
                                    <h3 class="project-title">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php echo esc_html(custom_portfolio_get_project_meta(get_the_ID(), 'project_name') ?: get_the_title()); ?>
                                        </a>
                                    </h3>
                                    <p class="project-description">
                                        <?php echo esc_html(custom_portfolio_get_project_meta(get_the_ID(), 'project_description') ?: wp_trim_words(get_the_content(), 20)); ?>
                                    </p>
                                    <div class="project-meta">
                                        <?php 
                                        $start_date = custom_portfolio_get_project_meta(get_the_ID(), 'project_start_date');
                                        $end_date = custom_portfolio_get_project_meta(get_the_ID(), 'project_end_date');
                                        if ($start_date) : ?>
                                            <span>Start: <?php echo esc_html($start_date); ?></span>
                                        <?php endif; ?>
                                        <?php if ($end_date) : ?>
                                            <span>End: <?php echo esc_html($end_date); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <?php 
                                    $project_url = get_permalink(get_the_ID());
                                    if ($project_url) : ?>
                                        <a href="<?php echo esc_url($project_url); ?>" class="btn" target="_blank">View Project</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>
                <?php wp_reset_postdata(); ?>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
            
            <div class="view-all-projects">
                <a href="<?php echo esc_url(get_post_type_archive_link('project')); ?>" class="btn btn-primary"><?php _e('View All Projects', 'custom-portfolio'); ?></a>
            </div>
        </section>

        <!-- Recent Blog Posts Section -->
        <section class="recent-posts">
            <h2 class="section-title"><?php _e('Recent Blog Posts', 'custom-portfolio'); ?></h2>
            
            <?php
            $recent_posts = new WP_Query(array(
                'posts_per_page' => 3,
                'post_type' => 'post'
            ));
            
            if ($recent_posts->have_posts()) : ?>
                <div class="posts-grid">
                    <?php while ($recent_posts->have_posts()) : $recent_posts->the_post(); ?>
                        <article class="post-card">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="post-thumbnail">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium'); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <div class="post-content">
                                <header class="entry-header">
                                    <h3 class="entry-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                    
                                    <div class="entry-meta">
                                        <span class="posted-on"><?php echo get_the_date(); ?></span>
                                        <span class="byline"><?php echo get_the_author(); ?></span>
                                    </div>
                                </header>
                                
                                <div class="entry-summary">
                                    <?php the_excerpt(); ?>
                                </div>
                                
                                <footer class="entry-footer">
                                    <a href="<?php the_permalink(); ?>" class="btn">Read More</a>
                                </footer>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>
                
                <div class="view-all-posts">
                    <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="btn btn-secondary"><?php _e('View All Posts', 'custom-portfolio'); ?></a>
                </div>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </section>
    </div>
</main>

<?php get_footer(); ?>
