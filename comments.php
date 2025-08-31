<?php
/**
 * The template for displaying comments
 *
 * @package CustomPortfolio
 */

/*
 * If the current post is protected by a password and
 * the visitor has not entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">

    <?php if (have_comments()) : ?>
        <h3 class="comments-title">
            <?php
            $comments_number = get_comments_number();
            if ('1' === $comments_number) {
                printf(
                    /* translators: %s: post title */
                    esc_html__('One thought on &ldquo;%s&rdquo;', 'custom-portfolio'),
                    '<span>' . wp_kses_post(get_the_title()) . '</span>'
                );
            } else {
                printf(
                    /* translators: 1: number of comments, 2: post title */
                    esc_html(_nx(
                        '%1$s thought on &ldquo;%2$s&rdquo;',
                        '%1$s thoughts on &ldquo;%2$s&rdquo;',
                        $comments_number,
                        'comments title',
                        'custom-portfolio'
                    )),
                    number_format_i18n($comments_number),
                    '<span>' . wp_kses_post(get_the_title()) . '</span>'
                );
            }
            ?>
        </h3>

        <ol class="comment-list">
            <?php
            wp_list_comments(array(
                'style'      => 'ol',
                'short_ping' => true,
                'avatar_size' => 60,
            ));
            ?>
        </ol>

        <?php
        // Are there comments to navigate through?
        if (get_comment_pages_count() > 1 && get_option('page_comments')) :
        ?>
        <nav class="comment-navigation" role="navigation">
            <h4 class="screen-reader-text"><?php _e('Comment navigation', 'custom-portfolio'); ?></h4>
            <div class="nav-links">
                <div class="nav-previous"><?php previous_comments_link(__('&larr; Older Comments', 'custom-portfolio')); ?></div>
                <div class="nav-next"><?php next_comments_link(__('Newer Comments &rarr;', 'custom-portfolio')); ?></div>
            </div>
        </nav>
        <?php endif; ?>

        <?php
        // If comments are closed and there are comments, let's leave a little note, shall we?
        if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) :
        ?>
        <p class="no-comments"><?php _e('Comments are closed.', 'custom-portfolio'); ?></p>
        <?php endif; ?>

    <?php endif; ?>

    <?php
    comment_form(array(
        'title_reply' => __('Leave a Comment', 'custom-portfolio'),
        'title_reply_to' => __('Reply to %s', 'custom-portfolio'),
        'cancel_reply_link' => __('Cancel Reply', 'custom-portfolio'),
        'label_submit' => __('Post Comment', 'custom-portfolio'),
        'comment_field' => '<p class="comment-form-comment"><label for="comment">' . _x('Comment', 'noun', 'custom-portfolio') . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder="' . __('Enter your comment here...', 'custom-portfolio') . '"></textarea></p>',
        'comment_notes_before' => '<p class="comment-notes">' . __('Your email address will not be published. Required fields are marked *', 'custom-portfolio') . '</p>',
        'comment_notes_after' => '<p class="form-allowed-tags">' . sprintf(__('You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s', 'custom-portfolio'), ' <code>' . allowed_tags() . '</code>') . '</p>',
    ));
    ?>

</div><!-- #comments -->
