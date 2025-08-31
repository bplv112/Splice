<?php
/**
 * The template for displaying search results
 *
 * @package CustomPortfolio
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="container">
        <header class="page-header">
            <h1 class="page-title">
                <?php
                printf(
                    /* translators: %s: search query. */
                    esc_html__('Search Results for: %s', 'custom-portfolio'),
                    '<span>' . get_search_query() . '</span>'
                );
                ?>
            </h1>
        </header>

        <?php if (have_posts()) : ?>
            <div class="search-results">
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('search-result-item'); ?>>
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="result-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium'); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <div class="result-content">
                            <header class="entry-header">
                                <h2 class="entry-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>
                                
                                <div class="entry-meta">
                                    <span class="post-type">
                                        <?php 
                                        $post_type = get_post_type();
                                        if ($post_type === 'project') {
                                            _e('Project', 'custom-portfolio');
                                        } else {
                                            _e('Post', 'custom-portfolio');
                                        }
                                        ?>
                                    </span>
                                    <span class="posted-on"><?php echo get_the_date(); ?></span>
                                    <span class="byline"><?php echo get_the_author(); ?></span>
                                </div>
                            </header>
                            
                            <div class="entry-summary">
                                <?php the_excerpt(); ?>
                            </div>
                            
                            <footer class="entry-footer">
                                <a href="<?php the_permalink(); ?>" class="btn"><?php _e('Read More', 'custom-portfolio'); ?></a>
                            </footer>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
            
            <?php
            // Pagination
            the_posts_pagination(array(
                'mid_size' => 2,
                'prev_text' => __('Previous', 'custom-portfolio'),
                'next_text' => __('Next', 'custom-portfolio'),
            ));
            ?>
            
        <?php else : ?>
            <div class="no-results">
                <h2><?php _e('No results found', 'custom-portfolio'); ?></h2>
                <p><?php _e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'custom-portfolio'); ?></p>
                <?php get_search_form(); ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
