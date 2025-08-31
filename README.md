# Custom Portfolio WordPress Theme

A custom WordPress theme built from scratch for showcasing projects and portfolio work. This theme demonstrates advanced WordPress development skills including custom post types, REST API endpoints, dynamic navigation, and responsive design.

## Features

### 🎨 Theme Development
- **Custom WordPress theme** built from scratch (no page builders)
- **WordPress best practices** followed throughout
- **2 custom page templates**: Home and Blog
- **Responsive design** with mobile-first approach
- **Modern CSS Grid and Flexbox** layouts

### 📝 Custom Post Types
- **Projects post type** with custom fields:
  - Project Name
  - Project Description
  - Project Start Date
  - Project End Date
  - Project URL
- **Custom meta boxes** for easy content management
- **Admin columns** with sortable functionality

### 🖼️ Custom Templates
- **Archive template** for projects listing
- **Single project template** with detailed view
- **Custom page templates** for Home and Blog
- **Sidebar support** with widgets

### 🧭 Dynamic Navigation
- **Multi-level dropdown menus** using `wp_nav_menu()`
- **Custom navigation walker** for enhanced functionality
- **Mobile-responsive** hamburger menu
- **Keyboard navigation** support
- **Accessibility features** (ARIA labels, skip links)

### 🔌 REST API Endpoint
- **Custom endpoint**: `/wp-json/custom-portfolio/v1/projects`
- **JSON response** with project data
- **Date filtering** support via query parameters
- **Security measures** with proper sanitization

### 📱 Responsive Design
- **Mobile-friendly** design
- **CSS Grid and Flexbox** for modern layouts
- **Progressive enhancement** approach
- **Touch-friendly** interface elements

### 🔒 Security Features
- **Input sanitization** for all user data
- **Output escaping** for secure display
- **Nonce verification** for forms
- **Capability checks** for admin functions
- **SQL injection prevention** through WordPress functions

### ⚡ Interactive Features
- **AJAX project filtering** by date range
- **Smooth animations** and transitions
- **Loading states** for better UX
- **Form validation** with JavaScript

## Installation

1. **Upload the theme** to `/wp-content/themes/CustomPortfolio/`
2. **Activate the theme** in WordPress Admin → Appearance → Themes
3. **Create pages** and assign the custom templates:
   - Create a page and select "Home" template
   - Create a page and select "Blog" template
4. **Set up navigation menus**:
   - Go to Appearance → Menus
   - Create a menu and assign to "Primary Menu" location
5. **Add widgets** to the sidebar (Appearance → Widgets)

## Usage

### Creating Projects

1. Go to **Projects → Add New** in WordPress admin
2. Fill in the project details:
   - **Title**: Main project title
   - **Project Name**: Custom project name (optional)
   - **Project Description**: Brief description
   - **Start Date**: When the project began
   - **End Date**: When the project completed
   - **Project URL**: Link to live project
3. **Add featured image** for visual appeal
4. **Publish** the project

### Custom Page Templates

#### Home Template
- Hero section with site branding
- Featured projects showcase
- Recent blog posts section
- Call-to-action buttons

#### Blog Template
- Blog posts listing with sidebar
- Pagination support
- Category and tag display
- Author information

### REST API Usage

Access project data via the custom endpoint:

```
GET /wp-json/custom-portfolio/v1/projects
```

**Query Parameters:**
- `start_date`: Filter projects from this date (YYYY-MM-DD)
- `end_date`: Filter projects until this date (YYYY-MM-DD)

**Example Response:**
```json
[
  {
    "id": 123,
    "title": "Project Title",
    "project_name": "Custom Project Name",
    "project_description": "Project description",
    "project_start_date": "2023-01-01",
    "project_end_date": "2023-12-31",
    "project_url": "https://example.com",
    "featured_image": "https://example.com/image.jpg"
  }
]
```

### Project Filtering

The projects archive page includes a filter form that allows users to:
- Filter by start date range
- Filter by end date range
- Clear filters to show all projects
- AJAX-powered filtering for smooth UX

## File Structure

```
CustomPortfolio/
├── assets/
│   ├── css/
│   ├── js/
│   │   └── main.js
│   └── images/
├── inc/
├── page-templates/
│   ├── home.php
│   └── blog.php
├── template-parts/
├── archive-project.php
├── footer.php
├── functions.php
├── header.php
├── index.php
├── README.md
├── screenshot.png
├── sidebar.php
├── single-project.php
└── style.css
```

## Customization

### Adding Custom Styles
Edit `style.css` to customize the theme appearance. The file includes:
- Base styles and reset
- Header and navigation styles
- Project grid layouts
- Responsive breakpoints
- Interactive elements

### Modifying JavaScript
Edit `assets/js/main.js` to customize:
- Mobile menu behavior
- AJAX filtering functionality
- Interactive animations
- Form validation

### Extending Functionality
Modify `functions.php` to add:
- Additional custom post types
- New REST API endpoints
- Custom widgets
- Theme customizer options

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Requirements

- WordPress 5.0 or higher
- PHP 7.4 or higher
- MySQL 5.6 or higher
- Modern web browser with JavaScript enabled

## Security Notes

- All user inputs are sanitized using WordPress functions
- Output is properly escaped to prevent XSS attacks
- Nonce verification is implemented for all forms
- Capability checks ensure proper access control
- SQL queries use WordPress prepared statements

## Performance

- Optimized CSS and JavaScript
- Efficient database queries
- Image optimization support
- Lazy loading for images
- Minimal external dependencies

## Support

This theme is built as a demonstration of WordPress development skills. For questions or issues, please refer to the WordPress Codex and developer documentation.

## License

This theme is created for educational and demonstration purposes. Feel free to use and modify as needed.


