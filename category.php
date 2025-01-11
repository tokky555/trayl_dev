<?php
$category = get_queried_object();

if (in_array($category->slug, ['eat', 'book', 'culture', 'visit'])) {
    get_template_part('template-parts/category/design', 'grid');
} elseif (in_array($category->slug, ['learn', 'life', 'hobby','blog'])) {
    get_template_part('template-parts/category/design', 'list');
} elseif ($category->slug === 'gallery') {
    get_template_part('template-parts/category/design', 'gallery');
} else {
    // Fallback for unexpected cases
    get_template_part('template-parts/category/design', 'list');
}
?>