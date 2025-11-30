import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Force HTTPS on all links and resources in production
if (window.location.protocol === 'https:') {
    document.addEventListener('DOMContentLoaded', function() {
        // Convert all http:// URLs to https://
        document.querySelectorAll('a[href*="http://"]').forEach(el => {
            if (el.href.includes(window.location.hostname)) {
                el.href = el.href.replace('http://', 'https://');
            }
        });
        
        document.querySelectorAll('img[src*="http://"]').forEach(el => {
            if (el.src.includes(window.location.hostname)) {
                el.src = el.src.replace('http://', 'https://');
            }
        });
        
        document.querySelectorAll('link[href*="http://"]').forEach(el => {
            if (el.href.includes(window.location.hostname)) {
                el.href = el.href.replace('http://', 'https://');
            }
        });
        
        document.querySelectorAll('script[src*="http://"]').forEach(el => {
            if (el.src.includes(window.location.hostname)) {
                el.src = el.src.replace('http://', 'https://');
            }
        });
    });
}
