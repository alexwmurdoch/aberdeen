<?php
/**
 * The Sidebar widget area for footer.
 *
 * @package dazzling
 */
?>

<?php
// If footer sidebars do not have widget let's bail.

if (!is_active_sidebar('footer-widget-1') && !is_active_sidebar('footer-widget-2') && !is_active_sidebar('footer-widget-3') && !is_active_sidebar('footer-widget-4'))
    return;
// If we made it this far we must have some footer widgets.

$footer_widgets = 0;
$footer_cols = '';

if (is_active_sidebar('footer-widget-1')) {
    $footer_widgets++;
}
if (is_active_sidebar('footer-widget-2')) {
    $footer_widgets++;
}
if (is_active_sidebar('footer-widget-3')) {
    $footer_widgets++;
}
if (is_active_sidebar('footer-widget-4')) {
    $footer_widgets++;
}

switch ($footer_widgets) {
    case 1:
        $footer_cols = 'col-md-12';
        break;
    case 2:
        $footer_cols = 'col-md-6';
        break;
    case 3:
        $footer_cols = 'col-md-4';
        break;
    case 4:
        $footer_cols = 'col-md-3';
        break;
    default: //should not get here ever but added a footer_cols value anyway
        $footer_cols = 'col-md-3';
        break;
}
?>
<div id="top-footer" class="footer-widget-area">
    <div class="container">
        <div class="row">
            <div class="footer-widget-area">
                <?php if (is_active_sidebar('footer-widget-1')) : ?>
                    <div class="<?php echo $footer_cols; ?> footer-widget" role="complementary">
                        <?php dynamic_sidebar('footer-widget-1'); ?>
                    </div><!-- .widget-area .first -->
                <?php endif; ?>

                <?php if (is_active_sidebar('footer-widget-2')) : ?>
                    <div class="<?php echo $footer_cols; ?> footer-widget" role="complementary">
                        <?php dynamic_sidebar('footer-widget-2'); ?>
                    </div><!-- .widget-area .second -->
                <?php endif; ?>

                <?php if (is_active_sidebar('footer-widget-3')) : ?>
                    <div class="<?php echo $footer_cols; ?> footer-widget" role="complementary">
                        <?php dynamic_sidebar('footer-widget-3'); ?>
                    </div><!-- .widget-area .third -->
                <?php endif; ?>

                <?php if (is_active_sidebar('footer-widget-4')) : ?>
                    <div class="<?php echo $footer_cols; ?> footer-widget" role="complementary">
                        <?php dynamic_sidebar('footer-widget-4'); ?>
                    </div><!-- .widget-area .forth -->
                <?php endif; ?>
            </div>
        </div><!-- .row -->
    </div><!-- .container -->
</div><!-- #top-footer -->