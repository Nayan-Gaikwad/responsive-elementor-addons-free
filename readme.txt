=== Responsive Elementor Addons ===
Contributors: cyberchimps
Donate Link: https://cyberchimps.com
Tags: one click demo import, gutenberg, elementor, templates
Requires at least: 5.0
Tested up to: 5.9
Elementor tested up to: 3.5.5
Requires PHP: 5.6
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Responsive Elementor Addons is a plugin to add some exciting elementor widgets.

== Changelog ==
= 1.0.0 - 9th November 2022 =
- New: REA Button
- New: REA Pricing Table
- New: REA Icon Box
- New: REA Media Carousel
- New: REA Video

== Installation ==

= Adding a new Widget =

1) Go to plugin->includes->widgets-manager->class-widgets-manager
2) Add name of the widget (widgetname) inside get_responsive_widget_list()
3) Register your widget class inside register_responsive_widgets()
4) Create a widget class extending Widget_Base class inside includes/widgets-manager/widgets/class-{widgetname}.php.
5) Add all required functions metioned in the document -
 [create elementor widget](https://developers.elementor.com/creating-a-new-widget/)
6) We have created our new widget category
**responsive-elementor-addon**, so add your widget to this category only.
7) Add SCSS file for widget to assets/dev/scss/frontend/{widgetname}/{widgetname}.scss and import this file into assets/dev/scss/frontend/frontend.scss
8) Add JS file to for the widget to assets/dev/scss/frontend/{widgetname}/{widgetname}.js and import this file into assets/dev/scss/frontend/frontend.js

= Steps to setup development Environment =

1. run "composer install"
2. run "npm install"

= Continuos compiled JS generation =
1. run "grunt watch_scripts"

= Continuos compiled CSS generation =
1. run "grunt watch_styles"

= Code quality check =

1. PHPCS - composer run phpcs
2. PHPCBF - composer run phpcbf
