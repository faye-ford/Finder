/**
 * Finder CMS - AJAX Form Handler
 * Prevents page reloads on form submissions by using fetch API
 */

document.addEventListener('DOMContentLoaded', function() {
    // Handle all forms with data-ajax attribute
    document.addEventListener('submit', function(e) {
        const form = e.target;
        
        // Only handle forms marked for AJAX
        if (!form.hasAttribute('data-ajax')) {
            return;
        }
        
        // Skip like buttons - they have their own handler
        const action = form.getAttribute('action') || '';
        if (action.includes('posts.like')) {
            return;
        }
        
        e.preventDefault();
        
        const formData = new FormData(form);
        const url = form.action;
        const method = formData.get('_method') || form.method || 'POST';
        
        // Show loading state on submit button
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn ? submitBtn.innerHTML : '';
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="inline-block animate-spin mr-2">⏳</span> Processing...';
        }
        
        fetch(url, {
            method: method.toUpperCase(),
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Show success message
            showToast(data.message || 'Action completed successfully!', 'success');
            
            // Reload the page if needed (for some actions)
            if (data.reload) {
                setTimeout(() => window.location.reload(), 1000);
            }
            
            // Remove the element if deleted
            if (data.removed) {
                const elementId = data.elementId;
                if (elementId) {
                    const element = document.getElementById(elementId);
                    if (element) {
                        element.style.transition = 'opacity 0.3s';
                        element.style.opacity = '0';
                        setTimeout(() => element.remove(), 300);
                    }
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast(error.message || 'An error occurred. Please try again.', 'error');
        })
        .finally(() => {
            // Restore button state
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        });
    });
    
    // Toast notification system
    function showToast(message, type = 'success') {
        // Remove existing toasts
        document.querySelectorAll('.ajax-toast').forEach(t => t.remove());
        
        const colors = {
            success: 'bg-emerald-500',
            error: 'bg-rose-500',
            warning: 'bg-amber-500',
            info: 'bg-blue-500'
        };
        
        const toast = document.createElement('div');
        toast.className = `ajax-toast fixed bottom-4 right-4 ${colors[type]} text-white px-6 py-3 rounded-xl shadow-xl z-50 transform transition-all duration-300 translate-y-4 opacity-0`;
        toast.innerHTML = `
            <div class="flex items-center gap-3">
                <span>${type === 'success' ? '✓' : type === 'error' ? '✕' : 'ℹ'}</span>
                <span>${message}</span>
            </div>
        `;
        
        document.body.appendChild(toast);
        
        // Animate in
        setTimeout(() => {
            toast.classList.remove('translate-y-4', 'opacity-0');
        }, 10);
        
        // Auto remove
        setTimeout(() => {
            toast.classList.add('translate-y-4', 'opacity-0');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
    
    // Like button handler - handles forms with action containing 'posts.like'
    document.addEventListener('submit', function(e) {
        const form = e.target;
        const action = form.getAttribute('action') || '';
        
        // Only handle like forms
        if (!action.includes('posts.like')) {
            return;
        }
        
        e.preventDefault();
        
        const formData = new FormData(form);
        const url = form.action;
        
        // Find the like count element
        const postId = action.match(/posts\/(\d+)\/like/)?.[1];
        const countEl = postId ? document.getElementById(`like-count-${postId}`) : null;
        const iconEl = form.querySelector('svg');
        
        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            // Update like count
            if (countEl && data.likes_count !== undefined) {
                countEl.textContent = data.likes_count;
            }
            // Update heart icon fill
            if (iconEl && data.liked !== undefined) {
                iconEl.setAttribute('fill', data.liked ? 'currentColor' : 'none');
            }
        })
        .catch(console.error);
    });
    
    // Bookmark button handler
    document.addEventListener('click', function(e) {
        const bookmarkBtn = e.target.closest('[data-bookmark]');
        if (bookmarkBtn) {
            e.preventDefault();
            const url = bookmarkBtn.getAttribute('data-bookmark');
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                const iconEl = bookmarkBtn.querySelector('svg');
                if (iconEl) {
                    iconEl.classList.toggle('text-rose-500', data.bookmarked);
                    iconEl.classList.toggle('fill-current', data.bookmarked);
                }
            })
            .catch(console.error);
        }
    });
    
    // Follow button handler
    document.addEventListener('click', function(e) {
        const followBtn = e.target.closest('[data-follow]');
        if (followBtn) {
            e.preventDefault();
            const url = followBtn.getAttribute('data-follow');
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                const btn = followBtn;
                btn.classList.toggle('bg-slate-800', !data.following);
                btn.classList.toggle('bg-rose-500', data.following);
                btn.textContent = data.following ? 'Following' : 'Follow';
                btn.setAttribute('data-follow', data.following ? btn.dataset.unfollow : btn.dataset.follow);
            })
            .catch(console.error);
        }
    });
});