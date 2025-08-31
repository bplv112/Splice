<?php
/**
 * Template Name: Blog
 * 
 * @package CustomPortfolio
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="container">
        <div class="blog-layout">
            <div class="blog-main">
                <header class="page-header">
                    <h1 class="page-title"><?php the_title(); ?></h1>
                    <?php if (get_the_content()) : ?>
                        <div class="page-description">
                            <?php the_content(); ?>
                        </div>
                    <?php endif; ?>
                </header>

                <?php
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                $blog_query = new WP_Query(array(
                    'post_type' => 'post',
                    'posts_per_page' => get_option('posts_per_page'),
                    'paged' => $paged
                ));
                
                if ($blog_query->have_posts()) : ?>
                    <div class="posts-grid">
                        <?php while ($blog_query->have_posts()) : $blog_query->the_post(); ?>
                            <article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="post-thumbnail">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('medium'); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="post-content">
                                    <header class="entry-header">
                                        <h2 class="entry-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h2>
                                        
                                        <div class="entry-meta">
                                            <span class="posted-on">
                                                <time datetime="<?php echo get_the_date('c'); ?>">
                                                    <?php echo get_the_date(); ?>
                                                </time>
                                            </span>
                                            <span class="byline">
                                                <?php printf(__('by %s', 'custom-portfolio'), get_the_author()); ?>
                                            </span>
                                            <?php if (has_category()) : ?>
                                                <span class="cat-links">
                                                    <?php the_category(', '); ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </header>
                                    
                                    <div class="entry-summary">
                                        <?php the_excerpt(); ?>
                                    </div>
                                    
                                    <footer class="entry-footer">
                                        <a href="<?php the_permalink(); ?>" class="btn"><?php _e('Read More', 'custom-portfolio'); ?></a>
                                        
                                        <?php if (has_tag()) : ?>
                                            <div class="tags-links">
                                                <?php the_tags(__('Tags: ', 'custom-portfolio'), ', '); ?>
                                            </div>
                                        <?php endif; ?>
                                    </footer>
                                </div>
                            </article>
                        <?php endwhile; ?>
                    </div>
                    
                    <?php
                    // Custom pagination for the blog query
                    $big = 999999999;
                    echo '<div class="pagination">';
                    echo paginate_links(array(
                        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                        'format' => '?paged=%#%',
                        'current' => max(1, get_query_var('paged')),
                        'total' => $blog_query->max_num_pages,
                        'prev_text' => __('Previous', 'custom-portfolio'),
                        'next_text' => __('Next', 'custom-portfolio'),
                    ));
                    echo '</div>';
                    ?>
                    
                <?php else : ?>
                    <div class="no-posts">
                        <h2><?php _e('No posts found', 'custom-portfolio'); ?></h2>
                        <p><?php _e('It looks like nothing was found at this location. Maybe try a search?', 'custom-portfolio'); ?></p>
                        <?php get_search_form(); ?>
                    </div>
                <?php endif; ?>
                <?php wp_reset_postdata(); ?>
            </div>
            
            <aside class="blog-sidebar">
                <?php get_sidebar(); ?>
            </aside>
        </div>
    </div>
</main>

<?php get_footer(); ?>

