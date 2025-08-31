/**
 * Custom Portfolio Theme JavaScript
 * 
 * @package CustomPortfolio
 */

jQuery(document).ready(function($) {
    'use strict';
    
    // Mobile menu toggle
    $('.menu-toggle').on('click', function() {
        var $navigation = $('.main-navigation');
        var $button = $(this);
        var $icon = $button.find('.menu-icon');
        
        $navigation.toggleClass('active');
        
        if ($navigation.hasClass('active')) {
            $button.attr('aria-expanded', 'true');
            $icon.text('✕');
            // Add close button if it doesn't exist
            if ($('.mobile-menu-close').length === 0) {
                $navigation.find('> ul').prepend('<button class="mobile-menu-close" aria-label="Close menu">✕</button>');
            }
        } else {
            $button.attr('aria-expanded', 'false');
            $icon.text('☰');
            $('.mobile-menu-close').remove();
        }
    });
    
    // Close mobile menu when clicking close button
    $(document).on('click', '.mobile-menu-close', function() {
        var $navigation = $('.main-navigation');
        var $button = $('.menu-toggle');
        var $icon = $button.find('.menu-icon');
        
        $navigation.removeClass('active');
        $button.attr('aria-expanded', 'false');
        $icon.text('☰');
        $('.mobile-menu-close').remove();
    });
    
    // Close mobile menu when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.main-navigation, .menu-toggle').length) {
            $('.main-navigation').removeClass('active');
            $('.menu-toggle').attr('aria-expanded', 'false').find('.menu-icon').text('☰');
            $('.mobile-menu-close').remove();
        }
    });
    
    // Projects filter form
    $('#projects-filter-form').on('submit', function(e) {
        e.preventDefault();
        
        var $form = $(this);
        var $container = $('#projects-container');
        var $submitButton = $form.find('button[type="submit"]');
        var originalText = $submitButton.text();
        
        // Show loading state
        $submitButton.text('Filtering...').prop('disabled', true);
        
        // Get form data
        var formData = {
            action: 'custom_portfolio_filter_projects',
            nonce: custom_portfolio_ajax.nonce,
            start_date: $('#start_date').val(),
            end_date: $('#end_date').val()
        };
        
        // Make AJAX request
        $.ajax({
            url: custom_portfolio_ajax.ajax_url,
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    $container.html(response.data);
                    
                    // Smooth scroll to results
                    $('html, body').animate({
                        scrollTop: $container.offset().top - 100
                    }, 500);
                } else {
                    $container.html('<p>Error loading projects. Please try again.</p>');
                }
                $('.btn').removeClass('loading');
            },
            error: function() {
                $container.html('<p>Error loading projects. Please try again.</p>');
            },
            complete: function() {
                $submitButton.text(originalText).prop('disabled', false);
            }
        });
    });
    
    // Clear filter button
    $('#clear-filter').on('click', function() {
        $('#projects-filter-form')[0].reset();
        
        // Reload the page to show all projects
        window.location.reload();
    });
    
    // Smooth scrolling for anchor links
    $('a[href^="#"]').on('click', function(e) {
        var target = $(this.getAttribute('href'));
        if (target.length) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: target.offset().top - 100
            }, 500);
        }
    });

    
    // Lazy loading for images (if needed)
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });
        
        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }
    
    // Add hover effects for project cards
    $('.project-card').hover(
        function() {
            $(this).addClass('hover');
        },
        function() {
            $(this).removeClass('hover');
        }
    );
    
    // Form validation for date inputs
    $('#start_date, #end_date').on('change', function() {
        var startDate = $('#start_date').val();
        var endDate = $('#end_date').val();
        
        if (startDate && endDate && startDate > endDate) {
            alert('Start date cannot be after end date.');
            $(this).val('');
        }
    });
    
    // Add keyboard navigation for mobile menu
    $('.main-navigation a').on('keydown', function(e) {
        if (e.keyCode === 13 || e.keyCode === 32) { // Enter or Space
            e.preventDefault();
            $(this).click();
        }
    });
    
    // Add focus management for mobile menu
    $('.menu-toggle').on('click', function() {
        setTimeout(function() {
            if ($('.main-navigation').hasClass('active')) {
                $('.main-navigation a').first().focus();
            }
        }, 100);
    });
    
    // Close mobile menu on escape key
    $(document).on('keydown', function(e) {
        if (e.keyCode === 27 && $('.main-navigation').hasClass('active')) { // Escape
            $('.menu-toggle').click();
        }
    });

    
    // Initialize tooltips (if needed)
    $('[data-tooltip]').on('mouseenter', function() {
        var $element = $(this);
        var tooltipText = $element.data('tooltip');
        
        if (tooltipText) {
            $element.append('<span class="tooltip">' + tooltipText + '</span>');
        }
    }).on('mouseleave', function() {
        $(this).find('.tooltip').remove();
    });
    
    // Smart dropdown positioning for grandchild menus
    function positionDropdowns() {
        $('.main-navigation ul ul ul').each(function() {
            var $dropdown = $(this);
            var $parent = $dropdown.parent();
            var dropdownWidth = $dropdown.outerWidth();
            var parentOffset = $parent.offset();
            var parentWidth = $parent.outerWidth();
            var viewportWidth = $(window).width();
            
            // Calculate if dropdown would go outside viewport
            var wouldOverflow = (parentOffset.left + parentWidth + dropdownWidth) > viewportWidth;
            
            if (wouldOverflow) {
                // Position to the left
                $dropdown.css({
                    'left': 'auto',
                    'right': '100%'
                });
                $parent.addClass('dropdown-left');
            } else {
                // Position to the right (default)
                $dropdown.css({
                    'left': '100%',
                    'right': 'auto'
                });
                $parent.removeClass('dropdown-left');
            }
        });
    }
    
    // Enhanced desktop navigation with better UX
    var hoverTimeout;
    var activeDropdown = null;
    
    // Position dropdowns on hover with improved timing
    $('.main-navigation ul ul li').hover(
        function() {
            var $this = $(this);
            var $dropdown = $this.find('> ul');
            
            if ($dropdown.length) {
                // Clear any existing timeout
                clearTimeout(hoverTimeout);
                
                // Small delay to prevent accidental triggering
                hoverTimeout = setTimeout(function() {
                    positionDropdowns();
                    
                    // Add a visual indicator that the menu is accessible
                    $this.addClass('menu-hover');
                    
                    // Track the active dropdown
                    activeDropdown = $dropdown;
                }, 150);
            }
        },
        function() {
            var $this = $(this);
            var $dropdown = $this.find('> ul');
            
            // Clear timeout
            clearTimeout(hoverTimeout);
            
            // Remove hover class
            $this.removeClass('menu-hover');
            
            // Only reset if we're not hovering over the dropdown itself
            if (activeDropdown !== $dropdown) {
                // Reset positioning when not hovering
                $('.main-navigation ul ul ul').css({
                    'left': '100%',
                    'right': 'auto'
                });
                $('.main-navigation ul ul li').removeClass('dropdown-left');
                activeDropdown = null;
            }
        }
    );
    
    // Keep dropdowns visible when hovering over them
    $('.main-navigation ul ul ul').hover(
        function() {
            var $dropdown = $(this);
            
            // Keep the dropdown visible and track it as active
            $dropdown.show();
            activeDropdown = $dropdown;
        },
        function() {
            var $dropdown = $(this);
            
            // Hide when leaving the dropdown area
            $dropdown.hide();
            activeDropdown = null;
            
            // Reset positioning
            $('.main-navigation ul ul ul').css({
                'left': '100%',
                'right': 'auto'
            });
            $('.main-navigation ul ul li').removeClass('dropdown-left');
        }
    );
    
    // Position dropdowns on window resize
    $(window).on('resize', function() {
        positionDropdowns();
    });
    
    // Initial positioning
    positionDropdowns();
});
