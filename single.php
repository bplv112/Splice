<?php
/**
 * The template for displaying single posts
 *
 * @package CustomPortfolio
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="container">
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?>>
                <!-- Post Header -->
                <header class="post-header">
                    <div class="post-meta-top">
                        <span class="post-category">
                            <?php the_category(', '); ?>
                        </span>
                        <span class="post-date">
                            <time datetime="<?php echo get_the_date('c'); ?>">
                                <?php echo get_the_date(); ?>
                            </time>
                        </span>
                    </div>
                    
                    <h1 class="post-title"><?php the_title(); ?></h1>
                    
                    <div class="post-meta">
                        <div class="post-author">
                            <span class="author-avatar">
                                <?php echo get_avatar(get_the_author_meta('ID'), 50); ?>
                            </span>
                            <div class="author-info">
                                <span class="author-name"><?php the_author(); ?></span>
                                <span class="author-bio"><?php echo get_the_author_meta('description'); ?></span>
                            </div>
                        </div>
                        
                        <div class="post-stats">
                            <span class="reading-time">
                                <?php
                                $content = get_the_content();
                                $word_count = str_word_count(strip_tags($content));
                                $reading_time = ceil($word_count / 200); // 200 words per minute
                                echo $reading_time . ' min read';
                                ?>
                            </span>
                        </div>
                    </div>
                </header>

                <!-- Featured Image -->
                <?php if (has_post_thumbnail()) : ?>
                    <div class="post-featured-image">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>

                <!-- Post Content -->
                <div class="post-content">
                    <?php the_content(); ?>
                    
                    <?php
                    wp_link_pages(array(
                        'before' => '<div class="page-links">' . __('Pages:', 'custom-portfolio'),
                        'after'  => '</div>',
                    ));
                    ?>
                </div>

                <!-- Post Footer -->
                <footer class="post-footer">
                    <!-- Tags -->
                    <?php if (has_tag()) : ?>
                        <div class="post-tags">
                            <h4><?php _e('Tags:', 'custom-portfolio'); ?></h4>
                            <div class="tags-list">
                                <?php the_tags('', '', ''); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Share Buttons -->
                    <div class="post-share">
                        <h4><?php _e('Share this post:', 'custom-portfolio'); ?></h4>
                        <div class="share-buttons">
                            <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="share-btn share-twitter">
                                Twitter
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="share-btn share-facebook">
                                Facebook
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="share-btn share-linkedin">
                                LinkedIn
                            </a>
                        </div>
                    </div>

                    <!-- Author Bio -->
                    <div class="author-bio-section">
                        <h4><?php _e('About the Author', 'custom-portfolio'); ?></h4>
                        <div class="author-bio-content">
                            <div class="author-avatar-large">
                                <?php echo get_avatar(get_the_author_meta('ID'), 80); ?>
                            </div>
                            <div class="author-details">
                                <h5 class="author-name"><?php the_author(); ?></h5>
                                <p class="author-description"><?php echo get_the_author_meta('description'); ?></p>
                                <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" class="author-posts-link">
                                    <?php _e('View all posts by', 'custom-portfolio'); ?> <?php the_author(); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </footer>

                <!-- Post Navigation -->
                <nav class="post-navigation">
                    <div class="nav-links">
                        <?php
                        $prev_post = get_previous_post();
                        $next_post = get_next_post();
                        ?>
                        
                        <?php if ($prev_post) : ?>
                            <div class="nav-previous">
                                <a href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>" rel="prev">
                                    <span class="nav-subtitle"><?php _e('Previous Post', 'custom-portfolio'); ?></span>
                                    <span class="nav-title"><?php echo esc_html(get_the_title($prev_post->ID)); ?></span>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($next_post) : ?>
                            <div class="nav-next">
                                <a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>" rel="next">
                                    <span class="nav-subtitle"><?php _e('Next Post', 'custom-portfolio'); ?></span>
                                    <span class="nav-title"><?php echo esc_html(get_the_title($next_post->ID)); ?></span>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </nav>

                <!-- Comments -->
                <?php
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
                ?>
            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>

