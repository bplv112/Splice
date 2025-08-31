<?php
/**
 * The template for displaying single projects
 *
 * @package CustomPortfolio
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="container">
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('single-project'); ?>>
                <header class="project-header">
                    <h1 class="project-title entry-title">
                        <?php echo esc_html(custom_portfolio_get_project_meta(get_the_ID(), 'project_name') ?: get_the_title()); ?>
                    </h1>
                    
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="project-featured-image">
                            <?php the_post_thumbnail('project-large'); ?>
                        </div>
                    <?php endif; ?>
                </header>

                <div class="project-details">
                    <div class="project-detail">
                        <div class="detail-label"><?php _e('Project Name', 'custom-portfolio'); ?></div>
                        <div class="detail-value">
                            <?php echo esc_html(custom_portfolio_get_project_meta(get_the_ID(), 'project_name') ?: get_the_title()); ?>
                        </div>
                    </div>
                    
                    <div class="project-detail">
                        <div class="detail-label"><?php _e('Project Description', 'custom-portfolio'); ?></div>
                        <div class="detail-value">
                            <?php echo esc_html(custom_portfolio_get_project_meta(get_the_ID(), 'project_description')); ?>
                        </div>
                    </div>
                    
                    <div class="project-detail">
                        <div class="detail-label"><?php _e('Start Date', 'custom-portfolio'); ?></div>
                        <div class="detail-value">
                            <?php 
                            $start_date = custom_portfolio_get_project_meta(get_the_ID(), 'project_start_date');
                            echo $start_date ? esc_html($start_date) : __('Not specified', 'custom-portfolio');
                            ?>
                        </div>
                    </div>
                    
                    <div class="project-detail">
                        <div class="detail-label"><?php _e('End Date', 'custom-portfolio'); ?></div>
                        <div class="detail-value">
                            <?php 
                            $end_date = custom_portfolio_get_project_meta(get_the_ID(), 'project_end_date');
                            echo $end_date ? esc_html($end_date) : __('Not specified', 'custom-portfolio');
                            ?>
                        </div>
                    </div>
                    
                    <div class="project-detail">
                        <div class="detail-label"><?php _e('Project URL', 'custom-portfolio'); ?></div>
                        <div class="detail-value">
                            <?php 
                            $project_url = custom_portfolio_get_project_meta(get_the_ID(), 'project_url');
                            if ($project_url) : ?>
                                <a href="<?php echo esc_url($project_url); ?>" target="_blank" rel="noopener noreferrer">
                                    <?php echo esc_url($project_url); ?>
                                </a>
                            <?php else : ?>
                                <?php _e('Not specified', 'custom-portfolio'); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="project-detail">
                        <div class="detail-label"><?php _e('Date Created', 'custom-portfolio'); ?></div>
                        <div class="detail-value">
                            <?php echo get_the_date(); ?>
                        </div>
                    </div>
                </div>

                <div class="project-content">
                    <h2><?php _e('Project Details', 'custom-portfolio'); ?></h2>
                    <?php the_content(); ?>
                </div>

                <footer class="project-footer">
                    <div class="project-navigation">
                        <?php
                        $prev_post = get_previous_post();
                        $next_post = get_next_post();
                        ?>
                        
                        <?php if ($prev_post) : ?>
                            <div class="nav-previous">
                                <a href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>" rel="prev">
                                    <span class="nav-subtitle"><?php _e('Previous Project', 'custom-portfolio'); ?></span>
                                    <span class="nav-title"><?php echo esc_html(get_the_title($prev_post->ID)); ?></span>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($next_post) : ?>
                            <div class="nav-next">
                                <a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>" rel="next">
                                    <span class="nav-subtitle"><?php _e('Next Project', 'custom-portfolio'); ?></span>
                                    <span class="nav-title"><?php echo esc_html(get_the_title($next_post->ID)); ?></span>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="project-actions">
                        <a href="<?php echo esc_url(get_post_type_archive_link('project')); ?>" class="btn">
                            <?php _e('Back to Projects', 'custom-portfolio'); ?>
                        </a>
                        
                        <?php 
                        $project_url = custom_portfolio_get_project_meta(get_the_ID(), 'project_url');
                        if ($project_url) : ?>
                            <a href="<?php echo esc_url($project_url); ?>" class="btn btn-primary" target="_blank" rel="noopener noreferrer">
                                <?php _e('Visit Project', 'custom-portfolio'); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </footer>
            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>

