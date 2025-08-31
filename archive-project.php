<?php
/**
 * The template for displaying project archives
 *
 * @package CustomPortfolio
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="container">
        <header class="page-header">
            <h1 class="page-title"><?php _e('Projects', 'custom-portfolio'); ?></h1>
            <div class="page-description">
                <p><?php _e('Browse through our portfolio of projects and work.', 'custom-portfolio'); ?></p>
            </div>
        </header>

        <!-- Projects Filter Form -->
        <div class="projects-filter">
            <h3><?php _e('Filter Projects', 'custom-portfolio'); ?></h3>
            <form class="filter-form" id="projects-filter-form">
                <div class="filter-group">
                    <label for="start_date"><?php _e('Start Date From:', 'custom-portfolio'); ?></label>
                    <input type="date" id="start_date" name="start_date" />
                </div>
                
                <div class="filter-group">
                    <label for="end_date"><?php _e('End Date To:', 'custom-portfolio'); ?></label>
                    <input type="date" id="end_date" name="end_date" />
                </div>
                
                <div class="filter-group">
                    <button type="submit" class="btn"><?php _e('Filter Projects', 'custom-portfolio'); ?></button>
                    <button type="button" class="btn btn-secondary" id="clear-filter"><?php _e('Clear Filter', 'custom-portfolio'); ?></button>
                </div>
            </form>
        </div>

        <!-- Projects Grid -->
        <div id="projects-container" class="projects-grid">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
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
            <?php else : ?>
                <div class="no-projects">
                    <h2><?php _e('No projects found', 'custom-portfolio'); ?></h2>
                    <p><?php _e('No projects match your current criteria.', 'custom-portfolio'); ?></p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <?php if (have_posts()) : ?>
            <div class="pagination">
                <?php
                the_posts_pagination(array(
                    'mid_size' => 2,
                    'prev_text' => __('Previous', 'custom-portfolio'),
                    'next_text' => __('Next', 'custom-portfolio'),
                ));
                ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
