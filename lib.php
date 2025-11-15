<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Theme functions for Stellar child theme.
 *
 * @package    theme_stellar
 * @copyright  2024 Your Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Post process the CSS tree.
 *
 * @param string $tree The CSS tree.
 * @param theme_config $theme The theme config object.
 */
function theme_stellar_css_tree_post_processor($tree, $theme) {
    error_log('theme_stellar_css_tree_post_processor() is deprecated. Required' .
        'prefixes for Bootstrap are now in theme/stellar/scss/moodle/prefixes.scss');
    $prefixer = new theme_boost\autoprefixer($tree);
    $prefixer->prefix();
}

/**
 * Inject additional SCSS.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 */
function theme_stellar_get_extra_scss($theme) {
    $content = '';
    $imageurl = $theme->setting_file_url('backgroundimage', 'backgroundimage');

    if (!empty($imageurl)) {
        $content .= '@media (min-width: 768px) {';
        $content .= 'body { background-image: url("' . $imageurl . '"); background-size: cover; } }';
    }

    $loginbackgroundimageurl = $theme->setting_file_url('loginbackgroundimage', 'loginbackgroundimage');
    if (!empty($loginbackgroundimageurl)) {
        $content .= 'body.pagelayout-login #page { background-image: url("' . $loginbackgroundimageurl . '"); background-size: cover; }';
    }

    return !empty($theme->settings->scss) ? "{$theme->settings->scss}\n{$content}" : $content;
}

/**
 * Serves any files associated with the theme settings.
 */
function theme_stellar_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array()) {
    if ($context->contextlevel == CONTEXT_SYSTEM && in_array($filearea, ['logo', 'backgroundimage', 'loginbackgroundimage'])) {
        $theme = theme_config::load('stellar');
        $options['cacheability'] = $options['cacheability'] ?? 'public';
        return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
    } else {
        send_file_not_found();
    }
}

/**
 * Get the current user preferences that are available.
 */
function theme_stellar_user_preferences(): array {
    return [
        'drawer-open-block' => [
            'type' => PARAM_BOOL,
            'null' => NULL_NOT_ALLOWED,
            'default' => false,
            'permissioncallback' => [core_user::class, 'is_current_user'],
        ],
        'drawer-open-index' => [
            'type' => PARAM_BOOL,
            'null' => NULL_NOT_ALLOWED,
            'default' => true,
            'permissioncallback' => [core_user::class, 'is_current_user'],
        ],
    ];
}

/**
 * Returns the main SCSS content.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 */
function theme_stellar_get_main_scss_content($theme) {
    global $CFG;

    $scss = '';
    $filename = !empty($theme->settings->preset) ? $theme->settings->preset : null;
    $fs = get_file_storage();

    $context = context_system::instance();
    if ($filename == 'default.scss') {
        $scss .= file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/default.scss');
    } else if ($filename == 'plain.scss') {
        $scss .= file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/plain.scss');
    } else if ($filename == 'stellar_preset.scss') {
        $scss .= file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/default.scss');
        $scss .= file_get_contents($CFG->dirroot . '/theme/stellar/scss/preset/stellar_preset.scss');
    } else if ($filename && ($presetfile = $fs->get_file($context->id, 'theme_stellar', 'preset', 0, '/', $filename))) {
        $scss .= file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/default.scss');
        $scss .= $presetfile->get_content();
    } else {
        // Safety fallback - maybe new installs etc.
        $scss .= file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/default.scss');
    }
    print_object ($scss);
    return $scss;
}

/**
 * Get compiled css.
 *
 * @return string compiled css
 */
function theme_stellar_get_precompiled_css() {
    global $CFG;
    return file_get_contents($CFG->dirroot . '/theme/stellar/style/moodle.css');
}

/**
 * Get SCSS to prepend.
 */
function theme_stellar_get_pre_scss($theme) {
    global $CFG;
    $scss = '';
    $configurable = ['brandcolor' => ['primary']];

    foreach ($configurable as $configkey => $targets) {
        $value = $theme->settings->{$configkey} ?? null;
        if (!empty($value)) {
            array_map(fn($target) => $scss .= "$" . $target . ": " . $value . ";\n", (array) $targets);
        }
    }

    if (!empty($theme->settings->scsspre)) {
        $scss .= $theme->settings->scsspre;
    }

    return $scss;
}