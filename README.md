# WordPress Developer Screening Tasks - Implementation

This project implements all required screening tasks using a TwentyTwentyFive child theme approach with modular, maintainable code structure.

## Implementation Overview

**Theme Extension**: All customizations implemented via child theme to preserve parent theme updates while maintaining full functionality.

**Architecture**: Modular class-based structure with proper namespacing, autoloading, and WordPress coding standards compliance.

## Completed Tasks

### Task #1: Custom CSS Structure
- **Solution**: Child theme with dedicated `style.css` for custom rules
- **Approach**: Proper enqueueing via `wp_enqueue_style`
- **Scalability**: Modular CSS structure ready for future expansions

### Task #2: Custom JavaScript Loading
- **Implementation**: `assets/js/scripts.js` loaded in footer via `wp_enqueue_script`
- **Performance**: Proper dependency management and version control

### Task #3: Custom Post Type & Taxonomy
- **Post Type**: "Books" with slug "library" and translatable labels
- **Taxonomy**: "Genre" with slug "book-genre" and translatable labels
- **Code**: Modular class-based implementation in `inc/WP/CustomPostTypes.php` and `inc/WP/CustomTaxonomies.php`

### Task #4: Custom Templates
- **4.1 Single Book**: Custom template with AJAX-loaded related books (JSON response)
- **4.2 Genre Archive**: Paginated genre listing (5 books per page)
- **AJAX**: Dedicated endpoints for dynamic content loading

### Task #5: FAQ Accordion Gutenberg Block
- **Implementation**: Custom plugin approach due to Vite config limitations
- **Location**: `/wp-content/plugins/faq-accordion/`
- **Features**: 
  - Multiple Q&A pairs with RichText editing
  - Accordion behavior using native HTML5 `<details>` elements
  - Programmatic numbering and responsive design
  - Customizable heading component
  - Modern CSS with custom properties
- **Technical Notes**: Uses RichText instead of InnerBlocks due to resource constraints
- **Standards**: Fixed all WordPress deprecation warnings, modern coding practices
