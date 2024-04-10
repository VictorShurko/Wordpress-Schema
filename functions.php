<?php
// Добавляем микроразметку в head
function add_microdata_to_header() {
    // WPHeader если установлен плагин All in One SEO Pack
    global $metaTitle, $metaDesc, $metaKey, $post;
    $title_schema = $metaTitle ?: wp_get_document_title();
    $description_schema = $metaDesc ?: get_post_meta($post->ID, '_aioseop_description', true);
    $keywords_schema = $metaKey ?: '';

    if (!$keywords_schema) {
        $post_tags = get_the_tags();
        if ($post_tags) {
            $keywords_schema = implode(', ', wp_list_pluck($post_tags, 'name'));
        }
    }

    ?>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WPHeader",
        "headline": "<?php echo esc_html($title_schema); ?>",
        "description": "<?php echo esc_html($description_schema); ?>",
        "keywords": "<?php echo esc_html($keywords_schema); ?>",
        "url": "<?php echo esc_url(get_permalink($post->ID)); ?>"
    }
    </script>
    <?php
    //end - WPHeader
}

add_action('wp_head', 'add_microdata_to_header');