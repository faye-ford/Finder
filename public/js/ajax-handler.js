/**
 * Finder CMS - AJAX Form Handler
 * Prevents page reloads on form submissions by using fetch API
 */

document.addEventListener('DOMContentLoaded', function() {
    // LIKE BUTTON HANDLER - Must run first!
    document.addEventListener('submit', function(e) {
        var form = e.target;
        var action = form.getAttribute('action') || '';
        
        // Only handle like forms
        if (action.indexOf('posts.like') === -1) {
            return;
        }
        
        e.preventDefault();
        
        // Find the like count element and icon
        var postIdMatch = action.match(/posts\/(\d+)\/like/);
        var postId = postIdMatch ? postIdMatch[1] : null;
        var countEl = postId ? document.getElementById('like-count-' + postId) : null;
        var iconEl = postId ? document.getElementById('like-icon-' + postId) : null;
        
        fetch(action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(function(response) { return response.json(); })
        .then(function(data) {
            // Update like count
            if (countEl && data.likes_count !== undefined) {
                countEl.textContent = data.likes_count;
            }
            // Update heart icon - Instagram style (red filled when liked)
            if (iconEl && data.liked !== undefined) {
                if (data.liked) {
                    iconEl.setAttribute('fill', 'currentColor');
                    iconEl.classList.add('liked');
                    // Add animation
                    iconEl.classList.add('like-animated');
                    setTimeout(function() { iconEl.classList.remove('like-animated'); }, 300);
                } else {
                    iconEl.setAttribute('fill', 'none');
                    iconEl.classList.remove('liked');
                }
            }
        })
        .catch(function(err) { console.error(err); });
    });
    
    // GENERAL AJAX FORM HANDLER - For all other data-ajax forms
    document.addEventListener('submit', function(e) {
        var form = e.target;
        
        // Only handle forms marked for AJAX
        if (!form.hasAttribute('data-ajax')) {
            return;
        }
        
        // Skip like forms (handled above)
        var action = form.getAttribute('action') || '';
        if (action.indexOf('posts.like') !== -1) {
            return;
        }
        
        e.preventDefault();
        
        var formData = new FormData(form);
        var url = form.action;
        var method = formData.get('_method') || form.method || 'POST';
        
        // Show loading state on submit button
        var submitBtn = form.querySelector('button[type="submit"]');
        var originalText = submitBtn ? submitBtn.innerHTML : '';
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="inline-block animate-spin mr-2">⏳</span> Processing...';
        }
        
        fetch(url, {
            method: method.toUpperCase(),
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(function(response) { return response.json(); })
        .then(function(data) {
            // Show success message
            showToast(data.message || 'Action completed successfully!', 'success');
            
            // Reload the page if needed
            if (data.reload) {
                setTimeout(function() { window.location.reload(); }, 1000);
            }
            
            // Remove the element if deleted
            if (data.removed) {
                var elementId = data.elementId;
                if (elementId) {
                    var element = document.getElementById(elementId);
                    if (element) {
                        element.style.transition = 'opacity 0.3s';
                        element.style.opacity = '0';
                        setTimeout(function() { element.remove(); }, 300);
                    }
                }
            }
        })
        .catch(function(error) {
            console.error('Error:', error);
            showToast(error.message || 'An error occurred. Please try again.', 'error');
        })
        .finally(function() {
            // Restore button state
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        });
    });
    
    // Toast notification system
    function showToast(message, type) {
        type = type || 'success';
        
        // Remove existing toasts
        var existingToasts = document.querySelectorAll('.ajax-toast');
        for (var i = 0; i < existingToasts.length; i++) {
            existingToasts[i].remove();
        }
        
        var colors = {
            success: 'bg-emerald-500',
            error: 'bg-rose-500',
            warning: 'bg-amber-500',
            info: 'bg-blue-500'
        };
        
        var toast = document.createElement('div');
        toast.className = 'ajax-toast fixed bottom-4 right-4 ' + colors[type] + ' text-white px-6 py-3 rounded-xl shadow-xl z-50 transform transition-all duration-300 translate-y-4 opacity-0';
        toast.innerHTML = '<div class="flex items-center gap-3"><span>' + (type === 'success' ? '✓' : type === 'error' ? '✕' : 'ℹ') + '</span><span>' + message + '</span></div>';
        
        document.body.appendChild(toast);
        
        // Animate in
        setTimeout(function() {
            toast.classList.remove('translate-y-4', 'opacity-0');
        }, 10);
        
        // Auto remove
        setTimeout(function() {
            toast.classList.add('translate-y-4', 'opacity-0');
            setTimeout(function() { toast.remove(); }, 300);
        }, 3000);
    }
});