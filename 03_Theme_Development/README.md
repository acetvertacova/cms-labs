# Laboratory Work №3

## Creating a Custom WordPress Theme

---

## 🎯 Purpose of the Work
Learn how to create a custom WordPress theme, understand its minimal structure, and learn how templates work.

---

## Steps Completed

### Step 1. Environment Setup
1. Navigated to the `wp-content/themes` folder in the local WordPress installation.
2. Created a new directory for the theme named `usm-theme`.
3. Enabled debugging in `wp-config.php`:

```php
define('WP_DEBUG', true);
```

### Step 2. Created Required Theme Files
1. Created `style.css` with theme metadata:

```css
/*
Theme Name: USM Theme
Author: Anastasia
Description: First theme - simple and understandable. 
Version: 0.0.1
Text Domain: usm-theme
Tags: light, simple, blog
*/
```
2. Added basic CSS rules.
3. Created `index.php` with a basic HTML structure.

### Step 3. Created Common Template Parts
1. Created `header.php` for the site header.
2. Created `footer.php` for the site footer.
3. Included them in `index.php` using:

```php
<?php get_header(); ?>
<?php get_footer(); ?>
```

4. Displayed the 5 latest posts on the homepage using the WordPress loop:
```php
<?php while (have_posts()) : the_post(); ?>
    <article <?php post_class('post-card'); ?>>
        <h2 class="post-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h2>

        <?php if (has_post_thumbnail()) : ?>
            <div class="post-thumbnail">
                <?php the_post_thumbnail('thumbnail'); ?>
            </div>
        <?php endif; ?>

        <div class="entry-content">
            <?php the_content(); ?>
        </div>
     </article>
<?php endwhile; ?>
```

---

## Step 4. Created Functions File
1. Created `functions.php`.
2. Enqueued the theme stylesheet:
```php
<?php
function usm_force_enqueue_scripts()
{
    wp_enqueue_style('usm-custom-style', get_template_directory_uri() . '/style.css', array(), time(), 'all');
}
add_action('wp_enqueue_scripts', 'usm_force_enqueue_scripts');
```

---

### Step 5. Created Additional Templates

| File          | Purpose                                                     |
|---------------|-------------------------------------------------------------|
| `single.php`  | Displayed single posts                                      |
| `page.php`    | Displayed static pages                                      |
| `sidebar.php` | Created for the sidebar, included with `get_sidebar()`      |
| `comments.php`| Displayed comments, included in `single.php` and `page.php` |
| `archive.php` | Displayed post archives                                     |

---

### Step 6. Applied Theme Styling

Added CSS styles for main elements: header, footer, content, and sidebar.

<img src = "03_Theme_Development/screenshots/home-page.png">

<img src = "03_Theme_Development/screenshots/nav.png">

<img src = "03_Theme_Development/screenshots/the-post.png">

---

## Theme Folder Structure
```
usm-theme/
├── archive.php
├── comments.php
├── footer.php
├── functions.php
├── header.php
├── index.php
├── page.php
├── screenshot.png
├── sidebar.php
├── single.php
└── style.css
```

---

## Key Questions

**1. Which two files are required for any WordPress theme?**

`style.css` and `index.php`.

---

**2. How were common template parts included?**

Using built-in WordPress functions:
```php
get_header();
get_footer();
get_sidebar();
```

---

**3. What is the difference between `index.php`, `single.php`, and `page.php`?**

| File        | Description                                  |
|-------------|----------------------------------------------|
| `index.php` | Displayed posts if no other template matched |
| `single.php`| Displayed a single post                      |
| `page.php`  | Displayed a static page                      |

---

**4. What was `functions.php` used for?**

It was used to add custom functionality to the theme, such as enqueuing scripts and styles, registering navigation menus, and enabling theme features (e.g. thumbnails, widgets).

## Useful link

- [Theme Development I](https://github.com/MSU-Courses/content-management-systems/tree/main/07_Theme_Development_I)
- [Theme Development II](https://github.com/MSU-Courses/content-management-systems/tree/main/08_Theme_Development_II)