<?php
/**
 * Module: Blog Grid
 * Delegates directly to the comprehensive Blog Section template
 */

if (waklert_module_is_empty()) { return; }

get_template_part('modules/content', 'blog_section');
