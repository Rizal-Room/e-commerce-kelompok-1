/**
 * Wishlist functionality - global
 */

window.toggleWishlist = function(productId) {
    fetch('/wishlist/toggle', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            product_id: productId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'success');
            // Reload to update wishlist icon state
            setTimeout(() => location.reload(), 800);
        }
    })
    .catch(error => {
        console.error('Wishlist toggle error:', error);
        // Check if user is not authenticated
        if (error.status === 401) {
            window.location.href = '/login';
        } else {
            showToast('Terjadi kesalahan', 'error');
        }
    });
}

window.showToast = function(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `px-6 py-4 rounded-lg shadow-lg animate-slide-up fixed bottom-4 right-4 z-50 ${
        type === 'success' ? 'bg-gray-800' : 'bg-red-500'
    } text-white font-medium text-sm`;
    toast.textContent = message;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}
